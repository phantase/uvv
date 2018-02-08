<?php

/**
 * checkLogin: Check if the user has credentials
 * WARNING : the username & password in the cookies is BAD !!!
 * see http://stackoverflow.com/questions/244882/what-is-the-best-way-to-implement-remember-me-for-a-website
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

if( isset($_COOKIE['login']) && isset($_COOKIE['password']) ) {
	$login = $_COOKIE['login'];
	$password = $_COOKIE['password'];
} else {
	$login = checkParam('login');
	$password = checkParam('password');
}
	
$rows = array();

if( $login != "administrateur" ){
	/** OPEN AND SELECT DATABASE **/
	$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

	/** SET QUERY **/
	$res = $connexion->prepare($queries['checkClubCredentials']);
	$success = $res->execute(array('login'=>$login,'password'=>$password));
	if( ! $success )
		die(createJSONResult("exception","Not a success"));

	while( $data = $res->fetch(PDO::FETCH_OBJ) ){
		$rows[] = $data;
	}
} else {
	if( $password != "123456" )
		die(createJSONResult("exception","Not a success"));
	
	$row = new stdClass();
	$row->numclub = -1;
	$row->nom = "Administrateur";
	$row->mail = "webmaster@unionvovinam.fr";
	$row->appartenance = 0;
	$row->estcomite = 0;
	$row->login = $login;
	
	$rows[] = $row;
}

if( count($rows) > 0 ) {	// Add the cookie only if we are logged in
	setcookie("numclub",		$rows[0]->numclub,		0);
	setcookie("nom",			$rows[0]->nom,			0);
	setcookie("mail",			$rows[0]->mail,			0);
	setcookie("appartenance",	$rows[0]->appartenance,	0);
	setcookie("estcomite",		$rows[0]->estcomite,	0);
	setcookie("login",			$rows[0]->login,		time()+60*60*24*30);
	setcookie("password",		$password,				time()+60*60*24*30);
}

print json_encode($rows);

?>