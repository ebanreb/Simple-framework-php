<div class="x_panel">
	<div class="x_title"><h2>Nuevo grupo</h2><div style="clear:both;"></div></div>
	<div id="form_nuevo_grupo">
		<form method="post" action="<?= ROOT?>groups/add.html" name="formNuevoGrupo" />
		 <!--<label for="input_id">Id: </label>
		 <input type="text" name="data[groups][id]" value="<?= $control->get_data('id');?>" id="input_id" />-->
		 <div class="form-group">
			 <label for="input_name">Nombre: </label>
			 <input class="form-control" type="text" required name="data[groups][name]" value="<?= $control->get_data('name');?>" id="input_name" />
		 </div>
		 <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">Enviar</button>
		</form>
	</div>
</div>