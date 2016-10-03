<div class="x_panel">
	<div class="x_title"><h2><?= $_SESSION['textos']['password_user_form_titulo'];?></h2><div style="clear:both;"></div></div>
	<div id="bloque">
		<div id="form_password_usuario">
			<form method="post" action="<?= ROOT?>users/password.html" name="formPasswordUsuario" accept-charset="UTF-8" id="fajax" class="contenido" >
			<div class="form-group">
				<label for="input_email"><?= $_SESSION['textos']['nuevopass_user_form_email'];?></label>
				<input class="form-control" required type="email" name="data[user][email]" id="input_email" />
			</div>
			<div class="form-group">
				<label for="input_passwrod"><?= $_SESSION['textos']['password_user_form_Password'];?></label>
				<input class="form-control" required type="password" name="data[user][password]" id="input_password" />
			</div>
			<div class="form-group">
				<label for="input_passwrod2"><?= $_SESSION['textos']['password_user_form_confpass'];?></label>
				<input class="form-control" required type="password" name="data[password2]" id="input_password2" />
			</div>
			<div class="form-group">
				<label for="input_codigo">Codigo</label>
				<input class="form-control" required type="text" name="data[user][codigo]" id="input_codigo" />
			</div>
			<button class="btn btn-default" type="submit" name="enviar" id="btn_enviar"><?= $_SESSION['textos']['password_user_form_enviar'];?></button>
			</form>
		</div>
	</div>
</div>