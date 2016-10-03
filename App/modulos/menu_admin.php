<div id="nav_menu" class="main_menu">
   <ul class="nav side-menu">
       <li <?php if(CONTROL=="users" && ACCION=="admin"): echo "class=\"active\""; endif ?>>
          <a href="<?= ROOT;?>users/admin.html"><i class="fa fa-home"></i> Inicio</a>
          <!--<a href="<?= ROOT;?>users/admin.html"><i class="fa fa-home"></i> Inicio <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu" style="display: block;">
                      <li><a href="index.html">Dashboard</a></li>
                      <li class="current-page"><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>-->
       </li>
	   <?php
	     if(isset($_SESSION['user'])){
	   ?> 
	     <li <?php if(CONTROL=="users" && ACCION!="admin"): echo "class=\"active\""; endif ?>><a href="<?= ROOT;?>users/index.html"><i class="fa fa-user"></i> Usuarios</a></li>
       <li <?php if(CONTROL=="groups"): echo "class=\"active\""; endif ?>><a href="<?= ROOT;?>groups/index.html"><i class="fa fa-users"></i> Grupos</a></li>
       <li <?php if(CONTROL=="menus"): echo "class=\"active\""; endif ?>><a href="<?= ROOT;?>menus/index.html"><i class="fa fa fa-list-ul"></i> Menus</a></li>
		   <li <?php if(CONTROL=="articulos"): echo "class=\"active\""; endif ?>><a href="<?= ROOT;?>articulos/index.html"><i class="fa fa-file-text"></i> Articulos</a></li>
       <li <?php if(CONTROL=="textos"): echo "class=\"active\""; endif ?>><a href="<?= ROOT;?>textos/index.html"><i class="fa fa-language"></i> Idiomas</a></li>
       <li><a href="<?= ROOT;?>users/logout.html"><i class="fa fa-power-off"></i> Cerrar sesion</a></li>
		<?php
		 }
		?>
   </ul>   
</div>