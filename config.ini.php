<?php
/*
*Configuracion de la base de datos
-----------------------------------*/
//database server
define('DB_SERVER', "localhost");
//database login name
define('DB_USER', "root");
//database login password
define('DB_PASS', "");
//database name
define('DB_DATABASE', "BD_NAME");

//database charset
define('DB_CHARSET', null);
/*Fin configuracion de la base de datos
-----------------------------------*/

$base = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && ! in_array(strtolower($_SERVER['HTTPS']), array( 'off', 'no' ))) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']."/";
define('ROOT',$base);

define('DOCUMENT_ROOT',$_SERVER["DOCUMENT_ROOT"]."/webs/miApp/");

/*Configuracion inicio pagina
------------------------------*/
define('URL', "portada/inicio.html");
define('ROUT', "portada");
define('ROUT_INI',"inicio");
/*Fin inicio pagina
------------------------------*/

/*idioma por defecto*/
define('LG','es');

/*Direccion de correo del administrador*/
define('CORREO',"");
?>