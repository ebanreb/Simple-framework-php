<?php
class Acl extends Controlador{
  /*var $mybd;*/
  /*Control de acceso*/

  /*public function Acl($bd=null){
    $this->mybd=new MySQL(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  }*/
  
  
  public $permisos= array('all' => true);
  
  public function index(){ 
  }
  
  public function con_ac(){
      $controler=$this->_read_dir();
	  //$this->del('con_ac','WHERE 1');
	  foreach($controler as $cont){
	     $data_con['con']['alias']=$cont;
		 
		 $consulta=$this->con->find('con_ac',null,
		                       array('conditions'=>array('alias'=>$cont,'parent_id IS NULL'))
		                      );
		 
		 if(!$this->con->num_rows($consulta)){
	     $this->con->fields=$data_con['con'];
	     $id=$this->con->insert('con_ac');
		 }else{
		   $res=$this->con->fetch_array_assoc($consulta);
		   $id=$res['id'];
		 }
		 
		 $data_ac['acc']['parent_id']=$id;
		 $acciones=get_class_methods($cont);
		 $acciones_b=get_class_methods('MySQL');
		 
		 foreach($acciones as $acc){
		   $sw=0;
		   foreach($acciones_b as $acc_b){
		      if($acc==$acc_b){
			     $sw=1;
				 break;
			  }
		   }
		   
		   $sub_consulta=$this->con->find('con_ac',null,
		                       array('conditions'=>array('alias'=>$acc,'parent_id'=>$id))
		                      );
		   
		   if(!$sw && !$this->con->num_rows($sub_consulta) && $acc[0]!='_'){
		    $data_ac['acc']['alias']=$acc;
		    $this->con->fields=$data_ac['acc'];
 	        $this->con->insert('con_ac');
		   }
		 }//fin foreach accion
		 
	  }//fin foreach control
  }
  
  public function initacces(){
     $this->con->del('acces_groups','WHERE groups_id=1');
	 $resultado=$this->con->consulta("SELECT id FROM con_ac WHERE parent_id IS NULL");
	 $data['permisos']['groups_id']=1;
	 while($fila=$this->con->fetch_array_assoc($resultado)){
	    $data['permisos']['con_ac_id']=$fila['id'];
		$data['permisos']['acceso']=1;
		$this->con->fields=$data['permisos'];
 	    $this->con->insert('acces_groups');
	 }
  }
  
  function _read_dir(){
         $ru="App/controles/";
         
         if($fich2=opendir($ru))
		 {
		   while($file=readdir($fich2)) 
			{ 
			  if($file!="." && $file!=".." && $file!='Thumbs.db')
				{ 
				  $control_aux=explode(".",$file);
				  if($control_aux[count($control_aux)-1]=="php")
				     $control[]=$control_aux[0];
				}
			}//fin while
		   closedir($fich2);
		 }
		 
		 return $control;
  }
  
  
}
?>