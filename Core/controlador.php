<?php
class Controlador{

  //variable que establece el layaout(plantilla de pagina) a cargar por defecto
  public $layout = "index_default";

  public $thumb;
  
  //variable que instanciara un objeto del tipo phpmailer
  public $mail;

  //recoge los datos de los formularios (metodo $_POST)
  public $data = array();

  //array con las variables que se le pasaran a la vista de la accion correspondiente
  public $setvars = array();

	  //etiqueta "Siguiente" del metodo paginación
  public $label_next = "Siguiente";
  //etiqueta "Anterior" del metodo paginación
  public $label_previous= "Anterior";
  
  public $label_one = "primera";
  public $label_last = "ultima";
  
  //etiqueta "Páginas" de l metodo paginación
  public $labelpagination = "P&aacute;ginas";
  public $divclass = "paginacion"; 
  //clase CSS para los enlaces del metodo showpagination
  public $hrefclass = "a_paginacion";
  
  public $etcetera = "etcetera";
  
  public $namediv = "capa";
  public $hreftext = "activo";

  public $error = array();

  public $con;

  function __construct(){
  	  //parent::__construct();
  	  $this->con = MySQL::instance();
  }

	/*------------show pagination-------------*/
	public function showpagination(){
		    $href=ROOT.CONTROL."/".ACCION;
		     
			if($this->con->amountitems>0){
			   echo '<div class="'.$this->divclass.'">';
			   //echo '<span>'.utf8_encode($this->labelpagination).': </span>';
			   if($this->con->pagina>1){
			      //echo '<a class="'.$this->hrefclass.'" href="&pagina='.($this->pagina-1).'"> '.$this->label_previous.'</a>';
				  echo '<a class="'.$this->hrefclass.'" name="'.$this->namediv.'" href="'.$href.'/pagina/'.($this->con->home).'.html"> '.utf8_encode($this->label_one).'</a>';
				  echo '<a class="'.$this->hrefclass.'" name="'.$this->namediv.'" href="'.$href.'/pagina/'.($this->con->pagina-1).'.html"> '.utf8_encode($this->label_previous).'</a>';
			   }
			   
			   /*if($this->pagina<$this->numPages){
			      $inicio=$this->home;
				  $fin=$this->end+1;
			   }else{
			     $inicio=$this->end-2;
				 $fin=$inicio+1;
			   }*/
			   
			   /*for($i=$this->home;$i<=$this->end;$i++){
			        if($i==$this->pagina){
			            echo ' <span class="'.$this->hreftext.'">'.$i.'</span>';
			        }else{
			            //echo ' <a class="'.$this->hrefclass.'" href="&pagina='.$i.'">'.$i.'</a>';
						//echo ' <a class="'.$this->hrefclass.'" href="'.$href.'&pagina='.$i.'">'.$i.'</a>';
						echo ' <a class="'.$this->hrefclass.'" href="'.$href.'/pagina'.($i).'.html">'.$i.'</a>';
			        }
			   }*/
			   
			   $display_pages=4;//cuantas paginas a mostrar
			   
			   for($i=$this->con->pagina;$i<=$this->con->end && $i<=($this->con->pagina+$display_pages); $i++){
			        if($i==$this->con->pagina){
			            echo ' <a class="'.$this->hreftext.'">'.$i.'</a>';
			        }else{
			            //echo ' <a class="'.$this->hrefclass.'" href="&pagina='.$i.'">'.$i.'</a>';
						//echo ' <a class="'.$this->hrefclass.'" href="'.$href.'&pagina='.$i.'">'.$i.'</a>';
						echo ' <a class="'.$this->hrefclass.'" href="'.$href.'/pagina/'.($i).'.html">'.$i.'</a>';
			        }
			   }
			   
			   
			   if (($this->con->pagina+$display_pages)< $this->con->end) echo '<a class="'.$this->etcetera.'">...</a>'; //etcetera...
			   
			   if($this->con->pagina<$this->con->numPages){
			       //echo '<a class="'.$this->hrefclass.'" href="&pagina='.($this->pagina+1).'"> '.$this->label_next.'</a>';
				   echo '<a class="'.$this->hrefclass.'" name="'.$this->namediv.'" href="'.$href.'/pagina/'.($this->con->pagina+1).'.html"> '.utf8_encode($this->label_next).'</a>';
				   echo '<a class="'.$this->hrefclass.'" name="'.$this->namediv.'" href="'.$href.'/pagina/'.($this->con->end).'.html"> '.utf8_encode($this->label_last).'</a>';
			   }
			   echo "</div>";
			   echo "<div style=\"clear:both;\"></div>";
		   }
	}
	/*-----fin showpagination------------*/

	/*
	**Obtenemos valores de las variables de formulario.
	*/
	public function get_data($index=null){
	     $value='';
		 
	     if(!empty($this->data[CONTROL][$index])){
		    $value=$this->data[CONTROL][$index];
		 }
		 
		 return $value;
	}

	/*
	**reseteamos variable de recogida de datos de formulario
	*/
	public function reset_data(){
	    $this->data = array();
	}

	/*
	**Reseteamos variable de gestion de errores
	*/
	public function reset_error(){
	    $this->error = array();
	}
	  
	/*
	**Reseteamos variable de gestion de parametros pasados a la vista desde el controlador
	*/
	public function reset_vars(){
	    $this->setvars = array();
	}

	/*
	**Variables que se le pasan a la vista
	*/
	public function set($name_var=null,$value_var=null){
		 //$this->setvars[]=array($name_var,$value_var);
		$this->setvars[$name_var]=$value_var;
	}

	/*
	**convierte fecha timestamp a formato mysql
	*/  
	public function timestampFormatData($unixNumber,$type=null){
	    //return date('Y-m-d H:i:s',$unixNumber);
		if(!$type)
		   return date('Y/m/d',$unixNumber);
		else
		   return date('Y/m/d H:i:s',$unixNumber);
	}

	/*
	**convierte fecha timestamp a formato normal
	*/
	public function timestampFormat($unixNumber,$type=null){
	    //return date('Y-m-d H:i:s',$unixNumber);
		if(!$type)
		   return date('d/m/Y',$unixNumber);
		else
		   return date('d/m/Y H:i:s',$unixNumber);
	}
	 
	////////////////////////////////////////////////////
	//Convierte fecha de mysql a normal
	////////////////////////////////////////////////////
	public function cambiaf_a_normal($fecha){
	    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	    return $lafecha;
	}

	////////////////////////////////////////////////////
	//Convierte fecha de normal a mysql
	////////////////////////////////////////////////////
	public function cambiaf_a_mysql($fecha){
	    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
	    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
	    return $lafecha;
	}
	 
	/*
	**Ordenar array--(False:ASC, True:DESC)
	---------------------------------------------------------------------------------------*/
	public function orderMultiDimensionalArray ($toOrderArray, $field, $inverse = false) {
	    $position = array();
	    $newRow = array();
	    foreach ($toOrderArray as $key => $row) {
	            $position[$key]  = $row[$field];
	            $newRow[$key] = $row;
	    }
	    if ($inverse) {
	        arsort($position);
	    }
	    else {
	        asort($position);
	    }
	    $returnArray = array();
	    foreach ($position as $key => $pos) {     
	        $returnArray[] = $newRow[$key];
	    }
	    return $returnArray;
	}

	public function ordenar($orArray){
	   $order="";
		 $campo="";
	     if(!empty($_GET)){	 
			 foreach($_GET as $value){
				if(!empty($order)){
				  $campo=$value;
				  break;
				}
				if($value=='asc' || $value=='desc'){
				   $order=$value;
				}
			 }
		 }
		 
		 if(!empty($order)){//ordenamos el array priorizacion por el campo
		  
		  switch($order){
		    case 'asc':
		         if(!empty($orArray)){
			      $orArray=$this->orderMultiDimensionalArray ($orArray, $campo, $inverse = false);
				 }
				  $this->orden='desc';
			break;
			case 'desc':
		         if(!empty($orArray)){	
			      $orArray=$this->orderMultiDimensionalArray ($orArray, $campo, $inverse = true);
				 }
				  $this->orden='asc';
			break;
			
		  }//fin switch
		}else{
		  $this->orden='asc';
		}
		
		return $orArray;
	}

	/*Crea link de ordenacion*/
	public function sort_link($field=null,$text=null){
	  //echo "<a href=\"".ROOT.CONTROL."/".ACCION."/".$this->orden."/".$field.".html\">";
	  $url_aux=explode('.',$_SERVER['REQUEST_URI']);
	  $url_aux_b=explode('/',$url_aux[0]);
	  $fin=count($url_aux_b);
	  
	  if(!empty($_GET)){	 
			 foreach($_GET as $value){
				if($value=='asc' || $value=='desc'){
				   $fin=$fin-2;
				   break;
				}
			 }
	  }
		 
	  $url="";
	  
	  for($i=0;$i<$fin;$i++){
	     $url.=$url_aux_b[$i]."/";
	  }
	  
	  echo "<a href=\"".$url.$this->orden."/".$field.".html\">";
	  if(!empty($text))
	     echo $text;
	  else
	     echo ucfirst($field);
	  echo "</a>";
	}
	/*
	---------------------------------------------------------------------------------------*/

	/*
	**string_format
	*/
	public function string_format($str=null) {
		// replaces str "Hello {0}, {1}, {0}" with strings, based on
		// index in array
		$numArgs = func_num_args() - 1;
		
		if($numArgs > 0) {
			$arg_list = array_slice(func_get_args(), 1);
			
			// start after $str
			for($i=0; $i < $numArgs; $i++) {
				$str = str_replace("%" . $i, $arg_list[$i], $str);
			}
		}

		return $str;
	}

}
?>