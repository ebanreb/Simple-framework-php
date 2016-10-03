<?php
class Articulos extends Controlador{
  
  /*Control de acceso
  *public $permisos= array('all' => true); Acceso total.
  -------------------------------------*/
  
  public $permisos= array('articulo' => true);
  
  public function index(){
    $this->layout="index_admin";
	
    $limit=15;
    $consulta = $this->con->pagination("articulos",null,$limit);
	$articulos['articulo']=$this->con->array_list($consulta);
	
	$this->set('articulos',$articulos);

	//echo $_GET['pagina'];
    
  }
  
  /*
  **Add
  */
  public function add(){
   
   $this->layout="index_admin";
   
     if(!empty($this->data)){//*
	 
	    if(!$this->_validaarticulo()){//**
		  $cadena = '';
		  foreach($this->error as $mensaje){
				  $cadena.=$mensaje."<br>";
		  }
		  $cadena = "<p>Se detectaron los siguientes errores. Por favor, corr&iacute;jalos y continue. Gracias.</p><br><div style='padding-left:20px;'>".                 $cadena."</div>";
		  Core::mensaje($cadena."<br><br>");
	  
       }else{

       	   if(!empty($this->data['articulos']['carpeta'])){
          
		          $c = $this->data['articulos']['carpeta'];
		          $fotos =$this->_read_dir_dir($c);
		          sort($fotos,SORT_NUMERIC);
		          $i=0;
		          $html="";
		          $html.='<table style="width: 100%;" border="0"><tbody><tr>';
		          foreach($fotos as $clave => $valor){
		          	 $nom= $valor;
		          	 $partes= explode(".", $nom);
		          	 $subNom=$partes[0]."-m.".$partes[1];
		             $html.='
		                 <td style="text-align: center;">
		                     <a href="/images/articulos/'.$c.'/'.$nom.'" target="_blank"><img src="/images/articulos/'.$c.'/'.$subNom.'" /></a>
		                 </td>
		             ';
		             $i=$i+1;
		             if($i==4){
		             	$html.='</tr><tr>
								<td style="text-align: center;">&nbsp;</td>
								<td style="text-align: center;">&nbsp;</td>
								<td style="text-align: center;">&nbsp;</td>
								<td style="text-align: center;">&nbsp;</td>
								</tr><tr>';
		             	$i=0;
		             }
		          }
		          for($j=0;$j<(4-$i);$j++){
                      $html.='<td></td>';
		          }
		          $html.'</tr></tbody></table>';
		          $this->data['articulos']['texto1'].=$html;
		   }
		   
		   $this->data['articulos']['titulo']=get_magic_quotes_gpc() ? stripslashes($this->data['articulos']['titulo']) : $this->data['articulos']['titulo'];
		   $this->data['articulos']['texto1']=get_magic_quotes_gpc() ? stripslashes($this->data['articulos']['texto1']) : $this->data['articulos']['texto1'];
		   
		   $this->con->fields=$this->data['articulos'];
		   if($this->con->insert("articulos")){
		       Core::mensaje("Se creo el articulo.");
			   Core::redireccion("articulos/index.html");
		   }else{
		      Core::mensaje("No se pudo crear el articulo.Intentelo de nuevo.");
		   }
		   
	   }//**
	   
	 }//*
	 
	  $carpetas=$this->_read_dir();
	 
	  $this->set('carpetas',$carpetas);
	 
  }
  
  /*
  **Edit
  */
  public function edit($id=null){
    $this->layout="index_admin";
  
        if (!$id) {
			Core::mensaje("Id de articulo invalida.");
			Core::redireccion("articulos/index.html");
		}
		
		    if(!empty($this->data)){//*
			   
			   if(!$this->_validaarticulo()){//**
				  $cadena = '';
				  foreach($this->error as $mensaje){
						  $cadena.=$mensaje."<br>";
				  }
				  $cadena = "<p>Se detectaron los siguintes errores. Por favor, corr&iacute;jalos y continue. Gracias.</p><br><div style='padding-left:20px;'>".                 $cadena."</div>";
				  Core::mensaje($cadena."<br><br>");
			  
				  }else{
			       
				   $this->data['articulos']['titulo']=get_magic_quotes_gpc() ? stripslashes($this->data['articulos']['titulo']) : $this->data['articulos']['titulo'];
				   $this->data['articulos']['texto1']=get_magic_quotes_gpc() ? stripslashes($this->data['articulos']['texto1']) : $this->data['articulos']['texto1'];
			   
				   $this->con->fields=$this->data['articulos'];
				   if($this->con->update("articulos","WHERE id=".$id)){
					   Core::mensaje("Se modifico el articulo.");
					   if(isset($this->data['tipo']['enviar'])){
						      Core::redireccion("articulos/index.html");
					   }/*else{
						      $this->redireccion("articulos/edit/".$id.".html");
					   }*/
				   }else{
					  Core::mensaje("No se pudo modificar el articulo.Intentelo de nuevo");
					  Core::redireccion("articulos/edit.html");
				   }
		   
	            }//**
			   
			}//*
			
			       $consulta=$this->con->find('articulos',
	                            null,
								array('conditions'=>array('id'=>$id))
						 );
						 
				   $this->data['articulos']=$this->con->fetch_array_assoc($consulta);
				   
				   
		 $carpetas=$this->_read_dir();
	 
	     $this->set('carpetas',$carpetas);
				  
		 $this->set('id',$id);
			
  }
  
  /*
  **Delete
  */
  public function delete($id=null){
     $this->layout="index_admin";
	 
		if (!$id) {
			Core::mensaje("Id de articulo invalida.");
			Core::redireccion("articulos/index.html");
		}
		
			if($this->con->del('articulos','WHERE id='.$id)) {
					   Core::mensaje("Se elimino el articulo.");
					   $this->redireccion("articulos/index.html");
			}else{
				   Core::mensaje("No fue posible eliminar el rexistro.Intentelo de nuevo.");
				   Core::redireccion("articulos/index.html");
			}
			
	}
	
  
  /*
  **Articulo seleccionado
  */
  public function articulo($alias=null,$aliasHijo=null){
  $tituloPadre=null;
     if(!$alias){
	 
	     $consulta=$this->con->find('articulos',
	                            null,
								array('conditions'=>array('principal'=>1))
						 );
						 
	 }else{
	 
	    if(!$aliasHijo){
			  
		     $consultaMenu=$this->con->find('menus',
									null,
									array('conditions'=>array('articulo'=>$alias))
							 );
		     $menu=array();
	         $menu['menu']=$this->con->fetch_array_assoc($consultaMenu);
			 $tituloPadre=$menu['menu']['texto'];
		
			 $consulta=$this->con->find('articulos',
									null,
									array('conditions'=>array('alias'=>$alias))
							 );
		 }else{
		     
		     $consultaMenu=$this->con->find('menus',
									null,
									array('conditions'=>array('alias'=>$alias))
							 );
		     $menu=array();
	         $menu['menu']=$this->con->fetch_array_assoc($consultaMenu);
			 
			 /*$consultaArticuloPadre=$this->find('articulos',
									null,
									array('conditions'=>array('alias'=>$menu['menu']['articulo']))
							 );
		     $articuloPadre=array();
	         $articuloPadre['articuloPadre']=$this->fetch_array_assoc($consultaArticuloPadre);
			 $tituloPadre=$articuloPadre['articuloPadre']['titulo'];*/
			 $tituloPadre=$menu['menu']['texto'];
		     
		     $consulta=$this->con->find('articulos',
									null,
									array('conditions'=>array('alias'=>$aliasHijo))
							 );
		 }
		 
	 }
	 
	  $articulo=array();
	  $articulo['articulo']=$this->con->fetch_array_assoc($consulta);
	  
	  if(!$alias){
	     $consulta=$this->con->find('menus',
	                            null,
								array('conditions'=>array('articulo'=>$articulo['articulo']['alias']))
						 );
		 $secInicial=$this->con->fetch_array_assoc($consulta);
		 $alias=$secInicial['alias'];
	  }
				  
	  $this->set('articulo',$articulo);
	 
	  $this->set('thisAlias',$alias);
	  
	  $this->set('tituloPadre',$tituloPadre);
  }
  
  
  /*obtenemos los directorios de fotos de articulos*/
  function _read_dir(){
         $ru=DOCUMENT_ROOT."images/articulos/";
         $carpetas = array();
         if($fich2=opendir($ru))
		 {
		   while($file=readdir($fich2)) 
			{ 
			  if($file!="." && $file!=".." && $file!='Thumbs.db')
				{ 
				  //$idioma_aux=explode("_",$file);
				  $carpetas['carpeta'][]=array('indice'=>$file);
				}
			}//fin while
		   closedir($fich2);
		 }
		 
		 return $carpetas;
  }


   /*obtenemos las fotos de fotos de articulos*/
  function _read_dir_dir($r=null){
         $ru=DOCUMENT_ROOT."images/articulos/".$r."/";
         $patron  = '/(-m)/i';
         //$patron=preg_quote('-m');
         $fotos=array();

         if($fich2=opendir($ru))
		 {
		   while($file=readdir($fich2)) 
			{ 
			  if($file!="." && $file!=".." && $file!='Thumbs.db')
				{ 
			     if (!preg_match($patron,$file)){
			     //if(!eregi("[ tnr]+".$patron."[ tnr]+",$file)){
                   $fotos[]=$file;
                  }
               } 
			}//fin while
		   closedir($fich2);
		 }
		 
		 return $fotos;
  }
  
  /**************************************************************************************************************************
  **Validacion
  */
  function _validaarticulo(){
    $no_errores = true;
	//print_r($this->data);
	$reg_num = '/^[0-9]{1,}$/i';
	$reg_alfa3  = '/^[a-zA-Z0-9_]{3,}$/i';
	
	if (!preg_match($reg_alfa3,$this->data["articulos"]["alias"])){
			$this->error[]= "El valor del campo alias debe ser de tipo alfanum&eacute;rico.";
			$no_errores=false;
    }
	
	if (empty($this->data["articulos"]["titulo"])){
			$this->error[]= "El valor del campo titulo debe ser de tipo alfanum&eacute;rico.";
			$no_errores=false;
    }
	
	if (empty($this->data["articulos"]["texto1"])){
			$this->error[]= "El valor del campo texto1 debe ser de tipo alfanum&eacute;rico.";
			$no_errores=false;
    }
	
	return $no_errores;
  }
  
}
?>