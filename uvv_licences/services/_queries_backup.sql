SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, 
	a.grade AS gradeid, lg.grade, lg.gradecourt, 
	a.categorie AS categorieid, lc.categorie, lc.categoriecourt,
	GROUP_CONCAT(fs.statutid SEPARATOR ','), GROUP_CONCAT(fs.statut SEPARATOR ','), GROUP_CONCAT(fs.statutcourt SEPARATOR ','), GROUP_CONCAT(fs.statuttype SEPARATOR ','), GROUP_CONCAT(fs.statutdebut SEPARATOR ','), GROUP_CONCAT(fs.statutfin SEPARATOR ',')
FROM lex_grades AS lg, lex_categories AS lc, adherents AS a
LEFT JOIN (SELECT s.statut AS statutid, s.adherent, s.debut AS statutdebut, s.fin AS statutfin, ls.statut, ls.statutcourt, lts.type AS statuttype FROM statut AS s, lex_statuts AS ls, lex_typesstatut AS lts WHERE s.statut=ls.id AND ls.type=lts.id) AS fs ON a.numlicence=fs.adherent 
WHERE a.grade=lg.id AND a.categorie=lc.id 
GROUP BY numlicence, nom, prenom, datenaissance, adrvoie, adrcp, adrville, mail, telfixe, telport,
	gradeid, grade, gradecourt, 
	categorieid, categorie, categoriecourt
ORDER BY numlicence