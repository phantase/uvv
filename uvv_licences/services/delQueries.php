<?php

/**
 * delQueries: delete something
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$query = 'del'.checkParam('query');
if(!isset($queries[$query])){
	die(createJSONResult("exception","bad query"));
}

$usefulthing = checkParam('usefulthing');

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
$del = $connexion->prepare($queries[$query]);

/** DELETE THE ROW **/
try {
	$success = $del->execute(array(
			'deletedid'=>checkParam('deletedid')
	));
	if( ! $success )
		die(createJSONResult("Faillure","Not a success"));
	
} catch( Exception $e ){
	die(createJSONResult("exception",$e->getMessage()));
}

print(createJSONResult("Success",$usefulthing));	// TODO : logguer ce qui a été fait, voir aussi à prévenir l'admin
//print(createJSONResult("Faillure","Ca a foiré chef"));

?>