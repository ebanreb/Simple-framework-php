<div class="x_panel">
	<div class="x_title"><h2><?= $_SESSION['textos']['add_user_titulo'];?></h2><div style="clear:both;"></div></div>
	<div id="form_nuevo_usuario">
		<form method="post" action="<?= ROOT?>users/add.html" name="formNuevoUsuario" accept-charset="UTF-8" />
			 <div class="form-group">
				 <label for="input_grupo"><?= $_SESSION['textos']['add_user_form_grupo'];?> </label>
				 <select name="data[users][groups_id]" id="input_grupo" required class="form-control">
				 <?php foreach($grupos['groups'] as $grupo){?>
				 <option value="<?= $grupo['id']?>" <?php if($grupo['id']==$control->get_data('groups_id')){?> selected="selected" <?php }?>><?= $grupo['name'];?></option>
				 <?php }?>
				 </select>
			 </div>
			 <div class="form-group">
				 <label for="input_nome"><?= $_SESSION['textos']['add_user_form_nombre'];?> </label>
				 <input class="form-control" type="text" name="data[users][nombre]" required value="<?= $control->get_data('nombre');?>" id="input_nome" />
			 </div>
			 <div class="form-group">
				 <label for="input_nome"><?= $_SESSION['textos']['add_user_form_apellidos'];?> </label>
				 <input  class="form-control" type="text" name="data[users][apellidos]" value="<?= $control->get_data('apellidos');?>" id="input_apelidos" />
			 </div>
			 <div class="form-group">
				 <label for="input_passwrod"><?= $_SESSION['textos']['add_user_form_password'];?> </label>
				 <input  class="form-control" type="text" name="data[users][password]" id="input_password" required />
			 </div>
			 <div class="form-group">
				 <label for="input_passwrod2"><?= $_SESSION['textos']['add_user_form_confpass'];?> </label>
				 <input  class="form-control" type="text" name="data[password2]" id="input_password2" required />
			 </div>
			 <div class="form-group">
				 <label for="input_email"><?= $_SESSION['textos']['add_user_form_email'];?> </label>
				 <input  class="form-control" type="email" name="data[users][email]" required value="<?= $control->get_data('email');?>" id="input_email" />
			 </div>
			 <div class="form-group">
				 <label for="input_email2"><?= $_SESSION['textos']['add_user_form_confemail'];?> </label>
				 <input  class="form-control" type="email" name="data[email2]" required id="input_email2" />
			 </div>
			 <input type="hidden" name="data[users][fecha_alta]" value="<?= $control->timestampFormatData(time(),true);?>" id="input_alta" /><br/><br/>
			 <input type="hidden" name="data[task]" value="add"/>
			 <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar"><?= $_SESSION['textos']['add_user_form_enviar'];?></button>
		</form>
	</div>
</div>