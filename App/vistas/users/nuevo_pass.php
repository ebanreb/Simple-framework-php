<div class="x_panel">
	<div class="x_title"><h2><?= $_SESSION['textos']['nuevopass_user_titulo'];?></h2><div style="clear:both;"></div></div>
	<div id="bloque">
		<div id="form_nuevo_password_usuario">
			<form method="post" action="<?= ROOT?>users/nuevo_pass.html" name="formNuevoPasswordUsuario" accept-charset="UTF-8" id="fajax" class="contenido" >
			<div class="form-group">
				<label for="input_email"><?= $_SESSION['textos']['nuevopass_user_form_email'];?></label>
				<input class="form-control" required type="email" name="data[user][email]" value="<?= $control->get_data('email');?>" id="input_email" />
			</div>
				<button class="btn btn-default" type="submit" name="enviar" id="btn_enviar"><?= $_SESSION['textos']['nuevopass_user_form_enviar'];?></button>
			</form>
		</div>
		<div id="box">
		  <a href="<?= ROOT?>users/password.html" name="dat_contenido">Introducir Codigo!</a>
		</div>
	</div>
</div>