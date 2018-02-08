<?php

function sendMail($msg,$otherto) {

	// To
        $to = $otherto;
//	$to = 'vovinamorleans@gmail.com';
	
//	if( $otherto != null )
//		$to .= ','.$otherto;
	 
	// Subject
	$subject = 'Fête de la fondation 2016 - Récapitulatif inscription';
	 
	// Headers
	$headers = 'From: Vovinam Orléans <vovinamorleans@gmail.com>'."\r\n";
        $headers .= 'Bcc: Vovinam Orléans <vovinamorleans@gmail.com>'."\r\n";
	$headers .= 'Mime-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= "\r\n";
	 
	// Function mail()
	mail($to, $subject, $msg, $headers);

}