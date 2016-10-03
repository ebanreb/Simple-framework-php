<?php
class Textos extends Controlador{
  /*var $mybd;*/
  /*Control de acceso
  *public $permisos= array('all' => true); Acceso total.
  -------------------------------------*/
  /*public function Acl($bd=null){
    $this->mybd=new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  }*/
  
  
  //public $permisos= array('all' => true);
  
  /*
  **Index
  */
  public function index(){
     $this->layout="index_admin";
	 
	 $idiomas=$this->_read_dir();
	 
	 $this->set('idiomas',$idiomas);
	 
  }
  
  /*
  **idioma_apartados
  */
  public function idioma_apartados($indice=null){
     $this->layout="index_admin";
	 
	 $archivos=$this->_read_file($indice);
	 
	 $this->set('archivos',$archivos);
	 $this->set('directorio',$indice);
  }
  
  public function edit($indice=null,$archivo=null){
    $this->layout="index_admin";

    header("Content-Type:text/html; charset=utf-8");
	
	if(!$indice){
	  Core::mensaje("Iindice idioma invalido.");
	  Core::redireccion("idiomas/index.html");
	}
	
	if(!empty($this->data)){//*
	  
	   //$tu_array=array("variable"=>"valor","variable2"=>"valor_Variable2");
	   //unlink("lg/".$indice."/".$archivo.".php.ini");
       $fp=fopen("lg/".$indice."/".$archivo.".php.ini","w"); // abres el archivo en modo escritura "a+"
       foreach ($this->data['idiomas'] as $key=>$valor){
       	 
       	 //$valor = utf8_encode($valor); 
		 $valor=get_magic_quotes_gpc() ? stripslashes($valor) : $valor;
		 //$valor = utf8_encode($key."=\"".$valor."\"\n"); 
         fwrite ($fp,$key."=\"".$valor."\"\n");
         
       }
       fclose($fp);
	   Core::mensaje("Se guardo el contenido del archivo.");  
	}//*
	
	// Analizar sin secciones
	
    //$matriz_ini = parse_ini_file("lg/".$indice."/".$archivo.".php.ini");
	$matriz_ini =Core::parseIniFile("lg/".$indice."/".$archivo.".php.ini");
	
	$this->set('matriz_ini',$matriz_ini);
	$this->set('indice',$indice);
	$this->set('archivo',$archivo);
  }
  
  /*obtenemos los directorios de idiomas disponibles*/
  function _read_dir(){
         $ru="lg/";
         
         if($fich2=opendir($ru))
		 {
		   while($file=readdir($fich2)) 
			{ 
			  if($file!="." && $file!=".." && $file!='Thumbs.db')
				{ 
				  //$idioma_aux=explode("_",$file);
				  $idiomas['idioma'][]=array('indice'=>$file);
				}
			}//fin while
		   closedir($fich2);
		 }
		 
		 return $idiomas;
  }
  
  /*obtenemos los archivos de idiomas disponibles*/
  function _read_file($dir=null){
         $ru="lg/".$dir."/";
         header("Content-Type:text/html; charset=utf-8");
         if($fich2=opendir($ru))
		 {
		   while($file=readdir($fich2)) 
			{ 
			  if($file!="." && $file!=".." && $file!='Thumbs.db')
				{ 
				  $archivos_aux=explode(".",$file);
				  $archivos['archivo'][]=array('indice'=>$archivos_aux[0],'file'=>$file);
				}
			}//fin while
		   closedir($fich2);
		 }
		 
		 return $archivos;
  }
  
}
?>