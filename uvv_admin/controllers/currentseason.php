<?php

// Retrieve all functions from the MODELS file
include_once('models/get_seasons.php');

// Retrieve the invoices
$season = get_currentSeason();

if( count($season) != 1 ){
	$season = array(array("nom" => _('error')));
}
	
?>