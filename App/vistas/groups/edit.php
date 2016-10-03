<div class="x_panel">
	<div class="x_title"><h2>Editar grupo</h2><div style="clear:both;"></div></div>
	<div id="form_editar_grupo">
		<form method="post" action="<?= ROOT?>groups/edit/<?= $control->get_data('id');?>.html" name="formEditarGrupo" />
		 <div class="form-group">
			 <label for="input_name">Nombre: </label>
			 <input class="form-control" required type="text" name="data[groups][name]" value="<?= $control->get_data('name');?>" id="input_name" />
		 </div>
		 <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">Enviar</button>
		</form>
	</div>
</div>