var comites;

$(function() {
	
	var table = $('#clubsList').DataTable( {
		"ajax": {
			"url": "services/getQueries.php?query=getClubsWithComite",
			"dataSrc": ""
		},
		"columns": [
			{
				"class":          'details-control',
				"orderable":      false,
				"data":           null,
				"defaultContent": ''
			},
			{ "data": "numclub" },
			{ "data": "nom" },
			{ "data": "appartenance" }
		],
		"language": {
			"emptyTable":	"Pas de données disponibles dans la table",
            "info":			"Page _PAGE_ de _PAGES_",
            "infoEmpty":	"Aucun club disponible",
            "infoFiltered":	"(filtré de _MAX_ clubs au total)",
            "lengthMenu":	"Affiche _MENU_ clubs par page",
			"loadingRecords": "Chargement...",
			"processing":     "Calcul...",
			"search":         "Recherche:",
            "zeroRecords":	"Aucun club trouvée",
			"paginate": {
				"first":      "Début",
				"last":       "Fin",
				"next":       "Suivant",
				"previous":   "Précédent"
			}
		}
	} );
	
	
	// Selection/Déselection d'une ligne
	$('#clubsList tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

	// Affichage/Masquage du détail d'une ligne
	$('#clubsList tbody').on('click', 'td.details-control', function () {
		var tr = $(this).parents('tr');
		var row = table.row( tr );

		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child( format(row.data()) ).show();
			tr.addClass('shown');
			
			$('.edit').editable('services/updQueries.php', {
				indicator 	: 'Sauvegarde...',
				tooltip 	: 'Cliquer pour éditer...',
				submitdata 	: function(value, settings) {
					return { query: "Club", idcol: 'numsaison', col: this.id.split("_")[0], numsaison: this.id.split("_")[1] };
				},
				callback 	: function(value, settings) {
					var tr = $(this).parents('tr').prev('tr');
					var row = table.row(tr);
					var d = row.data();
					d[this.id.split("_")[0]] = value;
					row.data(d).draw();
				},
				style 	: 'inherit'
			});
			$('.editdate').editable('services/updQueries.php', {
				indicator 	: 'Sauvegarde...',
				tooltip 	: 'Cliquer pour éditer...',
				type 		: 'datepicker',
				datepicker	: {
					changeMonth:true,
					changeYear:true,
					dateFormat:'dd/mm/yy'
				},
				submitdata 	: function(value, settings) {
					return { query: "Saison", idcol: 'numsaison', col: this.id.split("_")[0], numsaison: this.id.split("_")[1], estdate: true };
				},
				callback 	: function(value, settings) {
					var newvalue = value.split('/')[2]+"-"+value.split('/')[1]+"-"+value.split('/')[0];
					var tr = $(this).parents('tr').prev('tr');
					var row = table.row(tr);
					var d = row.data();
					d[this.id.split("_")[0]] = newvalue;
					row.data(d).draw();
				},
				style 	: 'inherit'
			});
		}
	} );
	
	// Bouton Supprimer
	$('#delButton').click( function () {
		var baseurl = "services/delQueries.php?";
		var parameters = "query=delSaison&saison="+table.row('.selected').data().numsaison; // TODO : ajouter qui a demandé cette suppression
		$.getJSON(baseurl+parameters,function(data){
			if(data.result=="Success"){
				table.row('.selected').remove().draw( false );
			} else {
				alert("Saison non supprimée : "+data.message);
			}
		});
    } );
	
	// Bouton Ajouter
	$('#addButton').click( function () {
		$( "#dialog-formAddNewRow" ).dialog( "open" );
    } );
	
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
	
	// Récupère les comités pour le formulaire de création de club
	$.getJSON("services/getQueries.php?query=getComites",function(data){
		comites = data;
		var htmlContent = '<option value="0">Aucun</option>\n';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].numclub+'">'+data[i].nom+'</option>\n';
		}
		$('#appartenance').html(htmlContent);
	});

	
	// Variables du formulaire d'ajout
	var nom = $( "#nom" ),
      debut = $( "#debut" ),
      fin = $( "#fin" ),
	  allFields = $( [] ).add( nom ).add( debut ).add( fin ),
      tips = $( ".validateTips" );
	
	// Formulaire d'ajout
	$( "#debut" ).datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat:'dd/mm/yy'
		});
	$( "#fin" ).datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat:'dd/mm/yy'
		});
	$( "#dialog-formAddNewRow" ).dialog({
      autoOpen: false,
      height: 600,
      width: 600,
      modal: true,
      buttons: {
        "Ajouter une saison": function() {
          var bValid = true;
          allFields.removeClass( "ui-state-error" );
 
          bValid = bValid && checkLength( nom, "du nom", 1, 30 );
 
          if ( bValid ) {
			var baseurl = "services/addQueries.php?";
			var parameters = "query=Saison&"+$('#formAddNewRow').serialize(); // TODO : ajouter qui a demandé cet ajout
			$.post(baseurl,parameters,function(data){
				if(data[0].numsaison){
					var rowNode = table.row.add(data[0]).draw().node();
					$( rowNode ).css('color','red').animate({color:'black'});
				} else {
					alert("Saison non ajoutée : "+data.message);
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

function format ( d ) {
	var output = '<fieldset>';
	if( d.estcomite == "1" )
		output += '<legend>Comité</legend>';
	else
		output += '<legend>Club</legend>';
	var appartenance = (d.appartenance) ? d.appartenance : "Aucun";
	output += '<div style="width:100%;">'+
					'<div style="width:40%; float:left;"><b>Nom : 					</b><span class="edit" style="display:inline;" id="nom_'+d.numclub+'"	>'+d.nom+'</span></div>'+
					'<div style="width:40%; float:left;"><b>Comité : 				</b><span class="editcomite" id="appartenance_'+d.numclub+'"			>'+appartenance+'</span></div>'+
				'</div>'+
			'</fieldset>';
	return output;
}