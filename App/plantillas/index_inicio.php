<!doctype html>
<html lang="es">
 <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>
  <title> appDiet</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT;?>css/inicio.css">
  <meta name="Author" content="Bernab� C.Alonso">
  <meta name="Keywords" content="dietas">
  <meta name="Description" content="dietas">
  <?php Core::htmlheader();?>
 </head>

<body>

<div id="container">
	<div id="header">
	  
	</div>
	<div id="content">
		<div id="centro">
		  <!--Inicio mensaje-->
			<div id="mensaje"><?php Core::get_mensaje();?></div>
		  <!--Fin mensaje-->

		  <?php require_once("Core/gestor.php");?>
		</div>
	</div>
</div>

 </body>
</html>