<?php

// Retrieve all functions from the MODELS file
include_once('models/get_seasons.php');

$season = get_singleSeason(filter_input(INPUT_GET, 'seasonnumber'));