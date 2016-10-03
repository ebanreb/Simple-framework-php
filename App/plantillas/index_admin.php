<!doctype html>
<html lang="es">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>
  <title> miApp - Administraci&oacute;n</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

  <script>
	  $.datepicker.regional['es'] = {
		 closeText: 'Cerrar',
		 prevText: '<Ant',
		 nextText: 'Sig>',
		 currentText: 'Hoy',
		 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		 weekHeader: 'Sm',
		 dateFormat: 'dd/mm/yy',
		 firstDay: 1,
		 isRTL: false,
		 showMonthAfterYear: false,
		 yearSuffix: ''
		 };
	  $.datepicker.setDefaults($.datepicker.regional['es']);
	  $( function() {
	    $( ".showdpk" ).datepicker({
			  changeYear: true,
			  changeMonth: true,
			  autoSize: true,
			  yearRange: "-100:+0", // last hundred years
			});
	  } );
  </script>

  <link rel="stylesheet" type="text/css" href="<?= ROOT;?>css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT;?>css/estilosAdmin.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT;?>css/respAdmin.css">
  <meta name="Author" content="Bernabé C.Alonso">
  <script src="<?= ROOT;?>js/main.js"></script>

  <?php Core::htmlheaderadmin();?>
  <?php Core::TinyMCE();?>
 </head>

<body>


<div id="container">
	
	<div id="content">

	    <?php if(isset($_SESSION['user'])): ?>
	    <!--<div class="nav toggle">-->
                	<!--<a id="menu_toggle"><i class="fa fa-bars"></i></a>-->
                	<input type="checkbox" class="menu-checkbox" id="menu-toogle"/>
					<label for="menu-toogle" class="menu-toogle"><i class="fa fa-bars"></i></label>
        <!--</div>-->
        <?php endif; ?>

        <?php if(isset($_SESSION['user'])): ?>
		<div id="izquierda">
		    <div class="nav_title">
		       <a href="<?= ROOT;?>users/admin.html" class="site_title"><i class="fa fa-user-secret"  aria-hidden="true"></i> <span>appAdmin</span></a>
            </div>

            
	            <div class="profile">
	              <div class="profile_pic">
	                <img src="<?= ROOT;?>images/img.jpg" alt="..." class="img-circle profile_img">
	              </div>
	              <div class="profile_info">
	                <span>Hola,</span>
	                <h2><?= $_SESSION['user']['nombre'] ?></h2>
	              </div>
	            </div>
	            <div style="clear:both;"></div>
            

			<?php require_once("App/modulos/menu_admin.php");?>
		</div>
		<?php endif; ?>
		
		<div id="centro">

          
		  <div class="top_nav">
		  	<div class="nav_menu">
		  	 	
		  	 	<?php if(isset($_SESSION['user'])): ?>
                <ul class="nav navbar-nav navbar-right">
	                <li class="">
	                  <a class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                    <img src="<?= ROOT;?>images/img.jpg" alt=""><?= $_SESSION['user']['nombre'] ?>
	                    <span class=" fa fa-angle-down"></span>
	                  </a>
	                  <ul class="dropdown-menu dropdown-usermenu pull-right">
	                    <li><a href="javascript:;"><span>Mis datos</span></a></li>
	                    <li><a href="<?= ROOT;?>users/logout.html"><i class="fa fa-sign-out pull-right"></i> Cerrar sesion</a></li>
	                  </ul>
	                </li>
	            </ul>
	            <?php endif; ?>
		  	</div>
		  </div>

		  <!--Inicio mensaje-->
		  <div id="mensaje"><?php Core::get_mensaje();?></div>
		  <!--Fin mensaje-->

		  <div id="dat_centro">
		    <?php if(isset($_SESSION['user'])): require_once("App/modulos/breadcrumbs.php"); endif; ?>
			<?php require_once("Core/gestor.php");?>
		 </div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div style="clear:both;"></div>
	
</div>
<div id="footer"></div>

 </body>
</html>