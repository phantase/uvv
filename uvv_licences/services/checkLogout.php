<?php

/**
 * checkLogout: Remove the user has credentials
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$_COOKIE['numclub'] = null;
$_COOKIE['nom'] = null;
$_COOKIE['mail'] = null;
$_COOKIE['appartenance'] = null;
$_COOKIE['estcomite'] = null;
$_COOKIE['login'] = null;
$_COOKIE['password'] = null;

setcookie("numclub",		null,		-1);
setcookie("nom",			null,		-1);
setcookie("mail",			null,		-1);
setcookie("appartenance",	null,		-1);
setcookie("estcomite",		null,		-1);
setcookie("login",			null,		-1);
setcookie("password",		null,		-1);

print(createJSONResult("Success","Good job boy!"));

?>