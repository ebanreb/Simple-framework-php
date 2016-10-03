<div class="x_panel">
    <div class="x_title"><h2>login</h2><div style="clear:both;"></div></div>
	<div id="form_login_user">
		<?php if(!isset($_SESSION['user'])){?>
			<form method="post" action="<?= ROOT?>users/admin.html" name="formLoginUsuario" accept-charset="UTF-8">
			 <div class="form-group">
				 <label for="input_login">Email: </label>
				 <input class="form-control" type="text" name="data[login]" id="input_login" />
			 </div>
			 <div class="form-group">
				 <label for="input_password">Password: </label>
				 <input class="form-control" type="password" name="data[password]" id="input_password" />
			 </div>
			 <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">Enviar</button>
			</form>
			<div>
				<a href="<?= ROOT ?>users/nuevo_pass.html" name="dat_contenido">olvidaste el password?</a>
			</div>
		<?php }else{?>
			<div id="saludo">
				Hola <span><?= $_SESSION['user']['nombre'];?></span>&nbsp;
				|&nbsp;<a href="<?= ROOT;?>users/logout.html">cerrar sesion</a>
			</div>
		<?php }?>
	</div>
</div>