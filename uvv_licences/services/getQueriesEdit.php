<?php

/**
 * getQueriesEdit: retrieve something for jquery.editable SELECTs
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$query = checkParam('query');
if(!isset($queries[$query])){
	die(createJSONResult("exception","bad query"));
}

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
$res = $connexion->query($queries[$query]);

//$rows = array();

/** GO THROUGH RESULTS OF QUERY **/
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows["_".$data->id] = $data->value;
}

print json_encode($rows);

?>