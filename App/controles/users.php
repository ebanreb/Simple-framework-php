<?php
class Users extends Controlador{
  
  /*Control de acceso
  *public $permisos= array('all' => true); Acceso total.
  -------------------------------------*/
  
  public $permisos= array('login' => true,'password' => true,'nuevo_pass'=>true,'registro'=>true,'admin'=>true,'verificacion'=>true);
  
  public function index(){
    $this->layout="index_admin";
	
    $limit=15;
    $consulta = $this->con->pagination("users",null,$limit);
	$this->set('res_users',$consulta);
  }
  
  /*
  **Add
  */
  public function add(){
     $this->layout="index_admin";
	 
	 if(!empty($this->data)){//*
	 
	    if(!$this->_validausuario()){//**
		  $cadena = '';
		  foreach($this->error as $mensaje){
				  $cadena.=$mensaje."<br>";
		  }
		  $cadena = $_SESSION['textos']['error_datos']."<br><div style='padding-left:20px;'>".$cadena."</div>";
		  Core::mensaje($cadena."<br><br>");
	  
       }else{
	       $verificationCode = $this -> _getToken(6);
		   if(!empty($this->data['users']['password'])){
		     $this->data['users']['password']=md5($this->data['users']['password']);
		   }
		   
		   $this->data['users']['fecha_nacimiento']=$this->cambiaf_a_mysql($this->data['users']['fecha_nacimiento']);
		   $this->data['users']['codigo_verificacion'] = $verificationCode;
		   
		   $this->con->fields=$this->data['users'];
		   if($this->con->insert("users")){
		      $men=$_SESSION['textos']['add_user_ok'];
			   
			   if(!empty($_FILES["file"]["name"])){
			           if(move_uploaded_file($_FILES["file"]["tmp_name"],DOCUMENT_ROOT."images/foto_perfil/" . $this->con->insert_id().".jpg"));
			           else{
				            $men.=$_SESSION['textos']['add_user_foto_error'];
			           }
			   }
			   
			   //if(!$this->_mailavisocuenta($this->insert_id(),$this->data['users']['email'],$this->data['users']['nome'])){
			   if(!$this->_enviarEmailVerificacion($this->data['users']['email'],$verificationCode)){
			     $men.="<br/><br/>".$this->string_format($_SESSION['textos']['add_user_mail_error'], $this->data['users']['email']);
				 $men.="<br/>".$mail->ErrorInfo;
			   }
			   Core::mensaje($men);
			   Core::redireccion("users/index.html");
		   }else{
		       Core::mensaje($_SESSION['textos']['add_user_error']);
			   //Core::redireccion("users/add.html");
		   }
		   
	   }//**
	   
	 }//*
	 
		 $consulta=$this->con->find('groups',array('fields'=>array('id,name')));
		 while($fila=$this->con->fetch_array_assoc($consulta)){
			  $grupos['groups'][]=array('id'=>$fila['id'],'name'=>$fila['name']);
		 }
		 $this->set('grupos',$grupos);
	 
  }
  
  /*
  **Edit
  */
  public function edit($id=null){
     $this->layout="index_admin";
	 
	 if (!$id) {
			Core::mensaje($_SESSION['textos']['edit_user_id_error']);
			Core::redireccion("users/index.html");
	 }else{
	 
	      if(!empty($this->data)){//*
		     
			  if(!$this->_validausuario()){//**
				  $cadena = '';
				  foreach($this->error as $mensaje){
						  $cadena.=$mensaje."<br>";
				  }
				   $cadena = $_SESSION['textos']['error_datos']."<br><div style='padding-left:20px;'>".$cadena."</div>";
				  Core::mensaje($cadena."<br><br>");
			  
			   }else{
			   
				   if(!empty($this->data['users']['password'])){
					 $this->data['users']['password']=md5($this->data['users']['password']);
				   }else{
				     $consulta=$this->con->find('users',null,array('conditions'=>array('id'=>$id)));
						 
				     $el_pass=$this->con->fetch_array_assoc($consulta);
					 
					 $this->data['users']['password']=$el_pass['password'];
				   }
				   
				   if(empty($this->data['users']['email'])){
				     $consulta=$this->con->find('users',null,array('conditions'=>array('id'=>$id)));
						 
				     $el_mail=$this->con->fetch_array_assoc($consulta);
					 
					 $this->data['users']['email']=$el_mail['email'];
				   }
				   
				   $this->data['users']['fecha_nacimiento']=$this->cambiaf_a_mysql($this->data['users']['fecha_nacimiento']);
				   
				   if(!empty($this->data['baja'])){
				     $this->data['users']['fecha_baja']=$this->timestampFormatData(time(),true);
				   }
				   
				   $this->con->fields=$this->data['users'];
				   if($this->con->update("users"," WHERE id=".$id)){
					 $men=$_SESSION['textos']['edit_user_ok'];
					   
			         if(!empty($_FILES["file"]["name"])){
			           if(move_uploaded_file($_FILES["file"]["tmp_name"],DOCUMENT_ROOT."images/foto_perfil/" .$id.".jpg"));
			           else{
				            $men.=$_SESSION['textos']['edit_user_foto_error'];
			           }
					 }
					   
					   Core::mensaje($men);
					   Core::redireccion("users/index.html");
				   }else{
					   Core::mensaje($_SESSION['textos']['edit_user_error']);
				   }
				   
			   }//**
			 
		  }else{
		           $consulta=$this->con->find('users',
	                            null,
								array('conditions'=>array('id'=>$id))
						 );
						 
				   $this->data['users']=$this->con->fetch_array_assoc($consulta);
		  }//*
	   
	 }
	 
	     $consulta=$this->con->find('groups',array('fields'=>array('id,name')));
		 while($fila=$this->con->fetch_array_assoc($consulta)){
			  $grupos['groups'][]=array('id'=>$fila['id'],'name'=>$fila['name']);
		 }
		 $this->set('grupos',$grupos);
		 
		 $this->set('id',$id);
  }
  
  /*
  **Delete
  */
  public function delete($id=null){
        $this->layout="index_admin";
		
		if (!$id) {
			Core::mensaje($_SESSION['textos']['delete_user_id_error']);
			Core::redireccion("users/index.html");
		}
		
			if($this->del('users','WHERE id='.$id)) {
				   Core::mensaje($_SESSION['textos']['delete_user_ok']);
				   Core::redireccion("users/index.html");
			}else{
				   Core::mensaje($_SESSION['textos']['delete_user_error']);
				   Core::redireccion("users/index.html");
			}
  }
  
  /*
  **admin
  */
  public function admin(){
    $this->layout="index_admin";
	
	if(!empty($this->data)){
	
	   $this->data['password']=md5($this->data['password']); 
       $consulta=$this->con->find('users',null,
								array('conditions'=>array('email'=>$this->data['login'],'password'=>$this->data['password']))
					       );
						   
	  if($this->con->num_rows($consulta)){
		 //$_SESSION['user']=$this->fetch_array_assoc($consulta);
		  
	  	 $datos=$this->con->fetch_array_assoc($consulta);
		 
		 if($datos['verificado']==1){
           
           $this->data['users']['fecha_mod']=$this->timestampFormatData(time(),true);
		   $this->con->fields=$this->data['users'];
		   $this->con->update("users"," WHERE email='".$this->data['login']."'");
	
	 	   $_SESSION['user']=$datos;
	 	   $_SESSION['user']['fecha_mod'] = $this->data['users']['fecha_mod'];
		   
           Core::redireccion(ROOT."users/admin.html");
           
		 }else{
           Core::redireccion(ROOT."users/verificacion.html");
		 }

		 //$this->redireccion(ROOT."users/admin.html");
		 //$this->redireccion(ROOT."/".ROOT_INI.".html");
	  }else{
	     //Core::mensaje("Ha introducido un login o una contrase&ntilde;a incorrecta.<br/><br/>Si has olvidado la contrase&ntilde;a <a href=\"".ROOT."users/nuevo_pass.html\">pincha en este enlace</a>.<br/><br/>");
		 Core::mensaje($this->string_format($_SESSION['textos']['login_error'],ROOT."users/nuevo_pass.html"));
		 Core::redireccion(ROOT."users/admin.html");
	  }
	  
	}
  }
  
  /*
  **Enviar mail
  */
  function _mailavisocuenta($id=null,$correo=null,$nombre=null){
        $key=100+$id;
		
        $this->email->Host = "localhost";
		$this->email->From = CORREO;
		$this->email->FromName = $_SESSION['textos']['user_mailavisocuenta_fromname'];
		$this->email->Subject = $_SESSION['textos']['user_mailavisocuenta_subject'];
		$this->email->AddAddress($correo);
		//$this->email->AddCC(CORREO);
		
		$body= $this->string_format($_SESSION['textos']['user_mailavisocuenta_body'],ROOT."users/password/".$key.".html");
		$this->email->Body = $body;
		$this->email->AltBody = $this->string_format($_SESSION['textos']['user_mailavisocuenta_altbody'],ROOT."users/password/".$key.".html");
		$exito=$this->email->Send();
		return $exito;
  }
  
  /*
  **Permisos usuarios
  */
  public function permisos($id=null){
  
  $this->layout="index_admin";
      
	  if (!$id) {
			Core::mensaje($_SESSION['textos']['user_permisos_id_error']);
			Core::redireccion("users/index.html");
	  }
	       
		   if(!empty($this->data)){//*
		   
		     $consulta=$this->con->find('acces_users',null,
								array('conditions'=>array('users_id'=>$id))
			 );
			 
		     if($this->con->num_rows($consulta)>0){
				 
		         $this->con->del('acces_users','WHERE users_id='.$id);
				 if($this->con->affected_rows()>0) {
				
					   //print_r($this->data);
					  foreach($this->data['users'] as $datafin){
					   if(!empty($datafin['acceso'])){
						   $myarray=array();
					       $myarray['acces_users']['users_id']=$datafin['users_id'];
					       $myarray['acces_users']['con_ac_id']=$datafin['con_ac_id'];
					       $myarray['acces_users']['acceso']=$datafin['acceso'];
                           //print_r($myarray);
                           $this->con->reset();
						   $this->con->fields=$myarray['acces_users'];
						   if($this->con->insert("acces_users")){
							   Core::mensaje($_SESSION['textos']['user_permisos_ok']);
						   }else{
							  Core::mensaje($_SESSION['textos']['user_permisos_error']);
							  Core::redireccion("users/index.html");
						   }
						 }
					  }
					  Core::redireccion("users/index.html");
					  
					  
				}else{
					   Core::mensaje($_SESSION['textos']['user_permisos_error']);
					   Core::redireccion("users/index.html");
				}
			}else{
 			          foreach($this->data['users'] as $datafin){
					    if(!empty($datafin['acceso'])){
						  $myarray=array();
						  $myarray['acces_users']['users_id']=$datafin['users_id'];
						  $myarray['acces_users']['con_ac_id']=$datafin['con_ac_id'];
						  $myarray['acces_users']['acceso']=$datafin['acceso'];
						  //print_r($myarray);
						  $this->con->reset();
						  $this->con->fields=$myarray['acces_users'];
							   if($this->con->insert("acces_users")){
								      Core::mensaje($_SESSION['textos']['user_permisos_ok']);
							   }else{
									  Core::mensaje($_SESSION['textos']['user_permisos_error']);
									  Core::redireccion("users/index.html");
							   }
						 }
					  }
					  Core::redireccion("users/index.html");
			    }
			  
		   }//*
		             $consulta_user=$this->con->find('users',null,
								array('conditions'=>array('id'=>$id))
					 );
					 
					 
					 $consulta=$this->con->find('acces_users',null,
								array('conditions'=>array('users_id'=>$id))
					 );
					 $r_acces=array();
					 while($fila=$this->con->fetch_array_assoc($consulta)){
					     $r_acces[]=array('id'=>$fila['id'],'users_id'=>$fila['users_id'],'con_ac_id'=>$fila['con_ac_id'],'acceso'=>$fila['acceso']);
					 }
					 
					 
					 $consulta=$this->con->find('con_ac',null,
								array('conditions'=>array('parent_id IS NULL'))
					 );
					 
					 $r_con=array();
					 while($fila=$this->con->fetch_array_assoc($consulta)){
					    $val=0;
					    foreach($r_acces as $valor) {
								/*if($valor['con_ac_id'] == $fila['id'] && $valor['acceso']==1){
									$val=1;
									break;
								}*/
								if ($valor['con_ac_id'] == $fila['id']) {
									if ($valor['acceso']==1)
									     $val=1;
									elseif ($valor['acceso']==-1) 
										 $val=-1;
									
									break;
								}	
						}
						
						$r_ac=array();
						$sub_consulta=$this->con->find('con_ac',null,
								array('conditions'=>array('parent_id'=>$fila['id']))
					    );
						while($sub_fila=$this->con->fetch_array_assoc($sub_consulta)){
							$sub_val=0;
							foreach($r_acces as $va) {
									/*if($va['con_ac_id'] == $sub_fila['id'] && $va['acceso']==1){
										$sub_val=1;
										break;
									}*/
									if ($va['con_ac_id'] == $sub_fila['id']) {
										if ($va['acceso']==1)
										     $sub_val=1;
										elseif ($va['acceso']==-1)
											 $sub_val=-1;
										
										break;
									}
							}
						  $r_ac[]=array('id'=>$sub_fila['id'],'parent_id'=>$sub_fila['parent_id'],'alias'=>$sub_fila['alias'],'acceso'=>$sub_val);
					    }
						
					    $r_con[]=array('id'=>$fila['id'],'parent_id'=>$fila['parent_id'],'alias'=>$fila['alias'],'acceso'=>$val,'acciones'=>$r_ac);
					 }
					 
					$this->set('r_con',$r_con);
					$this->set('el_user',$this->con->fetch_array_assoc($consulta_user));
	  
  }
  
  
 /*
  **Registro
  */
  public function registro(){
	 
	 if(!empty($this->data)){//*
	 
	    if(!$this->_validausuario() || !$this->_validapassword()){//**
		  $cadena = '';
		  foreach($this->error as $mensaje){
				  $cadena.=$mensaje."<br>";
		  }
		  $cadena = $_SESSION['textos']['error_datos']."<br><div style='padding-left:20px;'>".$cadena."</div>";
		  Core::mensaje($cadena."<br><br>");
	  
       }else{
	       
	       $verificationCode = $this -> _getToken(6);
		   if(!empty($this->data['users']['password'])){
		     $this->data['users']['password']=md5($this->data['users']['password']);
		   }
		   
		    $this->data['users']['fecha_nacimiento']=$this->cambiaf_a_mysql($this->data['users']['fecha_nacimiento']);
		   
		    $this->data['users']['groups_id']=4;
		    $this->data['users']['codigo_verificacion'] = $verificationCode;
		   
		   $this->con->fields=$this->data['users'];
		   if($this->con->insert("users")){
			   
			   $men=$_SESSION['textos']['registro_user_ok'];
			   
			   if(!empty($_FILES["file"])){
			           if(move_uploaded_file($_FILES["file"]["tmp_name"],DOCUMENT_ROOT."images/foto_perfil/" . $this->con->insert_id().".jpg"));
			           else{
				            $men.=$_SESSION['textos']['registro_user_foto_error'];
			           }
			   }
			   
			   //if(!$this->_mailavisocuenta($this->insert_id(),$this->data['users']['email'],$this->data['users']['nome'])){
			   if(!$this->_enviarEmailVerificacion($this->data['users']['email'],$verificationCode)){
			     $men.="<br/><br/>".$this->string_format($_SESSION['textos']['registro_user_mail_error'], $this->data['users']['email']);
				 $men.="<br/>".$mail->ErrorInfo;
			   }
			   Core::mensaje($men);
			   Core::redireccion("");
		   }else{
		      Core::mensaje($_SESSION['textos']['registro_user_error']);
		   }
		   
	   }//**
	   
	 }//*
	 
  }
  
  /*
  **misdatos
  */
  public function misdatos(){
  
  $id=$_SESSION['user']['id'];
	 
	      if(!empty($this->data)){//*
		     
			  if(!$this->_validausuario()){//**
				  $cadena = '';
				  foreach($this->error as $mensaje){
						  $cadena.=$mensaje."<br>";
				  }
				  $cadena = $_SESSION['textos']['error_datos']."<br><div style='padding-left:20px;'>".$cadena."</div>";
				  Core::mensaje($cadena."<br><br>");
				  
				  $this->data['users']['fecha_nacimiento']=$this->cambiaf_a_mysql($this->data['users']['fecha_nacimiento']);
			  
			   }else{
			   
				   if(!empty($this->data['users']['password'])){
					 $this->data['users']['password']=md5($this->data['users']['password']);
				   }else{
				     $consulta=$this->con->find('users',null,array('conditions'=>array('id'=>$id)));
						 
				     $el_pass=$this->fetch_array_assoc($consulta);
					 
					 $this->data['users']['password']=$el_pass['password'];
				   }
				   
				   if(empty($this->data['users']['email'])){
				     $consulta=$this->con->find('users',null,array('conditions'=>array('id'=>$id)));
						 
				     $el_mail=$this->con->fetch_array_assoc($consulta);
					 
					 $this->data['users']['email']=$el_mail['email'];
				   }
				   
				   $this->data['users']['fecha_nacimiento']=$this->cambiaf_a_mysql($this->data['users']['fecha_nacimiento']);
				   
				   if(!empty($this->data['baja'])){
				     $this->data['users']['fecha_baja']=$this->timestampFormatData(time(),true);
				   }
				   
				   $this->con->fields=$this->data['users'];
				   if($this->con->update("users"," WHERE id=".$id)){
					 $men=$_SESSION['textos']['misdatos_user_ok'];
					   
			         if(!empty($_FILES["file"])){
			           if(move_uploaded_file($_FILES["file"]["tmp_name"],DOCUMENT_ROOT."images/foto_perfil/" .$id.".jpg"));
			           else{
				            $men.=$_SESSION['textos']['misdatos_user_foto_error'];
			           }
					 }
					   
					   $consulta=$this->con->find('users',null,
								array('conditions'=>array('id'=>$id))
					       );
						 
                       unset($_SESSION['user']);						 
		               $_SESSION['user']=$this->con->fetch_array_assoc($consulta);
					   
					   Core::mensaje($men);
					   Core::redireccion("users/misdatos.html");
				   }else{
					   Core::mensaje($_SESSION['textos']['misdatos_user_error']);
				   }
				   
			   }//**
			 
		  }else{
		           $consulta=$this->con->find('users',
	                            null,
								array('conditions'=>array('id'=>$id))
						 );
						 
				   $this->data['users']=$this->con->fetch_array_assoc($consulta);
		  }//*
	 
  }
  
  /*
  *login
  */
  public function login(){
      
	  $this->data['password']=md5($this->data['password']); 
      $consulta=$this->con->find('users',null,
								array('conditions'=>array('email'=>$this->data['login'],'password'=>$this->data['password']))
					       );
						   
	  if($this->con->num_rows($consulta)){
		 //$_SESSION['user']=$this->fetch_array_assoc($consulta);
	  	 $datos=$this->con->fetch_array_assoc($consulta);
		 
		 if($datos['verificado']==1){
           
              $this->data['users']['fecha_mod']=$this->timestampFormatData(time(),true);
			  $this->con->fields=$this->data['users'];
			  $this->con->update("users"," WHERE email='".$this->data['login']."'");
	
	 	      $_SESSION['user']=$datos;
	 	      $_SESSION['user']['fecha_mod'] = $this->data['users']['fecha_mod'];

	 	      //$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
	          //$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
	 	      
              Core::redireccion(ROOT."/".ROOT_INI.".html");
           
		 }else{
           Core::redireccion(ROOT."users/verificacion.html");
		 }
         
		 //Core::redireccion("");
		 //Core::redireccion(ROOT."users/admin.html");
		 //Core::redireccion(ROOT."/".ROOT_INI.".html");
	  }else{
	     //Core::mensaje("Ha introducido un login o una contrase&ntilde;a incorrecta.<br/><br/>Si has olvidado la contrase&ntilde;a <a href=\"".ROOT."users/nuevo_pass.html\">pincha en este enlace</a>.<br/><br/>");
		 Core::mensaje($this->string_format($_SESSION['textos']['login_error'],ROOT."users/nuevo_pass.html"));
		 Core::redireccion("");
	  }

  }
  
  /*
  **logout
  */
  public function logout(){
     if(isset($_SESSION['user'])){
	     unset($_SESSION['user']);
		 Core::redireccion("");
	 }
	 
  }

  public function verificacion(){
        
        $this->layout="index_admin";
	 
		  if(!empty($this->data)){//*
		     
			 $consulta=$this->con->find('users',
		                            array('fields'=>array('codigo_verificacion')),
									array('conditions'=>array('email'=>$this->data['user']['email']))
							 );
			 if($this->con->num_rows($consulta)){
			    $datos=$this->con->fetch_array_assoc($consulta);

				if( (!empty($datos['codigo_verificacion'])) && ($datos['codigo_verificacion']!=-1) && ($datos['codigo_verificacion'] == $this->data['user']['codigo']) ){
                      
                      $valor = 1;
                      $this->data['users']['verificado'] = $valor;
                      $this->data['users']['codigo_verificacion'] = -1;
                      $this->data['users']['fecha_mod']=$this->timestampFormatData(time(),true);
					  $this->con->fields=$this->data['users'];
					  if($this->con->update("users"," WHERE email='".$this->data['user']['email']."'")){
					  	  $consulta=$this->con->find('users',null,
								array('conditions'=>array('email'=>$this->data['user']['email']))
					       );
						   
	                      if($this->con->num_rows($consulta)){
	                      	$_SESSION['user']=$this->con->fetch_array_assoc($consulta);
	                      	Core::redireccion(ROOT.URL.".html");
	                      }else{
					        Core::mensaje("no se pudo realizar la verificaión!, intentelo otra vez :(");
					      }
						  
					  }else{
					      Core::mensaje("no se pudo realizar la verificaión!, intentelo otra vez :(");
					  }
                  
                }else
                   Core::mensaje("el codigo introducido es incorrecto!, intentelo otra vez :(");

			 }else{
			    Core::mensaje("el email introducido es incorrecto!, intentelo otra vez :(");
			 }

			 Core::redireccion("users/verificacion.html");
			 
		  }//*
  }  
  
  /*
  **Password()
  */
  public function password(){
     $this->layout="index_admin";
	 
 	  if(!empty($this->data)){//*
          
 	  	  $consulta=$this->con->find('users',
	                            array('fields'=>array('id')),
								array('conditions'=>array('email'=>$this->data['user']['email']))
						 );
		 if($this->con->num_rows($consulta)){
		    
            $datos=$this->con->fetch_array_assoc($consulta);

		    if($this->_verificacionCodigoNewPassword($datos['id'],$this->data['user']['codigo'])){
                 $this->data['users']['password'] = $this->data['user']['password'];
		    	 if(!$this->_validapassword()){//**
				    $cadena = '';
				    foreach($this->error as $mensaje){
						  $cadena.=$mensaje."<br>";
				    }
				    $cadena = $_SESSION['textos']['error_datos']."<br><div style='padding-left:20px;'>".$cadena."</div>";
				    Core::mensaje($cadena."<br><br>");
		  
		        }else{
					  
					  $this->data['users']['password']=md5($this->data['user']['password']);
					  $this->con->fields=$this->data['users'];
					  if($this->con->update("users"," WHERE id=".$datos['id'])){
					  	 $this->con->del('rt_password','WHERE user_id='.$datos['id']);
						 $this->data['login']=$this->data['user']['email'];
						 $this->data['password']=$this->data['password2'];
						 $this->login(); 
					  }else{
					      Core::mensaje($_SESSION['textos']['password_user_error']);
					  }
			   }//**

		    }else{
		    	Core::mensaje("El codigo introducido es erroneo ¬¬");
		    } 

		 }else{
		    Core::mensaje($_SESSION['textos']['user_nuevopass_error']);
		 }
	   	 
	 }//*
	  
	  //$this->set('key',$key);
	
  }

  /*Verificación de que el codigo de cambio/recuperación de password es correcto*/
 public function _verificacionCodigoNewPassword($uid,$codigo){
  
            $consulta=$this->con->find('rt_password',null,array('conditions'=>array('user_id'=>$uid)));			 
		    if($this->num_rows($consulta)){
		    	$datos=$this->con->fetch_array_assoc($consulta);
		    	$tm = time();
                if( ($datos['codigo'] == $codigo) && $datos['tiempo'] >= $tm) {
                   return true;
                }else
                   return false;
		    }else{
                return false;
            }

            
 }
  
  /*
  **nuevo_pass
  */
  public function nuevo_pass(){
     $this->layout="index_admin";
	 
	  if(!empty($this->data)){//*
	     
		 $consulta=$this->con->find('users',
	                            array('fields'=>array('id')),
								array('conditions'=>array('email'=>$this->data['user']['email']))
						 );
		 if($this->con->num_rows($consulta)){
		    $datos=$this->con->fetch_array_assoc($consulta);
			//$key=$datos['id']+100;
			$this -> _recDePassword($datos['id'], $this->data['user']['email']);
			//$this->password($key);
			//Core::redireccion("users/password/".$key.".html");
			Core::redireccion("");
		 }else{
		    Core::mensaje($_SESSION['textos']['user_nuevopass_error']);
		 }
		 
	  }//*
	 
  }


  /*Solicitud de cambio/recuperación de password*/
 public function _recDePassword($user_id, $email){

        $time = time()+(12*3600);
        $codigo = $this -> _getToken(6);
        //$this -> _enviarEmailRtPassword($email,$codigo);
        //$sql  ="INSERT INTO rt_password (unique_id, codigo, tiempo) VALUES (?, ?, ?); ";
        $this->data['users']['user_id']=$user_id;
        $this->data['users']['codigo']=$codigo;
        $this->data['users']['tiempo']=$time;
        $this->con->fields=$this->data['users'];
		   if($this->con->insert("rt_password")){
			   
			   //if(!$this->_mailavisocuenta($this->insert_id(),$this->data['users']['email'],$this->data['users']['nome'])){
			   if(!$this -> _enviarEmailRtPassword($email,$codigo)){
			     $men.="No se pudo finalizar el proceso :-c , intentalo otra vez";
				 $men.="<br/>".$mail->ErrorInfo;
			   }else{
			   	 $men="Se envio un email a la cuenta de correo ".$email." con las instucciones para el cambio de contraseña.";
			   }
			   Core::mensaje($men);
		   }else{
		      Core::mensaje("No se pudo finalizar el proceso :-c , intentalo otra vez");
		   }
 }


  public function _enviarEmailVerificacion($email,$verificationCode){
         $htmlStr = "";
         $htmlStr .= "Hola " . $email . ",<br /><br />";
                 
         $htmlStr .= "La primera vez que te logues se te pedira que introduzcas el siguiente codigo para activar tu cuenta.<br /><br /><br />";
         $htmlStr .= "{$verificationCode}<br /><br /><br />";
                 
         $htmlStr .= "Muchas gracias,<br />";

         $breaks = array("<br />","<br>","<br/>");  
         $altB = str_ireplace($breaks, "\r\n", $htmlStr); 
                 
         
         $name = "appDiet";
         $email_sender = "ifritfire2003@hotmail.com";
         $subject = "Codigo de verificación de cuenta";
         $recipient_email = $email;
 
         /*$headers  = "MIME-Version: 1.0rn";
         $headers .= "Content-type: text/html; charset=utf8";
         $headers .= "From: {$name} <{$email_sender}> n";*/
 
         $body = $htmlStr;
 
                // send email using the mail function, you can also use php mailer library if you want
                if(mail($recipient_email, $subject, $altB, $headers) ){
               //if( $this->_SendMAIL($recipient_email, $subject, $body, $body,$email_sender,$name) ){
                    
                    $this->data['users']['verificacion_envio']=1;
			        $this->con->fields=$this->data['users'];
                    $this->con->update("users"," WHERE email=".$email);

                    return true;
                     
                }else{
                    //die("Sending failed.");
                   return false;
                }
    }

    public function _enviarEmailRtPassword($email,$codigo){
         $htmlStr = "";
         $htmlStr .= "Hola " . $email . ",<br /><br />";
                 
         $htmlStr .= "Recibimos una solicitud de cambio de contraseña. Para confirmar tu nueva contraseña introduce el siguiente codigo en el formulario de cambio de contraseña: .<br /><br />";
         $htmlStr .= $codigo."<br /><br />";
         $htmlStr .= "El codigo sera valido por 12h.<br/><br/>";
         
         $htmlStr .= "Por favor, ignora este mensaje en el caso que no nos hayas enviado un cambio de contraseña de tu cuenta.<br/>";
                 
         $htmlStr .= "Muchas gracias,<br /><br />";

         $breaks = array("<br />","<br>","<br/>");  
         $altB = str_ireplace($breaks, "\r\n", $htmlStr); 
                 
         
         $name = "appDiet";
         $email_sender = "ifritfire2003@hotmail.com";
         $subject = "Recuperar Contraseña";
         $recipient_email = $email;
 
         /*$headers  = 'MIME-Version: 1.0' ."\r\n";
         $headers .= 'Content-type: text/plain; charset=utf8'."\r\n";
         $headers .= 'From: '. strip_tags($name). ' < ' . strip_tags($email_sender) .' >'."\r\n";*/
 
         $body = $htmlStr;
 
                // send email using the mail function, you can also use php mailer library if you want
               if(mail($recipient_email, $subject, $altB, $headers) ){
               //if( $this->_SendMAIL($recipient_email, $subject, $body, $altB,$email_sender,$name) ){
                  return true;
               }else{
                  //die("Sending failed.");
                  return false;
               }
    }

    function _SendMAIL($para,$subject,$body,$altbody,$mailFROM,$mailNameCompany){
        $this->mail->PluginDir = "php/phpmailer/";
        $this->mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
        $this->mail->From = $mailFROM;
        $this->mail->FromName = $mailNameCompany;
        $this->mail->Subject = $subject;
        $email = $para;
         
        $this->mail->SMTPAuth = true; 
        $this->mail->Body = $body;
        $this->mail->AltBody = $altbody;
        $this->mail->IsHTML(true);
        $this->mail->CharSet = "UTF-8";
        $this->mail->Timeout=20;
        $this->mail->AddAddress($email);
        $exito = $this->mail->Send();
        $intentos=1; 
        /*while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
          sleep(5);
          $exito = $mail->Send();
          $intentos=$intentos+1;                
        }
         
        if ($mail->ErrorInfo=="SMTP Error: Data not accepted") {
               $exito=true;
        }*/

        while ((!$exito) && ($intentos < 5)) {
          sleep(5);
          //echo $mail->ErrorInfo;
          $exito = $this->mail->Send();
          $intentos=$intentos+1;  
          
        }
         
            
        /*if(!$exito){
          echo "Problemas enviando correo electrónico a ".$valor;
          echo "<br/>".$mail->ErrorInfo;  
           }
           else
           {
          echo "Mensaje enviado correctamente";
           }*/ 

        return $exito;
    }


  /*
   Generador de codigos
  */
   public function _crypto_rand_secure($min, $max) { 
       $range = $max - $min; 
       if ($range < 0) 
         return $min; // not so random... 
       $log = log($range, 2); 
       $bytes = (int) ($log / 8) + 1; // length in bytes 
       $bits = (int) $log + 1; // length in bits 
       $filter = (int) (1 << $bits) - 1; // set all lower bits to 1 
       do { 
           $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes))); 
           $rnd = $rnd & $filter; // discard irrelevant bits 
        } while ($rnd >= $range); 
        return $min + $rnd;
    } 

    public function _getToken($length){ 
      $token = ""; 
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
      $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz"; 
      $codeAlphabet.= "0123456789"; 
      for($i=0;$i<$length;$i++){ 
        $token .= $codeAlphabet[$this->_crypto_rand_secure(0,strlen($codeAlphabet))]; 
      } 
      return $token; 
    }



   /*
  **Valida password
  */
 function _validapassword(){
    $no_errores = true;
    $reg_pass='/^[a-zA-Z0-9]{3,}$/i';
	
	   if(!preg_match($reg_pass, $this->data["users"]["password"])){
	      $this->error[]=$_SESSION['textos']['user_validapassword_error1'];
	      $no_errores=false;
	   }
	   
	   if($this->data['users']['password']!=$this->data['password2'])
	   {
	      $this->error[]= $_SESSION['textos']['user_validapassword_error2'];
	      $no_errores=false;
	   }
    return $no_errores;
  }
  
  
  /**************************************************************************************************************************
  **Validacion
  */
  function _validausuario(){
    $no_errores = true;
	//print_r($this->data);
	$reg_email = '/^[_a-zA-Z-]+[._a-zA-Z0-9-]+@[a-zA-Z0-9-]+\.[.a-zA-Z0-9]+/i';
	$reg_num = '/^[0-9]{1,}$/i';
	$reg_telefono = '/^[0-9]{9,}$/i';
	$reg_alfa3='/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]{3,}$/i';
	$reg_pass='/^[a-zA-Z0-9]{3,}$/i';
	
	
	
	if ( !preg_match($reg_alfa3, utf8_decode($this->data["users"]["nombre"]))){
			$this->error[]= $_SESSION['textos']['user_validausuario_error1'];
			$no_errores=false;
    }
	
	
	if($this->data['task']=='add' || ($this->data['task']=='edit' && !empty($this->data['users']['email'])))
	{
	
		if ( !preg_match($reg_email, $this->data["users"]["email"])){
				$this->error[]= $_SESSION['textos']['user_validausuario_error2'];
				$no_errores=false;
		}else{
			 $consulta=$this->con->find('users',
									array('fields'=>array('email')),
									array('conditions'=>array('email'=>$this->data['users']['email']))
	
						 );
			if($this->con->num_rows($consulta)>0){
			 $this->error[]= $this->string_format($_SESSION['textos']['user_validausuario_error3'],$this->data['users']['email']);
			  $no_errores=false;
			}
			if($this->data["users"]["email"]!=$this->data["email2"]){
			  $this->error[]= $_SESSION['textos']['user_validausuario_error4'];
			  $no_errores=false;
			}
		}
	
	}
	
	if(!empty($this->data['users']['password'])){
	   if(!preg_match($reg_pass, $this->data["users"]["password"])){
	      $this->error[]= $_SESSION['textos']['user_validausuario_error5'];
	      $no_errores=false;
	   }
	   if($this->data['users']['password']!=$this->data['password2'])
	   {
	      $this->error[]= $_SESSION['textos']['user_validausuario_error6'];
	      $no_errores=false;
	   }
	}
	
	if(!empty($_FILES["file"]["name"])) {
		$size_foto=$_FILES["file"]["size"];
	}
	
	if (!empty($_FILES["file"]["name"]) && (($_FILES["file"]["type"] != "image/jpeg") && ($_FILES["file"]["type"] != "image/jpg"))){
		$this->error[]= $_SESSION['textos']['user_validausuario_error7'];
	    $no_errores=false;
	}
	
	if (!empty($_FILES["file"]["name"]) && ($size_foto>100000)){
		$this->error[]= $_SESSION['textos']['user_validausuario_error8'];
	    $no_errores=false;
	}
	
	
	return $no_errores;
  }

  
  /*
  contador usuarios
  */
  public function _contador(){
     date_default_timezone_set('UTC');

	//se requiere el archivo para validar los datos de usuario de bdd para conectar   
	$ip = $_SERVER['REMOTE_ADDR'];   
	$fecha = date("j \d\e\l n \d\e Y");   
	$hora = date("h:i:s");   
	$horau = date("h");   
	$diau = date("z");   
	$aniou = date("Y");   
	//se asignan la variables   
	$sql = "SELECT aniou, diau, horau, ip ";   
	$sql.= "FROM contador WHERE aniou LIKE '$aniou' AND diau LIKE '$diau' AND horau LIKE '$horau' AND ip LIKE '$ip' ";   
	$es = $this->con->consulta($sql);   
	//se buscan los registros que coincidan con la hora,dia,año e ip    
	if($this->con->num_rows($es)>0)   
	{//no se cuenta la visita   
	}   
	else if(!isset($_SESSION['user']) OR $_SESSION['user']['groups_id']!=1)   
	{   
	 $sql = "INSERT INTO contador (id, ip, fecha, hora, horau, diau, aniou) ";   
	 $sql.= "VALUES ('','$ip','$fecha','$hora','$horau','$diau','$aniou')";   
	 $es = $this->con->consulta($sql);   
	}   
	//creamos el condicionamiendo para logearlo o no.   
	$sql = "SELECT * ";   
	$sql.= "FROM contador WHERE id ";   
	$es =$this->con->consulta($sql);   
	$visitas = $this->con->num_rows($es);   
	
	$this->set('visitas',$visitas);
	
  }
  
}
?>