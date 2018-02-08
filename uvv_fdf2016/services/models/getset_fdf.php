<?php

/** TOKEN **/
function get_token($numlicence)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT t.id, t.numlicence, t.token, t.validity FROM uvv_fdf2016_adh_token AS t WHERE t.numlicence=:licence');
    $req->bindParam(':licence',$numlicence);
    $req->execute();
    $token = $req->fetch(PDO::FETCH_ASSOC);
    
    return $token;
}
function set_token($numlicence)
{
    global $bdd;
    
    $token = rand();
    
    if(get_token($numlicence) != false ){
        $req = $bdd->prepare('UPDATE uvv_fdf2016_adh_token SET token=:token, validity=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE numlicence=:licence');
    } else {
        $req = $bdd->prepare('INSERT INTO uvv_fdf2016_adh_token(id,numlicence,token,validity) VALUES (NULL,:licence,:token,DATE_ADD(NOW(), INTERVAL 1 HOUR))');
    }
    $req->bindParam(':licence',$numlicence);
    $req->bindParam(':token',$token);
    $req->execute();
    
    return $token;
}
function check_token($numlicence,$token)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT t.id FROM uvv_fdf2016_adh_token AS t WHERE t.numlicence=:licence AND t.token=:token AND t.validity>NOW()');
    $req->bindParam(':licence',$numlicence);
    $req->bindParam(':token',$token);
    $req->execute();
    $result = $req->fetchAll();
    
    return (count($result)>0);
}
/** INSCRIPTION **/
function get_inscription($numlicence)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT i.id, i.numlicence, i.stage, i.compet, i.nuit, i.samedi, i.dimanche, i.commentaires, i.inscription FROM uvv_fdf2016_adh_inscr AS i WHERE i.numlicence=:licence');
    $req->bindParam(':licence',$numlicence);
    $req->execute();
    $inscription = $req->fetch(PDO::FETCH_ASSOC);
    
    return $inscription;
}
function set_inscription($numlicence, $stage, $compet, $nuit, $samedi, $dimanche, $commentaires)
{
    global $bdd;
    
    $output = array('success' => false);
    
    if(get_inscription($numlicence) != false ){
        // this is an update
        $output['method'] = "update";
        $req = $bdd->prepare('UPDATE uvv_fdf2016_adh_inscr SET stage = :stage, compet = :compet, nuit = :nuit, samedi = :samedi, dimanche = :dimanche, commentaires = :commentaires WHERE numlicence = :numlicence');
    } else {
        // this is an insert
        $output['method'] = "insert";
        $req = $bdd->prepare('INSERT INTO uvv_fdf2016_adh_inscr (id,numlicence,stage,compet,nuit,samedi,dimanche,commentaires) VALUES (NULL, :numlicence, :stage, :compet, :nuit, :samedi, :dimanche, :commentaires)');
    }
    
    $req->bindParam(':numlicence',$numlicence);
    $req->bindParam(':stage',$stage);
    $req->bindParam(':compet',$compet);
    $req->bindParam(':nuit',$nuit);
    $req->bindParam(':samedi',$samedi);
    $req->bindParam(':dimanche',$dimanche);
    $req->bindParam(':commentaires',$commentaires);
    $output['success'] = $req->execute();
    
    return $output;
}
/** ACCOMPAGNANTS **/
function get_accompagnants($numlicence)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT a.id, a.numlicence, a.nomprenom, a.sexe, a.age, a.nuit, a.samedi, a.dimanche, a.chambord FROM uvv_fdf2016_adh_accomp AS a WHERE a.numlicence=:licence ORDER BY a.id ASC');
    $req->bindParam(':licence',$numlicence);
    $req->execute();
    $accompagnants = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $accompagnants;
}
function del_accompagnants($numlicence)
{
    global $bdd;
    
    $req = $bdd->prepare('DELETE FROM uvv_fdf2016_adh_accomp WHERE numlicence=:licence');
    $req->bindParam(':licence',$numlicence);
    return $req->execute();
    
}
function add_accompagnant($numlicence,$accompagnant)
{
    global $bdd;
    
    $req = $bdd->prepare('INSERT INTO uvv_fdf2016_adh_accomp (id, numlicence, nomprenom, sexe, age, nuit, samedi, dimanche, chambord) VALUES (NULL, :licence, :nomprenom, :sexe, :age, :nuit, :samedi, :dimanche, :chambord)');
    $req->bindParam(':licence',$numlicence);
    $req->bindParam(':nomprenom',$accompagnant['nomprenom']);
    $req->bindParam(':sexe',$accompagnant['sexe']);
    $req->bindParam(':age',$accompagnant['age']);
    $req->bindParam(':nuit',$accompagnant['nuit']);
    $req->bindParam(':samedi',$accompagnant['samedi']);
    $req->bindParam(':dimanche',$accompagnant['dimanche']);
    $req->bindParam(':chambord',$accompagnant['chambord']);
    return $req->execute();
    
}

/** INSCRIPTIONS **/
function get_inscriptions()
{
	global $bdd;
	
	$req = $bdd->prepare('SELECT i.id, i.numlicence, a.nom, a.prenom, a.datenaissance, a.mail, i.stage, i.compet, i.nuit, i.samedi, i.dimanche, i.commentaires, i.inscription FROM uvv_fdf2016_adh_inscr AS i, uvv_adherents AS a WHERE i.numlicence=a.numlicence ORDER BY i.inscription');
	$req->execute();
	$inscriptions = $req->fetchAll(PDO::FETCH_ASSOC);
	
	return $inscriptions;
}
function get_clubinfo($numlicence)
{
	global $bdd;
	
	$req = $bdd->prepare('SELECT c.numclub, c.nom AS club, sa.nom AS saisonclub FROM uvv_clubs AS c, uvv_statut AS s, uvv_saisons AS sa WHERE s.saison=sa.numsaison AND s.statut=3 AND s.club=c.numclub AND s.adherent=:numlicence ORDER BY s.saison DESC LIMIT 1');
	$req->bindParam(':numlicence',$numlicence);
	$req->execute();
	$clubinfo = $req->fetch(PDO::FETCH_ASSOC);
	
	return $clubinfo;
}

function get_tokens_pas_inscrits()
{
	global $bdd;
	
	$req = $bdd->prepare('SELECT t.id, t.numlicence, a.nom, a.prenom, a.datenaissance, a.mail, t.validity FROM uvv_fdf2016_adh_token AS t, uvv_adherents AS a WHERE t.numlicence=a.numlicence AND t.numlicence NOT IN (SELECT i.numlicence FROM uvv_fdf2016_adh_inscr AS i)');
	$req->execute();
	$tokens = $req->fetchAll(PDO::FETCH_ASSOC);
	
	return $tokens;
}