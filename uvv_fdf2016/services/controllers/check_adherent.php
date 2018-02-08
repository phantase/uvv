<?php

$adherent = check_adherent($licence,$nom);

if( $adherent ){
    
    $adherent['token'] = set_token($adherent['numlicence']);
    
    $inscription = get_inscription($licence);
    
    $accompagnants = get_accompagnants($licence);
    
    $retour = array('adherent' => $adherent,
                    'inscription' => $inscription,
                    'accompagnants' => $accompagnants);
    
}