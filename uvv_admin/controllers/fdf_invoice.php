<?php

// Retrieve all functions from the MODELS file
include_once('models/get_fdf.php');
include_once('models/get_clubs.php');

$invoice['datefac'] = date('d-m-Y');

$tresorier = get_clubTresorier($_GET['numclub']);

$inscrits = get_fdf_inscriptions();

$invoice['inscrits'] = array();
$invoice['total'] = 0;
$invoice['participants'] = 0;

foreach($inscrits as $cle => $inscrit){

    // CLUB INFOS
    $cinfo = get_fdf_clubinfo($inscrit['numlicence']);
    
    if( $cinfo['numclub'] == $_GET['numclub'] ){
        $invoice['club'] = $cinfo['club'];
        $invoice['numclub'] = $cinfo['numclub'];
        $invoice['participants']++;
        
        $noms[$cle] = $inscrit['nom'];
        $prenoms[$cle] = $inscrit['prenom'];
        
        $inscrit['total'] = ($inscrit['stage'])*10+($inscrit['compet'])*10+($inscrit['nuit'])*30+($inscrit['samedi'])*15+($inscrit['dimanche'])*10;

        $invoice['total']+=$inscrit['total'];
        
        $invoice['inscrits'][] = $inscrit;
    }
	
}

array_multisort($noms,SORT_ASC,$prenoms,SORT_ASC,$invoice['inscrits']);