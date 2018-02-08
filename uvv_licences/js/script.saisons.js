$(function() {
	
	var table = $('#saisonsList').DataTable( {
		"ajax": {
			"url": "services/getQueries.php?query=getSaisons",
			"dataSrc": ""
		},
		"columns": [
			{
				"class":          'details-control',
				"orderable":      false,
				"data":           null,
				"defaultContent": ''
			},
			{ "data": "numsaison" },
			{ "data": "nom" },
			{ data: null, render : function ( data, type, row ) {
				var dd = data.debut.split("-");
				return dd[2]+"/"+dd[1]+"/"+dd[0];
			} },
			{ data: null, render : function ( data, type, row ) {
				var df = data.fin.split("-");
				return df[2]+"/"+df[1]+"/"+df[0];
			} }
		],
		"language": {
			"emptyTable":	"Pas de données disponibles dans la table",
            "info":			"Page _PAGE_ de _PAGES_",
            "infoEmpty":	"Aucune saison disponible",
            "infoFiltered":	"(filtré de _MAX_ saisons au total)",
            "lengthMenu":	"Affiche _MENU_ saisons par page",
			"loadingRecords": "Chargement...",
			"processing":     "Calcul...",
			"search":         "Recherche:",
            "zeroRecords":	"Aucune saison trouvée",
			"paginate": {
				"first":      "Début",
				"last":       "Fin",
				"next":       "Suivant",
				"previous":   "Précédent"
			}
		}
	} );
	
	
	// Selection/Déselection d'une ligne
	$('#saisonsList tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

	// Affichage/Masquage du détail d'une ligne
	$('#saisonsList tbody').on('click', 'td.details-control', function () {
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
					return { query: "Saison", idcol: 'numsaison', col: this.id.split("_")[0], numsaison: this.id.split("_")[1] };
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
	var debutA = d.debut.split('-');
	var debutB = debutA[2]+"/"+debutA[1]+"/"+debutA[0];
	var finA = d.fin.split('-');
	var finB = finA[2]+"/"+finA[1]+"/"+finA[0];
	return '<fieldset>'+
				'<legend>Saison</legend>'+
				'<div style="width:100%;">'+
					'<div style="width:40%; float:left;"><b>Nom : 					</b><span class="edit" style="display:inline;" id="nom_'+d.numsaison+'"	>'+d.nom+'</span></div>'+
					'<div style="width:40%; float:left;"><b>Début : 				</b><span class="editdate" id="debut_'+d.numsaison+'"					>'+debutB+'</span></div>'+
					'<div style="width:20%; float:left;"><b>Fin : 					</b><span class="editdate" id="fin_'+d.numsaison+'"						>'+finB+'</span></div>'+
				'</div>'+
			'</fieldset>';
}