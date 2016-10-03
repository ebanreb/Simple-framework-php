<?php
//Disable error reporting
//error_reporting(0);

session_name("WebsiteID"); //establecer el nombre de la sesión actual

require_once("config.ini.php");
require_once("Core/core.php");
require_once("Core/resize.php");
require_once("Core/phpmailer/class.phpmailer.php");
require_once("Core/mysql.inc.php");
require_once("Core/controlador.php");
require_once("Core/app.php");

if(!isset($_SESSION)) {
    session_start();
    Core::checkSession();
}

// Utilizar una función anónima, a partir de PHP 5.3.0
spl_autoload_register(function ($clase) {
    include_once 'App/controles/' . $clase . '.php';
});

Core::get_idioma();
//print_r($_SESSION['textos']);

//instancia de la app
$app = new App();
//lanzamos la app
$app -> render();
//cargamos la vista
$app -> vista();


//set_error_handler('error');

//***Log de errores de la pagina
function error($numero,$texto){
$ddf = fopen('error.log','a');
fwrite($ddf,"[".date("r")."] Error ".$numero.":".$texto."\r\n");
fclose($ddf);
}

?>