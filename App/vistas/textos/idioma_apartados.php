<div class="x_panel">
	<div class="x_title"><h2>Archivos</h2><div style="clear:both;"></div></div>
	<div id="tablelist">
		<table class="table">
			<thead class="tablehead"><th>Archivo</th><th></th></thead>
			<tbody>
			<?php
			$i=0;
			foreach($archivos['archivo'] as $archivo){
			if($i%2)
			   $class="tablenull";
			else
			   $class="tablerow";
			?>
			<tr id="tablerowdata" class="<?= $class;?>">
			   <td><?= $archivo['indice'];?></td>
			   <td><a class="btn btn-link" href="<?= ROOT;?>textos/edit/<?= $directorio;?>/<?= $archivo['indice'];?>.html"><?= $archivo['file'];?></a></td>
			</tr>
			<?php
			$i++;
			}
			?>
			</tbody>
		</table>
	</div>
</div>