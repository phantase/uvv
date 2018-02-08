<?php

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$viewFacture = checkParam('viewfact');
$viewClub = null;
if( isset($_COOKIE['numclub']) ){
	$viewClub = $_COOKIE['numclub'];
} else {
	die(createJSONResult("exception","Please give a club number"));
}

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

if( $viewClub != -1 ){ // If not admin, we must check the right to the user to see this Object
	$res = $connexion->prepare($queries['checkFactureRight']);
	$res->execute(array('club'=>$viewClub,'facture'=>$viewFacture));
	$fact = $res->fetch();
	if( $fact[0] != 1 )
		die(createJSONResult("exception","Pas autorisé"));
}
/** SET QUERY **/
$res = $connexion->prepare($queries["getAdherents4Facture"]);
$rows = array();
$success = $res->execute(array('facture'=>$viewFacture));

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