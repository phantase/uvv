<?php

function get_fdf_inscriptions()
{
	global $bdd;
	
	$req = $bdd->prepare('SELECT i.id, i.numlicence, a.nom, a.prenom, '
                . 'a.datenaissance, a.mail, i.stage, i.compet, i.nuit, '
                . 'i.samedi, i.dimanche, i.commentaires, i.inscription, '
                . 'a.categorie, a.grade AS gradeid, lg.grade, lg.gradecourt '
                . 'FROM uvv_fdf2016_adh_inscr AS i, uvv_adherents AS a, '
                . 'uvv_lex_grades AS lg '
                . 'WHERE i.numlicence=a.numlicence AND a.grade=lg.id '
                . 'ORDER BY i.inscription');
	$req->execute();
	$inscriptions = $req->fetchAll(PDO::FETCH_ASSOC);
	
	return $inscriptions;
}
function get_fdf_clubinfo($numlicence)
{
	global $bdd;
	
	$req = $bdd->prepare('SELECT c.numclub, c.nom AS club, '
                . 'sa.nom AS saisonclub '
                . 'FROM uvv_clubs AS c, uvv_statut AS s, uvv_saisons AS sa '
                . 'WHERE s.saison=sa.numsaison AND s.statut=3 '
                . 'AND s.club=c.numclub AND s.adherent=:numlicence '
                . 'ORDER BY s.saison DESC LIMIT 1');
	$req->bindParam(':numlicence',$numlicence);
	$req->execute();
	$clubinfo = $req->fetch(PDO::FETCH_ASSOC);
	
	return $clubinfo;
}
function get_fdf_accompagnants($numlicence)
{
        global $bdd;
	
	$req = $bdd->prepare('SELECT c.numclub, c.nom AS club, '
                . 'sa.nom AS saisonclub '
                . 'FROM uvv_clubs AS c, uvv_statut AS s, uvv_saisons AS sa '
                . 'WHERE s.saison=sa.numsaison AND s.statut=3 '
                . 'AND s.club=c.numclub AND s.adherent=:numlicence '
                . 'ORDER BY s.saison DESC LIMIT 1');
	$req->bindParam(':numlicence',$numlicence);
	$req->execute();
	$accompagnants = $req->fetch(PDO::FETCH_ASSOC);
	
	return $accompagnants;
}

function get_fdf_tokens_pas_inscrits()
{
	global $bdd;
	
	$req = $bdd->prepare('SELECT t.id, t.numlicence, a.nom, a.prenom, '
                . 'a.datenaissance, a.mail, t.validity '
                . 'FROM uvv_fdf2016_adh_token AS t, uvv_adherents AS a '
                . 'WHERE t.numlicence=a.numlicence '
                . 'AND t.numlicence NOT IN '
                . '(SELECT i.numlicence FROM uvv_fdf2016_adh_inscr AS i)');
	$req->execute();
	$tokens = $req->fetchAll(PDO::FETCH_ASSOC);
	
	return $tokens;
}

?>