<?php

// Retrieve all functions from the MODELS file
include_once('models/get_invoices.php');
include_once('models/get_clubs.php');

$invoice = get_singleInvoice(filter_input(INPUT_GET, 'invoicenumber'));

if( !isAdmin() && $invoice['club'] !=  $_SESSION['clubnum'] ){
    $invoice = null;
} else {
    $invoice['datefac'] = date_create($invoice['datefact'])->format('d-m-Y');
    $invoice['datedue'] = date_create($invoice['datefact'])->add(new DateInterval('P1M'))->format('d-m-Y');
    $tresorier = get_clubTresorier($invoice['club']);
    $adherents = get_memberInvoice(filter_input(INPUT_GET, 'invoicenumber'));
    $invoice[0] = 0; $invoice[1] = 0; $invoice[2] = 0; $invoice[3] = 0;
    $invoice['0-price'] = 0; $invoice['1-price'] = 0; $invoice['2-price'] = 0; $invoice['3-price'] = 0;
    $invoice['total'] = 0;
    foreach( $adherents as $cle => $adherent ){
        $invoice[$adherent['categorieid']]++;
        $invoice[$adherent['categorieid'].'-price'] += $adherent['montant'];
        $invoice['total'] += $adherent['montant'];
    }
}