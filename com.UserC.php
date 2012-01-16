<?php

	require_once('pojos/User.php');
	require_once('mail/class.phpmailer.php');
	
	class UserC{
		
		public function hello(){
			return true;
		}
		
		public function getSessionId()
		{
			$session = Zend_Registry::get('session');
			return $session->id;
		}
		
		public function logIn($user){
			
			Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
			$db = Zend_Db::factory('Pdo_Mysql', array(
				'host'     => DATABASE_SERVER,
				'username' => DATABASE_USERNAME,
				'password' => DATABASE_PASSWORD,
				'dbname'   => DATABASE_NAME
			));
			
			$authAdapter  = new Zend_Auth_Adapter_DbTable($db);
			$authAdapter->setTableName('user');
			$authAdapter->setIdentityColumn('user');
			$authAdapter->setCredentialColumn('pass');
			
			// Set the input credential values to authenticate against
			$authAdapter->setIdentity($user->user);
			$authAdapter->setCredential($user->pass);
			
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authAdapter);
			
			if ($result->isValid())
			{					
				$session = Zend_Registry::get('session');
				$session->id = $authAdapter->getResultRowObject()->id;// Obtener el ID DEL USUARIO
				return true;
			}
			
			return "Usuario y/o Pass Incorrectos";
		}
		
		public function forwardData($user){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
	     	mysql_select_db(DATABASE_NAME);
			
			$query = "SELECT * FROM user WHERE user = '".$user->user."' OR email = '".$user->email."'";  // OR EMAIL  = EMAIL
			$result = mysql_query($query);
			     
			if($row = mysql_fetch_object($result)) {
				$user->user = $row->user;
				$user->email = $row->email;
				$user->pass = $row->pass;
				return $this->sendMail($user, "Recuperacion de Contraseña");		
			}
			else{
				return "El Usuario o e-mail no existen";
			}
		}
		
		public function createUser($user){
			$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die("Error MySQL.");
	     	mysql_select_db(DATABASE_NAME);
			         	 
   		    if( !$this->findUserByUorE($user) ){
			   	$query = "INSERT INTO user(user, email, pass) values ('$user->user','$user->email','$user->pass')";
				$resultado=mysql_query($query);
				mysql_close($mysql);	
			}else 
			{
			   	return "El usuario o email ya estan registrados";
			}
			
			$emailRes = $this->sendMail($user, "Sus Datos de Registro");
			//Si no se pudo enviar el correo se envia el error
			if( $emailRes == true )
				return true;
			else
				return $emailRes;
		}
		
		private function findUserByUorE($user){
		     
		     $query = "SELECT * FROM user 
		     			WHERE user = '".$user->user."' OR email = '".$user->email."'";	
		     $result = mysql_query($query);
		     $numero = mysql_num_rows($result);
		     
		     if($numero != 0)
		     {
		     	 mysql_free_result($result);
		     	 return true;
		     }
		     
			 return false;
		}
		
		private function sendMail($user, $sub){	
			//$body = file_get_contents('http://173.255.197.54/socialZend/mailing/1/');
									
			$mail = new PHPMailer();
			$mail->IsSMTP(); 
			$mail->Host = "ssl://smtp.gmail.com"; 
			$mail->SMTPAuth = true; 
			$mail->Username = "idwasoft@gmail.com"; 
			$mail->Password = "interioremf7"; 
			$mail->Port = 465;

			$mail->From = "idwasoft@gmail.com";
			$mail->FromName = "PREP Mailer";
			$mail->AddAddress($user->email, $user->user);
			
			$mail->WordWrap = 50; // set word wrap to 50 characters
			$mail->IsHTML(true); // set email format to HTML
			
			$mail->Subject = $sub;
			/*$body = str_replace('%USUARIO%', $user->user, $body);
			$body = str_replace('%EMAIL%', $user->email, $body);
			$body = str_replace('%CONTRASENA%', $user->pass, $body);*/
			
			$mail->MsgHTML(file_get_contents("mail/index.html")); 
			$body = $mail->Body;
			$body = str_replace('%ASUNTO%', $sub, $body);
			$body = str_replace('%USUARIO%', $user->user, $body);
			$body = str_replace('%EMAIL%', $user->email, $body);
			$body = str_replace('%CONTRASENA%', $user->pass, $body);
			$mail->MsgHTML($body);

			if($mail->Send())
			{
				return true;
			}
			else
			{
				return "No se ah podido enviar el correo";	
			}
			
		}
		
	}
?>