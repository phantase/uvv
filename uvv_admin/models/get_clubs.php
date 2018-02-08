<?php

function get_allClubs()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT c.numclub, c.nom, c.mail, c.appartenance, c.estcomite, c.login '
            . 'FROM uvv_clubs AS c '
            . 'ORDER BY c.nom ASC');
    $req->execute();
    $clubs = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $clubs;
}

function get_OnlyClubs()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT club.numclub, club.nom AS nomclub, club.mail, '
            . 'club.appartenance AS numcomite, comite.nom AS nomcomite '
            . 'FROM uvv_clubs AS club, uvv_clubs AS comite '
            . 'WHERE NOT club.estcomite '
            . 'AND club.appartenance = comite.numclub '
            . 'ORDER BY club.nom ASC');
    $req->execute();
    $clubs = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $clubs;
}

function get_OnlyComites()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT comite.numclub AS numcomite, '
            . 'comite.nom AS nomcomite, comite.mail AS mailcomite '
            . 'FROM uvv_clubs AS comite '
            . 'WHERE comite.estcomite '
            . 'ORDER BY comite.nom ASC');
    $req->execute();
    $clubs = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $clubs;
}

function get_ClubWithLoginPassword($login,$password)
{
    global $bdd;
    $login = (string) $login;
    $password = (string) $password;
	
	$crypted = md5($password);
	
    $req = $bdd->prepare('SELECT c.numclub, c.nom, c.mail, c.appartenance, c.estcomite, c.login '
            . 'FROM uvv_clubs AS c '
            . 'WHERE c.login = :login AND c.password = :crypted');
    $req->bindParam(':login', $login, PDO::PARAM_STR);
    $req->bindParam(':crypted', $crypted, PDO::PARAM_STR);
    $req->execute();
    $clubs = $req->fetchAll();
    
    return $clubs;
}

function get_clubTresorier($numclub)
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT ct.id, ct.numclub, ct.nomprenom, ct.adrvoie, ct.adrcp, ct.adrville, ct.mail '
            . 'FROM uvv_club_tresorier AS ct '
            . 'WHERE ct.numclub=:numclub');
    $req->bindParam(':numclub', $numclub, PDO::PARAM_INT);
    $req->execute();
    $tresorier = $req->fetch();
    
    return $tresorier;
}

?>