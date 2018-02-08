<?php
	/*
		ob_start();
		var_dump($someVar);
		$result = ob_get_clean();
	*/
	
	session_start();
	
	// Stuff for the i18n (translation/internationalization)
	$lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr';
	switch($lang){
		case 'en':
			$locale = 'en_US';
			break;
		case 'fr':
		default:
			$locale = 'fr_FR';
			break;
	}
	/* $acfg['setlocale_before'] = setlocale(LC_ALL, "0"); */
	/* $acfg['putenv_LC_ALL_result'] = */ putenv('LC_ALL='.$locale);
	/* $acfg['setlocale_result'] = */ setlocale(LC_ALL, $locale);
	/* $acfg['bindtextdomain_result'] = */ bindtextdomain('uvv', realpath("./locale") );
	/* $acfg['textdomain_result'] = */ textdomain('uvv');
	/* $acfg['setlocale_after'] = setlocale(LC_ALL, "0"); */
	/* var_dump($acfg); */
	
	function isAdmin() {
		return (isset( $_SESSION['clubnum'] ) && $_SESSION['clubnum'] == 1);
	}
	
	function isLogged() {
		return (isset( $_SESSION['clubnum'] ) );
	}
	
        $printmode = false;
        if(filter_has_var(INPUT_GET, "print")){
            if( filter_input(INPUT_GET, "print") === "true" ){
                $printmode = true;
            }
        }
        
	include_once('models/sql_connection.php');

	$action = isset($_GET['action']) ? $_GET['action'] : "home";

        /* Required CSS lib, JS lib and JS to be executed after page load */
	$cssLibSkeleton = "";
	$jsLibSkeleton = "";
	$jsSkeleton = "";
        switch($action) {
            case "invoices":
            case "fdf":
                if( !$printmode ) {
                    $cssLibSkeleton = ""
                        . "<!-- DataTables -->\n"
                        . "<link rel=\"stylesheet\" href=\"plugins/datatables/dataTables.bootstrap.css\">\n";
                    $jsLibSkeleton = ""
                        . "<!-- DataTables -->\n"
                        . "<script src=\"plugins/datatables/jquery.dataTables.min.js\"></script>\n"
                        . "<script src=\"plugins/datatables/dataTables.bootstrap.min.js\"></script>\n";
                    $jsSkeleton = "$(\"#invoices-table\").DataTable( {\n"
                            . "\"language\": {\n"
                            . " \"emptyTable\": \""._('No data available in table')."\",\n"
                            . " \"info\": \""._('Showing page _PAGE_ of _PAGES_')."\",\n"
                            . " \"infoEmpty\": \""._('No records available')."\",\n"
                            . " \"infoFiltered\": \""._('(filtered from _MAX_ total records)')."\",\n"
                            . " \"lengthMenu\": \""._('Display _MENU_ records per page')."\",\n"
                            . " \"loadingRecords\": \""._('Loading...')."\",\n"
                            . " \"processing\": \""._('Processing...')."\",\n"
                            . " \"search\": \""._('Search:')."\",\n"
                            . " \"zeroRecords\": \""._('Nothing found - sorry')."\",\n"
                            . " \"paginate\": {\n"
                            . "     \"first\": \""._('First')."\",\n"
                            . "     \"last\": \""._('Last')."\",\n"
                            . "     \"next\": \""._('Next')."\",\n"
                            . "     \"previous\": \""._('Previous')."\"\n"
                            . " },\n"
                            . " \"aria\": {\n"
                            . "     \"sortAscending\": \""._('activate to sort column ascending')."\",\n"
                            . "     \"sortDescending\": \""._('activate to sort column descending')."\"\n"
                            . " }\n"
                            . "}\n"
                            . "} );\n";
                }
                break;
        }
        
	switch($action) {
		case "home": if(!isset($title)){ $title = _('Home'); }
			if( isset($_POST['login']) && isset($_POST['password']) ){
				$login = $_POST['login'];
				$password = $_POST['password'];
				// $rememberme = isset($_POST['rememberme']) ? $_POST['rememberme'] == 'on' : false;
				
				include_once('controllers/checkclub.php');
			}
			include_once('views/pages/skeleton.php');
			break;
		case "invoices": if(!isset($title)){ $title = _('Invoices'); }
		case "invoice": if(!isset($title)){ $title = _('Invoice'); }
                case "seasons": if(!isset($title)){ $title = _('Seasons'); }
                case "season": if(!isset($title)){ $title = _('Season'); }
                case "fdf": if(!isset($title)){ $title = _('Fête de Fondation'); }
                case "fdf_invoice": if(!isset($title)){ $title = _('Fête de Fondation - Facture'); }
		case "help": if(!isset($title)){ $title = _('Help'); }
		case "about": if(!isset($title)){ $title = _('About'); }
		case "terms": if(!isset($title)){ $title = _('Terms'); }
		case "404": if(!isset($title)){ $title = _('404 Page not found'); }
		case "500": if(!isset($title)){ $title = _('500 Error'); }
			include_once('views/pages/skeleton.php');
			break;
		case "login":
			include_once('views/pages/login.php');
			break;
		case "logout":
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			session_destroy();
			$action = "home";
			include_once('views/pages/skeleton.php');
			break;
		case "register":
			include_once('views/pages/register.php');
			break;
		case "forgotpassword":
			include_once('views/pages/forgotpassword.php');
			break;
	}
	
?>