<?php

define("INVOICE_ALL",0);
define("INVOICE_PAYED",1);
define("INVOICE_UNPAYED",2);

function get_allInvoices($payed)
{
    global $bdd;
        
    $payedFilter = '';
    if( $payed == INVOICE_PAYED ) {
        $payedFilter = ' AND f.paye ';
    } else if( $payed == INVOICE_UNPAYED ) {
        $payedFilter = ' AND NOT f.paye ';
    }
    
    $req = $bdd->prepare('SELECT f.numfacture, f.club, c.nom, f.montant, f.datefact, s.nom AS saison, f.paye, count(fa.id) AS nblicences '
            . 'FROM uvv_factures AS f, uvv_clubs AS c, uvv_saisons AS s, uvv_factureadherents AS fa '
            . 'WHERE f.club = c.numclub AND f.saison = s.numsaison AND f.numfacture = fa.facture '
            . $payedFilter
            . 'GROUP BY f.numfacture, f.club, c.nom, f.montant, f.datefact, s.nom, f.paye '
            . 'ORDER BY f.datefact ASC ');
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}

function get_allClubInvoices($numclub,$payed)
{
    global $bdd;
        
    $payedFilter = '';
    if( $payed == INVOICE_PAYED ) {
        $payedFilter = ' AND f.paye ';
    } else if( $payed == INVOICE_UNPAYED ) {
        $payedFilter = ' AND NOT f.paye ';
    }
    
    $req = $bdd->prepare('SELECT f.numfacture, f.club, c.nom, f.montant, f.datefact, s.nom AS saison, f.paye, count(fa.id) AS nblicences '
            . 'FROM uvv_factures AS f, uvv_clubs AS c, uvv_saisons AS s, uvv_factureadherents AS fa '
            . 'WHERE f.club = c.numclub AND c.numclub=:numclub AND f.saison = s.numsaison AND f.numfacture = fa.facture '
            . $payedFilter
            . 'GROUP BY f.numfacture, f.club, c.nom, f.montant, f.datefact, s.nom, f.paye '
            . 'ORDER BY f.datefact ASC');
    $req->bindParam(':numclub', $numclub, PDO::PARAM_INT);
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}

function get_unPayedInvoices()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT f.numfacture, f.club, c.nom, f.montant, f.datefact, f.saison, f.paye, count(fa.id) AS nblicences '
            . 'FROM uvv_factures AS f, uvv_clubs AS c, uvv_factureadherents AS fa '
            . 'WHERE f.club = c.numclub AND f.numfacture=fa.facture AND NOT f.paye '
            . 'GROUP BY f.numfacture, f.club, c.nom, f.montant, f.datefact, f.saison, f.paye '
            . 'ORDER BY f.datefact ASC');
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}

function get_unPayedClubInvoices($numclub)
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT f.numfacture, f.club, c.nom, f.montant, f.datefact, f.saison, f.paye, count(fa.id) AS nblicences '
            . 'FROM uvv_factures AS f, uvv_clubs AS c, uvv_factureadherents AS fa '
            . 'WHERE f.club = c.numclub AND f.numfacture=fa.facture AND NOT f.paye AND c.numclub=:numclub '
            . 'GROUP BY f.numfacture, f.club, c.nom, f.montant, f.datefact, f.saison, f.paye '
            . 'ORDER BY f.datefact ASC');
    $req->bindParam(':numclub', $numclub, PDO::PARAM_INT);
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}

function get_singleInvoice($numinvoice)
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT f.numfacture, f.club, c.nom, f.montant, f.datefact, s.nom AS saison, f.paye, count(fa.id) AS nblicences '
            . 'FROM uvv_factures AS f, uvv_clubs AS c, uvv_saisons AS s, uvv_factureadherents AS fa '
            . 'WHERE f.club = c.numclub AND f.saison = s.numsaison AND f.numfacture = fa.facture AND f.numfacture=:numinvoice '
            . 'GROUP BY f.numfacture, f.club, c.nom, f.montant, f.datefact, s.nom, f.paye '
            . 'ORDER BY f.datefact ASC');
    $req->bindParam(':numinvoice', $numinvoice, PDO::PARAM_INT);
    $req->execute();
    $facture = $req->fetch();
    
    return $facture;
}

function get_memberInvoice($numinvoice)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT fa.id, fa.adherent, a.nom, a.prenom, '
            . 'fa.montant, fa.grade AS gradeid, lg.grade, lg.gradecourt, '
            . 'fa.categorie AS categorieid, lc.categorie, lc.categoriecourt '
            . 'FROM uvv_factureadherents AS fa, uvv_adherents AS a,'
            . 'uvv_lex_grades AS lg, uvv_lex_categories AS lc '
            . 'WHERE fa.adherent=a.numlicence '
            . 'AND fa.grade=lg.id '
            . 'AND fa.categorie=lc.id '
            . 'AND fa.facture=:numinvoice '
            . 'ORDER BY fa.categorie, a.nom, a.prenom');
    $req->bindParam(':numinvoice',$numinvoice,PDO::PARAM_INT);
    $req->execute();
    $adherents = $req->fetchAll();
    
    return $adherents;
}

?>