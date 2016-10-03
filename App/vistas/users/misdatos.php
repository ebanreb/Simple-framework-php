<h2><?= $_SESSION['textos']['misdatos_user_titulo'];?></h2><br /><br />
<div id="bloque">
<div id="form_misdatos">
<form method="post" action="<?= ROOT?>users/misdatos.html" name="formMisdatos" accept-charset="UTF-8" id="fajax" class="contenido" >
<table>
<tr>
 <td><label for="input_nome"><?= $_SESSION['textos']['misdatos_user_form_nombre'];?> </label></td>
 <td><input type="text" name="data[users][nombre]" value="<?= $control->get_data('nombre');?>" id="input_nome" /></td>
</tr>
<tr>
 <td><label for="input_nome"><?= $_SESSION['textos']['misdatos_user_form_apellidos'];?> </label></td>
 <td><input type="text" name="data[users][apellidos]" value="<?= $control->get_data('apellidos');?>" id="input_apelidos" /></td>
</tr>
<tr>
 <td><label for="input_passwrod"><?= $_SESSION['textos']['misdatos_user_form_password'];?> </label></td>
 <td><input type="text" name="data[users][password]" id="input_password" /></td>
</tr>
<tr>
 <td><label for="input_passwrod2"><?= $_SESSION['textos']['misdatos_user_form_confpass'];?> </label></td>
 <td><input type="text" name="data[password2]" id="input_password2" /></td>
</tr>
<tr>
 <td><label for="input_nacimiento"><?= $_SESSION['textos']['misdatos_user_form_fecha_nacimiento'];?> </label></td>
 <td><input type="text" name="data[users][fecha_nacimiento]" readonly="readonly" onClick="popUpCalendar(this,formMisdatos.input_nacimiento, 'dd/mm/yyyy');" value="<?= $control->cambiaf_a_normal($control->get_data('fecha_nacimiento'));?>" id="input_nacimiento" /></td>
</tr>
<tr>
 <td><label for="input_email"><?= $_SESSION['textos']['misdatos_user_form_email'];?> </label></td>
 <td>
   <input type="text" name="data[users][email]" id="input_email" /><br />
   <?php Core::textA('misdatos_user_form_emailantiguo',1);?>:&nbsp;<?= $control->get_data('email');?>
 </td>
</tr>
<tr>
 <td><label for="input_email2"><?=$_SESSION['textos']['misdatos_user_form_confemail'];?> </label></td>
 <td><input type="text" name="data[email2]" id="input_email2" /></td>
</tr>
<tr>
 <td><label for="file"><?= $_SESSION['textos']['misdatos_user_form_foto'];?></label></td>
 <td><input type="file" name="file" id="file" /></td>
</tr>
<tr>
 <td></td>
 <td>
   <?php
				  if(file_exists(DOCUMENT_ROOT."images/foto_perfil/".$_SESSION['user']['id'].".jpg")){
                ?>
                    <img src="<?= ROOT;?>images/foto_perfil/<?= $_SESSION['user']['id'];?>.jpg" alt="<?= $_SESSION['user']['nombre'];?>"  width="150px" />
                <?php
				  }else{
                ?>
                    <img src="<?= ROOT;?>images/escudo_gris.png"  width="150px" />
                <?php
				  }
				 ?>
   
 </td>
</tr>
</table> 
  <input type="hidden" name="data[task]" value="edit"/>
 <button type="submit" name="enviar" id="btn_enviar"><?= $_SESSION['textos']['misdatos_user_form_enviar'];?></button>
</form>
</div>
</div>