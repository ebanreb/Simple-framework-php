<div class="x_panel">
	<div class="x_title"><h2>Textos</h2><div style="clear:both;"></div></div>
	<div id="tablelist">
		<table class="table">
			<thead class="tablehead"><th>Idioma</th><th></th></thead>
			<tbody>
				<?php
				$i=0;
				foreach($idiomas['idioma'] as $idioma){
				if($i%2)
				   $class="tablenull";
				else
				   $class="tablerow";
				?>
				<tr id="tablerowdata" class="<?= $class;?>">
				   <td><?= $idioma['indice'];?></td>
				   <td><a class="btn btn-link" href="<?= ROOT;?>textos/idioma_apartados/<?= $idioma['indice'];?>.html">ver</a></td>
				</tr>
				<?php
				$i++;
				}
				?>
			</tbody>
		</table>
	</div>
</div>