<?php

// Retrieve all functions from the MODELS file
include_once('models/get_members.php');

// Retrieve the members
$members = get_allMembers();

$nbMembers = count($members);

// Go through all the results to secure display
foreach($members as $cle => $member)
{
	
}
	
?>