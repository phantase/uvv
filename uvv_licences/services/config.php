<?php

/**
 * config file
 */

/** Definition of DB parameters */
define('DB_NAME', 'unionvovinamwww');
define('DB_USER', 'unionvovinamwww');
define('DB_PASSWORD', 'zaVxvCoi');
define('DB_HOST', 'mysql51-53.pro');
define('DB_CHARSET', 'utf8');

/** Definition of prefix for the DB */
define('TABLE_PREFIX','');
define('ALLOWED_SYNTAXES','#\b(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT( +INTO){0,1}|MERGE|SELECT|UPDATE|UNION( +ALL){0,1})\b#');

function checkParam($param){
	if(!isset($_REQUEST[$param])) {
		error_log("Exception: input parameter missing : ".$param);
		die(createJSONResult("exception","input parameter missing"));
	}

	$$param = $_REQUEST[$param];
	if(preg_match(ALLOWED_SYNTAXES,$$param)) {
		error_log("Exception: input parameter not accepted : ".$param." (".$$param.")");
		die(createJSONResult("exception","input parameter not accepted"));
	} else {
		return $$param;
	}
}

function createJSONResult($type,$message){
	$arr = array("result"=>$type,"message"=>$message);
	return json_encode($arr);
}

?>
