<!doctype html>
<html lang="es">
 <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>
  <title>appDiet</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT;?>css/estilos.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT;?>css/impresora.css" media="print" />
  <meta name="Author" content="Bernabé C.Alonso">
  <meta name="Keywords" content="dietas">
  <meta name="Description" content="Dietas">
  <?php Core::htmlheader();?>
 </head>

<body>
<a name="inicio"></a>
<div id="container">
	<div id="header">
	  
	</div>
	<div id="nav">
			<?php include_once("App/modulos/menu.php");?>
	</div>
	<div id="content">
		<div id="centro">
			  <div id="dat_centro">
				<!--Inicio mensaje-->
				<div id="mensaje"><?php Core::get_mensaje();?></div>
				<!--Fin mensaje-->

				<?php require_once("Core/gestor.php");?>
			 </div>
	    </div>
	</div>
	<div style="clear:both;"></div>
	<div id="footer">
	</div>
</div>

 </body>
</html>