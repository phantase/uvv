<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Union Vovinam - Espace adhérent</title>
	
    <link rel="stylesheet" type="text/css" href="css/style2.css">
	<link rel="stylesheet" type="text/css" href="css/style2print.css" media="print">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	
	<script type="text/javascript" charset="utf8" src="js/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="js/jquery-ui.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.jeditable.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.jeditable.datepicker.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.validate.js"></script>
    <script type="text/javascript" charset="utf8" src="js/script2.factures.js"></script>
    <script type="text/javascript" charset="utf8" src="js/script2.js"></script>

  </head>
  <body>
	
	<div id="ruban_haut">
		<div class="container">
			Être fort pour être utile
		</div>
	</div>
	
	<div id="headers" class="container">
		<a href="http://www.unionvovinam.fr"><img id="logo_union" src="images/logo_union1.png" alt="Union Vovinam" Title="Union Vovinam" /></a>
		<div id="navigation" class="nav_bar">
			<ul>
				<li id="btnHome" class="icon"><a href="#"><img src="images/home.png" alt="Accueil" title="Accueil" /></a></li>
				<li id="btnFactures"><a href="#">Factures</a></li>
				<!--<li id="btnClubs"><a href="#">Clubs</a></li>-->
				<li id="identite"></li>
				<li id="btnLogin" class="right"><a href="#">Connexion</a></li>
				<li id="btnLogout" class="right"><a href="#">deconnexion</a></li>
				<li id="notifLicencesNombre" class="right"></li>
				<li id="notifLicenciesNombre" class="right"></li>
			</ul>
		</div>
		<div id="adherentsToolbar">
			<input type="button" value="Valider" id="valButton" class="btn" /> 
			<input type="button" value="Valider le paiement" id="valButtonPaye" class="btn hide4Print" style="width:150px;" /> 
			<span id="title" class="title">Estimation de facture</span>
			<span id="histo"><b>Historique : </b><select class="viewSelect" name="viewHisto" id="viewHisto" ></select></span>
		</div>
		<div id="factureInfos">
			<span id="factureInfosClub" class="title"></span>
			<span class="title">&nbsp;|&nbsp;</span>
			<span id="factureInfosDate" class="title"></span>
			<span class="title hide4Print">&nbsp;|&nbsp;</span>
			<span id="factureInfosPaye" class="title hide4Print"></span>
		</div>
	</div>
	
	<!-- ESPACE FACTURE -->
	<div id="factureWrapper" class="container">
	</div>
	
	<div id="factureFooter" class="container">
		<div id="factureFooterEstimation">
			<p><b>Atention : </b>Ceci est une estimation et ne peut tenir lieu de facture. Pour obtenir la facture, veuillez utiliser le bouton "Valider" en haut à gauche.</p>
		</div>
		<div id="factureFooterFacture">
			<p><b>Merci de rappeler le n° de la facture lors de l’envoi du règlement ( à marquer a dos du chèque).</b></p>
			<br/>
			<p>Le règlement sera à mettre à l’ordre de : <b>UI VVNVVD</b> et à envoyer au vice-secrétaire de l’association :</p>
			<blockquote>
				Jean-Sébastien PETER<br/>
				Domaine d’Ambert<br/>
				45400 Chanteau<br/>
			</blockquote>
		</div>
	</div>

	<!-- FENETRE DE CONNEXION -->
	<div id="dialog-formLogin" title="Se connecter">
		<p class="validateTips">Tous les champs sont obligatoires.</p>
		<form id="formLogin" action="#" title="Connexion">
			<fieldset>
				<label for="login">Identifiant</label>
				<input type="text" name="login" id="login"/><br />
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password" />
				<br />
			</fieldset>
		</form>
	</div>

	<!-- CONFIRMATION AJOUT FACTURE -->
	<div id="dialog-confirm" title="Confirmer la création ?">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Êtes-vous sur de vouloir confirmer la création de cette facture ?</p>
	</div>
	
	<!-- CONFIRMATION PAIEMENT FACTURE -->
	<div id="dialog-confirm-paiement" title="Confirmer le paiement de la facture ?">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Validez-vous le paiement de cette facture ?</p>
	</div>
	
  </body>
</html>