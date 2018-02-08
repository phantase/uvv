var adhFac, facs;

function initWindows() {

	$( "#dialog-confirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:220,
		width: 400,
		modal: true,
		buttons: {
			"Confirmer": function() {
				$('#valButton').hide();	// faudrait faire mieux que cacher le bouton...
				$( this ).dialog( "close" );
				$.getJSON("services/addFacture.php",function(data){
					if( data['result'] == 'exception' ){
						alert("Erreur, il n'y avait rien à payer...");
					} else {
						retrieveFactures(data['message']);
						
					}
				});
			},
			"Annuler": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#dialog-confirm-paiement" ).dialog({
		autoOpen: false,
		resizable: false,
		height:220,
		width: 400,
		modal: true,
		buttons: {
			"Confirmer": function() {
				$('#valButtonPaye').hide();	// faudrait faire mieux que cacher le bouton...
				$( this ).dialog( "close" );
				$.getJSON("services/payeFacture.php?facture="+$('#viewHisto').val(),function(data){
					if( data['result'] == 'exception' ){
						alert("Erreur...");
					} else {
						retrieveFactures(data['message']);
					}
				});
			},
			"Annuler": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$('#valButtonPaye').hide();
	$('#factureInfos').hide();
	$('#factureFooterEstimation').hide();
	$('#factureFooterFacture').hide();
	
}

function initAdherents() {

	retrieveFactures();

	$('#viewHisto').change( function() {
		changeFacture();
	});
	
	$('#valButton').click( function() {
		$( "#dialog-confirm" ).dialog( "open" );
	});
	
	$('#valButtonPaye').click( function() {
		$( "#dialog-confirm-paiement" ).dialog( "open" );
	});
	
	changeFacture(true);

}

function retrieveFactures(val){
	// Récupère l'historique des factures
	$.getJSON("services/getFactures.php",function(data){
		facs = data;
		var htmlContent = '<option value="A">En cours (estimation)</option>\n';
		for( var i = 0; i < data.length; i++ ){
			htmlContent += '<option value="'+data[i].numfacture+'">#'+data[i].numfacture+'/ '+data[i].datefact+' ('+data[i].montant+' €)</option>\n';
		}
		$('#viewHisto').html(htmlContent);
		if( val )
			$('#viewHisto').val(val);
			$('#viewHisto').change();
	});
}

function changeFacture(init){

	var urlFactInfo = "services/getAdherents2Facture.php";
	$('#title').html("Estimation de facture");
	$('#valButton').show();
	$('#factureInfos').hide();
	$('#factureFooterEstimation').show();
	$('#factureFooterFacture').hide();
	if( $('#viewHisto').val() != 'A' && !init ) {
		var curFactId = $('#viewHisto').val();
		var curFact = null;
		for( var idx = 0; idx < facs.length; idx++ ){
			if( facs[idx].numfacture == curFactId )
				curFact = facs[idx];
		}
		urlFactInfo = "services/getAdherents4Facture.php?viewfact="+curFactId;
		$('#title').html("Facture #"+curFactId);
		$('#factureInfosClub').html(curFact.nom);
		$('#factureInfosDate').html(curFact.datefact);
		if( curFact.paye == 0 ) {
			$('#factureInfosPaye').html("Paiement en attente");
			$('#valButtonPaye').val('Valider le paiement');
			$('#valButtonPaye').off('click');
			$('#valButtonPaye').click( function() {
				$( "#dialog-confirm-paiement" ).dialog( "open" );
			});
		} else {
			$('#factureInfosPaye').html("Paiement confirmé");
			$('#valButtonPaye').val('Editer les licences');
			$('#valButtonPaye').off('click');
			$('#valButtonPaye').click( function() {
				window.open("services/licences.php?facture="+curFactId);
			});
		}
		if( isAdmin )
			$('#valButtonPaye').show();
		else
			$('#valButtonPaye').hide();
		$('#factureInfos').show();
		$('#valButton').hide();
		$('#factureFooterEstimation').hide();
		$('#factureFooterFacture').show();
	}

	$.getJSON(urlFactInfo,function(data){
		adhFac = data;
		var htmlContent = '<table>';
		var categorie = 0;
		var total = 0;
		for( var i = 0; i < data.length; i++ ){
			if( categorie != data[i].categorieid ) {
				htmlContent += '<tr><th colspan="3">'+data[i].categorie+'</th><tr>';
				categorie = data[i].categorieid;
			}
			htmlContent += '<tr><td>'+data[i].nom+' '+data[i].prenom+'</td><td class="tc">'+data[i].gradecourt+'</td><td class="tc">'+data[i].montant+' €</td></tr>';
			total += data[i].montant*1;
		}
		htmlContent += '<tr><th colspan="3">&nbsp;</th<tr>';
		htmlContent += '<tr><th colspan="2">Total</th><th>'+total+' €</th<tr>';
		htmlContent += '</table>';
		$('#factureWrapper').html(htmlContent);
	});
}