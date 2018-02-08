<?php

/**
 * addPart: Add something
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$query = checkParam('query');
if(!isset($queries['add'.$query])){
	die(createJSONResult("exception","bad query"));
}
	
$arrayToInsert = getParamsArray('add'.$query,null);

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
$insert = $connexion->prepare($queries['add'.$query]);

/** INSERT THE VALUE **/
try {
	$success = $insert->execute($arrayToInsert);
	
	if( ! $success )
		die(createJSONResult("Faillure","Echec de l'ajout..."));
	
} catch( Exception $e ){
	die(createJSONResult("exception",$e->getMessage()));
}

/** RETRIEVE THE INSERTED RECORD **/
$res = $connexion->prepare($queries['getSingle'.$query]);
$rows = array();
$success = $res->execute(getParamsArray('getSingle'.$query,$connexion->lastInsertId()));
if( ! $success )
	die(createJSONResult("exception","Not a success"));

while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows[] = $data;
}

print(json_encode($rows));

?>