var lex_grades, lex_categories, clubs, saisons;

// Variables du formulaire d'ajout
var nom, prenom, datenaissance, adrvoie, adrcp, adrville, telfixe, telport, mail, grade, categorie, allFields, tips;
// Variables utiles et necessaires
var table;
	  
function initWindows() {

	nomadh = $( "#nomadh" );
	prenom = $( "#prenom" );
	datenaissance = $( "#datenaissance" );
	adrvoie = $( "#adrvoie" );
	adrcp = $( "#adrcp" );
	adrville = $( "#adrville" );
	telfixe = $( "#telfixe" );
	telport = $( "#telport" );
	mailadh = $( "#mailadh" );
	grade = $( "#grade" );
	categorie = $( "#categorie" );
	allFields = $( [] ).add( nomadh ).add( prenom ).add( datenaissance ).add( adrvoie ).add( adrcp ).add( adrville ).add( telfixe ).add( telport ).add( mailadh ).add( grade ).add( categorie );
	tips = $( ".validateTips" );
	
// Formulaire d'ajout
	$( "#dialog-formAddNewRow" ).dialog({
      autoOpen: false,
      height: 700,
      width: 600,
      modal: true,
      buttons: {
        "Ajouter un adhérent": function() {
          var bValid = true;
          allFields.removeClass( "ui-state-error" );
 
          bValid = bValid && checkLength( nomadh, "du nom", 1, 30 );
          bValid = bValid && checkLength( prenom, "du prénom", 1, 30 );
 
          if ( bValid ) {
			var baseurl = "services/addQueries.php?";
			var formSerial = $('#formAddNewRow').serialize().substring(0,$('#formAddNewRow').serialize().indexOf('&licencier'));
			var parameters = "query=Adherent&"+formSerial; // TODO : ajouter qui a demandé cet ajout, ajouter le numClub
			$.post(baseurl,parameters,function(data){
				if(data[0].numlicence){
					var rowNode = table.row.add(data[0]).draw(true).node();
					$( rowNode ).css('color','red').animate({color:'black'});
					// Ajout de l'adhérent dans la liste des créations
					var parameters3 = "query=Statut&adherent="+data[0].numlicence+"&club="+$('#club').val()+"&statut="+"12"; // TODO : attention, le statut de création est ici marqué en dur...
					$.post(baseurl,parameters3,function(data3){
						if(data3[0].statut) {
							// TODO : faire quelque chose (ou pas)
						} else {
							alert("Adhérent ajouté, mais échec de l'écriture de la date de création : "+data.message);
						}
					},"json");
					if( $('input[name=licencier]:checked', '#formAddNewRow').val() == 'oui' ){
						// Ajout de l'adhérent dans la liste des licenciés pour la saison actuelle
						var parameters2 = "query=Statut&adherent="+data[0].numlicence+"&club="+$('#club').val()+"&statut="+"1"; // TODO : attention, le statut de licencié en attente de paiement est ici marqué en dur...
						$.post(baseurl,parameters2,function(data2){
							if(data2[0].statut) {
								/*var tr = $('#btnLicencier_'+data[0].adherent).parents('tr');	// TODO : trouver comment faire pour que le bouton licencier ne soit pas visible alors que l'adhérent devrait être licencié...
								var row = table.row(tr);*/
								
								var dataArray = table.rows().data();
								var row = table.row(dataArray.length -1);
								
								var d = row.data();
								d['statut'] = data[0].statut;
								d['statutcourt'] = data[0].statutcourt;
								row.data(d).draw(true);
								
								$('#la_add_'+data[0].adherent).hide();
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
	
	$( "#dialog-formMove" ).dialog({
      autoOpen: false,
      height: 450,
      width: 600,
      modal: true,
      buttons: {
        "Transférer cet adhérent": function() {

			if( $('#mv_numlicence2').val() != "" ){
				var baseurl = "services/addQueries.php?";
				var parameters = "query=Statut&adherent="+$('#mv_numlicence2').val()+"&club="+$('#mv_club').val()+"&statut="+"1"; // TODO : attention, le statut de licencié en attente de paiement est ici marqué en dur...
				$.post(baseurl,parameters,function(data){
					if(data[0].statut) {
						table.ajax.reload();
					} else {
						alert("Adhérent non licencié : "+data.message);
					}
				},"json");
				$( this ).dialog( "close" );
			} else {
				$('#wngMovLookup').html('Merci de choisir un adhérent!');
			}
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        
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
			var parameters = "query=Statut&adherent="+$('#la_numlicence').val()+"&club="+$('#la_club').val()+"&statut="+"1"; // TODO : attention, le statut de licencié en attente de paiement est ici marqué en dur...
			$.post(baseurl,parameters,function(data){
				if(data[0].statut) {
					
					var tr = $('#btnLicencier_'+data[0].adherent).parents('tr');
					var row = table.row(tr);
					var d = row.data();
					d['statut'] = data[0].statut;
					d['statutcourt'] = data[0].statutcourt;
					row.data(d).draw(false);
					
					$('#la_add_'+data[0].adherent).hide();
					
					getAdherentStatuts(data[0].adherent);
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
			var parameters = "query=Statut&adherent="+$('#sa_numlicence').val()+"&club="+$('#sa_club').val()+"&statut="+$('#sa_statut').val();
			$.post(baseurl,parameters,function(data){
				if(data[0].statut) {
					getAdherentStatuts(data[0].adherent);
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
}
	
function initAdherents() {

	table = $('#adherentsList').DataTable( {
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
            } },
			{ data: null, render: function ( data, type, row ) {
				if( data.statut ) { // On a un statut, mais si on est licencié en attente de paiement, on peut encore annuler ce statut pour redevenir sans statut
					if( data.statutid == 1 && ( data.statutclub == club[0].numclub || club[0].numclub == -1 ) )
						return '<abbr title="'+data.statut+'">'+data.statutcourt+'</abbr>&nbsp;<input type="button" value="X" class="btnDelLicencier" id="btnDelLicencier_'+data.idstatut+'_'+data.numlicence+'" />';
					else
						return '<abbr title="'+data.statut+'">'+data.statutcourt+'</abbr>';
				} else {
					if( isAdmin )
						return '';
					else
						return '<input type="button" value="Licencier" class="btnLicencier" id="btnLicencier_'+data.numlicence+'" />'; // TODO : problème quand on est sur les pages suivantes...
				}
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
		},
		"drawCallback": function(settings, json) {
			$('.btnLicencier').unbind("click");
			$('.btnLicencier').click( function() {
	
				var baseurl = "services/addQueries.php?";
				var parameters = "query=Statut&adherent="+this.id.split('_')[1]+"&club="+$('#viewClub').val()+"&statut="+"1"; // TODO : attention, statut de licencié en attente de paiement marqué en dur...
				$.post(baseurl,parameters,function(data){
					if(data.result){
						alert("Impossible de licencier l'adhérent. Raison : " + data.message);
					} else {
						if(data[0].statut) {
							
							var tr = $('#btnLicencier_'+data[0].adherent).parents('tr');
							var row = table.row(tr);
							var d = row.data();
							d['statut'] = data[0].statut;
							d['statutcourt'] = data[0].statutcourt;
							d['statutid'] = data[0].statutid;
							row.data(d).draw(false);
							
							$('#la_add_'+data[0].adherent).hide();
							
							getAdherentStatuts(data[0].adherent);
						} else {
							alert("Adhérent non licencié : "+data.message);
						}
					}
				},"json");
			} );
			$('.btnDelLicencier').unbind("click");
			$('.btnDelLicencier').click( function() {
				var baseurl = "services/delQueries.php?";
				var parameters = "query=StatutAdherent&deletedid="+this.id.split('_')[1]+"&usefulthing="+this.id.split('_')[1]+"_"+this.id.split('_')[2]; // NOTE : la technique de passer les infos via le "usefulthing" est vraiment crade...
				$.post(baseurl,parameters,function(data){
					if(data.result){
						if(data.result == "Success") {
							
							var tr = $('#btnDelLicencier_'+data.message).parents('tr');
							var row = table.row(tr);
							var d = row.data();
							d['statut'] = null;
							d['statutcourt'] = null;
							d['statutid'] = null;
							
							row.data(d).draw(false);
							
							$('#la_add_'+data.message.split('_')[1]).hide();
							
							getAdherentStatuts(data.message.split('_')[1]);
						} else {
							alert("Adhérent non 'dé'licencié : "+data.message);
						}
					}
				},"json");
			} );
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
			
			getAdherentStatuts(row.data().numlicence);
			getAdherentGrades(row.data().numlicence);
			if( row.data().statut )
				$('#la_add_'+row.data().numlicence).hide();
			
			// To have a maxlenght on the phone numbers : see http://blogpad.fcmendoza.com/2010/10/jeditable-maxlength_12.html
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
					row.data(d).draw(false);
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
					row.data(d).draw(false);
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
					row.data(d).draw(false);
					getAdherentGrades(this.id.split('_')[1]);
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
					row.data(d).draw(false);
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
	
	// Bouton Transfert
	$('#movButton').click( function () {
		$( "#dialog-formMove" ).dialog( "open" );
		$("#btnMovLookup").unbind();
		$("#btnMovLookup").click(function(){
			var numlic = $('#mv_numlicence').val();
			console.log("Numéro licence : "+numlic);
			$.getJSON("services/getQueriesParams.php?query=getSingleAdherentByNumLicence&numlicence="+numlic,function(data){
				if( data.length > 0 ){
					$('#mv_numlicence2').val( data[0].numlicence );
					$('#mv_nom').val( data[0].nom );
					$('#mv_prenom').val( data[0].prenom );
					$('#wngMovLookup').html("");
				} else {
					$('#wngMovLookup').html("Ce numéro n'existe pas!");
				}
			});
		});
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
		$('#mv_club').html(htmlContent);
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
		var htmlContent2 = '';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].numsaison+'">'+data[i].nom+'</option>\n';
		}
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
	
	$( "#datenaissance" ).datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat:'dd/mm/yy'
	});
	
}

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
				'<div style="width:100%;" id="grades_'+d.numlicence+'">'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Historique</legend>'+
				'<div style="width:100%;" id="history_'+d.numlicence+'">'+
				'<img src="css/images/ajax-loader.gif" alt="Attente des informations..." title="Attente des informations..." />'+
				'</div>'+
			'</fieldset>'+
			'<fieldset>'+
				'<legend>Action sur l\'adhérent</legend>'+
				'<div style="width:100%;">'+
					/*'<input class="la_add_button" type="button" value="Licencier" id="la_add_'+d.numlicence+'" /> '+*/ /* Bouton supprimé, étant donné que le raffraichissement ne se fait pas via ce bouton et tend à faire croire aux utilisateurs que l'action de licencier l'adhérent n'a pas fonctionnée... */
					'<input class="sa_add_button" type="button" value="Ajouter un rôle" id="sa_add_'+d.numlicence+'" /> '+
				'</div>'+
			'</fieldset>';
	return output;
}

function getAdherentStatuts(numlicence){
	// Retrieve the statuts of the adherent
	$.getJSON("services/getQueriesParams.php?query=getAdherentStatuts&adherent="+numlicence,function(data){
		var htmlContent = '<ul>';
		var statuttype = 0;
		for( var i = 0; i < data.length; i++ ){
			if( data[i].statutid == 1 ){
				$("#btnDelLicencier_null_"+data[i].adherent).attr("id","btnDelLicencier_"+data[i].id+"_"+data[i].adherent);
			}
			if( statuttype != data[i].statuttypeid ) {
				if( htmlContent.length > 4 )
					htmlContent += '</ul>';
				htmlContent += '<li>'+data[i].statuttype+'</li><ul>';
				statuttype = data[i].statuttypeid;
			}
			htmlContent += '<li class="saisonencours'+data[i].saisonencours+'">'+data[i].statut+' ('+data[i].clubnom+' - '+data[i].saisonnom+')';
			if( data[i].clubid == club[0].numclub || club[0].numclub == -1 ){	// We check if the current is the one at the origin of this role (or is the admin), if yes, we allow him to remove it, otherwise, he cannot
				if( data[i].statuttypeid == 2 || data[i].statuttypeid == 3 ){	// TODO: ne plus avoir ces valeurs en dur...
					htmlContent += '<input class="histo_saferm_role" type="button" value="X" title="Retirer le rôle" id="histo_rm_role_'+data[i].id+'_'+data[i].adherent+'" />';
				}
				if( data[i].statuttypeid == 5 || data[i].statuttypeid == 6 ){	// TODO: ne plus avoir ces valeurs en dur...
					htmlContent += '<input class="histo_rm_role" type="button" value="X" title="Supprimer définitivement" id="histo_rm_role_'+data[i].id+'_'+data[i].adherent+'" />';
				}
			}
			htmlContent += '</li>';
		}
		htmlContent += '</ul>';
		$('#history_'+numlicence).html(htmlContent);
		$(".histo_saferm_role").click(function(){
			var baseurl = "services/delQueries.php?";
			var parameters = "query=SafeStatutAdherent&deletedid="+this.id.split('_')[3]+"&usefulthing="+this.id.split('_')[3]+"_"+this.id.split('_')[4]; // NOTE : la technique de passer les infos via le "usefulthing" est vraiment crade...
			$.post(baseurl,parameters,function(data){
				if(data.result){
					if(data.result == "Success") {
						getAdherentStatuts(data.message.split('_')[1]);
					} else {
						alert("Rôle non supprimé : "+data.message);
					}
				}
			},"json");
		});
		$(".histo_rm_role").click(function(){
			var baseurl = "services/delQueries.php?";
			var parameters = "query=StatutAdherent&deletedid="+this.id.split('_')[3]+"&usefulthing="+this.id.split('_')[3]+"_"+this.id.split('_')[4]; // NOTE : la technique de passer les infos via le "usefulthing" est vraiment crade...
			$.post(baseurl,parameters,function(data){
				if(data.result){
					if(data.result == "Success") {
						getAdherentStatuts(data.message.split('_')[1]);
					} else {
						alert("Rôle non supprimé : "+data.message);
					}
				}
			},"json");
		});
	});
}

function getAdherentGrades(numlicence){
	// Retrieve the grades history of the adherent
	$.getJSON("services/getQueriesParams.php?query=getAdherentGrades&adherent="+numlicence,function(data){
		var htmlContent = '<ul><li>Historique :</li><ul>';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<li class="saisonencours'+data[i].saisonencours+'">'+data[i].grade+' ('+data[i].clubnom+' - '+data[i].saisonnom+')';
			// Les lignes suivantes sont utiles si on veut supprimer des valeurs... A voir s'il faut les réactiver ou non...
/*			if( data[i].statuttypeid == 2 || data[i].statuttypeid == 3 ){	// TODO: ne plus avoir ces valeurs en dur...
				htmlContent += '<input class="histo_saferm_role" type="button" value="X" title="Retirer le rôle" id="histo_rm_role_'+data[i].id+'_'+data[i].adherent+'" />';
			}
			if( data[i].statuttypeid == 5 || data[i].statuttypeid == 6 ){	// TODO: ne plus avoir ces valeurs en dur...
				htmlContent += '<input class="histo_rm_role" type="button" value="X" title="Supprimer définitivement" id="histo_rm_role_'+data[i].id+'_'+data[i].adherent+'" />';
			}*/
			htmlContent += '</li>';
		}
		htmlContent += '</ul>';
		$('#grades_'+numlicence).html(htmlContent);
		// Les lignes suivantes sont utiles si on veut supprimer des valeurs... A voir s'il faut les réactiver ou non...
/*		$(".histo_saferm_role").click(function(){
			var baseurl = "services/delQueries.php?";
			var parameters = "query=SafeStatutAdherent&deletedid="+this.id.split('_')[3]+"&usefulthing="+this.id.split('_')[3]+"_"+this.id.split('_')[4]; // NOTE : la technique de passer les infos via le "usefulthing" est vraiment crade...
			$.post(baseurl,parameters,function(data){
				if(data.result){
					if(data.result == "Success") {
						getAdherentStatuts(data.message.split('_')[1]);
					} else {
						alert("Rôle non supprimé : "+data.message);
					}
				}
			},"json");
		});
		$(".histo_rm_role").click(function(){
			var baseurl = "services/delQueries.php?";
			var parameters = "query=StatutAdherent&deletedid="+this.id.split('_')[3]+"&usefulthing="+this.id.split('_')[3]+"_"+this.id.split('_')[4]; // NOTE : la technique de passer les infos via le "usefulthing" est vraiment crade...
			$.post(baseurl,parameters,function(data){
				if(data.result){
					if(data.result == "Success") {
						getAdherentStatuts(data.message.split('_')[1]);
					} else {
						alert("Rôle non supprimé : "+data.message);
					}
				}
			},"json");
		});*/
	});
}