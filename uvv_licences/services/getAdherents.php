<?php

/**
 * getAdherents: retrieve adherents
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$typeFilter = checkParam('typefilter');
$viewClub = checkParam('viewclub');
if( $viewClub == 'null' | $viewClub == 0 ){
	if( isset($_COOKIE['numclub']) && $_COOKIE['numclub']!=-1 ){
		$viewClub = $_COOKIE['numclub'];
	} else {
		$viewClub = 0;
	}
}

if( $viewClub == 0 ){
	// Voir tous les club
	$query = ($typeFilter == 0) ? "getAdherentsFull" : "getAdherentsFilter";
	$arrayOfParams = ($typeFilter == 0) ? null : array('typefilter'=>$typeFilter);
} else {
	// Voir juste le club sélectionné
	$query = ($typeFilter == 0) ? "getAdherentsClubFull" : "getAdherentsClubFilter";
	$arrayOfParams = ($typeFilter == 0) ? array('club'=>$viewClub) : array('typefilter'=>$typeFilter,'club'=>$viewClub);
}

$saison = checkParam('saison');
if( $saison == '0' ){
	$querySaison = "";
} else {
	$query .= "Saison";
	$arrayOfParams['saison'] = $saison;
}

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
error_log($query);
$res = $connexion->prepare($queries[$query]);
$rows = array();
$success = $res->execute($arrayOfParams);

if( ! $success ){
	error_log(print_r($connexion->errorInfo(),true));
	die(createJSONResult("exception","Not a success"));
}
	
/** GO THROUGH RESULTS OF QUERY **/
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows[] = $data;
}

print json_encode($rows);

?>