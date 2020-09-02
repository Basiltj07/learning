<?php

function sendEmail($subject,$body,$to,$name){
 try {
	require_once('PHPMailerAutoload.php');
	$mail = new PHPMailer;
	$mail->isSMTP();                                   
	$mail->Host = 'mail.qhseinternational.com'; 
	$mail->SMTPAuth = true;                
	$mail->Username = 'admin@qhseinternational.com';    
	$mail->Password = 'qhseadmin@2019';     
	$mail->SMTPSecure = 'tls';                         
	$mail->Port = 587;    
	$mail->setFrom('basiltj07@gmail.com', 'QHSE International');
	$mail->addAddress($to, $name); 

	$mail->addReplyTo('basiltj07@gmail.com', 'Information');

	$mail->isHTML(true);    

	$mail->Subject = $subject;
	$mail->Body    = $body;
	if(!$mail->send()) {
		return 0;
	} else {
		return 1;
	}
 } catch(Exception $e){
      return 0;
 }


}