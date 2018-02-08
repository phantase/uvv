<?php
function get_allSeasons()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT s.numsaison, s.nom, s.debut, s.fin, s.encours FROM uvv_saisons AS s ORDER BY s.fin DESC');
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}

function get_currentSeason()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT s.numsaison, s.nom, s.debut, s.fin, s.encours FROM uvv_saisons AS s WHERE s.encours = 1 ORDER BY s.fin DESC');
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}

function get_singleSeason($numsaison)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT s.numsaison, s.nom, s.debut, s.fin, s.encours FROM uvv_saisons AS s WHERE s.numsaison = :numsaison');
    $req->bindParam(':numsaison',$numsaison);
    $req->execute();
    $season = $req->fetch();
    
    return $season;
}
?>