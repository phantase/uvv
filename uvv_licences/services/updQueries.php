<?php

/**
 * UpdQueries: Update something
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );
require_once( ABSPATH . 'queries.php' );

$query = checkParam('query');
if(!isset($queries['upd'.$query])){
	die(createJSONResult("exception","bad query"));
}
$newvalue = checkParam('value');
$idcol = checkParam('idcol');
if(isset($_REQUEST['lexique'])){
	$newvalue = substr($newvalue,1);
}
if(isset($_REQUEST['estdate'])){
	$dateA = explode('/',$newvalue);
	$newvalue = $dateA[2]."-".$dateA[1]."-".$dateA[0];
}

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

$col = checkParam('col');

/** SET QUERY **/ // Bon, c'est dégueux d'avoir utiliser un str_replace, mais là sur le coup, j'avais pas envie de démultiplier les requêtes pour le plaisir...
$update = $connexion->prepare(str_replace("@@COLFROM@@",$col,$queries['upd'.$query]));

/** UPDATE THE VALUE **/
try {
	$success = $update->execute(array(
		'newvalue'=>$newvalue,
		$idcol=>checkParam($idcol)));
	
	if( ! $success )
		die("Echec");
	
} catch( Exception $e ){
	die("Echecbis");
}

if( $col == 'grade' ){ // Si on change le grade, on veut le conserver en historique
	$addHistory = $connexion->prepare($queries['addGradeSaison']);
	try {
		$success2 = $addHistory->execute(array(
			'adherent'=>checkParam('numlicence'),
			'club'=>checkParam('numclub'),
			'grade'=>$newvalue
		));
		
		if( !$success2 )
			die("Echecter");
	} catch( Exception $s ){
		die("Echecqua");
	}
}

/** IF LEXIQUE : RETURN THE VALUE AND NOT THE ID **/
if(isset($_REQUEST['lexique'])){
	$res = $connexion->prepare($queries['getLEX'.$_REQUEST['lexique'].'ForId']);
	$success = $res->execute(array('id'=>$newvalue));
	if( ! $success )
		die(createJSONResult("exception","Not a success"));
	/** GO THROUGH RESULTS OF QUERY **/
	while( $data = $res->fetch(PDO::FETCH_OBJ) ){
		$newvalue = $data->value;
	}
}
if(isset($_REQUEST['estdate'])){
		$dateA = explode('-',$newvalue); // newvalue : yyyy-mm-dd
		$newvalue = $dateA[2]."/".$dateA[1]."/".$dateA[0];
}

print($newvalue);

?>