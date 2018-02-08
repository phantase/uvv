var lex_grades, lex_categories, clubs, saisons;
	
$(function() {
	
	var table = $('#adherentsList').DataTable( {
		"ajax": {
			"url": "services/getAdherents.php?viewclub=0&typefilter=0&saison=0",
			"dataSrc": ""
		},
		"columns": [
			{
				"class":          'details-control',
				"orderable":      false,
				"data":           null,
				"defaultContent": ''
			},
			{ "data": "numlicence" },
			{ "data": "nom" },
			{ "data": "prenom" },
			{ data: null, render : function ( data, type, row ) {
				var dn = data.datenaissance.split("-");
				return dn[2]+"/"+dn[1]+"/"+dn[0];
			} },
			{ data: null, render: function ( data, type, row ) {
                return '<abbr title="'+data.grade+'">'+data.gradecourt+'</abbr>';
            } },
			{ data: null, render: function ( data, type, row ) {
                return '<abbr title="'+data.categorie+'">'+data.categoriecourt+'</abbr>';
            } }
		],
		"language": {
			"emptyTable":	"Pas de données disponibles dans la table",
            "info":			"Page _PAGE_ de _PAGES_",
            "infoEmpty":	"Aucun adhérent disponible",
            "infoFiltered":	"(filtré de _MAX_ adhérents au total)",
            "lengthMenu":	"Affiche _MENU_ adhérents par page",
			"loadingRecords": "Chargement...",
			"processing":     "Calcul...",
			"search":         "Recherche:",
            "zeroRecords":	"Aucun adhérent trouvé",
			"paginate": {
				"first":      "Début",
				"last":       "Fin",
				"next":       "Suivant",
				"previous":   "Précédent"
			}
		}
	} );
	
	
	// Selection/Déselection d'une ligne
	$('#adherentsList tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

	// Affichage/Masquage du détail d'une ligne
	$('#adherentsList tbody').on('click', 'td.details-control', function () {
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
					return { query: "Adherent", idcol: 'numlicence', col: this.id.split("_")[0], numlicence: this.id.split("_")[1] };
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
			$('.editnele').editable('services/updQueries.php', {
				indicator 	: 'Sauvegarde...',
				tooltip 	: 'Cliquer pour éditer...',
				type 		: 'datepicker',
				datepicker	: {
					changeMonth:true,
					changeYear:true,
					dateFormat:'dd/mm/yy'
				},
				submitdata 	: function(value, settings) {
					return { query: "Adherent", idcol: 'numlicence', col: this.id.split("_")[0], numlicence: this.id.split("_")[1], estdate: true };
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
			$('.editgrade').editable('services/updQueries.php', {
				type 		: 'select',
				loadurl 	: 'services/getQueriesEdit.php',
				loaddata 	: { query: "getLEXGrades"},
				indicator 	: 'Sauvegarde...',
				tooltip 	: 'Cliquer pour éditer...',
				submit 		: 'OK',
				submitdata 	: function(value, settings) {
					return { query: "Adherent", idcol: 'numlicence', col: this.id.split("_")[0], numlicence: this.id.split("_")[1], lexique:'Grade' };
				},
				callback 	: function(value, settings) {
					var tr = $(this).parents('tr').prev('tr');
					var row = table.row(tr);
					var d = row.data();
					$.each(lex_grades,function(i,v){
						if( v.grade == value ) {
							d['gradeid'] = v.id;
							d['grade'] = v.grade;
							d['gradecourt'] = v.gradecourt;
							return;
						}
					});
					d[this.id.split("_")[0]] = value;
					row.data(d).draw();
				},
				style 	: 'inherit'
			});
			$('.editcategorie').editable('services/updQueries.php', {
				type 		: 'select',
				loadurl 	: 'services/getQueriesEdit.php',
				loaddata 	: { query: "getLEXCategories"},
				indicator 	: 'Sauvegarde...',
				tooltip 	: 'Cliquer pour éditer...',
				submit 		: 'OK',
				submitdata 	: function(value, settings) {
					return { query: "Adherent", idcol: 'numlicence', col: this.id.split("_")[0], numlicence: this.id.split("_")[1], lexique:'Categorie' };
				},
				callback 	: function(value, settings) {
					var tr = $(this).parents('tr').prev('tr');
					var row = table.row(tr);
					var d = row.data();
					$.each(lex_categories,function(i,v){
						if( v.categorie == value ) {
							d['categorieid'] = v.id;
							d['categorie'] = v.categorie;
							d['categoriecourt'] = v.categoriecourt;
							return;
						}
					});
					d[this.id.split("_")[0]] = value;
					row.data(d).draw();
				},
				style 	: 'inherit'
			});
			
			$('.la_add_button').click( function() {
				var numlicence = this.id.split("_")[2];
				$('#la_numlicence').val(numlicence);
				$('#la_nom').val($('#nom_'+numlicence).html());
				$('#la_prenom').val($('#prenom_'+numlicence).html());
				$('#dialog-formLicencier').dialog("open");
			});
			$('.sa_add_button').click( function() {
				var numlicence = this.id.split("_")[2];
				$('#sa_numlicence').val(numlicence);
				$('#sa_nom').val($('#nom_'+numlicence).html());
				$('#sa_prenom').val($('#prenom_'+numlicence).html());
				$('#dialog-formStatut').dialog("open");
			});
		}
	} );
	
	// Bouton Supprimer
	$('#delButton').click( function () {
		var baseurl = "services/delQueries.php?";
		var parameters = "query=delAdherent&licence="+table.row('.selected').data().numlicence; // TODO : ajouter qui a demandé cette suppression
		$.getJSON(baseurl+parameters,function(data){
			if(data.result=="Success"){
				table.row('.selected').remove().draw( false );
			} else {
				alert("Adhérent non supprimé : "+data.message);
			}
		});
    } );
	
	// Bouton Ajouter
	$('#addButton').click( function () {
		$( "#dialog-formAddNewRow" ).dialog( "open" );
    } );
	
	// Select Club...
	$('.viewSelect').change( function() {
		table.ajax.url("services/getAdherents.php?viewclub="+$('#viewClub').val()+"&typefilter="+$('#viewFilter').val()+"&saison="+$('#viewSaison').val()).load();
	});
	
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
      prenom = $( "#prenom" ),
      datenaissance = $( "#datenaissance" ),
	  adrvoie = $( "#adrvoie" ),
	  adrcp = $( "#adrcp" ),
	  adrville = $( "#adrville" ),
	  telfixe = $( "#telfixe" ),
	  telport = $( "#telport" ),
	  mail = $( "#mail" ),
	  grade = $( "#grade" ),
	  categorie = $( "#categorie" ),
	  allFields = $( [] ).add( nom ).add( prenom ).add( datenaissance ).add( adrvoie ).add( adrcp ).add( adrville ).add( telfixe ).add( telport ).add( mail ).add( grade ).add( categorie ),
      tips = $( ".validateTips" );
	
	// Récupère les grades pour le formulaire d'ajout
	$.getJSON("services/getQueries.php?query=getLEXGrades",function(data){
		lex_grades = data;
		var htmlContent = '';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].id+'">'+data[i].grade+'</option>\n';
		}
		$('#grade').html(htmlContent);
	});
	// Récupère les catégories pour le formulaire d'ajout
	$.getJSON("services/getQueries.php?query=getLEXCategories",function(data){
		lex_categories = data;
		var htmlContent = '';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].id+'">'+data[i].categorie+'</option>\n';
		}
		$('#categorie').html(htmlContent);
	});
	// Récupère les clubs pour le formulaire d'ajout & la combobox de choix de club pour filtrage
	$.getJSON("services/getClubs.php",function(data){
		clubs = data;
		var htmlContent = '';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].numclub+'">'+data[i].nom+'</option>\n';
		}
		$('#club').html(htmlContent);
		$('#la_club').html(htmlContent);
		$('#sa_club').html(htmlContent);
		if(data.length > 1)
			htmlContent = '<option value="0">Tous</option>\n' + htmlContent;
		$('#viewClub').html(htmlContent);
	});
	// Récupère les types de statut pour la combobox de choix de statut pour filtrage
	$.getJSON("services/getQueries.php?query=getLEXTypesStatut",function(data){
		var htmlContent = '<option value="0">Tous</option>\n';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].id+'">'+data[i].type+'</option>\n';
		}
		$('#viewFilter').html(htmlContent);
	});
	// Récupère les saisons pour le formulaire d'ajout et pour la combobox de choix de saison pour filtrage
	$.getJSON("services/getQueries.php?query=getSaisons",function(data){
		saisons = data;
		var htmlContent = '';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].debut+'|'+data[i].fin+'">'+data[i].nom+'</option>\n';
		}
		$('#saison').html(htmlContent);
		$('#la_saison').html(htmlContent);
		$('#sa_saison').html(htmlContent);
		if(data.length > 1)
			htmlContent = '<option value="0">Tous</option>\n' + htmlContent;
		$('#viewSaison').html(htmlContent);
	});
	// Récupère les rôles (sauf création & licencié) pour le formulaire d'ajout de rôle à un adhérent
	$.getJSON("services/getQueries.php?query=getStatutAdherent",function(data){
		statutAdherent = data;
		var htmlContent = '';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].id+'">'+data[i].statut+'</option>\n';
		}
		$('#sa_statut').html(htmlContent);
	});
	
	// Formulaire d'ajout
	$( "#datenaissance" ).datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat:'dd/mm/yy'
		});
	$( "#dialog-formAddNewRow" ).dialog({
      autoOpen: false,
      height: 650,
      width: 600,
      modal: true,
      buttons: {
        "Ajouter un adhérent": function() {
          var bValid = true;
          allFields.removeClass( "ui-state-error" );
 
          bValid = bValid && checkLength( nom, "du nom", 1, 30 );
          bValid = bValid && checkLength( prenom, "du prénom", 1, 30 );
 
          if ( bValid ) {
			var baseurl = "services/addQueries.php?";
			var formSerial = $('#formAddNewRow').serialize().substring(0,$('#formAddNewRow').serialize().indexOf('&licencier'));
			var parameters = "query=Adherent&"+formSerial; // TODO : ajouter qui a demandé cet ajout, ajouter le numClub
			$.post(baseurl,parameters,function(data){
				if(data[0].numlicence){
					var rowNode = table.row.add(data[0]).draw().node();
					$( rowNode ).css('color','red').animate({color:'black'});
					if( $('input[name=licencier]:checked', '#formAddNewRow').val() == 'oui' ){
						// Ajout de l'adhérent dans la liste des licenciés pour la saison actuelle
						var lic_deb = $('#saison').val().split('|')[0];
						var lic_fin = $('#saison').val().split('|')[1];
						var parameters2 = "query=Statut&adherent="+data[0].numlicence+"&club="+$('#club').val()+"&statut="+"1"+"&debut="+lic_deb+"&fin="+lic_fin; // TODO : attention, le statut de licencié en attente de paiement est ici marqué en dur...
						$.post(baseurl,parameters2,function(data2){
							if(data2[0].statut) {
								// TODO : faire quelque chose (ou pas)
							} else {
								alert("Adhérent ajouté, mais non licencié : "+data.message);
							}
						},"json");
					}
				} else {
					alert("Adhérent non ajouté : "+data.message);
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
	
	$( "#dialog-formLicencier" ).dialog({
      autoOpen: false,
      height: 350,
      width: 600,
      modal: true,
      buttons: {
        "Licencier cet adhérent": function() {

			var baseurl = "services/addQueries.php?";
			var lic_deb = $('#la_saison').val().split('|')[0];
			var lic_fin = $('#la_saison').val().split('|')[1];
			var parameters = "query=Statut&adherent="+$('#la_numlicence').val()+"&club="+$('#la_club').val()+"&statut="+"1"+"&debut="+lic_deb+"&fin="+lic_fin; // TODO : attention, le statut de licencié en attente de paiement est ici marqué en dur...
			$.post(baseurl,parameters,function(data){
				if(data[0].statut) {
					// TODO : faire quelque chose (ou pas)
					// TODO : ce qu'il faut faire, c'est mettre à jour la liste avec les infos (chaud, chaud !!!)
					alert("Adhérent licencié (paiement en attente");
				} else {
					alert("Adhérent non licencié : "+data.message);
				}
			},"json");
            $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        
      }
    });
	
	$( "#dialog-formStatut" ).dialog({
      autoOpen: false,
      height: 350,
      width: 600,
      modal: true,
      buttons: {
        "Ajouter ce rôle": function() {

			var baseurl = "services/addQueries.php?";
			var lic_deb = $('#sa_saison').val().split('|')[0];
			var lic_fin = $('#sa_saison').val().split('|')[1];
			var parameters = "query=Statut&adherent="+$('#sa_numlicence').val()+"&club="+$('#sa_club').val()+"&statut="+$('#sa_statut').val()+"&debut="+lic_deb+"&fin="+lic_fin;
			$.post(baseurl,parameters,function(data){
				if(data[0].statut) {
					// TODO : faire quelque chose (ou pas)
					// TODO : ce qu'il faut faire, c'est mettre à jour la liste avec les infos (chaud, chaud !!!)
					alert("Rôle ajouté");
				} else {
					alert("Rôle non ajouté : "+data.message);
				}
			},"json");
            $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        
      }
    });
	
	 
	
});

function format ( d ) {
	var neleA = d.datenaissance.split('-');
	var nele = neleA[2]+"/"+neleA[1]+"/"+neleA[0];
	var output = '<fieldset>'+
				'<legend>Etat Civil</legend>'+
				'<div style="width:100%;">'+
					'<div style="width:40%; float:left;"><b>Nom : 					</b><span class="edit" style="display:inline;" id="nom_'+d.numlicence+'"			>'+d.nom+'</span></div>'+
					'<div style="width:40%; float:left;"><b>Prénom : 				</b><span class="edit" id="prenom_'+d.numlicence+'"			>'+d.prenom+'</span></div>'+
					'<div style="width:20%; float:left;"><b>Né le : 				</b><span class="editnele" id="datenaissance_'+d.numlicence+'"	>'+nele+'</span></div>'+
				'</div>'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Adresse</legend>'+
				'<div style="width:100%;">'+
					'<div style="width:100%; float:left;"><b>Voie : 				</b><span class="edit" id="adrvoie_'+d.numlicence+'"		>'+d.adrvoie+'</span></div>'+
				'</div>'+
				'<div style="width:100%;">'+
					'<div style="width:20%; float:left;"><b>Code Postal : 			</b><span class="edit" id="adrcp_'+d.numlicence+'"			>'+d.adrcp+'</span></div>'+
					'<div style="width:80%; float:left;"><b>Ville : 				</b><span class="edit" id="adrville_'+d.numlicence+'"		>'+d.adrville+'</span></div>'+
				'</div>'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Contact</legend>'+
				'<div style="width:100%;">'+
					'<div style="width:30%; float:left;"><b>Téléphone (fixe) : 		</b><span class="edit" id="telfixe_'+d.numlicence+'"		>'+d.telfixe+'</span></div>'+
					'<div style="width:30%; float:left;"><b>Téléphone (portable) : 	</b><span class="edit" id="telport_'+d.numlicence+'"		>'+d.telport+'</span></div>'+
					'<div style="width:40%; float:left;"><b>Courriel : 				</b><span class="edit" id="mail_'+d.numlicence+'"			>'+d.mail+'</span></div>'+
				'</div>'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Pratique</legend>'+
				'<div style="width:100%;">'+
					'<div style="width:50%; float:left;"><b>Grade : 				</b><span class="editgrade" id="grade_'+d.numlicence+'"			>'+d.grade+'</span></div>'+
					'<div style="width:50%; float:left;"><b>Catégorie : 			</b><span class="editcategorie" id="categorie_'+d.numlicence+'"		>'+d.categorie+'</span></div>'+
				'</div>'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Club</legend>'+
				'<div style="width:100%;">';
	if( d.statutsids ) {
		var statutstypeA = d.statutstypes.split(',');
		var statutsA = d.statuts.split(',');
		var statutscourtsA = d.statutscourts.split(',');
		var statutsdebutsA = d.statutsdebuts.split(',');
		var statutsfinsA = d.statutsfins.split(',');
		var statutsidsA = d.statutsids.split(',');
		var statutsclubsidsA = d.statutsclubsids.split(',');
		var statutsclubsnomsA = d.statutsclubsnoms.split(',');
	
		output += '<table><tr><th>Club</th><th>Statut</th><th>Début</th><th>Fin</th></tr>';
		for( var i = 0; i < statutsidsA.length; i++ ){
			output += '<tr><td>'+statutsclubsnomsA[i]+'</td><td>'+statutsA[i]+'</td><td>'+statutsdebutsA[i]+'</td><td>'+statutsfinsA[i]+'</td></tr>';
		}
		output += '</table>';
	} else {
		output += '<i>Cet adhérent n\'a jamais été rattaché à un club...</i>';
	}
	
	output += '</div>'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Action sur l\'adhérent</legend>'+
				'<div style="width:100%;">';
				
	output += '<input class="la_add_button" type="button" value="Licencier" id="la_add_'+d.numlicence+'" /> ';
	output += '<input class="sa_add_button" type="button" value="Ajouter un rôle" id="sa_add_'+d.numlicence+'" /> ';
	
	output += '</div>'+
			'</fieldset>';
	return output;
}