<?php
$visitas=Core::getmodulo("users","_contador");
?>
<div id="contador_visitas"><span class="negrita">Visitas:&nbsp;</span><span><?= $visitas;?></span></div>