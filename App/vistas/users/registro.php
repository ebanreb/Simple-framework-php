<h2><?= $_SESSION['textos']['registro_user_titulo'];?></h2><br/>
<div id="bloque">
<div id="form_registro">
<form method="post" action="<?= ROOT?>users/registro.html" name="formRegistro" accept-charset="UTF-8" enctype="multipart/form-data" id="fajax" class="contenido">
<table>
<tr>
 <td><label for="input_nome"><?= $_SESSION['textos']['registro_user_form_nome'];?> </label></td>
 <td><input type="text" name="data[users][nombre]" value="<?= $control->get_data('nombre');?>" id="input_nome" /></td>
</tr>
<tr>
 <td><label for="input_apelidos"><?= $_SESSION['textos']['registro_user_form_apellidos'];?> </label></td>
 <td><input type="text" name="data[users][apellidos]" value="<?= $control->get_data('apellidos');?>" id="input_apelidos" /></td>
</tr>
<tr>
 <td><label for="input_passwrod"><?= $_SESSION['textos']['registro_user_form_password'];?> </label></td>
 <td><input type="text" name="data[users][password]" id="input_password" /></td>
</tr>
<tr>
 <td><label for="input_passwrod2"><?= $_SESSION['textos']['registro_user_form_confpass'];?> </label></td>
 <td><input type="text" name="data[password2]" id="input_password2" /></td>
</tr>
<tr>
 <td><label for="input_nacimiento"><?= $_SESSION['textos']['registro_user_form_fecha_nacimiento'];?> </label></td>
 <td><input type="text" name="data[users][fecha_nacimiento]" onClick="popUpCalendar(this, formRegistro.input_nacimiento, 'dd/mm/yyyy');" readonly="readonly" value="<?= $control->get_data('fecha_nacimiento');?>" id="input_nacimiento" /></td>
</tr>
<tr>
 <td><label for="input_email"><?= $_SESSION['textos']['registro_user_form_email'];?> </label></td>
 <td><input type="text" name="data[users][email]" value="<?= $control->get_data('email');?>" id="input_email" /></td>
</tr>
<tr>
 <td><label for="input_email2"><?= $_SESSION['textos']['registro_user_form_confemail'];?> </label></td>
 <td><input type="text" name="data[email2]" id="input_email2" /></td>
</tr>
<tr>
 <td><label for="file"><?= $_SESSION['textos']['registro_user_form_foto'];?></label></td>
 <td><input type="file" name="file" id="file" /></td>
</tr>
 
</table>
 <input type="hidden" name="data[users][fecha_alta]" value="<?= $control->timestampFormatData(time(),true);?>" id="input_alta" />
 <input type="hidden" name="data[task]" value="add"/>
 <button type="submit" name="enviar" id="btn_enviar"><?= $_SESSION['textos']['registro_user_form_enviar'];?></button>
</form>
</div>
</div>