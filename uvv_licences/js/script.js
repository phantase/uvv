$(function() {
	// Coloration au survol des badges
	$('.badge').mouseenter(function(e){
		$(this).css('backgroundColor','#ddd');
	});
	$('.badge').mouseleave(function(e){
		$(this).css('backgroundColor','white');
	});
	
	// Transformation badge Login en bouton
	$('#badgeLogin').click(function(e){
		$( "#dialog-formLogin" ).dialog( "open" );
	});
	// Transformation badge Logout en bouton
	$('#badgeLogout').click(function(e){
		$.getJSON("services/checkLogout.php",function(data){
			if(data.result == "Success"){
				// LOGOUT REUSSIE
				showBadgesAnonymous();
				$('#identite').html("Non connecté");
			} else {
				// ERREUR DE LOGOUT
				showBadgesAuthenticated();
				$('#identite').html("Erreur d'identité");
			}
		});
	});

	// Transformation badge Adhérents en bouton
	$('#badgeAdherents').click(function(e){
		window.location = "adherents.php";
	});
	// Transformation badge Clubs en bouton
	$('#badgeClubs').click(function(e){
		window.location = "clubs.php";
	});
	// Transformation badge Saisons en bouton
	$('#badgeSaisons').click(function(e){
		window.location = "saisons.php";
	});
	
	// Vérification de l'identification par cookie
	$.getJSON("services/checkLogin.php",function(data){
		if(data.length > 0){
			// IDENTIFICATION REUSSIE (via COOKIES)
			showBadgesAuthenticated();
			$('#identite').html(data[0].nom);
			if( data[0].numclub == -1 )
				showBadgesAdmin();
			else
				showBadgesClub();
		} else {
			// PAS D'IDENTIFICATION
			showBadgesAnonymous();
		}
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
					// IDENTIFICATION REUSSIE
					showBadgesAuthenticated();
					$('#identite').html(data[0].nom)
					if( data[0].numclub == -1 )
						showBadgesAdmin();
					else
						showBadgesClub();
				} else {
					// IDENTIICATION LOUPEE
					alert("Erreur d'identification");
					showBadgesAnonymous();
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

function showBadgesAnonymous(){
	$('#badgeLogin').fadeIn();
	$('#badgeLogout').hide();
	$('#badgeNotificationLicencies').hide();
	$('#badgeNotificationAdherents').hide();
	$('#badgeNotificationFactures').hide();
	$('#badgeNotificationLicences').hide();
	$('#badgeAdherents').hide();
	$('#badgeLicencies').hide();
	$('#badgeBureau').hide();
	$('#badgeClubs').hide();
	$('#badgeLicences').hide();
	$('#badgeFactures').hide();
	$('#badgeSaisons').hide();
	$('#badgeLexiques').hide();
}
function showBadgesAuthenticated(){
	$('#badgeLogin').hide();
	$('#badgeLogout').fadeIn();
}
function showBadgesClub(){
	$('#badgeNotificationLicencies').fadeIn();
	$('#badgeNotificationAdherents').hide();
	$('#badgeNotificationFactures').fadeIn();
	$('#badgeNotificationLicences').hide();
	$('#badgeAdherents').fadeIn();
	$('#badgeLicencies').fadeIn();
	$('#badgeBureau').fadeIn();
	$('#badgeClubs').hide();
	$('#badgeLicences').fadeIn();
	$('#badgeFactures').fadeIn();
	$('#badgeSaisons').hide();
	$('#badgeLexiques').hide();
}
function showBadgesAdmin(){
	$('#badgeNotificationLicencies').fadeIn();
	$('#badgeNotificationAdherents').fadeIn();
	$('#badgeNotificationFactures').fadeIn();
	$('#badgeNotificationLicences').fadeIn();
	$('#badgeAdherents').fadeIn();
	$('#badgeLicencies').fadeIn();
	$('#badgeBureau').fadeIn();
	$('#badgeClubs').fadeIn();
	$('#badgeLicences').fadeIn();
	$('#badgeFactures').fadeIn();
	$('#badgeSaisons').fadeIn();
	$('#badgeLexiques').fadeIn();
	
	$.getJSON("services/getQueries.php?query=notifLicenciesPaiement",function(data){
		$('#notifLicenciesNombre').html(data[0].nb);
	});
	$.getJSON("services/getQueries.php?query=notifLicenciesLicence",function(data){
		$('#notifLicencesNombre').html(data[0].nb);
	});
	
}