<?php
/*
GU�A PASO A PASO PARA SOLUCIONAR EL PROBLEMA DE LOS ACENTOS Y E�ES

1.- Al crear la base de datos MySQL, aseg�rate que los campos string y dem�s esten en utf8_spanish_ci y el cotejamiento de las tablas en
utf_unicode_ci (m�s tarde en Operations > Collation de phpMyAdmin se puede cambiar)

2.- Pon en el <head>de todos los archivos HTML:
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

3.- Y en los puramente PHP (que muestran XML, llamadas de AJAX, APIs�) pon el c�digo:
header("Content-Type: text/html;charset=utf-8");

4.- Al crear la conexi�n de PHP con MySQL, env�a esta consulta justo tras la conexi�n:
mysql_query("SET NAMES 'utf8'");
(Para MySQLi escribe $acentos = $db->query("SET NAMES 'utf8'"); gracias Fernando)

5.- Quita el DefaultCharset del Apache o modif�calo

6.- Como �ltima y desesperada opci�n, quita todos los htmlentities(); y sustit�yelo por otro parser para �sanitizar� los datos.
*/
class MySQL{
  //variable de conexion con la Base de datos
  private $conexion;

  private static $_instance;
  
  private $total_consultas;

  public $use_charset = DB_CHARSET;
  
  //varable paginaci�n que marca el n�mero m�ximo de registros por pagina 
  public $limit = 15;
  //variable de paginaci�n; recoge el n�mero de registros que retorna la consulta 
  public $amountitems = 0;
  
  public $pagina = 1;
  public $numPages = 0;
  public $home = 0;
  public $end = 0;
  public $orden = 'asc';
  
  public $t_error = 0;
  
  //array que recoge los datos que se insertaran o modificaran en la BD
  public $fields = array();

  public $model = null;
  
/*-----Inicio de funcion MySQL-conexion con la base de datos---------------*/
private function __construct() {
	   
	   if(!isset($this->conexion)){  
		  
		    try {
			  // Nombre de host: 127.0.0.1, nombre de usuario: tu_usuario, contrase�a: tu_contrase�a, bd: sakila
			  $this->conexion = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
              
              if(!empty($this -> use_charset))
			     $this->conexion->set_charset($this -> use_charset);

			  //$this->core=new Core();
			  $this->mail = new phpmailer(true);
			  //$this->mail->PluginDir  
			} catch (Exception $e) {
			   die("Lo sentimos, no se pudo conectar");
			  //die("No se pudo conectar: " . $e->getMessage());
			  // �Oh, no! Existe un error 'connect_errno', fallando as� el intento de conexi�n
			  //if ($this->conexion->connect_errno) {
				    // La conexi�n fall�. �Que vamos a hacer? 
				    // Se podr�a contactar con uno mismo (�email?), registrar el error, mostrar una bonita p�gina, etc.
				    // No se debe revelar informaci�n delicada

				    // Probemos esto:
				    //echo "Lo sentimos, este sitio web est� experimentando problemas.";

				    // Algo que no se deber�a de hacer en un sitio p�blico, aunque este ejemplo lo mostrar�
				    // de todas formas, es imprimir informaci�n relacionada con errores de MySQL -- se podr�a registrar
				    //echo "Error: Fallo al conectarse a MySQL debido a: \n";
				    //echo "Errno: " . $mysqli->connect_errno . "\n";
				    //echo "Error: " . $mysqli->connect_error . "\n";
				    
				    // Podr�a ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
				    //exit;
			    //}
			}

	   }

}
/*----Fin de funcion MySQL--------------------*/

 /**
 * [instance singleton]
 * @return [object] [class database]
 */
public static function instance()
{
    if (!isset(self::$_instance))
    {
        $class = __CLASS__;
        self::$_instance = new $class;
    }
    return self::$_instance;
}
   
/*-----------inicio de funcion consulta-------*/
public function consulta($consulta){
     try {
       	
       	$resultado = $this->conexion->query($consulta);
       	$this->total_consultas++;
       	return $resultado; 

     } catch (Exception $e) {
       	
       	$this->t_error=1;
	      // �Oh, no! La consulta fall�. 
	    echo "Lo sentimos, este sitio web est� experimentando problemas.";
	    //echo "Fallo: " . $e->getMessage();

	    // De nuevo, no hacer esto en un sitio p�blico, aunque nosotros mostraremos
	    // c�mo obtener informaci�n del error
	    //echo "Error: La ejecuci�n de la consulta fall� debido a: \n";
	    //echo "Query: " . $sql . "\n";
	    //echo "Errno: " . $mysqli->errno . "\n";
	    //echo "Error: " . $mysqli->error . "\n";
	    exit;

     }  
       
   
     /*if(!$resultado){

     	
     }*/
     
       
}
/*-----------fin de funcion consulta-------*/


/*
**Retorna un array de objetos con todos los resultados debueltor po la consulta
*/
public function object_array_list($consulta=null,$model=null){
  $obj = null;
  $class = $model;
  while($fila=$this->fetch_object($consulta,$class)){
	    $obj[] = $fila;
	 }
  return $obj;
}

/*
**Retorna un array con todos los resultados debueltor po la consulta
*/
public function array_list($consulta=null){
  //$obj = null;
  //get_class($this);
  $to_array=array();
  while($fila=$this->fetch_array_assoc($consulta)){
	    $to_array[]=$fila;
	 }
  return $to_array;
}
 
/*--------Inicio de funcion paginacion-------*/
public function pagination($table=null,$consulta=null,$limit=null,$fields=null,$condiciones=null,$joins=null,$order=null,$tipoOrden=null){
      
	  //-->Campos a seleccionar
	  $f = "";
	  //-->Clausulas condicionales AND
	  $c = "";
	  //-->Clausulas condicionales OR
	  $o = "";
	  
	  if(!empty($fields)){
	   foreach($fields['fields'] as $field){
	    $f.= ($f!=""?", ":"").$field;
	   }
	  }else{
	    $f='*';
	  }
	  
	  /*Clausualas AND*/
	  if(!empty($condiciones['conditions'])){
	   foreach($condiciones['conditions'] as $condicion=>$value){
	     if(!empty($value) or $value==0)
	        $c.= ($c!=""?"AND ":"").$condicion." = '".$this->conexion->real_escape_string($value)."'";
		 else
		    $c.= ($c!=""?"AND ":"").$condicion." IS NULL";
	   }
	  }else{
	    $c=' 1';
	  }
	  
	 /*Clausulas OR*/
	 if(!empty($condiciones['or'])){
	     foreach($condiciones['or'] as $condicion=>$value){
		    if($condicion=='conditions'){
			  $c.= ($c!=""?" OR ( ":"");
			  //print_r($condiciones['or'][$condicion]);
			  foreach($condiciones['or'][$condicion] as $con=>$val){
			     if(!empty($val) or $val==0)
			        $o.= ($o!=""?" AND ":"").$con." = '".$this->conexion->real_escape_string($val)."'";
				 else
				    $o.= ($o!=""?" AND ":"").$con." IS NULL";
			  }
			  $c.=$o.") ";
			}else{
			   if(!empty($value) or $value==0)
			      $c.= ($c!=""?"OR ":"").$condicion." = '".$this->conexion->real_escape_string($value)."'";
			   else
			      $c.= ($c!=""?"OR ":"").$condicion." IS NULL";	
			}
	     }
	 }
	  
	 /*Clausulas INNER JOIN*/
	 if(!empty($joins)){
	    foreach($joins as $join){
	     $table.=" INNER JOIN ".$join['table']." ON ".$join['on'];
	   }
	 }
	 
	 /*ORDER BY*/
	  if(!empty($order)){
	    $or="";
	    $c.=" ORDER BY ";
	    foreach($order['order'] as $key=>$value){
	      $or.=($or!=""?", ":"").$key;
	   }
	   $c.=$or;
	   !empty($tipoOrden)? $c.=" ".$tipoOrden :"";
	  }
	 
	 
     if(!empty($limit))
	     $this->limit=$limit;
	 
	 if(empty($consulta)){
	   //$consulta="SELECT * FROM ".$table;
	   $consulta="SELECT ".$f." FROM ".$table." WHERE ".$c;
	 }
	 
	 $numeroRegistros=$this->num_rows($this->consulta($consulta));
	 $this->amountitems=$numeroRegistros;
	 /*----------------------------------------*/
	    if($numeroRegistros>0)
		{
	    	//////////calculo de elementos necesarios para paginacion
			//tama�o de la pagina
			$tamPag=$this->limit;
		
			//pagina actual si no esta definida y limites
			if(!isset($_GET["pagina"]))
			{
			   $this->pagina=1;
			   $inicio=1;
			   $final=$tamPag;
			}else{
			   $this->pagina = $_GET["pagina"];
			}
			//calculo del limite inferior
			$limitInf=($this->pagina-1)*$tamPag;
		
			//calculo del numero de paginas
			$numPags=ceil($numeroRegistros/$tamPag);
			$this->numPages=$numPags;
			if(!isset($this->pagina))
			{
			   $this->pagina=1;
			   $inicio=1;
			   $final=$tamPag;
			}else{
			   $seccionActual=intval(($this->pagina-1)/$tamPag);
			   $inicio=($seccionActual*$tamPag)+1;
		
			   if($this->pagina<$numPags)
			   {
				  $final=$inicio+$tamPag-1;
			   }else{
				  $final=$numPags;
			   }
		
			   if ($final>$numPags){
				  $final=$numPags;
			   }
			}
			$this->home = $inicio;
			$this->end = $final;

      $consulta.=" LIMIT ".$limitInf.",".$tamPag;
	 /*-----------------fin de dicho calculo-----------------------*/
   }
       //////////creacion de la consulta con limites
	  //echo $consulta;
	  return $this->consulta($consulta);
	  
     //////////fin consulta con limites
}
/*--------------Fin de funcion paginacion---------*/
   
/*Function Find
----------------------------------------------------------------------------*/
public function find($table=null,$fields=null,$condiciones=null,$joins=null,$order=null,$tipoOrden=null){

      //-->Campos que se seleccionan de la tabla
	  $f = "";
	  //-->Clausulas condicionales AND
	  $c = "";
	  //-->Clausulas condicionalses OR
	  $o = "";
	  
	  if(!empty($fields)){
	  
	   foreach($fields['fields'] as $field){
	    $f.= ($f!=""?", ":"").$field;
	   }
	   
	  }else{
	    $f='*';
	  }
	  
	  /*Clausualas AND*/
	  if(!empty($condiciones['conditions'])){
	   foreach($condiciones['conditions'] as $condicion=>$value){
	     if(empty($condicion)){
		   $c.= ($c!=""?" AND ":"").$value;
		 }elseif(!empty($value) or $value==0)
	        $c.= ($c!=""?" AND ":"").$condicion." = '".$this->conexion->real_escape_string($value)."'";
		 else
		    $c.= ($c!=""?" AND ":"").$condicion." IS NULL";
	   }
	  }else{
	    $c=' 1';
	  }
	  
	  /*Clausulas OR*/
	  if(!empty($condiciones['or'])){
	     foreach($condiciones['or'] as $condicion=>$value){
		    if($condicion=='conditions'){
			  $c.= ($c!=""?" OR ( ":"");
			  //print_r($condiciones['or'][$condicion]);
			  foreach($condiciones['or'][$condicion] as $con=>$val){
			     if(!empty($val) or $val==0)
			        $o.= ($o!=""?" AND ":"").$con." = '".$this->conexion->real_escape_string($val)."'";
				 else
				    $o.= ($o!=""?" AND ":"").$con." IS NULL";
			  }
			  $c.=$o.") ";
			}else{
			   if(!empty($value) or $value==0)
			      $c.= ($c!=""?"OR ":"").$condicion." = '".$this->conexion->real_escape_string($value)."'";
			   else
			      $c.= ($c!=""?"OR ":"").$condicion." IS NULL";	
			}
	     }
	  }
	  
	  /*Clausulas INNER JOIN*/
	  if(!empty($joins)){
	    foreach($joins as $join){
	     $table.=" INNER JOIN ".$join['table']." ON ".$join['on'];
	   }
	  }
	  
	 /*ORDER BY*/
	  if(!empty($order)){
	    $or="";
	    $c.=" ORDER BY ";
	    foreach($order['order'] as $key=>$value){
	      $or.=($or!=""?", ":"").$key;
	   }
	   $c.=$or;
	   !empty($tipoOrden)? $c.=" ".$tipoOrden :"";
	  }
      
	  $sql="SELECT ".$f." FROM ".$table." WHERE ".$c;
	  //echo $sql;
	  
	 return $this->consulta($sql);
}
/*FIN Function FIND
--------------------------------------------------------------------*/
  
/*
-----------------------------------------------
**Inicio funcion insert
**Introduce nuevos registros en la base de datos
------------------------------------------------
*/
public function insert($table){
    //-->campos a insertar
	$f = "";
	//-->valores a  insertar
	$v = "";
	reset($this->fields);
	foreach($this->fields as $field=>$value){
	  $f.= ($f!=""?", ":"").$field;
	  $v.= ($v!=""?", ":"")."'".$this->conexion->real_escape_string($value)."'";
	}
	
	$sql = "INSERT INTO ".$table." (".$f.") VALUES (".$v.")";
	//echo "SQL:".$sql;
	$this->consulta($sql);
	return $this->insert_id();
}/*----fin de funcion insert-----*/
 
/*
---------------------------------------------------------
**Inicio de funcion update
**Modifica los registros de una tabla de la Base de datos
----------------------------------------------------------
*/ 
public function update($table, $where){
    //-->Campos de la tabla a modificar
	$f = "";
	reset($this->fields);
	foreach($this->fields as $field=>$value){
	   $f.= ($f!=""?", ":"").$field." = '".$this->conexion->real_escape_string($value)."' ";
	}
	
	$sql = "UPDATE ".$table." SET ".$f." ".$where;
	//echo $sql;
	return $this->consulta($sql);
}
/*---Fin de funcion update-------*/
  
/*
------------------------------------------------------------------
**Inicio funcion delete
**Elimina los registros de una tabla especifica de la base de datos
-------------------------------------------------------------------
*/
public function del($table, $where){
	$sql = "DELETE FROM ".$table." ".$where;
	return $this->consulta($sql);
}
/*---Fin funcion delete-----*/
  
/*
**Reseteamos variable de consultas SQL
*/  
public function reset(){
    $this->fields = array();
}
  
/*
**Se cierrra la conexion con la Base de datos
*/
public function close_mysql(){
    $this->conexion->close();
} 
    
public function fetch_array($consulta){   
    return $consulta->fetch_array();  
}

  
public function fetch_array_assoc($consulta){
    return $consulta->fetch_assoc();
}

public function fetch_object($consulta,$obj=null){
	if(!empty($obj))
       return $consulta->fetch_object($obj);
    else
       return $consulta->fetch_object();
}

/*
**Numero de  filas retornadas por una consulta
*/    
public function num_rows($consulta){   
    return $consulta->num_rows;  
}

    
public function getTotalConsultas(){  
    return $this->total_consultas;  
}

/*
**Retorna el valor de id del ultimo registro insetado
*/  
public function insert_id(){
    return $this->conexion->insert_id;
}

/*
**Retorna el numero de filas afectadas por la operacion realizada sobre la Base de datos(insert, update, delete)
*/  
public function affected_rows(){
    return $this->conexion->affected_rows; 
}

/*
**Se da inicio a la transacci�n
*/  
public function ini_transac(){
    
    	//$this->conexion->begin_transaction(MYSQLI_TRANS_START_READ_ONLY); //Comienza una transacci�n. Requiere MySQL 5.6 y superior, y el motor InnoDB 
	    $this->conexion->autocommit(FALSE);   
}
  
/*
**finalizamos la transaccion: si correcta=>COMMIT si error=>ROLLBACK
*/
public function transac_commint(){

	$this->conexion->commit();

}

public function transac_rollback(){
	
    $this->conexion->rollback();
    
	$this->t_error=0;
}

public function set_use_charset($chs = null){
	$this -> use_charset = $chs;
}
  


function __destruct() {
       $this -> close_mysql();
   }

}

?>