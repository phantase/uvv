<?php
try
{
	/** DEFINE NEEDED PHP FILES **/
	define( 'ABSPATH', dirname(__FILE__) . '/' );
	require_once( ABSPATH . 'config.php' );
	require_once( ABSPATH . 'queries.php' );
	require_once( ABSPATH . 'mail.php' );
	
	if( isset($_COOKIE['numclub']) && $_COOKIE['numclub']==-1 ){
		$facture = $_GET['facture'];
	} else {
		die(createJSONResult("exception","Please log as an admin to do that !"));
	}
	
	/** OPEN AND SELECT DATABASE **/
	$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

    $connexion->beginTransaction();
	
	$setFacturePaye = $connexion->prepare($queries['setFacturePaye'])->execute(array('facture'=>$facture));

	$setAdherentsStatusPaye = $connexion->prepare($queries['setAdherentsStatusPaye'])->execute(array('facture'=>$facture,'oldstatut'=>2,'nvstatut'=>3));
	
    $connexion->commit();
   
    echo createJSONResult("success",$facture);
	
	$msg = "";
	$msg .= "<h1>Facture payée</h1>";
	$msg .= "<p>Bonjour,<br/>La Facture <b>".$facture."</b> vient d'être validée comme payée par un admin.</p>";
	$msg .= "<p>Vous pouvez retrouver le détail de cette facture sous le numéro suivant : <a>".$facture."</a>*.</p>";
	$msg .= "<p><b><i>L'équipe licences de l'Union Vovinam</i></b></p>";
	$msg .= "<p><small>* bientôt, un lien permettra directement d'aller sur la facture...</small></p>";
	
//	sendMail($msg,$_COOKIE['mail']);
	
}
catch(Exception $e)
{
    $connexion->rollback();

	die(createJSONResult("exception",$e->getMessage()));
	
    exit();
}

?>