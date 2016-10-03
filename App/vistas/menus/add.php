<div class="x_panel">
	<div class="x_title"><h2>Nuevo Men&uacute;</h2><div style="clear:both;"></div></div>
	<div id="form_nuevo_menu">
		<form method="post" action="<?= ROOT?>menus/add.html" name="formNuevoMenu" accept-charset="UTF-8" />
		 <div class="form-group">
			 <label for="input_menu">Menu padre</label>
			 <select  class="form-control" name="data[menus][parent]" id="input_menu">
			  <option value="NULL">---</option>
			 <?php foreach($menus['menus'] as $menu){?>
			 <option value="<?= $menu['id']?>" <?php if($menu['id']==$control->get_data('parent')){?> selected="selected" <?php }?>><?= $menu['texto'];?></option>
			 <?php }?>
			 </select>
		 </div>
		 <div class="form-group">
			 <label for="input_tipo">Tipo</label>
			 <select  class="form-control" name="data[menus][tipo]" id="input_tipo">
			  <option value="1">Interno</option>
			  <option value="2" <?php if($control->get_data('tipo')==2){?> selected="selected" <?php }?>>Externo</option>
			 </select>
		 </div>
		 <div class="form-group">
			 <label for="input_alias">Alias</label>
			 <input  class="form-control" type="text" name="data[menus][alias]" value="<?= $control->get_data('alias');?>" id="input_alias" />
		 </div>
		 <div class="form-group">
			 <label for="input_orden">Orden</label>
			 <input  class="form-control" type="text" name="data[menus][orden]" value="<?php if(!empty($control->data['menus']['orden'])){ echo $control->get_data('orden'); }else{ echo "0";}?>" id="input_orden" />
		 </div>
		 <div class="form-group">
			 <label for="input_texto">Texto</label>
			 <input  class="form-control" type="text" name="data[menus][texto]" value="<?= $control->get_data('texto');?>" id="input_texto" />
		 </div>
		 <div class="form-group">
			 <label for="input_title">Title</label>
			 <input  class="form-control" type="text" name="data[menus][title]" value="<?= $control->get_data('title');?>" id="input_title" />
		 </div>
		 <div class="form-group">
			 <label for="input_href">Href</label>
			 <input  class="form-control" type="text" name="data[menus][href]" id="input_href" />
		 </div>
		 <div class="form-group">
			 <label for="input_articulo">articulo</label>
			 <select  class="form-control" name="data[menus][articulo]" id="input_articulo">
			  <option value="">---</option>
			 <?php foreach($articulos['articulos'] as $art){?>
			 <option value="<?= $art['alias']?>" <?php if($art['alias']==$control->get_data('alias')){?> selected="selected" <?php }?>><?= $art['titulo'];?></option>
			 <?php }?>
			 </select>
		 </div>
		
		 <input type="hidden" name="data[task]" value="add"/>
		 <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">aceptar</button>
		</form>
	</div>
</div>