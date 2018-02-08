<?php

// Retrieve all functions from the MODELS file
include_once('models/get_invoices.php');

// Retrieve the invoices
if(isAdmin()){
    $unpayedinvoices = get_unPayedInvoices();
} else {
    $unpayedinvoices = get_unPayedClubInvoices($_SESSION['clubnum']);
}

$nbFactures = count($unpayedinvoices);

// Go through all the results to secure display
foreach($unpayedinvoices as $cle => $singleinvoice)
{
	$unpayedinvoices[$cle]['numfacture'] = $singleinvoice['numfacture'];
	$unpayedinvoices[$cle]['club'] = $singleinvoice['club'];
	$unpayedinvoices[$cle]['nom'] = $singleinvoice['nom'];
	$unpayedinvoices[$cle]['montant'] = $singleinvoice['montant'];
	$unpayedinvoices[$cle]['datefact'] = $singleinvoice['datefact'];
	$unpayedinvoices[$cle]['saison'] = $singleinvoice['saison'];
	$unpayedinvoices[$cle]['nblicences'] = $singleinvoice['nblicences'];
	
	$unpayedinvoices[$cle]['interval'] = date_create($singleinvoice['datefact'])->diff(new DateTime());
	
}
	
?>