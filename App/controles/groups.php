<?php
class Groups extends Controlador{
  
  /*Control de acceso
  *public $permisos= array('all' => true); Acceso total.
  -------------------------------------*/
  
  //public $permisos= array('all' => true);
  
  public function index(){
    $this->layout="index_admin";
    
    $limit=15;
    $consulta = $this->con->pagination("groups",null,$limit);
	
	
	/*$consulta=$this->find('groups g',
	                            array('fields'=>array('g.id','g.name','ac.groups_id')),
								array('conditions'=>array('g.id'=>2),'or'=>array('conditions'=>array('g.id'=>1,'g.name'=>'Administrador'))),
								array('join'=>array('table'=>'acces_groups ac','on'=>'g.id=ac.groups_id'))
						 );*/
	
	$this->set('res_groups',$consulta);
  }
  
  /*
  **Add
  */
  public function add(){
   
   $this->layout="index_admin";
   
     if(!empty($this->data)){//*
	 
	    if(!$this->_validagrupo()){//**
		  $cadena = '';
		  foreach($this->error as $mensaje){
				  $cadena.=$mensaje."<br>";
		  }
		  $cadena = "<p>Se detectaron los siguientes errores. Por favor, corr&iacute;jalos y continue. Gracias.</p><br><div style='padding-left:20px;'>".                 $cadena."</div>";
		  Core::mensaje($cadena."<br><br>");
	  
       }else{
	   
		   $this->con->fields=$this->data['groups'];
		   if($this->con->insert("groups")){
		       Core::mensaje("Creouse grupo.");
			   Core::redireccion("groups/index.html");
		   }else{
		      Core::mensaje("No se pudo crear el grupo.Intentelo de nuevo.");
		   }
		   
	   }//**
	   
	 }//*
	 
  }
  
  /*
  **Edit
  */
  public function edit($id=null){
    $this->layout="index_admin";
  
        if (!$id) {
			Core::mensaje("Id de grupo invalida.");
			Core::redireccion("groups/index.html");
		}
		
		    if(!empty($this->data)){//*
			   
			   if(!$this->_validagrupo()){//**
				  $cadena = '';
				  foreach($this->error as $mensaje){
						  $cadena.=$mensaje."<br>";
				  }
				  $cadena = "<p>Se detectaron los siguintes errores. Por favor, corr&iacute;jalos y continue. Gracias.</p><br><div style='padding-left:20px;'>".                 $cadena."</div>";
				  Core::mensaje($cadena."<br><br>");
			  
				  }else{
			   
				   $this->con->fields=$this->data['groups'];
				   if($this->con->update("groups","WHERE id=".$id)){
					   Core::mensaje("Se modifico el grupo.");
					   Core::redireccion("groups/index.html");
				   }else{
					  Core::mensaje("No se pudo modificar el grupo.Intentelo de nuevo");
					  Core::redireccion("groups/edit.html");
				   }
		   
	            }//**
			   
			}//*
			
			       $consulta=$this->con->find('groups',
	                            array('fields'=>array('id,name')),
								array('conditions'=>array('id'=>$id))
						 );
						 
				   $this->data['groups']=$this->con->fetch_array_assoc($consulta);
			
  }
  
  /*
  **Delete
  */
  public function delete($id=null){
     $this->layout="index_admin";
	 
		if (!$id) {
			Core::mensaje("Id de grupo invalida.");
			Core::redireccion("groups/index.html");
		}
		
		$consulta=$this->con->find('users',
	                            array('fields'=>array('id')),
								array('conditions'=>array('groups_id'=>$id))
						 );
		if($this->con->num_rows($consulta)>0){
 		       Core::mensaje("No es posible eliminar el grupo.Hay rexistros relacionados en la tabla users.");
			   Core::redireccion("groups/index.html");
		}else{
		
			if($this->con->del('groups','WHERE id='.$id)) {
				   Core::mensaje("Grupo borrado.");
				   Core::redireccion("groups/index.html");
			}else{
				   Core::mensaje("No fue posible eliminar el rexistro.Intentelo de nuevo.");
				   Core::redireccion("groups/index.html");
			}
			
		}
  }
  
 /*
  **Permisos grupo
  */
  public function permisos($id=null){
  
  $this->layout="index_admin";
      
	  if (!$id) {
			Core::mensaje("Id de grupo invalida.");
			Core::redireccion("groups/index.html");
	  }
	       
		   if(!empty($this->data)){//*
		   
		     $consulta=$this->con->find('acces_groups',null,
								array('conditions'=>array('groups_id'=>$id))
			 );
			 
		     if($this->con->num_rows($consulta)>0){
				 
		         $this->con->del('acces_groups','WHERE groups_id='.$id);
				 if($this->con->affected_rows()>0) {
				
					  foreach($this->data['groups'] as $datafin){
					    if(!empty($datafin['acceso'])){
						   $myarray=array();
					       $myarray['acces_groups']['groups_id']=$datafin['groups_id'];
					       $myarray['acces_groups']['con_ac_id']=$datafin['con_ac_id'];
					       $myarray['acces_groups']['acceso']=$datafin['acceso'];

                           $this->con->reset();
						   $this->con->fields=$myarray['acces_groups'];
						   if($this->con->insert("acces_groups")){
							   Core::mensaje("Modificados los permisos del grupo.");
						   }else{
							  Core::mensaje("No fue posible modificar los permisos del grupo.Intentelo de nuevo.");
							  Core::redireccion("groups/index.html");
						   }
						 }
					  }
					  Core::redireccion("groups/index.html");
					  
					  
				}else{
					   Core::mensaje("No foe posible modificar los permisos del grupo.Intentelo de nuevo.");
					   Core::redireccion("groups/index.html");
				}
			}else{
 			          foreach($this->data['groups'] as $datafin){
					    if(!empty($datafin['acceso'])){
						  $myarray=array();
						  $myarray['acces_groups']['groups_id']=$datafin['groups_id'];
						  $myarray['acces_groups']['con_ac_id']=$datafin['con_ac_id'];
						  $myarray['acces_groups']['acceso']=$datafin['acceso'];
						  
						  $this->con->reset();
						  $this->con->fields=$myarray['acces_groups'];
							   if($this->con->insert("acces_groups")){
								   Core::mensaje("Modificados los permisos del grupo.");
							   }else{
								  Core::mensaje("No fue posible modificar los permisos del grupo.Intentelo de nuevo.");
								  Core::redireccion("groups/index.html");
							   }
						}
					  }
					  Core::redireccion("groups/index.html");
			    }
			  
		   }//*
		             $consulta_grupo=$this->con->find('groups',null,
								array('conditions'=>array('id'=>$id))
					 );
					 
					 
					 
					 $consulta=$this->con->find('acces_groups',null,
								array('conditions'=>array('groups_id'=>$id))
					 );
					 $r_acces=array();
					 while($fila=$this->con->fetch_array_assoc($consulta)){
					     $r_acces[]=array('id'=>$fila['id'],'groups_id'=>$fila['groups_id'],'con_ac_id'=>$fila['con_ac_id'],'acceso'=>$fila['acceso']);
					 }
					 
					 
					 $consulta=$this->con->find('con_ac',null,
								array('conditions'=>array('parent_id IS NULL'))
					 );
					 $r_con=array();
					 while($fila=$this->con->fetch_array_assoc($consulta)){
					    $val=0;
					    foreach($r_acces as $valor) {
								/*if($valor['con_ac_id'] == $fila['id'] && $valor['acceso']==1){
									$val=1;
									break;
								}*/
								if( $valor['con_ac_id'] == $fila['id'] ){
									if($valor['acceso']==1)
									   $val=1;
									elseif($valor['acceso']==-1)
									   $val=-1;

									break;
								}	
						}
						
						$r_ac=array();
						$sub_consulta=$this->con->find('con_ac',null,
								array('conditions'=>array('parent_id'=>$fila['id']))
					    );
						while($sub_fila=$this->con->fetch_array_assoc($sub_consulta)){
							$sub_val=0;
							foreach($r_acces as $va) {
									/*if($va['con_ac_id'] == $sub_fila['id'] && $va['acceso']==1){
										$sub_val=1;
										break;
									}*/
									if( $va['con_ac_id'] == $sub_fila['id'] ){
										if( $va['acceso']==1 )
										   $sub_val=1;
									    elseif( $va['acceso']==-1 )
									       $sub_val=-1;
									   
										break;
									}
							}
						  $r_ac[]=array('id'=>$sub_fila['id'],'parent_id'=>$sub_fila['parent_id'],'alias'=>$sub_fila['alias'],'acceso'=>$sub_val);
					    }
						
					    $r_con[]=array('id'=>$fila['id'],'parent_id'=>$fila['parent_id'],'alias'=>$fila['alias'],'acceso'=>$val,'acciones'=>$r_ac);
					 }
					 
					 
					$this->set('r_con',$r_con);
					$this->set('el_grupo',$this->con->fetch_array_assoc($consulta_grupo));
	  
  }
  
  
  /**************************************************************************************************************************
  **Validacion
  */
  function _validagrupo(){
    $no_errores = true;
	//print_r($this->data);
	$reg_num = '/^[0-9]{1,}$/i';
	$reg_alfa3  = '/^[a-zA-Z0-9_]{3,}$/i';
	
	if ( !preg_match($reg_alfa3, $this->data["groups"]["name"])){
			$this->error[]= "El valor del campo nombre debe ser de tipo alfanum&eacute;rico.";
			$no_errores=false;
    }
	
	$consulta=$this->con->find('groups',
	                            array('fields'=>array('name')),
								array('conditions'=>array('UPPER(name)'=>strtoupper($this->data['groups']['name'])))
						 );
	if($this->con->num_rows($consulta)>0){
	  $this->error[]= "Ya existe un registro con el nombre ".$this->data['groups']['name'].".";
	  $no_errores=false;
	}
	
	return $no_errores;
  }
  
}
?>