<?php
class Core{

public static function getmodulo($control,$accion){

  $m_control=ucfirst($control);

  $instancia=new $m_control;

  $instancia->$accion();

  $aux=$instancia->setvars;

  foreach($aux as $key=>$value){
    return  $value;
  }

}

private function regenerateSession($reload = false)
{
    // Este token es usado por los formularios para prevenir los accesos maliciosos
    if(!isset($_SESSION['nonce']) || $reload)
        $_SESSION['nonce'] = md5(microtime(true));

    if(!isset($_SESSION['IPaddress']) || $reload)
        $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];

    if(!isset($_SESSION['userAgent']) || $reload)
        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];

    //$_SESSION['user_id'] = $this->user->getId();

    // Establecer sesión actual para expirar en 1 minuto
    $_SESSION['OBSOLETE'] = true;
    $_SESSION['EXPIRES'] = time() + 60;

    // Crear nueva sesión sin destruir el viejo
    session_regenerate_id(false);

    // Coge identificador de sesión actual y cerrar las dos sesiones para permitir que otras secuencias de comandos para utilizarlos
    $newSession = session_id();
    session_write_close();

    // Programar una ID de sesión a la nueva, y empezar de nuevo otra vez
    session_id($newSession);
    session_start();

    // No quiero éste a expirar
    //unset($_SESSION['OBSOLETE']);
    //unset($_SESSION['EXPIRES']);
}

public static function checkSession()
{
    try{

        if(!isset($_SESSION['OBSOLETE']) || !$_SESSION['OBSOLETE'] )
        {
            self::regenerateSession();
        }

        /*if($_SESSION['OBSOLETE'] && ($_SESSION['EXPIRES'] < time()))
            throw new Exception('La sesión ha expirado.');*/

        if( isset($_SESSION['EXPIRES']) && ($_SESSION['EXPIRES'] < time()) )
            $_SESSION['OBSOLETE'] = false;

        if(!isset($_SESSION['user']))
            throw new Exception('No se inició sesión.');

        if($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
            throw new Exception('Dirección IP mixmatch (posible intento de secuestro de sesión).');

        if($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
            throw new Exception('Navegador mixmatch (posible intento de secuestro de sesión).');

        /*if(!$this->loadUser($_SESSION['user_id']))
            throw new Exception('Attempted to log in user that does not exist with ID: ' . $_SESSION['user_id']);*/

        /*if(!$_SESSION['OBSOLETE'] && mt_rand(1, 100) == 1)
        {
            regenerateSession();
        }*/

        return true;

    }catch(Exception $e){
        return false;
    }
}

/*
**Redireccionamos hacia nueva ruta
*/
public static function redireccion($url=null){
     
     if(!isset($_GET['service'])){
         $parts=explode(":",$url);
       //$this->fin_transaccion();
     
     if(!empty($parts) && $parts[0]=='http')//**en caso de ser una ruta completa
          header("location:".$url);
       else
        header("location:".ROOT.$url);
      
     exit;
     }
    
}

/*
**Evitamos la cache
*/
public static function disableCache() {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

public static function breadcrumbs($separator = ' » ', $home = 'Inicio', $url_home = '', $ext = '.html') {

    $base_url = strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'))) . '://' . $_SERVER['HTTP_HOST'];
    $uri = $base_url.$_SERVER['REQUEST_URI'];
    $uri = str_replace(ROOT, '', $uri);
    $uri = str_replace(".html", '', $uri);
    //echo $uri;
    //$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $path = array_filter(explode('/', $uri));
    //$base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    $base = ROOT;

    $breadcrumbs = array('<a href="'. $base.$url_home .'">'. $home .'</a>');
 
    $last = end(array_keys($path));
    
    $i = 0;
    $aux = "";
    foreach ($path as $x => $crumb) {
        $title = ucwords(str_replace(array($ext, '_'), array('', ' '), $crumb));
        
        if(!empty($aux)){
          $aux .= "/".$crumb;
        }else{
          $aux .= $crumb;
        }

        if($i==0){
           $breadcrumbs[] = '<a href="'. $base . $crumb . $ext .'">'. $title .'</a>';
        } else {
            $breadcrumbs[] = $title;
        }

        $i++;
        /*if ($x != $last) {
            $breadcrumbs[] = '<a href="'. $base . $crumb . $ext .'">'. $title .'</a>';
        } else {
            $breadcrumbs[] = $title;
        }*/
    }
 
    return implode($separator, $breadcrumbs);
}
  
/*
**Establece mensaje del sistema
*/
public static function mensaje($ms=null){
   unset($_SESSION['mensaje']);
   $_SESSION['mensaje']=$ms;
}

/*
**Mensaje de sistema
*/
public static function get_mensaje(){
   if(!empty($_SESSION['mensaje'])){
      echo"
	    <script>
		  document.getElementById('mensaje').style.display='block';
		</script>
	  ";
    echo utf8_decode($_SESSION['mensaje']);
	  //echo $_SESSION['mensaje'];
	  unset($_SESSION['mensaje']);
   }
}

//cargando textos
public static function textA($texto=null,$tipo=null){
   
   if(empty($tipo) || $tipo==0){
     echo $_SESSION['textos'][$texto];
   }else{
      $cadena=str_replace("<p>","",$_SESSION['textos'][$texto]);
	  $cadena=str_replace("</p>","",$cadena);
	  echo $cadena;
   }
   
}

//parsea archivo de variables
public static function parseIniFile($iIniFile)
{
    /*$aResult  =
    $aMatches = array();
 
    $a = &$aResult;
    $s = '\s*([[:alnum:]_\- \*]+?)\s*';
    header("Content-Type: text/html; charset=utf-8");

    preg_match_all('#^\s*((\['.$s.'\])|(("?)'.$s.'\\5\s*=\s*("?)(.*?)\\7))\s*(;[^\n]*?)?$#ms', $this->file_get_contents_utf8($iIniFile), $aMatches, PREG_SET_ORDER);
 
    foreach ($aMatches as $aMatch)
      {
      if (empty($aMatch[2]))
              $a [$aMatch[6]] = $aMatch[8];
        else  $a = &$aResult [$aMatch[3]];
      }

      return $aResult;
    */
    
    $ini_iso88591 = file_get_contents($iIniFile);
    $ini_utf8     = iconv("ISO-8859-1", "UTF-8", $ini_iso88591);
    $ini_array    = parse_ini_string($ini_utf8,TRUE);
 
    return $ini_array;
}

/*public function file_get_contents_utf8($fn) {
     $content = @file_get_contents($fn);
      return mb_convert_encoding($content, 'UTF-8',
          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}*/
/*public function file_get_contents_utf8($fn) {
    $opts = array(
        'http' => array(
            'method'=>"POST",
            'header'=>"Content-Type: text/html; charset=utf-8"
        )
    );

    $context = stream_context_create($opts);
    $result = @file_get_contents($fn,false,$context);
    return $result;
}*/  

/*Variables de idioma*/
public static function get_idioma(){
  if(isset($_SESSION['textos'])){
      unset($_SESSION['textos']);
   }
  
  if(isset($_GET['lg'])){
     $ru=DOCUMENT_ROOT."lg/".$_GET['lg']."/";
     if($fich2=opendir($ru)){
       $_SESSION['textos']=array();
       while(($file=readdir($fich2)) !== false) { 
    	  if($file!="." && $file!=".." && $file!='Thumbs.db'){
    	      $arch=self::parseIniFile($ru.$file);
    		    $_SESSION['textos']=array_merge($_SESSION['textos'],$arch);
    		}
    	}//fin while
      closedir($fich2);
     }
  }else{
     $ru=DOCUMENT_ROOT."lg/".LG."/";
     if($fich2=opendir($ru)){
       $_SESSION['textos']=array();
		   while(($file=readdir($fich2)) !== false) { 
			  if($file!="." && $file!=".." && $file!='Thumbs.db'){
			      $arch=self::parseIniFile($ru.$file);
				    $_SESSION['textos']=array_merge((array)$_SESSION['textos'],(array)$arch);
				}
			}//fin while
		   closedir($fich2);
	   }
  }
  
  //return $idioma;
  
}

/*
**Headers
*/
public static function htmlheader(){
  echo "<script type=\"text/javascript\" src=\"".ROOT."js/funciones.js\"></script>";
  echo "<link type=\"text/css\" href=\"".ROOT."css/google/main.css\" rel=\"stylesheet\" />";
}

public static function htmlheaderadmin(){
  echo "<script type=\"text/javascript\" src=\"".ROOT."js/funciones.js\"></script>";
  echo "<link type=\"text/css\" href=\"".ROOT."css/google/main.css\" rel=\"stylesheet\" />";
}

/*
**Editor TinyMCE 
*/
public static function TinyMCE(){
echo"
<script type=\"text/javascript\" src=\"".ROOT."js/tiny_mce/tinymce.min.js\"></script>
<script type=\"text/javascript\">

    tinymce.init({
    selector: 'textarea#input_texto_art',theme: 'modern',height: 350,
    language: 'es',
    relative_urls : false,
    remove_script_host : true,
    document_base_url : '".ROOT."',
    plugins: [

         'advlist code autolink link image lists charmap print preview hr anchor pagebreak',
         'searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking',
         'table contextmenu directionality emoticons paste textcolor responsivefilemanager',
         'insertdatetime '
   ],
   toolbar1: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect',
   toolbar2: '| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ',
   image_advtab: true ,
   
   external_filemanager_path:'". ROOT ."Core/filemanager/',
   filemanager_title:'Responsive Filemanager' ,
   external_plugins: { 'filemanager' : '". ROOT ."js/tiny_mce/plugins/responsivefilemanager/plugin.min.js'}
 });

	
	
</script>
";
}

}
?>