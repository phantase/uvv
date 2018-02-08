<?php
try
{
	/** DEFINE NEEDED PHP FILES **/
	define( 'ABSPATH', dirname(__FILE__) . '/' );
	require_once( ABSPATH . 'config.php' );
	require_once( ABSPATH . 'queries.php' );
	require_once( ABSPATH . 'mail.php' );
	
	if( isset($_COOKIE['numclub']) && $_COOKIE['numclub']!=-1 ){
		$viewClub = $_COOKIE['numclub'];
	} else {
		die(createJSONResult("exception","Please log as a club to do that !"));
	}
	
	/** OPEN AND SELECT DATABASE **/
	$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

	$res = $connexion->prepare($queries['getAdherentsFactureTotal']);
	$res->execute(array('club'=>$viewClub));
	$fact = $res->fetch();
	if( $fact[0] == 0 )
		die(createJSONResult("exception","Rien à payer"));
	
    $connexion->beginTransaction();
	
	$addFacture = $connexion->prepare($queries['addFacture'])->execute(array('club'=>$viewClub));

	$idFacture = $connexion->lastInsertId();
	
	$setAdherentsToFacture = $connexion->prepare($queries['setAdherentsToFacture'])->execute(array('club'=>$viewClub,'facture'=>$idFacture));
	
	$moveAdherentsStatus = $connexion->prepare($queries['moveAdherentsStatus'])->execute(array('club'=>$viewClub,'oldstatut'=>1,'nvstatut'=>2));
	
    $connexion->commit();
   
    echo createJSONResult("success",$idFacture);
	
	$msg = "";
	$msg .= "<h1>Nouvelle facture créée</h1>";
	$msg .= "<p>Bonjour,<br/>Le Club <b>".$_COOKIE['nom']."</b> vient de générer une nouvelle facture d'un montant de <i>".$fact[0]." €</i>.</p>";
	$msg .= "<p>Vous pouvez retrouver le détail de cette facture sous le numéro suivant : <a>".$idFacture."</a>*.</p>";
	$msg .= "<p><b><i>L'équipe licences de l'Union Vovinam</i></b></p>";
	$msg .= "<p><small>* bientôt, un lien permettra directement d'aller sur la facture...</small></p>";
	
	sendMail($msg,$_COOKIE['mail']);
	
}
catch(Exception $e)
{
    $connexion->rollback();

	die(createJSONResult("exception",$e->getMessage()));
	
    exit();
}

?>