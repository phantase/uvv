<?php

// Retrieve all functions from the MODELS file
include_once('models/get_invoices.php');

// Retrieve if we want payed/unpayed/all
$payedinvoice = INVOICE_ALL;
if( filter_has_var(INPUT_GET, 'payed') ){
    if( filter_input(INPUT_GET, 'payed')==='yes' ){
        $payedinvoice = INVOICE_PAYED;
    } else if( filter_input(INPUT_GET, 'payed')==='no' ){
        $payedinvoice = INVOICE_UNPAYED;
    }
}

// Retrieve the invoices
if(isAdmin()){
    $allinvoices = get_allInvoices($payedinvoice);
} else {
    $allinvoices = get_allClubInvoices($_SESSION['clubnum'],$payedinvoice);
}

$nbFactures = count($allinvoices);

// Go through all the results to secure display
foreach($allinvoices as $cle => $singleinvoice)
{
	$allinvoices[$cle]['numfacture'] = $singleinvoice['numfacture'];
	$allinvoices[$cle]['club'] = $singleinvoice['club'];
	$allinvoices[$cle]['nom'] = $singleinvoice['nom'];
	$allinvoices[$cle]['montant'] = $singleinvoice['montant'];
	$allinvoices[$cle]['datefact'] = $singleinvoice['datefact'];
	$allinvoices[$cle]['saison'] = $singleinvoice['saison'];
	$allinvoices[$cle]['paye'] = $singleinvoice['paye'];
	$allinvoices[$cle]['nblicences'] = $singleinvoice['nblicences'];
	
	$allinvoices[$cle]['interval'] = date_create($singleinvoice['datefact'])->diff(new DateTime());
	
}
