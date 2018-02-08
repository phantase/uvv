<?php
function check_adherent($licence, $nom)
{
    global $bdd;
    
    $req = $bdd->prepare('SELECT a.numlicence, a.nom, a.prenom, a.datenaissance, a.categoriec, a.mail FROM uvv_adherents AS a WHERE a.numlicence=:licence AND UPPER(CAST(a.nom AS CHAR))=UPPER(:nom)');
    $req->bindParam(':licence',$licence);
    $req->bindParam(':nom',$nom);
    $req->execute();
    $adh = $req->fetch(PDO::FETCH_ASSOC);
    
    return $adh;
}
function set_adherent($licence, $nom, $prenom, $birthday, $mail)
{
    global $bdd;
    
    $req = $bdd->prepare('UPDATE uvv_adherents SET prenom=:prenom, datenaissance=:birthday, mail=:mail WHERE numlicence=:licence');
    $req->bindParam(':licence',$licence);
    $req->bindParam(':prenom',$prenom);
    $req->bindParam(':birthday',$birthday);
    $req->bindParam(':mail',$mail);
    $success = $req->execute();
    
    return $success;
}