<div class="x_panel">
  <div class="x_title"><h2><?= $indice;?>/<?= $archivo;?>.php.ini</h2><div style="clear:both;"></div></div>
  <div class="x_content"><a class="btn btn-default" href="<?= ROOT;?>textos/idioma_apartados/<?= $indice;?>.html">Archivos</a></div>
  <div id="tablelist">
    <form method="post" action="<?= ROOT?>textos/edit/<?= $indice;?>/<?= $archivo;?>.html" name="formEditarIni" accept-charset="UTF-8" >
    <table class="table">
       <thead class="tablehead"><th>Variable</th><th>Valor</th></thead>
       <tbody>
       <?php
       $i=0;
         foreach($matriz_ini as $key=>$value){ 
         if($i%2)
           $class="tablenull";
         else
           $class="tablerow";
       ?>
         <tr id="tablerowdata" class="<?= $class;?>">
           <td><?= $key;?></td>
           <td><textarea name="data[idiomas][<?=$key;?>]"><?= utf8_decode($value);?></textarea></td>
         </tr>
         <tr><td colspan="2"> <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">Enviar</button></td></tr>
       <?php
       $i++;
         }
       ?>
       </tbody>
    </table>
    <button class="btn btn-default" type="submit" name="enviar" id="btn_enviar">Enviar</button>
    </form>
  </div>
</div>