<?php
class Menus extends Controlador{
  
  /*Control de acceso
  *public $permisos= array('all' => true); Acceso total.
  -------------------------------------*/
  
  //public $permisos= array('all' => true);
  
  public function index(){
    $this->layout="index_admin";
	
	if(!empty($this->data)){
	
	  foreach($this->data['menu'] as $datafin){
	     $myarray=array();
		 $myarray['menus']['orden']=$datafin['menuOrden'];
		 
		 $this->con->reset();
		 $this->con->fields=$myarray['menus'];
		 if($this->con->update("menus","WHERE id=".$datafin['menuId'])){
					   Core::mensaje("Se modifico el menu.");
		 }else{
					  Core::mensaje("No se pudo modificar el menu.Intentelo de nuevo");
		 }
		 
	  }
	
	}
	
    $consulta=$this->con->find('menus',null,
							array('conditions'=>array('parent'=>0)),
							null,
							array('order'=>array('orden'=>1)),'ASC'
					       );
	$parent_menu['menu']=$this->con->array_list($consulta);
	
	$myarray=array();
	
	//$myarray['menu']['users_id']=$datafin['users_id'];
	
	foreach($parent_menu['menu'] as $p_menu){
	   $consulta=$this->con->find('menus',null,
								array('conditions'=>array('parent'=>$p_menu['id'])),
							    null,
							    array('order'=>array('orden'=>1)),'ASC'
					       );
	   $childs=$this->con->array_list($consulta);
	   $myarray[]=array('parent'=>$p_menu,'childs'=>$childs);
	}
	
	//print_r($parent_menu['menu']);
	
	$this->set('menu_principal',$myarray);
    
  }
  
  /*
  **Add
  */
  public function add(){
   
   $this->layout="index_admin";
   
     if(!empty($this->data)){//*
	 
	    if(!$this->_validamenu()){//**
		  $cadena = '';
		  foreach($this->error as $mensaje){
				  $cadena.=$mensaje."<br>";
		  }
		  $cadena = "<p>Se detectaron los siguientes errores. Por favor, corr&iacute;jalos y continue. Gracias.</p><br><div style='padding-left:20px;'>".                 $cadena."</div>";
		  Core::mensaje($cadena."<br><br>");
	  
       }else{
	        
		   if(empty($this->data['menus']['href'])){
					  $this->data['menus']['href']="articulos/articulo";
		   }
		   $this->con->fields=$this->data['menus'];
		   if($this->con->insert("menus")){
		       Core::mensaje("Se creo el menú.");
			   Core::redireccion("menus/index.html");
		   }else{
		      Core::mensaje("No se pudo crear el menú.Intentelo de nuevo.");
		   }
		   
	   }//**
	   
	 }//*
	 
	$menus = array();
	$consulta=$this->con->find('menus',null,
								array('conditions'=>array('parent'=>0))
					       );
		 while($fila=$this->con->fetch_array_assoc($consulta)){
			  $menus['menus'][]=array('id'=>$fila['id'],'texto'=>$fila['texto']);
		 }

	$articulos = array();
	$consulta=$this->con->find('articulos',null);
		 while($fila=$this->con->fetch_array_assoc($consulta)){
			  $articulos['articulos'][]=array('alias'=>$fila['alias'],'titulo'=>$fila['titulo']);
		 }
	 
		 $this->set('menus',$menus);
		 $this->set('articulos',$articulos);
	 
  }
  
  /*
  **Edit
  */
  public function edit($id=null){
    $this->layout="index_admin";
  
        if (!$id) {
			Core::mensaje("Id de mené invalida.");
			Core::redireccion("menus/index.html");
		}
		
		    if(!empty($this->data)){//*
			   
			   if(!$this->_validamenu()){//**
				  $cadena = '';
				  foreach($this->error as $mensaje){
						  $cadena.=$mensaje."<br>";
				  }
				  $cadena = "<p>Se detectaron los siguintes errores. Por favor, corr&iacute;jalos y continue. Gracias.</p><br><div style='padding-left:20px;'>".                 $cadena."</div>";
				  Core::mensaje($cadena."<br><br>");
			  
				  }else{
			   
			       if(empty($this->data['menus']['href'])){
					  $this->data['menus']['href']="articulos/articulo";
		           }
				   $this->con->fields=$this->data['menus'];
				   if($this->con->update("menus","WHERE id=".$id)){
					   Core::mensaje("Se modifico el menu.");
					   Core::redireccion("menus/index.html");
				   }else{
					  Core::mensaje("No se pudo modificar el menu.Intentelo de nuevo");
					  Core::redireccion("menus/edit.html");
				   }
		   
	            }//**
			   
			}//*
			
			       $consulta=$this->con->find('menus',
	                            null,
								array('conditions'=>array('id'=>$id))
						 );
						 
				   $this->data['menus']=$this->con->fetch_array_assoc($consulta);
				   
				   $consulta=$this->con->find('menus',null,
								array('conditions'=>array('parent'=>0))
					       );
						 while($fila=$this->con->fetch_array_assoc($consulta)){
							  $menus['menus'][]=array('id'=>$fila['id'],'texto'=>$fila['texto']);
						 }
					$consulta=$this->con->find('articulos',null);
						 while($fila=$this->con->fetch_array_assoc($consulta)){
							  $articulos['articulos'][]=array('alias'=>$fila['alias'],'titulo'=>$fila['titulo']);
						 }
					 
		 $this->set('menus',$menus);
		 $this->set('articulos',$articulos);
		 $this->set('id',$id);
			
  }
  
  /*
  **Delete
  */
  public function delete($id=null){
     $this->layout="index_admin";
	 
		if (!$id) {
			Core::mensaje("Id de menu invalida.");
			Core::redireccion("menus/index.html");
		}
		
			if($this->con->del('menus','WHERE id='.$id)) {
			       
				   $menuus=array();
				   $menuus['menus']['parent']=0;
				   
			       $this->con->fields=$menuus['menus'];
				   
				   if($this->con->update("menus","WHERE parent=".$id)){
					   Core::mensaje("Se elimino el menu.");
					   Core::redireccion("menus/index.html");
				   }else{
					  Core::mensaje("Se produjeron errores durante la eliminacion de el menu.");
					  Core::redireccion("menus/index.html");
				   }
			}else{
				   Core::mensaje("No fue posible eliminar el rexistro.Intentelo de nuevo.");
				   Core::redireccion("menus/index.html");
			}
			
		}
		
	/*
	**Menu principal
	*/
	public function menu_principal(){
	   
	   $consulta=$this->con->find('menus',null,
							array('conditions'=>array('parent'=>0))
					       );
		$parent_menu['menu']=$this->con->array_list($consulta);
		
		$myarray=array();
		//$myarray['menu']['users_id']=$datafin['users_id'];
		foreach($parent_menu['menu'] as $p_menu){
		   $consulta=$this->con->find('menus',null,
									array('conditions'=>array('parent'=>$p_menu['id']))
							   );
		   $childs=$this->con->array_list($consulta);
		   $myarray[]=array('parent'=>$p_menu,'childs'=>$childs);
		}
		
		//print_r($parent_menu['menu']);
		
		$this->set('menu_principal',$myarray);
	   
	}
  
  /**************************************************************************************************************************
  **Validacion
  */
  function _validamenu(){
    $no_errores = true;
	//print_r($this->data);
	$reg_num = '/^[0-9]{1,}$/i';
	$reg_alfa3  = '/^[a-zA-Z0-9_]{3,}$/i';
	
	if (!preg_match($reg_alfa3,$this->data["menus"]["alias"])){
			$this->error[]= "El valor del campo alias debe ser de tipo alfanum&eacute;rico.";
			$no_errores=false;
    }
	
	if (empty($this->data["menus"]["texto"])){
			$this->error[]= "El valor del campo texto debe ser de tipo alfanum&eacute;rico.";
			$no_errores=false;
    }
	
	return $no_errores;
  }
  
}
?>