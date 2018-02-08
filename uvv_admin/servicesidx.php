<?php
	/*
		ob_start();
		var_dump($someVar);
		$result = ob_get_clean();
	*/
	
//	session_start();
	
	setlocale(LC_ALL, 'fr_FR','fra');
	include_once('models/sql_connection.php');
	
        $action = isset($_GET['action']) ? $_GET['action'] : "getCapabilities";
	
	if( $action == "getAllUsers" ) {
                include_once('controllers/services/users.php');
                include_once('views/services/simplejsonoutput.php');
        } else if( $action == "getOnlyClubs" ) {
                include_once('controllers/services/clubs.php');
                include_once('views/services/simplejsonoutput.php');
        } else if( $action == "getOnlyComites" ) {
                include_once('controllers/services/comites.php');
                include_once('views/services/simplejsonoutput.php');
		} else if( $action == "getMemberClubId" ) {
                include_once('controllers/services/member_club_id.php');
                include_once('views/services/simplejsonoutput.php');
		} else if( $action == "getMemberStatus" ) {
                include_once('controllers/services/member_status.php');
                include_once('views/services/simplejsonoutput.php');
        } else if( $action == "getMemberGrade" ) {
                include_once('controllers/services/member_grade.php');
                include_once('views/services/simplejsonoutput.php');
        }
?>