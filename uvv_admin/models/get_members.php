    <?php
function get_allMembers()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT a.idbdd, a.numlicence, a.nom, a.prenom, '
            . 'a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, '
            . 'a.telfixe, a.telport, a.grade, a.categorie, a.gradec, '
            . 'a.categoriec, a.needcheck '
            . 'FROM uvv_adherents AS a '
            . 'ORDER BY a.nom ASC');
    $req->execute();
    $factures = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $factures;
}

function check_licence($licenceid)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT c.numclub, c.nom AS club, '
            . 'st.statut AS statutcode, lst.statut, lst.statutcourt, '
            . 'lst.type AS typecode, lts.type, '
            . 'sa.numsaison, sa.nom AS saison '
            . 'FROM uvv_statut AS st, uvv_saisons AS sa, uvv_lex_statuts AS lst,'
            . ' uvv_lex_typesstatut AS lts, uvv_clubs AS c '
            . 'WHERE st.adherent=:licenceid '
            . 'AND st.club=c.numclub '
            . 'AND st.saison=sa.numsaison '
            . 'AND sa.encours = 1 '
            . 'AND st.statut=lst.id '
            . 'AND lst.type=lts.id '
            . 'AND NOT lst.type=4');
    $req->bindParam(':licenceid',$licenceid);
    $req->execute();
    $more_info = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $more_info;
}

function get_grades($licenceid)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT c.numclub, c.nom AS club, '
            . 'lg.grade, lg.gradecourt, '
            . 'sa.nom AS saison '
            . 'FROM uvv_grades AS g, uvv_saisons AS sa, uvv_clubs AS c, uvv_lex_grades AS lg '
            . 'WHERE g.adherent=:licenceid '
            . 'AND lg.id=g.grade '
            . 'AND g.club=c.numclub '
            . 'AND g.saison=sa.numsaison '
            . 'ORDER BY sa.debut ');
    $req->bindParam(':licenceid',$licenceid);
    $req->execute();
    $more_info = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $more_info;
}

function get_licencedMembers($club)
{
    global $bdd;
    $club = (int) $club;
	
    $req = $bdd->prepare('SELECT a.idbdd, a.numlicence, a.nom, a.prenom, a.datenaissance, a.adrvoie, a.adrcp, a.adrville, a.mail, a.telfixe, a.telport, a.grade, a.categorie, a.gradec, a.categoriec, a.needcheck FROM uvv_adherents AS a ORDER BY a.nom ASC');
//    $req->bindParam(':club', $club, PDO::PARAM_INT);
    $req->execute();
    $users = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $users;
}

function get_allMembersClubId()
{
    global $bdd;

    $req = $bdd->prepare('SELECT uvv_adherents.numlicence, uvv_clubs.numclub '
            . 'FROM uvv_adherents, uvv_clubs, uvv_statut, uvv_saisons '
            . 'WHERE uvv_adherents.numlicence = uvv_statut.adherent AND uvv_statut.club = uvv_clubs.numclub AND uvv_statut.saison=uvv_saisons.numsaison AND uvv_saisons.encours=1');
    $req->execute();
    $members_club_id = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $members_club_id;
}

function get_allMembersStatus()
{
    global $bdd;

    $req = $bdd->prepare('SELECT uvv_adherents.numlicence, uvv_statut.statut '
            . 'FROM uvv_adherents, uvv_clubs, uvv_statut, uvv_saisons '
            . 'WHERE uvv_adherents.numlicence = uvv_statut.adherent AND uvv_statut.club = uvv_clubs.numclub AND uvv_statut.saison=uvv_saisons.numsaison AND uvv_saisons.encours=1');
    $req->execute();
    $members_status = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $members_status;
}

function get_allMembersGrade()
{
    global $bdd;

    $req = $bdd->prepare('SELECT uvv_grades.adherent, uvv_lex_grades.gradecourt '
            . 'FROM uvv_grades '
            . 'INNER JOIN uvv_lex_grades '
            . 'ON uvv_grades.grade = uvv_lex_grades.id '
            . 'INNER JOIN uvv_saisons '
            . 'ON uvv_grades.saison = uvv_saisons.numsaison AND uvv_saisons.encours=1');
    $req->execute();
    $members_grade = $req->fetchAll(PDO::FETCH_ASSOC);
    
    return $members_grade;
}

/*function get_unPayedFactures()
{
    global $bdd;
        
    $req = $bdd->prepare('SELECT f.numfacture, f.club, c.nom, f.montant, f.datefact, f.saison, f.paye, count(fa.id) AS nblicences FROM uvv_factures AS f, uvv_clubs AS c, uvv_factureadherents AS fa WHERE f.club = c.numclub AND f.numfacture=fa.facture AND NOT f.paye GROUP BY f.numfacture, f.club, c.nom, f.montant, f.datefact, f.saison, f.paye ORDER BY f.datefact ASC');
    $req->execute();
    $factures = $req->fetchAll();
    
    return $factures;
}*/
?>