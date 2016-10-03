<div class="x_panel">
  <div class="x_title"><h2>Menús</h2><div style="clear:both;"></div></div>
  <div class="x_content"><a class="btn btn-default" href="<?= ROOT;?>menus/add.html">Nuevo</a></div>
  <form method="post" action="<?= ROOT?>menus/index.html" name="formIndexMenu" accept-charset="UTF-8" />
  <div style="clear:both;"></div>
  <div id="index_menus">
    <ul id="principal">
    <?php
    if(!empty($menu_principal)){
    foreach($menu_principal as $menu){
    ?> 
       <li id="padre"><a href="<?= ROOT;?>menus/edit/<?= $menu['parent']['id'];?>.html"><?= $menu['parent']['texto'];?></a>
       <a class="btn btn-default borrarMenu" href="javascript:;" onClick="dialog('<?= ROOT;?>menus/delete/<?= $menu['parent']['id'];?>.html','¿Desea continuar con el borrado de <?= $menu['parent']['texto'];?>?');">borrar</a>
       <input type="hidden" name="data[menu][<?= $menu['parent']['id'];?>][menuId]" value="<?= $menu['parent']['id'];?>" />
       <input type="text" name="data[menu][<?= $menu['parent']['id'];?>][menuOrden]" value="<?= $menu['parent']['orden'];?>" />
       <button  class="btn btn-default" type="submit" name="enviar" id="btn_enviar">ordenar</button>
    <?php
        if(!empty($menu['childs'])){
    ?>
        <ul id="childs">
    <?php
         foreach($menu['childs'] as $child){
    ?>
          <li>
    	     <a href="<?= ROOT;?>menus/edit/<?= $child['id'];?>.html"><?= $child['texto'];?></a>
    		   <input type="hidden" name="data[menu][<?= $child['id'];?>][menuId]" value="<?= $child['id'];?>" />
    		   <input type="text" name="data[menu][<?= $child['id'];?>][menuOrden]" value="<?= $child['orden'];?>" />
           <a class="btn btn-default borrarMenu" href="javascript:;" onClick="dialog('<?= ROOT;?>menus/delete/<?= $child['id'];?>.html','¿Desea continuar con el borrado de <?= $child['texto'];?>?');">borrar</a>
           <div style="clear:both;"></div>
    	  </li>
    <?php
         }
    ?>
        </ul>
    	</li>
    <?php
       }
    	
     }
     
    }else{
    ?>
    <li>No hay registros.</li>
    <?php
    }
    ?>
    </ul>
  </div>
  </form>
</div>