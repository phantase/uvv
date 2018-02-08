	//Haut, haut, bas, bas, gauche, droite, gauche, droite, B, A
	var k = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65],
	n = 0;
(function($) {
    
    $('#form_checked').hide();
    $('#form_unchecked').hide();
    $('#check_your_info').hide();
    $('#info_inscr').hide();
    $('#plusinfochambord_content').hide();
    
    $('#licence_check').click(function(){
        var numlicence = $('#licence').val();
        var name = $('#name').val();
        $.post('services/services.php',{ action: "check_adherent", licence: numlicence, nom: name}, function(data){
            console.log(data);
            if( data && data.adherent.nom ){
                $('#form_checked').slideDown();
                $('#form_unchecked').slideUp();
                $('#check_your_info').slideDown();
                $('#licence').prop('disabled',true);
                $('#name').prop('disabled',true);
                $('#licence_check').prop('disabled',true);
                $('#surname').val(data.adherent.prenom);
                $('#birthday').val(data.adherent.datenaissance);
                $('#mail').val(data.adherent.mail);
                $('#sexe').val(data.adherent.categoriec);
                $('#token').val(data.adherent.token);
                $('#gender').removeClass('fa-genderless');
                $('#gender').removeClass('fa-mars');
                $('#gender').removeClass('fa-venus');
                if( data.adherent.categoriec === 'F' ){
                    $('#gender').addClass('fa-venus');
                } else {
                    $('#gender').addClass('fa-mars');
                }
                if( data.inscription ){
                    $('#stage').prop('checked', data.inscription.stage === "1");
                    $('#competition').prop('checked', data.inscription.compet === "1");
                    $('#nuit').prop('checked', data.inscription.nuit === "1");
                    $('#repassamedi').prop('checked', data.inscription.samedi === "1");
                    $('#repasdimanche').prop('checked', data.inscription.dimanche === "1");
                    $('#commentaires').val(data.inscription.commentaires);
                    $('#info_inscr').show();
                    $('#info_inscr_date').text(data.inscription.inscription);
                    $('#validate').val('Mettre à jour');
                    for( var a = 0; a < data.accompagnants.length ; a++ ){
                        addAccompagnant(
                                data.accompagnants[a].nomprenom,
                                data.accompagnants[a].sexe,
                                data.accompagnants[a].age,
                                data.accompagnants[a].nuit,
                                data.accompagnants[a].samedi,
                                data.accompagnants[a].dimanche,
                                data.accompagnants[a].chambord);
                    }
                }
            } else {
                $('#form_checked').slideUp();
                $('#form_unchecked').slideDown();
                $('#check_your_info').slideUp();
                $('#surname').val('');
                $('#birthday').val('');
                $('#mail').val('');
                $('#token').val('');
                $('#gender').addClass('fa-genderless');
                $('#gender').removeClass('fa-mars');
                $('#gender').removeClass('fa-venus');
            }
        }, "json");
    });
    
    $('#addaccompagnant').click(function(){
        addAccompagnant('',0,0,0,0,0,0);
    });
    
    $('#validate').click(function(){
       $('#formfaillure').hide();
       var token = $('#token').val();
       if( token != "" ){
           var object2send = new Object();
           var adherent = new Object();
           adherent.numlicence = $('#licence').val();
           adherent.nom = $('#name').val();
           adherent.prenom = $('#surname').val();
           adherent.nele = $('#birthday').val();
           adherent.sexe = $('#sexe').val();
           adherent.courriel = $('#mail').val();
           adherent.token = $('#token').val();
           object2send.adherent = adherent;
           var inscription = new Object();
           inscription.stage = $('#stage').prop('checked');
           inscription.compet = $('#competition').prop('checked');
           inscription.nuit = $('#nuit').prop('checked');
           inscription.samedi = $('#repassamedi').prop('checked');
           inscription.dimanche = $('#repasdimanche').prop('checked');
           inscription.commentaires = $('#commentaires').val();
           object2send.inscription = inscription;
           var accompagnants = new Array();
           var nbacc = $('#accompagnants_ph').children("div").length;
           for( var i = 1; i <= nbacc ; i++){
                if( $('#accomp_'+i).is(':visible') ){
                    var accomp = new Object();
                    accomp.nomprenom = $('#accomp_'+i+'_nomprenom').val();
                    accomp.age = $('#accomp_'+i+'_age').val();
                    accomp.sexe = $('input[name=accomp_'+i+'_sexe]:checked').val();
                    accomp.nuit = $('#accomp_'+i+'_nuit').prop('checked');
                    accomp.samedi = $('#accomp_'+i+'_samedi').prop('checked');
                    accomp.dimanche = $('#accomp_'+i+'_dimanche').prop('checked');
                    accomp.chambord = $('#accomp_'+i+'_chambord').prop('checked');
                    if( accomp.nomprenom !== "" ){
                        accompagnants.push(accomp);
                    }
                }
           }
           object2send.accompagnants = accompagnants;
           var json2send = JSON.stringify(object2send);
           console.log(json2send);
           $.post('services/services.php',{ action: "inscription", json: json2send}, function(data){
               console.log(data);
               if( data["success"] ){
                   $('#allform').slideUp();
                   if( data["method"] == "update" ){
                       $('#formupdatesuccess').show();
                   } else {
                       $('#forminsertsuccess').show();
                   }
               } else {
                   $('#formfaillure').show();
               }
           }, "json");
       }
    });
    
    $('#plusinfochambord').click(function(){
       $('#plusinfochambord_content').slideToggle(); 
    });
    
})(jQuery);

function addAccompagnant(nomprenom,sexe,age,nuit,samedi,dimanche,chambord){
    var accnb = $('#accompagnants_ph').children("div").length + 1;
    $('#accompagnants_ph').append("\<div id=\"accomp_"+accnb+"\">\n\
                                    <div class=\"row uniform\">\n\
                                        <div class=\"12u\">\n\
                                            <h6>Accompagnant #"+accnb+"</h6>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class=\"row uniform\">\n\
                                        <div class=\"8u 12u(xsmall)\">\n\
                                            <input type=\"text\" name=\"accomp_"+accnb+"_nomprenom\" id=\"accomp_"+accnb+"_nomprenom\" placeholder=\"Nom et prénom\" />\n\
                                        </div>\n\
                                        <div class=\"2u 6u(xsmall)\">\n\
                                            <input type=\"text\" name=\"accomp_"+accnb+"_age\" id=\"accomp_"+accnb+"_age\" placeholder=\"Age\" />\n\
                                        </div>\n\
                                        <div class=\"1u 3u(xsmall)\">\n\
                                            <input type=\"radio\" id=\"accomp_"+accnb+"_female\" name=\"accomp_"+accnb+"_sexe\" value=\"F\" checked>\n\
                                            <label for=\"accomp_"+accnb+"_female\"><i class=\"fa fa-female\"></i></label>\n\
                                        </div>\n\
                                        <div class=\"1u 3u(xsmall)\">\n\
                                            <input type=\"radio\" id=\"accomp_"+accnb+"_male\" name=\"accomp_"+accnb+"_sexe\" value=\"M\" >\n\
                                            <label for=\"accomp_"+accnb+"_male\"><i class=\"fa fa-male\"></i></label>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class=\"row uniform\">\n\
                                        <div class=\"4u 12u(xsmall)\">\n\
                                            <input type=\"checkbox\" name=\"accomp_"+accnb+"_nuit\" id=\"accomp_"+accnb+"_nuit\" />\n\
                                            <label for=\"accomp_"+accnb+"_nuit\">Nuit<label>\n\
                                        </div>\n\
                                        <div class=\"4u 12u(xsmall)\">\n\
                                            <input type=\"checkbox\" name=\"accomp_"+accnb+"_samedi\" id=\"accomp_"+accnb+"_samedi\" />\n\
                                            <label for=\"accomp_"+accnb+"_samedi\">Repas samedi soir<label>\n\
                                        </div>\n\
                                        <div class=\"4u 12u(xsmall)\">\n\
                                            <input type=\"checkbox\" name=\"accomp_"+accnb+"_dimanche\" id=\"accomp_"+accnb+"_dimanche\" />\n\
                                            <label for=\"accomp_"+accnb+"_dimanche\">Repas dimanche midi<label>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class=\"row uniform\">\n\
                                        <div class=\"4u 12u(xsmall)\">\n\
                                            <input type=\"checkbox\" name=\"accomp_"+accnb+"_chambord\" id=\"accomp_"+accnb+"_chambord\" />\n\
                                            <label for=\"accomp_"+accnb+"_chambord\">Sortie Chambord<label>\n\
                                        </div>\n\
                                        <div class=\"4u\">\n\
                                        </div>\n\
                                        <div class=\"4u 12u(xsmall)\">\n\
                                            <a class=\"button alt icon fa-remove\" id=\"accomp_"+accnb+"_remove\" class=\"accomp_remove\" >Retirer l'accompagnant</a>\n\
                                        </div>\n\
                                    </div>\n\
                                    </div>");
    if( nomprenom != ""){
        $('#accomp_'+accnb+'_nomprenom').val(nomprenom);
        $('#accomp_'+accnb+'_age').val(age);
        if( sexe == 'F'){
            $('#accomp_'+accnb+'_female').prop("checked",true);
        } else {
            $('#accomp_'+accnb+'_male').prop("checked",true);
        }
        $('#accomp_'+accnb+'_nuit').prop("checked",(nuit=="1"));
        $('#accomp_'+accnb+'_samedi').prop("checked",(samedi=="1"));
        $('#accomp_'+accnb+'_dimanche').prop("checked",(dimanche=="1"));
        $('#accomp_'+accnb+'_chambord').prop("checked",(chambord=="1"));
    }
    $('#accomp_'+accnb+'_remove').click(function(){
        var accid = this.id.split('_')[1];
        $('#accomp_'+accid).hide();
    });
	
}

	$(document).on('keydown', function(e) {
		if (e.keyCode === k[n++]) {
			if (n === k.length) {
				$('#form_register').show().css('visibility', 'visible');
				n = 0;
				return false;
			}
		}
		else {
			n = 0;
		}
	});
