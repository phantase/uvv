<?php

include_once('models/get_clubs.php');

$all_comites = get_OnlyComites();
$output = array();
foreach ($all_comites as $key => $single_comite) {
    $comite = array();
    $comite['numcomite'] = $single_comite['numcomite'];
    $comite['nomcomite'] = $single_comite['nomcomite'];
    $comite['mailcomite'] = $single_comite['mailcomite'];
    $output[] = $comite;
}
