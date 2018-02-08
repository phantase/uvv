<?php

// http://jc-cornic.developpez.com/tutoriels/php/pdf/index.php?page=page_2

include("libs/phpToPDF.php");

$PDF = new phpToPDF();

$PDF->AddPage();
//Sélection de la police
$PDF->SetFont('Arial','B',16);
$PDF->MultiCell(0, 10, "Facture n°723 - Saison 2013-2014\nPandas Verts de Peur", 1, "C", 0);

/** Tests **/

$PDF->AddPage();
$PDF->SetFont("Arial","B",16);
$PDF->Text(40,10,"Uniquement un texte");

$PDF->AddPage();
//Sélection de la police
$PDF->SetFont('Arial','B',16);
//Décalage de 8 cm à droite
$PDF->Cell(80);
//Texte centré dans une cellule 20*10 mm encadrée et retour à la ligne
$PDF->Cell(20,10,'Titre',1,1,'C'); 

$PDF->AddPage();
//Sélection de la police
$PDF->SetFont('Arial','B',16);
$PDF->MultiCell(0, 10, "Ceci est un texte multilignes centré avec un bord\nEt voici la deuxième ligne", 1, "C", 0);

$PDF->AddPage();
$PDF->SetFont('Arial','B',16);
$PDF->Image("./images/logo_union1.jpg", 50, 100);

$PDF->AddPage();
$PDF->SetFont('Arial','B',16);
// Définition des propriétés du tableau.
$proprietesTableau = array(
	'TB_ALIGN' => 'L',
	'L_MARGIN' => 15,
	'BRD_COLOR' => array(0,92,177),
	'BRD_SIZE' => '0.3',
	);
// Définition des propriétés du header du tableau.	
$proprieteHeader = array(
	'T_COLOR' => array(150,10,10),
	'T_SIZE' => 12,
	'T_FONT' => 'Arial',
	'T_ALIGN' => 'C',
	'V_ALIGN' => 'T',
	'T_TYPE' => 'B',
	'LN_SIZE' => 7,
	'BG_COLOR_COL0' => array(170, 240, 230),
	'BG_COLOR' => array(170, 240, 230),
	'BRD_COLOR' => array(0,92,177),
	'BRD_SIZE' => 0.2,
	'BRD_TYPE' => '1',
	'BRD_TYPE_NEW_PAGE' => '',
	);
// Contenu du header du tableau.	
$contenuHeader = array(
	50, 50, 50,
	"Titre de la première colonne", "année N-1", "année N",
	);
// Définition des propriétés du reste du contenu du tableau.	
$proprieteContenu = array(
	'T_COLOR' => array(0,0,0),
	'T_SIZE' => 10,
	'T_FONT' => 'Arial',
	'T_ALIGN_COL0' => 'L',
	'T_ALIGN' => 'R',
	'V_ALIGN' => 'M',
	'T_TYPE' => '',
	'LN_SIZE' => 6,
	'BG_COLOR_COL0' => array(245, 245, 150),
	'BG_COLOR' => array(255,255,255),
	'BRD_COLOR' => array(0,92,177),
	'BRD_SIZE' => 0.1,
	'BRD_TYPE' => '1',
	'BRD_TYPE_NEW_PAGE' => '',
	);	
// Contenu du tableau.	
$contenuTableau = array(
	"champ 1", 1, 2,
	"champ 2", 3, 4,
	"champ 3", 5, 6,
	"champ 4", 7, 8,
	);	
$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);

$PDF->Output();

?>