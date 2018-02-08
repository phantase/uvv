<?php

/**
 * queries: definition of all the queries used in the project
 */

/** DEFINE NEEDED PHP FILES **/
//define( 'ABSPATH', dirname(__FILE__) . '/' );
require_once( ABSPATH . 'config.php' );


	  /***************/
	 /** Adhérents **/
	/***************/

// Special
$queries['getAdherentsAI'] 					= 'SELECT `AUTO_INCREMENT` AS ai FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :tableschema AND   TABLE_NAME   = :tablename';
// Getters
$queries['getAdherents'] 					= 'SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence';
$queries['getSingleAdherent'] 				= 'SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc WHERE a.grade=lg.id AND a.categorie=lc.id AND a.idbdd = :idbdd ORDER BY numlicence';
$queries['getSingleAdherentByNumLicence']	= 'SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc WHERE a.grade=lg.id AND a.categorie=lc.id AND a.numlicence = :numlicence ORDER BY numlicence';

$queries['getAdherentsFull'] 				= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";
$queries['getAdherentsFullSaison'] 			= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2 WHERE s2.saison=:saison GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";
$queries['getAdherentsFilter'] 				= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2, uvv_lex_statuts AS ls2 WHERE s2.statut=ls2.id AND ls2.type=:typefilter GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";
$queries['getAdherentsFilterSaison'] 		= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2, uvv_lex_statuts AS ls2 WHERE s2.statut=ls2.id AND ls2.type=:typefilter AND s2.saison=:saison GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";

$queries['getAdherentsClubFull'] 			= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2 WHERE s2.club=:club GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";
$queries['getAdherentsClubFullSaison'] 		= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2 WHERE s2.club=:club AND s2.saison=:saison GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";
$queries['getAdherentsClubFilter'] 			= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2, uvv_lex_statuts AS ls2 WHERE s2.statut=ls2.id AND ls2.type=:typefilter AND s2.club=:club GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";
$queries['getAdherentsClubFilterSaison'] 	= "SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, stec.statutid, stec.statut, stec.statutcourt, stec.idstatut, stec.club AS statutclub  FROM uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_adherents AS a LEFT JOIN (SELECT lst.id AS statutid, lst.statut, lst.statutcourt, st.adherent, st.idstatut, st.club FROM uvv_saisons AS sa, uvv_statut AS st, uvv_lex_statuts AS lst WHERE st.saison=sa.numsaison AND sa.encours AND st.statut=lst.id AND lst.type=1) AS stec ON stec.adherent=a.numlicence JOIN (SELECT s2.adherent FROM uvv_statut AS s2, uvv_lex_statuts AS ls2 WHERE s2.statut=ls2.id AND ls2.type=:typefilter AND s2.club=:club AND s2.saison=:saison GROUP BY adherent) AS fs2 ON fs2.adherent=a.numlicence WHERE a.grade=lg.id AND a.categorie=lc.id ORDER BY numlicence";

// Deleter
$queries['delAdherent'] = ''; // TODO : question : do we need to remove an adherent ?
// Adder
$queries['addAdherent'] = 'INSERT INTO uvv_adherents (numlicence, nom, prenom, datenaissance, adrvoie, adrcp, adrville, mail, telfixe, telport, grade, categorie) VALUES (:numlicence, :nom, :prenom, :datenaissance, :adrvoie, :adrcp, :adrville, :mail, :telfixe, :telport, :grade, :categorie)';
// Updater(s)
$queries['updAdherent'] = 'UPDATE uvv_adherents SET @@COLFROM@@ = :newvalue WHERE numlicence=:numlicence';


	  /***********/
	 /** Clubs **/
	/***********/

// Special
$queries['checkClubCredentials'] = 'SELECT numclub, nom, mail, appartenance, estcomite, login FROM uvv_clubs WHERE login=:login AND password=MD5(:password)';
// Getters
$queries['getClub'] 			= 'SELECT numclub, nom FROM uvv_clubs WHERE numclub=:numclub';
$queries['getClubs'] 			= 'SELECT numclub, nom FROM uvv_clubs ORDER BY nom';
$queries['getClubsWithComite'] 	= 'SELECT c.numclub, c.nom, c2.nom AS appartenance, c.estcomite FROM uvv_clubs  AS c LEFT JOIN uvv_clubs AS c2 ON c.appartenance=c2.numclub ORDER BY c.nom';
$queries['getComites'] 			= 'SELECT numclub, nom FROM uvv_clubs WHERE estcomite = 1 ORDER BY nom';
// Deleter
$queries['delClub'] = ''; // TODO : question : do we need to remove a club ?
// Adder
$queries['addClub'] = 'INSERT INTO uvv_clubs (nom, mail, appartenance, estcomite, login, password) VALUES (:nom, :mail, :appartenance, :estcomite, :login, MD5(:password) )';
// Updaters
$queries['updClubInfo'] 					= 'UPDATE uvv_clubs SET nom = :nom, mail = :mail, appartenance = :appartenance, estcomite = :estcomite WHERE numclub = :numclub';
$queries['updClubInfo_nom'] 				= 'UPDATE uvv_clubs SET nom = :nom WHERE numclub = :numclub';
$queries['updClubInfo_mail'] 				= 'UPDATE uvv_clubs SET mail = :mail WHERE numclub = :numclub';
$queries['updClubInfo_appartenance'] 		= 'UPDATE uvv_clubs SET appartenance = :appartenance WHERE numclub = :numclub';
$queries['updClubInfo_estcomite'] 			= 'UPDATE uvv_clubs SET estcomite = :estcomite WHERE numclub = :numclub';
$queries['updClubCredentials'] 				= 'UPDATE uvv_clubs SET login = :login, password = MD5(:password) WHERE numclub = :numclub';
$queries['updClubCredentials_login'] 		= 'UPDATE uvv_clubs SET login = :login WHERE numclub = :numclub';
$queries['updClubCredentials_password'] 	= 'UPDATE uvv_clubs SET password = MD5(:password) WHERE numclub = :numclub';

	  /*************************/
	 /** Facture / Adhérents **/
	/*************************/

	  /**************/
	 /** Factures **/
	/**************/

$queries['checkFactureRight']		= "SELECT club=:club FROM uvv_factures WHERE numfacture=:facture";
	
$queries['getFactures']				= "SELECT f.club, f.numfacture, f.montant, f.datefact, c.nom, f.paye FROM uvv_factures AS f, uvv_clubs AS c WHERE f.club=c.numclub AND club=:club ORDER by f.numfacture";
$queries['getAllFactures']			= "SELECT f.club, f.numfacture, f.montant, f.datefact, c.nom, f.paye FROM uvv_factures AS f, uvv_clubs AS c WHERE f.club=c.numclub ORDER by f.numfacture";
$queries['addFacture']				= "INSERT INTO uvv_factures SELECT null, :club, sum(lc.tarif), NOW(), sa.numsaison, 0 FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_statut AS st, uvv_saisons AS sa WHERE a.grade=lg.id AND a.categorie=lc.id AND a.numlicence=st.adherent AND st.saison=sa.numsaison AND sa.encours AND st.statut=1 AND st.club=:club";
$queries['setAdherentsToFacture'] 	= "INSERT INTO uvv_factureadherents SELECT null, :facture, a.numlicence, lc.tarif, a.grade, a.categorie FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_statut AS st, uvv_saisons AS sa WHERE a.grade=lg.id AND a.categorie=lc.id AND a.numlicence=st.adherent AND st.saison=sa.numsaison AND sa.encours AND st.statut=1 AND st.club=:club ORDER BY a.categorie ASC, a.nom ASC, a.prenom ASC";
$queries['moveAdherentsStatus'] 	= "UPDATE uvv_statut SET statut = :nvstatut WHERE idstatut IN (SELECT idstatut FROM (SELECT st.idstatut FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_statut AS st, uvv_saisons AS sa WHERE a.grade=lg.id AND a.categorie=lc.id AND a.numlicence=st.adherent AND st.saison=sa.numsaison AND sa.encours AND st.statut=:oldstatut AND st.club=:club) AS foo)";
$queries['setFacturePaye']			= "UPDATE uvv_factures SET paye = 1 WHERE numfacture=:facture";
$queries['setAdherentsStatusPaye'] 	= "UPDATE uvv_statut SET statut = :nvstatut WHERE idstatut IN (SELECT idstatut FROM (SELECT st.idstatut FROM uvv_statut AS st, uvv_factureadherents AS fa, uvv_factures AS fs WHERE fs.numfacture=fa.facture AND fa.facture=:facture AND fa.adherent=st.adherent AND st.saison=fs.saison AND st.statut=:oldstatut) AS foo)";

$queries['getAdherents2Facture']		= "SELECT a.numlicence, a.nom, a.prenom, a.grade AS gradeid, lg.grade, lg.gradecourt, a.categorie AS categorieid, lc.categorie, lc.categoriecourt, lc.tarif AS montant FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_statut AS st, uvv_saisons AS sa WHERE a.grade=lg.id AND a.categorie=lc.id AND a.numlicence=st.adherent AND st.saison=sa.numsaison AND sa.encours AND st.statut=1 AND st.club=:club ORDER BY a.categorie ASC, a.nom ASC, a.prenom ASC";
$queries['getAdherentsFactureTotal']	= "SELECT sum(lc.tarif) FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_statut AS st, uvv_saisons AS sa WHERE a.grade=lg.id AND a.categorie=lc.id AND a.numlicence=st.adherent AND st.saison=sa.numsaison AND sa.encours AND st.statut=1 AND st.club=:club";

$queries['getAdherents4Facture'] 		= "SELECT a.numlicence, a.nom, a.prenom, fa.grade AS gradeid, lg.grade, lg.gradecourt, fa.categorie AS categorieid, lc.categorie, lc.categoriecourt, fa.montant FROM uvv_adherents AS a, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_factureadherents AS fa WHERE a.numlicence=fa.adherent AND lg.id=fa.grade AND lc.id=fa.categorie AND fa.facture=:facture ORDER BY fa.categorie ASC, a.nom ASC, a.prenom ASC";


$queries['getAdherentsFacture']			= "SELECT sa.nom AS saison, ad.numlicence, ad.nom, ad.prenom, DATE_FORMAT(ad.datenaissance,'%m/%d/%Y') AS datenaissance, fa.grade, lg.gradecourt, lg.grade AS gradecomplet, fa.categorie, lc.categoriecourt, lc.categorie AS categoriecomplet, cl.nom AS club, co.nom AS comite FROM uvv_saisons AS sa, uvv_adherents AS ad, uvv_lex_grades AS lg, uvv_lex_categories AS lc, uvv_factureadherents AS fa, uvv_factures AS fs, uvv_statut AS st, uvv_clubs AS cl LEFT JOIN uvv_clubs AS co ON cl.appartenance=co.numclub WHERE sa.numsaison=fs.saison AND fa.facture=fs.numfacture AND fa.grade=lg.id AND fa.categorie=lc.id AND fa.adherent=ad.numlicence AND st.adherent=fa.adherent AND st.saison=fs.saison AND st.statut=3 AND st.club=cl.numclub AND fa.facture=:facture";

	  /***********/
	 /** Reçus **/
	/***********/

	  /*************/
	 /** Saisons **/
	/*************/

// Getters
$queries['getSaisons'] 			= 'SELECT numsaison, nom, debut, fin FROM uvv_saisons ORDER BY debut DESC';
$queries['getSingleSaison'] 	= 'SELECT numsaison, nom, debut, fin FROM uvv_saisons WHERE numsaison=:numsaison';
// Adder
$queries['addSaison'] = 'INSERT INTO uvv_saisons (nom, debut, fin) VALUES (:nom, :debut, :fin)';
// Updater
$queries['updSaison'] = 'UPDATE uvv_saisons SET @@COLFROM@@ = :newvalue WHERE numsaison=:numsaison';

	  /************/
	 /** Grades **/
	/************/

// Getters
//$queries['getSingleStatut'] 	= 'SELECT s.adherent, s.club, s.statut AS statutid, s.saison, ls.statut, ls.statutcourt FROM uvv_statut AS s, uvv_lex_statuts AS ls WHERE s.statut=ls.id AND s.idstatut=:idstatut';
$queries['getAdherentGrades'] 	= 'SELECT s.adherent, s.idgrade AS id, s.club AS clubid, c.nom AS clubnom, s.grade AS gradeid, ls.grade, ls.gradecourt, s.saison AS saisonid, sa.nom AS saisonnom, sa.encours AS saisonencours FROM uvv_grades AS s, uvv_clubs AS c, uvv_lex_grades AS ls, uvv_saisons AS sa WHERE s.club=c.numclub AND s.grade=ls.id AND s.saison=sa.numsaison AND s.adherent=:adherent ORDER BY s.saison DESC';
//$queries['getStatutAdherent'] 	= 'SELECT s.id, s.statut, s.statutcourt FROM uvv_lex_statuts AS s WHERE s.type NOT IN (1,4)';
// Adder
$queries['addGradeSaison'] = 'INSERT INTO uvv_grades (adherent,club,grade,saison) SELECT :adherent,:club,:grade,numsaison FROM uvv_saisons WHERE encours = 1';
//$queries['addStatut'] = 'INSERT INTO uvv_statut (adherent,club,statut,saison) SELECT :adherent,:club,:statut,numsaison FROM uvv_saisons WHERE encours';
// Remover
//$queries['delStatutAdherent']	= 'DELETE FROM uvv_statut WHERE idstatut=:deletedid';
// Modifier
//$queries['delSafeStatutAdherent'] = 'UPDATE uvv_statut SET statut = statut + 9 WHERE idstatut=:deletedid';	// TODO: la technique pour passer d'un rôle à un autre est d'ajouter 9 (passage du rôle à Ex-rôle) si on rajoute des rôles dans le lexique, ça ne sera plus vrai...

	  /************/
	 /** Statut **/
	/************/

// Getters
$queries['getSingleStatut'] 	= 'SELECT s.adherent, s.club, s.statut AS statutid, s.saison, ls.statut, ls.statutcourt FROM uvv_statut AS s, uvv_lex_statuts AS ls WHERE s.statut=ls.id AND s.idstatut=:idstatut';
$queries['getAdherentStatuts'] 	= 'SELECT s.adherent, s.idstatut AS id, s.club AS clubid, c.nom AS clubnom, s.statut AS statutid, ls.statut, ls.statutcourt, ls.type AS statuttypeid, lts.type  AS statuttype, s.saison AS saisonid, sa.nom AS saisonnom, sa.encours AS saisonencours FROM uvv_statut AS s, uvv_clubs AS c, uvv_lex_statuts AS ls, uvv_lex_typesstatut AS lts, uvv_saisons AS sa WHERE s.club=c.numclub AND s.statut=ls.id AND ls.type=lts.id AND s.saison=sa.numsaison AND s.adherent=:adherent ORDER BY ls.type ASC, s.saison DESC';
$queries['getStatutAdherent'] 	= 'SELECT s.id, s.statut, s.statutcourt FROM uvv_lex_statuts AS s WHERE s.type NOT IN (1,4)';
// Adder
$queries['addStatutSaison'] = 'INSERT INTO uvv_statut (adherent,club,statut,saison) VALUES (:adherent,:club,:statut,:saison)';
$queries['addStatut'] = 'INSERT INTO uvv_statut (adherent,club,statut,saison) SELECT :adherent,:club,:statut,numsaison FROM uvv_saisons WHERE encours';
// Remover
$queries['delStatutAdherent']	= 'DELETE FROM uvv_statut WHERE idstatut=:deletedid';
// Modifier
$queries['delSafeStatutAdherent'] = 'UPDATE uvv_statut SET statut = statut + 9 WHERE idstatut=:deletedid';	// TODO: la technique pour passer d'un rôle à un autre est d'ajouter 9 (passage du rôle à Ex-rôle) si on rajoute des rôles dans le lexique, ça ne sera plus vrai...

	  /*******************/
	 /** NOTIFICATIONS **/
	/*******************/

$queries['notifLicenciesPaiement'] 	= 'SELECT count(*) AS nb FROM uvv_adherents AS a, uvv_statut AS s WHERE a.numlicence = s.adherent AND s.statut = 1'; // TODO : statut licencié en attente de paiement en dur ici, le changer
$queries['notifLicenciesLicence'] 	= 'SELECT count(*) AS nb FROM uvv_adherents AS a, uvv_statut AS s WHERE a.numlicence = s.adherent AND s.statut = 2'; // TODO : statut licencié en attente de licence en dur ici, le changer

	  /**************************/
	 /** LEXIQUES > Catégories**/
	/**************************/

// Getters
$queries['getLEXCategories'] 		= 'SELECT id, categorie, categoriecourt, categorie AS value FROM uvv_lex_categories ORDER BY id';
$queries['getLEXCategorieForId'] 	= 'SELECT id, categorie, categoriecourt, categorie AS value FROM uvv_lex_categories WHERE id=:id';
// Deleter
$queries['delLEXCategorie'] = ''; // TODO: question : do we need to remove something from the lexique ?
// Adder
$queries['addLEXCategorie'] = 'INSERT INTO uvv_lex_categories (categorie,categoriecourt) VALUES (:categorie, :categoriecourt)';
// Updaters
$queries['updLEXCategorie'] 				= 'UPDATE uvv_lex_categories SET categorie = :categorie, categoriecourt = :categoriecourt WHERE id=:id';
$queries['updLEXCategorie_categorie'] 		= 'UPDATE uvv_lex_categories SET categorie = :categorie WHERE id=:id';
$queries['updLEXCategorie_categoriecourt'] 	= 'UPDATE uvv_lex_categories SET categoriecourt = :categoriecourt WHERE id=:id';

	  /***********************/
	 /** LEXIQUES > Grades **/
	/***********************/

// Getters
$queries['getLEXGrades'] 		= 'SELECT id, grade, gradecourt, grade AS value FROM uvv_lex_grades ORDER BY id';
$queries['getLEXGradeForId'] 	= 'SELECT id, grade,gradecourt, grade AS value FROM uvv_lex_grades WHERE id=:id';
// Deleter
$queries['delLEXGrade'] = ''; // TODO: question : do we need to remove something from the lexique ?
// Adder
$queries['addLEXGrade'] = 'INSERT INTO uvv_lex_grades (grade,gradecourt) VALUES (:grade, :gradecourt)';
// Updaters
$queries['updLEXGrade'] 			= 'UPDATE uvv_lex_grades SET grade = :grade, gradecourt = :gradecourt WHERE id=:id';
$queries['updLEXGrade_grade'] 		= 'UPDATE uvv_lex_grades SET grade = :grade WHERE id=:id';
$queries['updLEXGrade_gradecourt'] 	= 'UPDATE uvv_lex_grades SET gradecourt = :gradecourt WHERE id=:id';

	  /************************/
	 /** LEXIQUES > Statuts **/
	/************************/

// Getters
$queries['getLEXStatuts'] 		= 'SELECT id, statut, statutcourt, type, statut AS value FROM uvv_lex_statuts ORDER BY id';
$queries['getLEXStatutForId'] 	= 'SELECT id, statut, statutcourt, type, statut AS value FROM uvv_lex_statuts WHERE id=:id';
// Deleter
$queries['delLEXStatut'] = ''; // TODO: question : do we need to remove something from the lexique ?
// Adder
$queries['addLEXStatut'] = 'INSERT INTO uvv_lex_statuts (statut, statutcourt, type) VALUES (:statut, :statutcourt, :type)';
// Updaters
$queries['updLEXStatut'] 				= 'UPDATE uvv_lex_statuts SET statut = :statut, statutcourt = :statutcourt, type = :type WHERE id=:id';
$queries['updLEXStatut_statut'] 		= 'UPDATE uvv_lex_statuts SET statut = :statut WHERE id=:id';
$queries['updLEXStatut_statutcourt'] 	= 'UPDATE uvv_lex_statuts SET statutcourt = :statutcourt WHERE id=:id';
$queries['updLEXStatut_type'] 			= 'UPDATE uvv_lex_statuts SET type = :type WHERE id=:id';

	  /********************************/
	 /** LEXIQUES > Types de Statut **/
	/********************************/

// Getters
$queries['getLEXTypesStatut'] 		= 'SELECT id, type, type AS value FROM uvv_lex_typesstatut ORDER BY id';
$queries['getLEXTypeStatutForId'] 	= 'SELECT id, type, type AS value FROM uvv_lex_typesstatut WHERE id=:id';
// Deleter
$queries['delLEXTypeStatut'] = ''; // TODO: question : do we need to remove something from the lexique ?
// Adder
$queries['addLEXTypeStatut'] = 'INSERT INTO uvv_lex_typesstatut (type) VALUES (:type)';
// Updater
$queries['updLEXTypeStatut'] = 'UPDATE uvv_lex_typesstatut SET type = :type WHERE id=:id';

  /***************************************/
 /** FONCTIONS SPECIFIQUES POUR LA BDD **/
/***************************************/

function getParamsArray($_query,$_objectSup1){
	switch ($_query) {
		case "addAdherent":
			$_numlicence = date('Y').str_pad(checkParam('club'),3,'0',STR_PAD_LEFT).str_pad(getAdherentsAI(),5,'0',STR_PAD_LEFT);
			$_datenaissance = explode('/',checkParam('datenaissance'));
			$__datenaissance = $_datenaissance[2].'-'.$_datenaissance[1].'-'.$_datenaissance[0];
			return array(
				'numlicence'=>$_numlicence,
				'nom'=>checkParam('nomadh'),
				'prenom'=>checkParam('prenom'),
				'datenaissance'=>$__datenaissance,
				'adrvoie'=>checkParam('adrvoie'),
				'adrcp'=>checkParam('adrcp'),
				'adrville'=>checkParam('adrville'),
				'mail'=>checkParam('mailadh'),
				'telfixe'=>checkParam('telfixe'),
				'telport'=>checkParam('telport'),
				'grade'=>checkParam('grade'),
				'categorie'=>checkParam('categorie'));
			break;
		case "addStatut":
			return array(
				'adherent'=>checkParam('adherent'),
				'club'=>checkParam('club'),
				'statut'=>checkParam('statut')
				);
			break;
		case "addStatutSaison":
			return array(
				'adherent'=>checkParam('adherent'),
				'club'=>checkParam('club'),
				'statut'=>checkParam('statut'),
				'saison'=>checkParam('saison')
				);
			break;
		case "addSaison":
			$_debut = explode('/',checkParam('debut'));
			$__debut = $_debut[2].'-'.$_debut[1].'-'.$_debut[0];
			$_fin = explode('/',checkParam('fin'));
			$__fin = $_fin[2].'-'.$_fin[1].'-'.$_fin[0];
			return array(
				'nom'=>checkParam('nom'),
				'debut'=>$__debut,
				'fin'=>$__fin);				
			break;
		case "getSingleAdherent":
			return array(
				'idbdd'=>$_objectSup1
				);
			break;
		case "getSingleAdherentByNumLicence":
			return array(
				'numlicence'=>checkParam('numlicence')
				);
			break;
		case "getSingleStatut":
			error_log("getSingleStatut >>> ".$_objectSup1);
			return array(
				'idstatut'=>$_objectSup1
				);
			break;
		case "getSingleSaison":
			return array(
				'numsaison'=>$_objectSup1
				);
			break;
		case "getAdherentsFull":
			return null;
			break;
		case "getAdherentsFilter":
			return array(
				'typefilter'=>checkParam('typefilter')
				);
			break;
		case "getAdherentsClubFull":
			return array(
				'club'=>checkParam('viewclub')
				);
			break;
		case "getAdherentsClubFilter":
			return array(
				'club'=>checkParam('viewclub'),
				'typefilter'=>checkParam('typefilter')
				);
			break;
		case "getAdherentStatuts":
			return array(
				'adherent'=>checkParam('adherent')
				);
			break;
		case "getAdherentGrades":
			return array(
				'adherent'=>checkParam('adherent')
				);
			break;
	}
}

function getAdherentsAI(){
	/** OPEN AND SELECT DATABASE **/
	$connexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);
	/** SET QUERY **/
	$queryGetAdherentsAI = 'SELECT `AUTO_INCREMENT` AS ai FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :tableschema AND   TABLE_NAME   = :tablename';
	$res = $connexion->prepare($queryGetAdherentsAI);
	/** RETRIEVE THE VALUE **/
	$success = $res->execute(array('tableschema'=>DB_NAME, 'tablename'=>TABLE_PREFIX.'uvv_adherents'));
	if( ! $success )
		die(createJSONResult("Faillure","Echec..."));
	/** GO THROUGH RESULTS OF QUERY **/
	while( $data = $res->fetch(PDO::FETCH_OBJ) )
		return $data->ai;
}

?>