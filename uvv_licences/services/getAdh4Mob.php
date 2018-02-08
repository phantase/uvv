<?php

/**
 * getAdh4Mob: retrieve adherents infos for mobile application
 */

/** DEFINE NEEDED PHP FILES **/
define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );

if( isset($_GET['numlicence']) ){
	$numlicence = $_GET['numlicence'];
} else {
	die(createJSONResult("exception","Not a success"));
}

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** QUERY to retrieve basic adherent information **/
$res = $connexion->prepare('SELECT a.numlicence, a.prenom, SUBSTRING(a.nom,1,1) AS nom, lc.categoriecourt AS categoriec, TIMESTAMPDIFF(YEAR,a.datenaissance,CURDATE()) AS age, mail FROM uvv_adherents AS a, uvv_lex_categories AS lc WHERE a.numlicence=:numlicence AND a.categorie=lc.id');
$rows_uvv_adherents = array();
$success = $res->execute(array('numlicence'=>$numlicence));
if( ! $success ){
	error_log(print_r($connexion->errorInfo(),true));
	die(createJSONResult("exception","Not a success"));
}
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows_uvv_adherents[] = $data;
}
/** QUERY to retrieve adherent's club **/
$res = $connexion->prepare('SELECT c.numclub, c.nom, c.appartenance FROM uvv_statut AS s, uvv_clubs AS c WHERE s.adherent=:numlicence AND c.numclub=s.club ORDER BY s.idstatut DESC');
$rows_club = array();
$success = $res->execute(array('numlicence'=>$numlicence));
if( ! $success ){
	error_log(print_r($connexion->errorInfo(),true));
	die(createJSONResult("exception","Not a success"));
}
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows_club[] = $data;
}
/** QUERY to retrieve adherent's comite **/
$numcomite = ""; $comite = "";
if( $rows_club[0]->appartenance != 0 ){
	$res = $connexion->prepare('SELECT c.numclub, c.nom  FROM uvv_clubs AS c WHERE c.numclub=:numcomite');
	$rows_comite = array();
	$success = $res->execute(array('numcomite'=>$rows_club[0]->appartenance));
	if( ! $success ){
		error_log(print_r($connexion->errorInfo(),true));
		die(createJSONResult("exception","Not a success"));
	}
	while( $data = $res->fetch(PDO::FETCH_OBJ) ){
		$rows_comite[] = $data;
	}
	$numcomite = $rows_comite[0]->numclub;
	$comite = $rows_comite[0]->nom;
}
/** QUERY to retrieve adherent's grades **/
$res = $connexion->prepare('SELECT g.grade AS idgrade, g.saison, s.debut, s.fin, YEAR(s.debut) AS annee, lg.grade , lg.gradecourt FROM uvv_grades AS g, uvv_saisons AS s, uvv_lex_grades AS lg WHERE g.adherent=:numlicence AND g.saison=s.numsaison AND g.grade=lg.id ORDER BY g.grade DESC');
$rows_grades = array(); $annees = array(); $anneepratique = 9999;
$success = $res->execute(array('numlicence'=>$numlicence));
if( ! $success ){
	error_log(print_r($connexion->errorInfo(),true));
	die(createJSONResult("exception","Not a success"));
}
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows_grades[] = $data;
	$annees[$data->gradecourt]=$data->annee;
	if( $data->annee < $anneepratique )
		$anneepratique = $data->annee;
}
/** QUERY to retrieve adherent's position in bureau **/
$res = $connexion->prepare('SELECT st.statut, st.club, c.estcomite FROM uvv_statut AS st, uvv_saisons AS sa, uvv_clubs AS c WHERE st.adherent=:numlicence AND st.saison=sa.numsaison AND sa.encours = 1 AND st.club=c.numclub');
$statuts = new stdClass();
$success = $res->execute(array('numlicence'=>$numlicence));
if( ! $success ){
	error_log(print_r($connexion->errorInfo(),true));
	die(createJSONResult("exception","Not a success"));
}
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	if( $data->statut == 3) {$statuts->licence = 1;}
	if( $data->statut == 7 && $data->estcomite == 0 ) {$statuts->pclub = 1;}
	if( $data->statut == 9 && $data->estcomite == 0 ) {$statuts->sclub = 1;}
	if( $data->statut == 11 && $data->estcomite == 0 ) {$statuts->tclub = 1;}
	if( $data->statut == 7 && $data->estcomite == 1 ) {$statuts->pcomi = 1;}
	if( $data->statut == 9 && $data->estcomite == 1 ) {$statuts->scomi = 1;}
	if( $data->statut == 11 && $data->estcomite == 1 ) {$statuts->tcomi = 1;}
	if( $data->statut == 7 && $data->club == 0 ) {$statuts->puni = 1;}
	if( $data->statut == 9 && $data->club == 0 ) {$statuts->suni = 1;}
	if( $data->statut == 11 && $data->club == 0 ) {$statuts->tuni = 1;}
}

$result = new stdClass();
$result->numlicence		= $rows_uvv_adherents[0]->numlicence;
$result->prenom			= $rows_uvv_adherents[0]->prenom;
$result->nom			= $rows_uvv_adherents[0]->nom;
$result->grade			= $rows_grades[0]->gradecourt;
$result->sexe			= $rows_uvv_adherents[0]->categoriec;
$result->age			= $rows_uvv_adherents[0]->age;
$result->mail			= $rows_uvv_adherents[0]->mail;
$result->numclub		= $rows_club[0]->numclub;
$result->club			= $rows_club[0]->nom;
$result->numcomite		= $numcomite;
$result->comite			= $comite;
$result->annee_pratique	= $anneepratique;
$result->annee_cj01		= $annees['CJ01'];
$result->annee_cj02		= $annees['CJ02'];
$result->annee_cj03		= $annees['CJ03'];
$result->annee_ms		= $annees['MS'];
$result->annee_m		= $annees['M'];
$result->licence				= $statuts->licence == 1 ? 1 : 0;
$result->president_club			= $statuts->pclub == 1 ? 1 : 0;
$result->tresorier_club			= $statuts->tclub == 1 ? 1 : 0;
$result->secretaire_club		= $statuts->sclub == 1 ? 1 : 0;
$result->president_comite		= $statuts->pcomi == 1 ? 1 : 0;
$result->tresorier_comite		= $statuts->tcomi == 1 ? 1 : 0;
$result->secretaire_comite		= $statuts->scomi == 1 ? 1 : 0;
$result->president_union		= $statuts->puni == 1 ? 1 : 0;
$result->tresorier_union		= $statuts->tuni == 1 ? 1 : 0;
$result->secretaire_union		= $statuts->suni == 1 ? 1 : 0;

//var_dump($result);

print json_encode($result);

?>