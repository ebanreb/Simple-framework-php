<div class="x_panel">
	<div class="x_title"><h2>Permisos del grupo: <?= $el_grupo['name'];?></h2><div style="clear:both;"></div></div>
	<div id="form_permisos_grupo">
	<form method="post" action="<?= ROOT?>groups/permisos/<?= $el_grupo['id'];?>.html" name="formPermisosGrupo" />
		<?php
		$i=0;
		foreach($r_con as $con){
		?> 
		<div class="permiso_con">
		<input type="hidden" name="data[groups][<?= $i;?>][groups_id]" value="<?= $el_grupo['id']?>" />
		<input type="hidden" name="data[groups][<?= $i;?>][con_ac_id]" value="<?= $con['id']?>" />
		<span style="text-decoration:underline;color:#003300;font-weight:bold;"><?= $con['alias'];?>:</span>
		  <div class="checkbox">
			  <input id="<?= $con['alias'];?>_si" type="checkbox" name="data[groups][<?= $i;?>][acceso]" <?php if($con['acceso']==1){?> checked="checked" <?php } ?> value="1"/>
			  <label class="especial" for="<?= $con['alias'];?>_si">si</label>
			  <input id="<?= $con['alias'];?>_no" type="checkbox" name="data[groups][<?= $i;?>][acceso]" <?php if($con['acceso']==-1){?> checked="checked" <?php } ?> value="-1"/>
			  <label class="especial" for="<?= $con['alias'];?>_no">no</label>
		  </div>
		</div>
		<div class="permiso_con_ac">
		<?php
		foreach($con['acciones'] as $ac){
		$i++;
		?>
		<input type="hidden" name="data[groups][<?= $i;?>][groups_id]" value="<?= $el_grupo['id']?>" />
		<input type="hidden" name="data[groups][<?= $i;?>][con_ac_id]" value="<?= $ac['id']?>" />
		<span style="text-decoration:underline;color:#009900;"><?php echo $ac['alias'];?>:</span>
            <div class="checkbox">
				<input id="<?= $con['alias'].$ac['alias'];?>_si" type="checkbox" name="data[groups][<?= $i;?>][acceso]" <?php if($ac['acceso']==1){?> checked="checked" <?php } ?> value="1"/>
				<label class="especial" for="<?= $con['alias'].$ac['alias'];?>_si">si</label>
				<input id="<?= $con['alias'].$ac['alias'];?>_no" type="checkbox" name="data[groups][<?= $i;?>][acceso]" <?php if($ac['acceso']==-1){?> checked="checked" <?php } ?> value="-1"/>
				<label class="especial" for="<?= $con['alias'].$ac['alias'];?>_no">no</label>
			</div>
		<?php
		}
		?>
		</div>
		<br /><br />
		<?php
		$i++;
		}
		?>
		<div class="x_content"><button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">Enviar</button></div>
	</form>
	</div>
</div>