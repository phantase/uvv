<?php

function sendMail($msg,$otherto) {

	// To
	$to = 'vice-secretaire@unionvovinam.fr,contact@unionvovinam.fr';
	
	if( $otherto != null )
		$to .= ','.$otherto;
	 
	// Subject
	$subject = 'Union Vovinam - Espace Licences';
	 
	// Headers
	$header = "From: \"Licences UVV\"<licences@unionvovinam.fr>"."\r\n";
	$headers = 'Mime-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= "\r\n";
	 
	// Function mail()
	mail($to, $subject, $msg, $headers);

}

?>