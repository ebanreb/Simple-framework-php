<?php
$i=0;
$class=null;
$consulta=$res_groups;
?>
<div class="x_panel">
	<div class="x_title"><h2>Grupos Acceso</h2><div style="clear:both;"></div></div>
	<div class="x_content"><a class="btn btn-default" href="<?= ROOT;?>groups/add.html">Nuevo Grupo</a></div>
	<?php
	if($control->con->amountitems>$control->con->limit)
	   $control->showpagination();

	if($control->con->num_rows($consulta)>0){
	   echo "<div id=\"tablelist\"><table class=\"table\">";
	   while($resultados = $control->con->fetch_array_assoc($consulta)){
		
	    if($i==0){
		  echo "<thead class=\"tablehead\">";
		  foreach($resultados as $field=>$value){
		    echo "<th>".$field."</th>"; 
		  }
		  echo "<th>Acciones</th></thead>"; 
		}
		
		if($i%2)
		   $class="tablenull";
		else
		   $class="tablerow";   

	    echo "<tbody><tr id='tablerowdata' class='".$class."'>";
		  foreach($resultados as $field=>$value){
		    echo "<td>".$value."&nbsp;</td>"; 
		  }
		  echo "<td>";
	?>
	       <div id="acciones">
	           <a class="btn btn-link tooltip" title="borrar" href="javascript:;" onClick="dialog('<?= ROOT;?>groups/delete/<?= $resultados['id'];?>.html','Realmente desexa borrar este rexistro?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
	           <a class="btn btn-link tooltip" title="editar" href="<?= ROOT;?>groups/edit/<?= $resultados['id'];?>.html"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
	           <a class="btn btn-link tooltip" title="asignar permisos" href="<?= ROOT;?>groups/permisos/<?= $resultados['id'];?>.html"><i class="fa fa-key" aria-hidden="true"></i></a>
	       </div>
	<?php
		  echo "</td>";       
		echo"</tr>";
		$i=$i+1;
	  }
	   echo "</tbody></table></div>";
	}else{
	  echo "<div align='center'>";
				echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
				echo "</div>";
	}

	if($control->con->amountitems>$control->con->limit)
	   $control->showpagination();
	?>
</div>