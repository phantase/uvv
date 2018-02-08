<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Union Vovinam - Espace adhérent</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
  </head>
  <body>
	
	<h1>Union Vovinam - Espace adhérent</h1>
	
	<div id="badges">
		
		<div class="badge" id="badgeUnion">
			<img src="images/logo_union1.png" alt="Union InterRégionale Vovinam Viet Vo Dao" title="Union InterRégionale Vovinam Viet Vo Dao"/>
		</div>
		
		<div class="badge" id="badgeIdentite">
			<img class="icon48px" src="images/icons/about48px.png" alt="Identité" title="Identité"/>
			<span class="label" id="identite">Non connecté</span>
		</div>
		
		<!-- Log(in/out) -->
		<div class="badge" style="display:none;" id="badgeLogin">
			<img class="icon" src="images/icons/login128px.png" alt="Login" title="Login"/>
			<span class="label">Connexion</span>
		</div>
		<div class="badge" style="display:none;" id="badgeLogout">
			<img class="icon" src="images/icons/logout128px.png" alt="Logout" title="Logout"/>
			<span class="label">Déconnexion</span>
		</div>
		
		<!-- Notifications -->
<!--		<div class="badge" style="display:none;" id="badgeNotificationAdherents">
			<div class="notif">
				<span class="notifNumber" id="notifAdherentsNombre">?</span>
				<img class="notifIcon" src="images/icons/address-book32px.png" alt="Adhérents" title="Adhérents"/>
			</div>
			<div class="notifLabel">Adhérents en attente</div>
			<span class="notifTodo">Bientôt</span>
		</div>-->
		<div class="badge" style="display:none;" id="badgeNotificationLicencies">
			<div class="notif">
				<span class="notifNumber" id="notifLicenciesNombre">?</span>
				<img class="notifIcon" src="images/icons/user32px.png" alt="Licenciés" title="Licenciés"/>
			</div>
			<div class="notifLabel">Licenciés en attente</div>
		</div>
		<div class="badge" style="display:none;" id="badgeNotificationLicences">
			<div class="notif">
				<span class="notifNumber" id="notifLicencesNombre">?</span>
				<img class="notifIcon" src="images/icons/bussiness-card32px.png" alt="Licences" title="Licences"/>
			</div>
			<div class="notifLabel">Licences en attente</div>
		</div>
		<div class="badge" style="display:none;" id="badgeNotificationFactures">
			<div class="notif">
				<span class="notifNumber" id="notifFacturesNombre">?</span>
				<img class="notifIcon" src="images/icons/document32px.png" alt="Factures" title="Factures"/>
			</div>
			<div class="notifLabel">Factures en attente</div>
			<span class="notifTodo">Bientôt</span>
		</div>

		<!-- Actions -->
		<div class="badge" style="display:none;" id="badgeAdherents">
			<img class="icon" src="images/icons/address-book128px.png" alt="Adhérents" title="Adhérents"/>
			<span class="label">Adhérents</span>
		</div>
<!--		<div class="badge" style="display:none;" id="badgeLicencies">
			<img class="icon" src="images/icons/user128px.png" alt="Licenciés" title="Licenciés"/>
			<span class="label">Licenciés</span>
		</div>-->
<!--	<div class="badge" style="display:none;" id="badgeBureau">
			<img class="icon" src="images/icons/users128px.png" alt="Bureau" title="Bureau"/>
			<span class="label">Bureau</span>
		</div>-->
		<div class="badge" style="display:none;" id="badgeClubs">
			<img class="icon" src="images/icons/users-alt128px.png" alt="Clubs" title="Clubs"/>
			<span class="label">Clubs</span>
		</div>
		<div class="badge" style="display:none;" id="badgeLicences">
			<img class="icon" src="images/icons/bussiness-card128px.png" alt="Licences" title="Licences"/>
			<span class="label">Licences</span>
			<span class="todo">Bientôt</span>
		</div>
		<div class="badge" style="display:none;" id="badgeFactures">
			<img class="icon" src="images/icons/documents128px.png" alt="Factures/Reçus" title="Factures/Reçus"/>
			<span class="label">Factures<br/>+ Reçus</span>
			<span class="todo">Bientôt</span>
		</div>
		<div class="badge" style="display:none;" id="badgeSaisons">
			<img class="icon" src="images/icons/calendar128px.png" alt="Saisons" title="Saisons"/>
			<span class="label">Saisons</span>
		</div>
		<div class="badge" style="display:none;" id="badgeLexiques">
			<img class="icon" src="images/icons/list-numbered128px.png" alt="Lexiques" title="Lexiques"/>
			<span class="label">Lexiques</span>
			<span class="todo">Bientôt</span>
		</div>
		
	</div>
	
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
	
    <script src="js/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="js/jquery-ui.js"></script>
    <script src="js/script.js"></script>

  </body>
</html>