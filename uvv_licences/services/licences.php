<?php

	/** DEFINE NEEDED PHP FILES **/
	define( 'ABSPATH', dirname(__FILE__) . '/' );
	require_once( ABSPATH . 'config.php' );
	require_once( ABSPATH . 'queries.php' );

// http://jc-cornic.developpez.com/tutoriels/php/pdf/index.php?page=page_2

include("../libs/phpToPDF.php");
include("../libs/phpqrcode.php");

function drawLicenceCard($PDF,$w,$h,$saison,$adhLicNb,$adhName,$adhBirth,$adhGrade,$adhCat,$adhClub,$adhCom){
// QRCode adherent
QRcode::png('http://www.unionvovinam.fr/adherent/'.$adhLicNb, '../qrcodes/'.$adhLicNb.'.png', QR_ECLEVEL_L, 3);
$PDF->Image("../qrcodes/".$adhLicNb.".png", $w+64, $h, 20, 20);
// Logo Union
$PDF->Image("../images/logo_union1.jpg", $w, $h, 26, 17);
// Bloc adresse
$PDF->SetFont("Arial","",5);
$PDF->SetTextColor(49,171,71);
$PDF->Text($w+35,$h+4.3,"16 impasse Jasmin 47000 AGEN");
$PDF->Text($w+40,$h+6.8,"Tel : 06.27.06.67.14");
$PDF->Text($w+35.8,$h+9.3,"Mail : contact@unionvovinam.fr");
$PDF->Text($w+37,$h+11.8,"Web : www.unionvovinam.fr");
// Texte Saison
$PDF->SetFont("Arial","B",12);
$PDF->SetTextColor(22,106,174);
$PDF->Text($w+25,$h+19,"Saison $saison");
// Texte N° de licence
$PDF->SetFont("Arial","B",10);
$PDF->SetTextColor(0,0,0);
$PDF->Text($w+31,$h+26,"N° de licence : $adhLicNb");
// Texte Labels
$PDF->SetFont("Arial","B",10);
$PDF->SetTextColor(0,0,0);
$PDF->Text($w+6,$h+32,"Nom : ");
$PDF->Text($w+6,$h+37,"Date de naissance : ");
$PDF->Text($w+6,$h+42,"Grade : ");
$PDF->Text($w+46,$h+42,"Catégorie : ");
$PDF->Text($w+6,$h+47,"Club : ");
$PDF->Text($w+6,$h+52,"Comité : ");
// Texte Adhérent
$PDF->SetFont("Arial","",10);
$PDF->SetTextColor(0,0,0);
$PDF->Text($w+17,$h+32,$adhName);
$PDF->Text($w+39,$h+37,$adhBirth);
$PDF->Text($w+19,$h+42,$adhGrade);
$PDF->Text($w+65,$h+42,$adhCat);
$PDF->Text($w+17,$h+47,$adhClub);
$PDF->Text($w+21,$h+52,$adhCom);
// Cadre
$PDF->Line($w,$h,$w,$h+55);
$PDF->Line($w+83,$h,$w+83,$h+55);
$PDF->Line($w,$h,$w+83,$h);
$PDF->Line($w,$h+55,$w+83,$h+55);
}

	if( isset($_COOKIE['numclub']) && $_COOKIE['numclub']==-1 ){
		$facture = $_GET['facture'];
	} else {
		die(createJSONResult("exception","Please log as an admin to do that !"));
	}
	
$arrayOfParams = array('facture'=>$facture);

/** OPEN AND SELECT DATABASE **/
$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);

/** SET QUERY **/
error_log($query);
$res = $connexion->prepare($queries['getAdherentsFacture']);
$rows = array();
$success = $res->execute($arrayOfParams);

if( ! $success ){
	error_log(print_r($connexion->errorInfo(),true));
	die(createJSONResult("exception","Not a success"));
}
	
/** GO THROUGH RESULTS OF QUERY **/
while( $data = $res->fetch(PDO::FETCH_OBJ) ){
	$rows[] = $data;
}

$cpt = 10;

$PDF = new phpToPDF();


/**
 ** HERE IS THE MAGIC NUMBERS...
 **
 ** 20x10	105x10
 **	20x65	105x65
 ** +55
 **/
 
 $magic_x1 = 15;
 $magic_x2 = 110;
 $magic_y = -45;
 $magic_dy = 55;
 
foreach($rows as $adh){

	if( $cpt == 10 ){
		$PDF->AddPage();
		$y = $magic_y;
		$cpt=0;
	}

	$cpt++;
	$x = $magic_x1;
	if( ($cpt % 2) == 0 )
		$x = $magic_x2;
	else
		$y+=$magic_dy;
	
	drawLicenceCard($PDF,$x,$y,
		$adh->saison,
		$adh->numlicence,
		$adh->nom." ".$adh->prenom,
		$adh->datenaissance,
		$adh->gradecourt,
		$adh->categoriecomplet,
		$adh->club,
		($adh->comite!='NULL'?$adh->comite:""));
}


/** Sortie **/
$PDF->Output();

?>