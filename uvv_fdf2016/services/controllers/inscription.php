<?php

if(check_token($requestparams['adherent']['numlicence'], $requestparams['adherent']['token'])){

    // MàJ les informations de l'adhérents
    set_adherent(
            $requestparams['adherent']['numlicence'], 
            $requestparams['adherent']['nom'], 
            $requestparams['adherent']['prenom'], 
            $requestparams['adherent']['nele'], 
            $requestparams['adherent']['courriel']);
    
    // Inscrit l'adhérent
    $result = set_inscription($requestparams['adherent']['numlicence'], 
                    $requestparams['inscription']['stage'], 
                    $requestparams['inscription']['compet'], 
                    $requestparams['inscription']['nuit'], 
                    $requestparams['inscription']['samedi'], 
                    $requestparams['inscription']['dimanche'], 
                    $requestparams['inscription']['commentaires']);

    // Si l'inscription a réussi, on inscrit les accompagnants
    if( $result['success'] ){
        // Supprime les anciennes inscriptions des accompagnants
        del_accompagnants($requestparams['adherent']['numlicence']);

        // Inscrit un par un les accompagnants
        for( $i = 0 ; $i < count($requestparams['accompagnants']) ; $i++ ){
            add_accompagnant($requestparams['adherent']['numlicence'], $requestparams['accompagnants'][$i]);
        }
    }
    
    if( $result['success'] ){
        
        // Calcul tarif probable...
        $explode = explode('-',$requestparams['adherent']['nele']);
        $age = 2016 - $explode[0] * 1;
        $tarif = 0;
        $tarifdetail = "<table>";
        
        $msg  = "Cher adhérent de l'Union Inter-régionale de Vovinam Viet Vo Dao,<br/><br/>";
        $msg .= "C'est avec plaisir que nous enregistrons votre inscription à la Fête de la fondation 2016 organisée par le Comité Orléanais.<br/>";
        $msg .= "Vous trouverez ci-dessous un récapitulatif de votre inscription.<br/><br/>";
        $msg .= "Nous vous disons à bientôt sur les tatamis de Meung-sur-Loire.<br/>";
        $msg .= "<p style=\"font-weight:bold;\">L'équipe d'organisation FdF2016</p>";
        
		$msg .= "<p><i>P.S.: N'oubliez pas de renvoyer le fichier d'inscription à la compétition si vous êtes inscrit à celle-ci (celui-ci se trouve au niveau du formulaire d'inscription).</i><br/>";
//		$msg .= "- <a href=\"http://www.unionvovinam.fr/uvv_fdf2016/files/Competition_FdF_2016_-_PW.pdf\">Organisation de la compétition</a></i><br/>";
//		$msg .= "- <a href=\"http://www.unionvovinam.fr/uvv_fdf2016/files/Fiche_d_inscription_competition_FdF_2016.xlsx\">Fichier d'inscription à la compétition</a></i></p>";
		
        $msg .= "<div style=\"clear:both;\"></div>";
        
        $msg .= "<h1>Récapitulatif de votre inscription à la Fête de la fondation 2016</h1>";
        $msg .= "<h2>Vo-Sinh</h2>";
        $msg .= "<h3>Informations</h3>";
        $msg .= "<ul>";
        $msg .= "<li><b>Licence : </b>".$requestparams['adherent']['numlicence']."</li>";
        $msg .= "<li><b>Nom : </b>".strtoupper($requestparams['adherent']['nom'])."</li>";
        $msg .= "<li><b>Prénom : </b>".$requestparams['adherent']['prenom']."</li>";
        $msg .= "<li><b>Date de naissance : </b>".$requestparams['adherent']['nele']."</li>";
        $msg .= "<li><b>Sexe : </b>".$requestparams['adherent']['sexe']."</li>";
        $msg .= "</ul>";
        $msg .= "<h3>Inscription</h3>";
        $msg .= "<ul>";
        if( $requestparams['inscription']['stage']==1 ) {
            $msg .= "<li><b>Stage : </b>Oui</li>";
            $tarif += 10;
            $tarifdetail .= "<tr><td>Stage</td><td>10 €</td></tr>";
        } else {
            $msg .= "<li><b>Stage : </b>Non</li>";
        }
        if( $requestparams['inscription']['compet']==1 ) {
            $msg .= "<li><b>Compétition : </b>Oui</li>";
            $tarif += 10;
            $tarifdetail .= "<tr><td>Compétition</td><td>10 €</td></tr>";
        } else {
            $msg .= "<li><b>Compétition : </b>Non</li>";
        }
        if( $requestparams['inscription']['nuit']==1 ) {
            $msg .= "<li><b>Nuit + Pdj : </b>Oui</li>";
            $tarif += 30;
            $tarifdetail .= "<tr><td>Nuit + Pdj</td><td>30 €</td></tr>";
        } else {
            $msg .= "<li><b>Nuit + Pdj : </b>Non</li>";
        }
        if( $requestparams['inscription']['samedi']==1 ) {
            $msg .= "<li><b>Repas samedi soir : </b>Oui</li>";
            if( $age > 12 ){
                $tarif += 15;
                $tarifdetail .= "<tr><td>Repas samedi soir (adulte)</td><td>15 €</td></tr>";
            } else {
                $tarif += 10;
                $tarifdetail .= "<tr><td>Repas samedi soir (enfant)</td><td>10 €</td></tr>";
            }
        } else {
            $msg .= "<li><b>Repas samedi soir : </b>Non</li>";
        }
        if( $requestparams['inscription']['dimanche']==1 ) {
            $msg .= "<li><b>Repas dimanche midi : </b>Oui</li>";
            if( $age > 12 ){
                $tarif += 10;
                $tarifdetail .= "<tr><td>Repas dimanche midi (adulte)</td><td>10 €</td></tr>";
            } else {
                $tarif += 5;
                $tarifdetail .= "<tr><td>Repas dimanche midi (enfant)</td><td>5 €</td></tr>";
            }
        } else {
            $msg .= "<li><b>Repas dimanche midi : </b>Non</li>";
        }
        $msg .= "<li><b>Commentaires : </b>".$requestparams['inscription']['commentaires']."</li>";
        $msg .= "</ul>";
        $msg .= "<h2>Accompagnants</h2>";
        if( count($requestparams['accompagnants'])>0 ){
            $msg .= "<table>";
            $msg .= "<tr><th>#</th><th>Nom prénom</th><th>Age</th><th>Sexe</th><th>Nuit + Pdj</th><th>Repas samedi soir</th><th>Repas dimanche midi</th><th>Excursion à Chambord</th></tr>";
            for( $i = 0 ; $i < count($requestparams['accompagnants']) ; $i++ ){
                $tarifdetail .= "<tr><td colspan=\"2\"><i>Accompagnant ".($i+1)."</i></td></tr>";
                $msg .= "<tr><td>".($i+1)."</td>";
                $msg .= "<td>".$requestparams['accompagnants'][$i]['nomprenom']."</td>";
                $msg .= "<td>".$requestparams['accompagnants'][$i]['age']."</td>";
                $ageacc = $requestparams['accompagnants'][$i]['age'] * 1;
                $msg .= "<td>".$requestparams['accompagnants'][$i]['sexe']."</td>";
                if( $requestparams['accompagnants'][$i]['nuit']==1 ){
                    $tarif += 30;
                    $tarifdetail .= "<tr><td>Nuit + Pdj</td><td>30 €</td></tr>";
                }
                $msg .= "<td>".($requestparams['accompagnants'][$i]['nuit']==1?"Oui":"Non")."</td>";
                if( $requestparams['accompagnants'][$i]['samedi']==1 ) {
                    if( $ageacc > 12 ){
                        $tarif += 15;
                        $tarifdetail .= "<tr><td>Repas samedi soir (adulte)</td><td>15 €</td></tr>";
                    } else {
                        $tarif += 10;
                        $tarifdetail .= "<tr><td>Repas samedi soir (enfant)</td><td>10 €</td></tr>";
                    }
                }
                $msg .= "<td>".($requestparams['accompagnants'][$i]['samedi']==1?"Oui":"Non")."</td>";
                if( $requestparams['accompagnants'][$i]['dimanche']==1 ) {
                    if( $ageacc > 12 ){
                        $tarif += 10;
                        $tarifdetail .= "<tr><td>Repas dimanche midi (adulte)</td><td>10 €</td></tr>";
                    } else {
                        $tarif += 5;
                        $tarifdetail .= "<tr><td>Repas dimanche midi (enfant)</td><td>5 €</td></tr>";
                    }
                }
                $msg .= "<td>".($requestparams['accompagnants'][$i]['dimanche']==1?"Oui":"Non")."</td>";
                $msg .= "<td>".($requestparams['accompagnants'][$i]['chambord']==1?"Oui":"Non")."</td></tr>";
            }
            $msg .= "</table>";
        } else {
            $msg .= "<p><i>Aucun accompagnant déclaré...</i></p>";
        }
        $msg .= "<h2>Tarif</h2>";
        $msg .= "<p><i>Le tarif est donné sous réserve d'informations d'âge correctes</i></p>";
        
        $tarifdetail .= "<tr><td><b>Total</b></td><td><b>".$tarif." €</b></td></tr>";
        $tarifdetail .= "</table>";
        
        $msg .= $tarifdetail;
        
//        sendMail($msg, null);
        sendMail($msg, $requestparams['adherent']['courriel']);
    }
    
} else {
    $result = array( 'success' => false, 'reason' => 'bad token' );
}