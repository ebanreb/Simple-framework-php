<div id="form_login_user">
<?php if(!isset($_SESSION['user'])){?>
<form method="post" action="<?php echo ROOT?>users/login.html" name="formLoginUsuario" accept-charset="UTF-8" >
<div id="box">
 <label for="input_login">Email: </label>
 <input type="text" name="data[login]" id="input_login" />
</div>
<div id="box">
 <label for="input_password">Password: </label>
 <input type="password" name="data[password]" id="input_password" />
 <button type="submit" name="enviar" id="btn_enviar">Enviar</button>
</div> 
<div id="box">
<a href="<?php echo ROOT;?>users/registro.html" class="ajax" name="dat_contenido">Registrate!</a>
&nbsp;&nbsp;
<a href="<?php echo ROOT;?>users/nuevo_pass.html" class="ajax" name="dat_contenido">olvidaste el password?</a>
</div>
</form>
<?php }else{?>
<div id="saludo">
Hola <span><?php echo $_SESSION['user']['nombre'];?></span>&nbsp;
|&nbsp;<a href="<?php echo ROOT;?>users/misdatos.html" class="ajax" name="dat_contenido">Mis datos</a>&nbsp;
|&nbsp;<a href="<?php echo ROOT;?>users/logout.html">cerrar sesion</a>
</div>
<?php }?>
</div>