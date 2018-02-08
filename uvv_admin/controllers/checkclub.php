<?php

// Retrieve all functions from the MODELS file
include_once('models/get_clubs.php');
	
// Retrieve all the clubs
$clubs = get_ClubWithLoginPassword($login,$password);

// Check if there is some results
if( count($clubs) != 1 ) {
	$authenticationMessage = array(
		"class" => "box-danger",
		"title" => _('Authentication failled'),
		"body" => _('The pair login/password is not recognized, please try again.'),
	);
} else {
	$_SESSION['clubnum'] = $clubs[0]['numclub'];
	$_SESSION['clubnom'] = $clubs[0]['nom'];
	$_SESSION['clubmail'] = $clubs[0]['mail'];
	$_SESSION['clubappartenance'] = $clubs[0]['appartenance'];
	$_SESSION['clubestcomite'] = $clubs[0]['estcomite'];
	$_SESSION['clublogin'] = $clubs[0]['login'];
	
	$authenticationMessage = array(
		"class" => "box-success",
		"title" => _('Authentication successful'),
		"body" => _('You are now logged in.'),
	);	
}

?>