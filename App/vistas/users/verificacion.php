<div id="formVf">
  		<h3>verificación de cuenta!</h3>
	    <form method="post" action="<?= ROOT?>users/verificacion.html" name="formVerificacionUsuario" accept-charset="UTF-8" id="fajax" class="contenido" >
	    	<div class="form-group">
				<label for="emailVeri">email</label>
				<input type="email" class="form-control" name="data[user][email]" id="emailVeri" autocomplete="off" required  placeholder="Email" />
			</div>
			<div class="form-group">
				<label for="codVerificacion">codigo de verificación</label>
				<input type="text" class="form-control" name="data[user][codigo]" id="codVerificacion" autocomplete="off" required  placeholder="Codigo de verificación" />
			</div>
			<button type="submit" name="enviar" id="btn_enviar">enviar</button>
		</form>
</div>