-- AJOUTER LES DEUX COLONNES gradec ET categoriec --
-- todo

-- CORRIGER LES GRADES DES MAITRES --
UPDATE uvv_adh_tmp SET grade='M' WHERE grade='Maître';
-- COPIE DE LA TABLE TEMPORAIRE (créée avec Talend) DANS LA TABLE DEFINITIVE --
INSERT INTO uvv_adherents (numlicence,nom,prenom,datenaissance,adrvoie,adrcp,adrville,mail,telfixe,telport,gradec,categoriec) 
SELECT CONCAT('2014',LPAD(clubid,3,'0'),LPAD(id,5,'0')), nom, prenom, CONCAT(dnannee,'-',dnmois,'-',dnjour), adrvoie, adrcp, adrville, mail, LPAD(telfixe,10,'0'), LPAD(telport,10,'0'),grade,categorie
FROM uvv_adh_tmp;
-- CORRECTIONS --
UPDATE uvv_adherents SET datenaissance='0000-00-00' WHERE datenaissance='1900-01-00';
UPDATE uvv_adherents SET telfixe=NULL WHERE telfixe='0000000000';
UPDATE uvv_adherents SET telport=NULL WHERE telport='0000000000';
UPDATE uvv_adherents SET gradec='CEO02', needcheck=1 WHERE gradec='CO02';
UPDATE uvv_adherents SET gradec='CEB00', needcheck=1 WHERE gradec='CEB';
UPDATE uvv_adherents SET gradec='CEB03', needcheck=1 WHERE gradec='CE003';
UPDATE uvv_adherents SET gradec='CEB01', needcheck=1 WHERE gradec='CE001';
UPDATE uvv_adherents SET gradec='CJ01', needcheck=1 WHERE gradec='CN01';
UPDATE uvv_adherents SET gradec='CEV01', needcheck=1 WHERE gradec='CV01';
UPDATE uvv_adherents SET gradec='CEB01', needcheck=1 WHERE gradec='E001';
UPDATE uvv_adherents SET gradec='CB01', needcheck=1 WHERE gradec='CB0';
UPDATE uvv_adherents SET gradec='CJ02', needcheck=1 WHERE gradec='CN02';
UPDATE uvv_adherents SET gradec='CEB00', needcheck=1 WHERE gradec='CE0';
UPDATE uvv_adherents SET gradec='CEB00', needcheck=1 WHERE gradec='CE00';
-- MAJ TABLE ADHERENTS POUR GRADES ET CATEGORIES --
UPDATE uvv_adherents JOIN uvv_lex_categories ON uvv_adherents.categoriec=uvv_lex_categories.categoriecourt SET uvv_adherents.categorie=uvv_lex_categories.id;
UPDATE uvv_adherents SET needcheck=1 WHERE categorie=0;
UPDATE uvv_adherents JOIN uvv_lex_grades ON uvv_adherents.gradec=uvv_lex_grades.gradecourt SET uvv_adherents.grade=uvv_lex_grades.id;
UPDATE uvv_adherents SET needcheck=1 WHERE grade=0;
-- SUPPRIMER LES DEUX COLONNES gradec ET categoriec --
-- todo

-- AJOUT DES DATES DE CREATION --
INSERT INTO uvv_statut (adherent, club, statut, saison) SELECT numlicence, SUBSTR(numlicence,5,3), 12, 1 FROM uvv_adherents