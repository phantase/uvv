<?php

/**
 * getQueries: retrieve something
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$query = checkParam('query');
if(!isset($queries[$query])){
	die(createJSONResult("exception","bad query"));
}

$arrayOfParams = getParamsArray($query,null);

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
$res = $connexion->prepare($queries[$query]);
$rows = array();
$success = $res->execute($arrayOfParams);

if( ! $success )
	die(createJSONResult("exception","Not a success"));

/** GO THROUGH RESULTS OF QUERY **/
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows[] = $data;
}

print json_encode($rows);

?>