<?php

//$action = isset($_GET['action']) ? $_GET['action'] : "nothing";
$action = isset($_GET['action']) ? $_GET['action'] : isset($_POST['action']) ? $_POST['action'] : "nothing";

switch($action)
{
    case "check_adherent":
        
        $licence = isset($_POST['licence']) ? $_POST['licence'] : "";
        $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
        if( $licence == "" || $nom == "" ){
            die(json_encode ('Error'));
        }
        
        include_once('models/sql_connection.php');
        include_once('models/get_adherents.php');
        include_once('models/getset_fdf.php');
        include_once('controllers/check_adherent.php');
        include_once('views/check_adherent.php');
        
        break;
        
    case "inscription":
        
        if( isset($_POST['json']) ){
            
            $json = $_POST['json'];
            
            $requestparams = json_decode(str_replace("\\","",$json),true);
            
            include_once('models/sql_connection.php');
            include_once('models/get_adherents.php');
            include_once('models/getset_fdf.php');
            include_once('controllers/mail.php');
            include_once('controllers/inscription.php');
            include_once('views/inscription.php');
        } else {
            die(json_encode('Error'));
        }
        
        break;
    
    default:
        die(json_encode("Error - ".$action));
}