<?php

include_once('models/get_members.php');

$all_users = get_allMembers();
$all_adherents = array();
foreach ($all_users as $key => $single_user) {
    $user_statuts = check_licence($single_user['numlicence']);
    
    if( count($user_statuts) > 0 ){
        $single_adherent = array();
        
        $single_adherent['numlicence'] = $single_user['numlicence'];
        $single_adherent['prenom'] = $single_user['prenom'];
        // Only keep the first letter
        $single_adherent['init_nom'] = substr(strtoupper($single_user['nom']),0,1);
        $single_adherent['nom'] = $single_user['nom'];
        // Compute the Age from the birthdate
        $birthDate = explode('-',$single_user['datenaissance']);
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
          ? ((date("Y") - $birthDate[0]) - 1)
          : (date("Y") - $birthDate[0]));
//        $single_adherent['age'] = $age;
        $single_adherent['birthdate'] = $single_user['datenaissance'];
        $single_adherent['cp'] = $single_user['adrcp'];
        $single_adherent['ville'] = $single_user['adrville'];
        $single_adherent['courriel'] = $single_user['mail'];
        $telephones = array();
        $telephones['fixe'] = $single_user['telfixe'];
        $telephones['portable'] = $single_user['telport'];
        $single_adherent['telephones'] = $telephones;
        
        foreach ($user_statuts as $user_statut) {
            switch($user_statut['typecode'])
            {
                case 1:
                    $licence = array('saison'=>$user_statut['saison'],
                                    'club'=>$user_statut['club'],
                                    'statut'=>$user_statut['statut']);
                    $single_adherent['licence'][] = $licence;
                    break;
                case 2:
                    $bureau = array('saison'=>$user_statut['saison'],
                                    'club'=>$user_statut['club'],
                                    'statut'=>$user_statut['statut']);
                    $single_adherent['bureau'][] = $bureau;
                    break;
                case 3:
                    $club = array('saison'=>$user_statut['saison'],
                                    'club'=>$user_statut['club'],
                                    'statut'=>$user_statut['statut']);
                    $single_adherent['club'][] = $club;
                    break;
                default:
                    
                    break;
            }
        }
        
        $user_grades = get_grades($single_user['numlicence']);
        foreach ($user_grades as $user_grade) {
            $grade = array('saison'=>$user_grade['saison'],
                            'club'=>$user_grade['club'],
                            'grade'=>$user_grade['grade']);
            $single_adherent['grades'][] = $grade;
        }
        
        $all_adherents[] = $single_adherent;
    }
}

$output = $all_adherents;