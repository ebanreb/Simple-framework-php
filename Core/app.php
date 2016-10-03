<?php

Class App{

	/**
	* @var
	*/
	private $control;

	/**
	* @var
	*/
	private $accion;

	 /**
	 * @var
	 */
	 private $mybd;

	 /**
	 * @var
	 */
	 private $acceso = false;

	 /**
	* @var
	*/
	private $params = [];

	 /**
	 * @var
	 */
	const CONTROLLERS_PATH = DOCUMENT_ROOT."App/controles/";

	public function __construct(){
        $this -> acceso = false;

		//obtenemos la url parseada
        $url = $this -> parseUrl();

        //Instancia del controlador
		if( isset($url[0]) && file_exists(self::CONTROLLERS_PATH.$url[0].".php")){       

		  if(!isset($_SESSION['user'])){//Usuarios NO REGISTRADOS en la plataforma
		              
					  //creamos una nueva instancia del control
					  $aux = ucfirst($url[0]);
					  $this -> control = new $aux(); 
					  
					  //identificamos la ACCION
					  
					  if(isset($url[1]))
					     $this -> accion = $url[1];
					  else
					  	 $this -> accion = "index";

					  //eliminamos el controlador de url, así sólo nos quedaran los parámetros del método
		              unset($url[0]);
		              //eliminamos el método de url, así sólo nos quedaran los parámetros del método
		              unset($url[1]);
		              //asociamos el resto de segmentos a $this->_params para pasarlos al método llamado, por defecto será un array vacío
		              $this -> params = $url ? array_values($url) : [];
					  
					  //recogemos la variables de formulario pasadas po metodo POST
					  if(!empty($_POST['data'])){
					     $this -> control -> reset_data();
					     $this -> control -> data = $_POST['data'];
					  }
					  
					  //comprobación de si hay permisos de acceso, para el usuario invitado, a la accion especificada 
					  if(!empty($this -> control -> permisos[$this -> accion]) || !empty($this -> control -> permisos['all'])){
						 $this -> acceso = true;    
					  }
					  
			  
		  }elseif( Core::checkSession() ){
		     //Usuarios REGISTRADOS en la plataforma
		     
			 //identificamos la ACCION
			 if(isset($url[1]))
			     $this -> accion = $url[1];
			 else
			  	$this -> accion = "index";
			 
			 //creamos una nueva instancia del control
			 $aux = ucfirst($url[0]);
			 $this -> control = new $aux();
			 
			 //marcamos inicio de transaccion para las operaciones de Insercion,Modificacion y eliminacion de registros sobre la BD.
			 //$control->inicio_transaccion();

			 //eliminamos el controlador de url, así sólo nos quedaran los parámetros del método
		     unset($url[0]);
		     //eliminamos el método de url, así sólo nos quedaran los parámetros del método
		     unset($url[1]);
		     //asociamos el resto de segmentos a $this->_params para pasarlos al método llamado, por defecto será un array vacío
		     $this -> params = $url ? array_values($url) : [];
			 
			 //recogemos la variables de formulario pasadas por metodo POST
			 if(!empty($_POST['data'])){
			    $this -> control -> reset_data();
			    $this -> control -> data = $_POST['data'];
			}

			 $this -> mybd = MySQL::instance();
						 
			 $consulta_id_accion=$this -> mybd -> consulta("SELECT id FROM con_ac WHERE alias='".$this -> accion."'");
			 $id_accion = $this -> mybd -> fetch_array_assoc($consulta_id_accion);
			 
			 $consulta_id_control=$this -> mybd -> consulta("SELECT id FROM con_ac WHERE alias='".get_class($this -> control)."'");
			 $id_control = $this -> mybd -> fetch_array_assoc($consulta_id_control);
			 
			 $consulta_acceso_accion_users = $this -> mybd -> consulta("SELECT acceso FROM acces_users WHERE con_ac_id='".$id_accion['id']."' AND users_id='".$_SESSION['user']['id']."'");
			 
			 $consulta_acceso_control_users = $this -> mybd -> consulta("SELECT acceso FROM acces_users WHERE con_ac_id='".$id_control['id']."' AND users_id='".$_SESSION['user']['id']."'");
			 
			 $consulta_acceso_accion_groups = $this -> mybd-> consulta("SELECT acceso FROM acces_groups WHERE con_ac_id='".$id_accion['id']."' AND groups_id='".$_SESSION['user']['groups_id']."'");
			 
			 $consulta_acceso_control_groups = $this -> mybd -> consulta("SELECT acceso FROM acces_groups WHERE con_ac_id='".$id_control['id']."' AND groups_id='".$_SESSION['user']['groups_id']."'");
			 
			 //si tiene permisos acceso por defecto a la accion especificada
			 if(!empty($this -> control -> permisos['all']) || !empty($this -> control->permisos[$this -> accion])){

			     $this -> acceso = true;
			     
			 }elseif($this -> mybd -> num_rows($consulta_acceso_accion_users)){//si existen permisos para accion/usuario->tabla acces_users
			         
			         $acceso_accion_users = $this -> mybd -> fetch_array_assoc($consulta_acceso_accion_users);
				
					 if($acceso_accion_users['acceso']){//si acceso permitido
					   
					     $this -> acceso = true;
					   
					 }
					
			 }elseif($this -> mybd -> num_rows($consulta_acceso_control_users)){//no existen permisos para accion/usuario pero si para control/usuario->tabla acces_users
			         
			         $acceso_control_users = $this -> mybd -> fetch_array_assoc($consulta_acceso_control_users);
				
					 if($acceso_control_users['acceso']){//si acceso permitido
					   
					     $this -> acceso = true;
					   
					 }
						
			 }elseif($this -> mybd -> num_rows($consulta_acceso_accion_groups)){//si el grupo al que pertenece el usuario tiene definido permisos para esa accion->tabla acces_groups
			          
					 $acceso_accion_groups = $this -> mybd -> fetch_array_assoc($consulta_acceso_accion_groups);
				
					 if($acceso_accion_groups['acceso']){//si grupo de usuario registrado tiene permisos de acceso
					   
						 $this -> acceso = true;
					   
					 }
					  
			 }elseif($this -> mybd -> num_rows($consulta_acceso_control_groups)){//si el grupo al que pertenece el usuario tiene permisos para el control control->table acces_groups
			      
				     $acceso_control_groups=$this -> mybd -> fetch_array_assoc($consulta_acceso_control_groups);
				
				     if($acceso_control_groups['acceso']){
  
						 $this -> acceso = true;
						   
					 }
			 
			 }
			 
		  }
		  //FIN Usuarios REGISTRADOS en la plataforma

		}else{
			   
			   if(!isset($url[0])){
		          $aux = ucfirst(ROUT);
				  $this -> control = new $aux(); 
				  
				  //identificamos la ACCION
				  $this -> accion = ROUT_INI;
				  
				  //recogemos la variables de formulario pasadas po metodo POST
				  if(!empty($_POST['data'])){
				     $this -> control -> reset_data();
				     $this -> control -> data = $_POST['data'];
				  }

				  $this -> acceso = true;
				  
			   }else{
			   	 include DOCUMENT_ROOT . "App/vistas/errores/404.php";
		         exit;
			   }
				
		}
	}

	/**
	 * [parseUrl Parseamos la url en trozos]
	 * @return [type] [description]
	 */
	public function parseUrl()
	{
	    if(isset($_GET["url"]))
	    {
	        return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));    
	    }
	}

	/**
     * [render  lanzamos el controlador/accion que se ha llamado con los parámetros]
     */
    public function render()
    {
        if($this -> acceso){
             
             define('CONTROL',strtolower(get_class($this -> control)));
             define('ACCION',$this -> accion);
             
             call_user_func_array([$this->control, $this->accion], $this->params);
             
        }else{//en caso de no tener ningun tipo de permiso a la accion o control especificados
			 
			 Core::mensaje("No tiene permiso de acceso esa secci&oacute;n.");
			 Core::redireccion(URL);
		}
        
    }

    /**
     * [vista]
     */
    public function vista()
    {
        if(!isset($_GET['service'])){

		     if(!file_exists(DOCUMENT_ROOT."App/plantillas/".$this->control->layout.".php"))
		     {
		        throw new Exception("Error: El archivo " . "App/plantillas/".$this -> control -> layout.".php" . " no existe", 1);
		     }
                $this -> control -> set('control', $this -> control);
		        ob_start();
		        //Las variables que se le pasan a la vista
				//-----------------------------------------
				if(!empty($this -> control -> setvars)){
					//extract — Importar variables a la tabla de símbolos actual desde un array
					extract($this -> control -> setvars);
				}
		        require_once(DOCUMENT_ROOT."App/plantillas/".$this -> control->layout.".php");
		        $str = ob_get_contents();
		        ob_end_clean();
		        echo $str;

		        //Reseteamos la variables que se le pasan a la vista
			    $this -> control -> reset_vars();
			    $this -> control -> reset_error();
		}
    }

	/**
     * [getController Devolvemos el controlador actual]
     * @return [type] [String]
     */
    public function getControl()
    {
        return $this->control;
    }
 
    /**
     * [getMethod Devolvemos el método actual]
     * @return [type] [String]
     */
    public function getAccion()
    {
        return $this->accion;
    }

	function __destruct() {
       
    }

}

?>