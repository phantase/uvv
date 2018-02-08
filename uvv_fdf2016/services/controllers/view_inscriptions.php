<?php

$inscrits = get_inscriptions();
foreach($inscrits as &$inscrit){
	$cinfo = get_clubinfo($inscrit['numlicence']);
	$inscrit['club'] = $cinfo['club'];
	$inscrit['saisonclub'] = $cinfo['saisonclub'];
}

$tokens = get_tokens_pas_inscrits();
foreach($tokens as &$token){
	$cinfo = get_clubinfo($token['numlicence']);
	$token['club'] = $cinfo['club'];
	$token['saisonclub'] = $cinfo['saisonclub'];
}