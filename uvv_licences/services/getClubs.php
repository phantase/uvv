<?php

/**
 * getQueries: retrieve something
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
if( isset($_COOKIE['numclub']) && $_COOKIE['numclub']!=-1 ){
	$res = $connexion->prepare($queries['getClub']);
	$success = $res->execute(array('numclub'=>$_COOKIE['numclub']));
	if( ! $success )
		die(createJSONResult("exception","Not a success"));
} else {
	$res = $connexion->query($queries['getClubs']);
}

$rows = array();

/** GO THROUGH RESULTS OF QUERY **/
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows[] = $data;
}

print json_encode($rows);

?>