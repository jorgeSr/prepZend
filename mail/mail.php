<?php


require("class.phpmailer.php");

	$body = file_get_contents('http://www.relojesomega.com.mx/prepZend/mailing/1/index.html');
	
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "mail.relojesomega.com.mx";
    $mail->Username = "u68376";
    $mail->Password = "Interiore7";
    $mail->SMTPAuth = true;

	$mail->From = "u68376@relojesomega.com.mx"; 
	$mail->FromName = "User Name"; 
	$mail->Subject = "Subject del Email"; 
	$mail->AltBody = "Hola, te doy mi nuevo numero\nxxxx."; 
	
	//$mail->MsgHTML("Hola, te doy mi nuevo numero<br><b>xxxx</b>.");
	$mail->MsgHTML( $body );
	
	$mail->AddAddress("underworld_dv@hotmail.com", "Destinatario");
	 
	$mail->IsHTML(true); 
	  
	if(!$mail->Send()) { 
	  echo "Error: " . $mail->ErrorInfo; 
	} else { 
	  echo "Mensaje enviado correctamente"; 
	}

?>