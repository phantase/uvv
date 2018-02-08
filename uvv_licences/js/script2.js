var club = null;

$(function() {

	showAnonymous();

	// Vérification de l'identification par cookie
	$.getJSON("services/checkLogin.php",function(data){
		if(data.length > 0){
			club = data;
			// IDENTIFICATION REUSSIE (via COOKIES)
			showAuthenticated();
			$('#identite').html(data[0].nom);
			if( data[0].numclub == -1 )
				showAdmin();
			else
				showClub();
		} else {
			// PAS D'IDENTIFICATION
			showAnonymous();
		}
	});

	// Transformation Home en bouton
	$('#btnHome').click(function(e){
		window.location = "index.php";
	});
	// Transformation Factures en bouton
	$('#btnFactures').click(function(e){
		window.location = "factures.php";
	});
	
	// Transformation Login en bouton
	$('#btnLogin').click(function(e){
		$( "#dialog-formLogin" ).dialog( "open" );
	});
	// Transformation Logout en bouton
	$('#btnLogout').click(function(e){
		$.getJSON("services/checkLogout.php",function(data){
			if(data.result == "Success"){
				// LOGOUT REUSSIE
				showAnonymous();
				$('#identite').html("Non connecté");
			} else {
				// ERREUR DE LOGOUT
				showAuthenticated();
				$('#identite').html("Erreur d'identité");
			}
		});
	});
	
	// Variables du formulaire de connexion
	var login = $( "#login" ),
      password = $( "#password" ),
	  allFields = $( [] ).add( login ).add( password ),
      tips = $( ".validateTips" );
	  
	// Fenêtre de connexion
	$( "#dialog-formLogin" ).dialog({
      autoOpen: false,
      height: 300,
      width: 400,
      modal: true,
      buttons: {
        "Se connecter": function() {
          var bValid = true;
          allFields.removeClass( "ui-state-error" );
 
          if ( bValid ) {
			var baseurl = "services/checkLogin.php?";
			var parameters =$('#formLogin').serialize();
			$.post(baseurl,parameters,function(data){
				if(data.length > 0){
					club = data;
					// IDENTIFICATION REUSSIE
					showAuthenticated();
					$('#identite').html(data[0].nom)
					if( data[0].numclub == -1 )
						showAdmin();
					else
						showClub();
				} else {
					// IDENTIICATION LOUPEE
					alert("Erreur d'identification");
					showAnonymous();
				}
			},"json");
            $( this ).dialog( "close" );
          }
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      }
    });
	
});

	// Fonction pour le formulaire
	function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "La longueur " + n + " doit être entre " +
          min + " et " + max + " caractères." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }

var isAdmin = false;
function showAnonymous(){
	$('#tableWrapper').hide();
	$('#adherentsToolbar').hide();
	$('#notifLicenciesNombre').hide();
	$('#notifLicencesNombre').hide();
	$('#btnLogin').fadeIn();
	$('#btnLogout').hide();
	$('#btnFactures').hide();
	isAdmin = false;
	
	initWindows();
}
var notInitAdherents = true;
function showAuthenticated(){
	$('#btnLogin').hide();
	$('#btnLogout').fadeIn();
	$('#btnFactures').fadeIn();
	
	$('#adherentsToolbar').fadeIn();
	$('#tableWrapper').fadeIn();
	if( notInitAdherents ) {
		initAdherents();
		notInitAdherents = false;
	}
	isAdmin = false;
}
function showClub(){
	isAdmin = false;
}
function showAdmin(){
	$('#notifLicenciesNombre').fadeIn();
	$('#notifLicencesNombre').fadeIn();

	$.getJSON("services/getQueries.php?query=notifLicenciesPaiement",function(data){
		$('#notifLicenciesNombre').html(data[0].nb);
	});
	$.getJSON("services/getQueries.php?query=notifLicenciesLicence",function(data){
		$('#notifLicencesNombre').html(data[0].nb);
	});
	isAdmin = true;
}