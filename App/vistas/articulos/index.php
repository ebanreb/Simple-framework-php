<?php
$i=0;
$class=null;
?>
<div class="x_panel">
	<div class="x_title"><h2>Articulos</h2><div style="clear:both;"></div></div>
	<div class="x_content"><a class="btn btn-default" href="<?= ROOT;?>articulos/add.html">Nuevo</a></div>
	<?php
	if($control->con->amountitems>$control->con->limit)
	   $control->showpagination();
	
	if(!empty($articulos['articulo'])):
	?>
	 <div id="tablelist">
	     <table class="table">
		     <thead class=tablehead>
			     <th>id</th><th>titulo</th><th>principal</th>
			     <th>Acciones</th>
			 </thead>
			  
		     <?php 
		         foreach($articulos['articulo'] as $articulo):
			
					if($i%2)
					   $class="tablenull";
					else
					   $class="tablerow";
			 ?>
			   
		     <tbody>
		         <tr id="tablerowdata" class="<?= $class ?>">
				     <td><?= $articulo['id'] ?></td><td><?= $articulo['titulo'] ?></td>
				     <td><?php if($articulo['principal']) echo "SI"; ?></td>
				     <td>
					       <div id="acciones">
					           <a class="btn btn-link tooltip" title="borrar" href="javascript:;" onClick="dialog('<?= ROOT;?>articulos/delete/<?= $articulo['id'];?>.html','Desea borrar el articulo<?= $articulo['titulo'];?>');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					           <a class="btn btn-link tooltip" title="editar" href="<?= ROOT;?>articulos/edit/<?= $articulo['id'];?>.html"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					       </div>
					 </td>       
			     </tr>
		     <?php
			         $i=$i+1;
	             endforeach;
	         ?>
	         </tbody>
	     </table>
	 </div>
	<?php
	else:
	?>
	            <div align="center">
				     <font face="verdana" size="-2">No hay registros</font>
				</div>
	<?php
	endif;

	if($control->con->amountitems>$control->con->limit)
	   $control->showpagination();
	?>
</div>