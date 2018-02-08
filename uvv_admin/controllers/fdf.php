<?php

// Retrieve all functions from the MODELS file
include_once('models/get_fdf.php');

// Retrieve all inscriptions
$inscrits = get_fdf_inscriptions();
$counts = array("stage"=>0,"compet"=>0,"nuit"=>0,"samedi"=>0,"dimanche"=>0,"hommes"=>0,"femmes"=>0);
foreach($inscrits as $cle => $inscrit){
    // COUNTS
    if($inscrit['stage']){ $counts["stage"]++; }
    if($inscrit['compet']){ $counts["compet"]++; }
    if($inscrit['nuit']){ $counts["nuit"]++; }
    if($inscrit['samedi']){ $counts["samedi"]++; }
    if($inscrit['dimanche']){ $counts["dimanche"]++; }
    if($inscrit['categorie']==1){ $counts["hommes"]++; }
    if($inscrit['categorie']==2){ $counts["femmes"]++; }
    
    // CLUB INFOS
    $cinfo = get_fdf_clubinfo($inscrit['numlicence']);
    $inscrit['numclub'] = $cinfo['numclub'];
    $inscrit['club'] = $cinfo['club'];
    $inscrit['saisonclub'] = $cinfo['saisonclub'];
    
    $clubs[$cle] = $inscrit['club'];
    $noms[$cle] = $inscrit['nom'];
    $prenoms[$cle] = $inscrit['prenom'];
    
    $inscrits[$cle] = $inscrit;
	
}

array_multisort($clubs,SORT_ASC,$noms,SORT_ASC,$prenoms,SORT_ASC,$inscrits);

$nbInscrits = count($inscrits);