<?php
class Portada extends Controlador{
   
   public $permisos= array('all' => true);
   
   public function inicio(){
      $this->layout="index_inicio";
	  
   }
   
}
?>