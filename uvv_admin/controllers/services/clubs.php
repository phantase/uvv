<?php

include_once('models/get_clubs.php');

$all_clubs = get_OnlyClubs();
$output = array();
foreach ($all_clubs as $key => $single_club) {
    $club = array();
    $club['numclub'] = $single_club['numclub'];
    $club['nomclub'] = $single_club['nomclub'];
    $club['mail'] = $single_club['mail'];
    $club['numcomite'] = $single_club['numcomite'];
    $club['nomcomite'] = $single_club['nomcomite'];
    $output[] = $club;
}
