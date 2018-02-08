<?php

/**
 * getAdherentsFacture: retrieve adherents with statut "Paiement en attente"
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$viewClub = null;
if( isset($_REQUEST['viewclub']) )
	$viewClub = $_REQUEST['viewclub'];	// autorisé ça que si on est admin...
if( $viewClub == 'null' | $viewClub == 0 ){
	if( isset($_COOKIE['numclub']) && $_COOKIE['numclub']!=-1 ){
		$viewClub = $_COOKIE['numclub'];
	} else {
		die(createJSONResult("exception","Please give a club number"));
	}
}

$query = "getAdherents2Facture";
$arrayOfParams = array('club'=>$viewClub);

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