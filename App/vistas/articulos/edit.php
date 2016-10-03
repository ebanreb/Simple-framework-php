<div class="x_panel">
	<div class="x_title"><h2>Editar Artículo</h2><div style="clear:both;"></div></div>
	<div id="form_editar_articulo">
		<form method="post" action="<?= ROOT?>articulos/edit/<?= $id;?>.html" name="formEditarArticulo" accept-charset="UTF-8" />
			 <div class="x_content">
			     <button class="btn btn-default" type="submit" name="data[tipo][enviar]" id="btnEnviar">Guardar</button>
			     <button class="btn btn-default" type="submit" name="data[tipo][aplicar]" id="btnAplicar">aplicar</button>
			 </div>
			 <div class="form-group">
			 	<label for="input_principal">Principal</label>
			 	<input id="input_principal" type="checkbox" name="data[articulos][principal]" <?php if($control->get_data('principal')==1){?> checked="checked" <?php } ?> value="1"/>
			 </div>
			 <div class="form-group">
			 	<label for="input_alias">alias</label>
			 	<input class="form-control" type="text" name="data[articulos][alias]" value="<?= $control->get_data('alias');?>" id="input_alias" />
			 </div>
			 <div class="form-group">
			 	<label for="input_titulo">Titulo</label>
			 	<input class="form-control" type="text" name="data[articulos][titulo]" value="<?= htmlspecialchars($control->get_data('titulo'));?>" id="input_titulo" />
			 </div>
			 <div class="form-group">
			 	<label for="input_texto_art">Texto1</label>
			 	<textarea name="data[articulos][texto1]" id="input_texto_art"><?= $control->get_data('texto1');?></textarea>
			 </div>
			 <div class="form-group">
			  	<label for="input_carpeta">Carpeta fotos</label>
				<select class="form-control" name="data[articulos][carpeta]" id="input_carpeta">
				<option value="NULL">---</option>
				<?php foreach($carpetas['carpeta'] as $carp){?>
				<option value="<?= $carp['indice'];?>" <?php if($carp['indice']==$control->get_data('carpeta')){?> selected="selected" <?php }?>><?= $carp['indice'];?></option>
				<?php }?>
				</select>
			 </div>
			 <input type="hidden" name="data[task]" value="edit"/>
	    </form>
	</div>
</div>