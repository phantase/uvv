<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Union Vovinam - Espace adhérent</title>
	
    <link rel="stylesheet" type="text/css" href="css/style2.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	
	<script type="text/javascript" charset="utf8" src="js/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="js/jquery-ui.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.jeditable.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.jeditable.datepicker.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.validate.js"></script>
	<script type="text/javascript" charset="utf8" src="js/script2.adherents.js"></script>
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
				<li id="btnLogout" class="right""><a href="#">deconnexion</a></li>
				<li id="notifLicencesNombre" class="right"></li>
				<li id="notifLicenciesNombre" class="right"></li>
			</ul>
		</div>
		<div id="adherentsToolbar">
			<input type="button" value="Supprimer" id="delButton" class="btn btnoff" disabled /> 
			<input type="button" value="Nouveau" id="addButton" class="btn" /> 
			<input type="button" value="Transfert" id="movButton" class="btn" /> 
			| <b>Statut : </b>
			<select class="viewSelect" name="viewFilter" id="viewFilter" ></select>
			| <b>Club : </b>
			<select class="viewSelect" name="viewClub" id="viewClub" ></select>
			| <b>Saison : </b>
			<select class="viewSelect" name="viewSaison" id="viewSaison" ></select>
		</div>
	</div>
	
	<!-- TABLEAU ADHERENTS -->
	<div id="tableWrapper" class="container">
		
		<table id="adherentsList" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Licence</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Né&nbsp;le</th>
					<th>Grade</th>
					<th>Catégorie</th>
					<th>Licencié</th>
				</tr>
			</thead>
	 
			<tfoot>
				<tr>
					<th></th>
					<th>Licence</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Né&nbsp;le</th>
					<th>Grade</th>
					<th>Catégorie</th>
					<th>Licencié</th>
				</tr>
			</tfoot>
		</table>
		
		<div id="dialog-formAddNewRow" title="Ajouter un adhérent">
			<p class="validateTips">Tous les champs sont obligatoires.</p>
			<form id="formAddNewRow" action="#" title="Add new record">
				<fieldset>
					<legend>Etat Civil</legend>
					<label for="nomadh">Nom</label>
					<input type="text" name="nomadh" id="nomadh"/>
					<label for="prenom">Prénom</label>
					<input type="text" name="prenom" id="prenom" size="30" />
					<br />
					<label for="datenaissance">Né le</label>
					<input type="text" name="datenaissance" id="datenaissance" />
				</fieldset>
				<fieldset>
					<legend>Adresse</legend>
					<label for="adrvoie">Voie</label>
					<input type="text" name="adrvoie" id="adrvoie" size="60" />
					<br />
					<label for="adrcp">Code Postal</label>
					<input type="text" name="adrcp" id="adrcp" size="7" />
					<label for="adrville">Ville</label>
					<input type="text" name="adrville" id="adrville" size="30" />
				</fieldset>
				<fieldset>
					<legend>Contact</legend>
					<label for="telfixe">Tél. (fixe)</label>
					<input type="text" name="telfixe" id="telfixe" />
					<label for="telport">Tél. (portable)</label>
					<input type="text" name="telport" id="telport" />
					<br />
					<label for="mailadh">Courriel</label>
					<input type="text" name="mailadh" id="mailadh" size="60" />
				</fieldset>
				<fieldset>
					<legend>Pratique</legend>
					<label for="grade">Grade</label>
					<select name="grade" id="grade" >
					</select>
					<label for="categorie">Catégorie</label>
					<select name="categorie" id="categorie" >
					</select>
				</fieldset>
				<fieldset>
					<legend>Club</legend>
					<label for="club">Club</label>
					<select name="club" id="club">
					</select>
					<br/>
					<label for="licencier">Licencier ?</label>
					<input type="radio" name="licencier" id="licencier_oui" value="oui">Oui | 
					<input type="radio" name="licencier" id="licencier_non" value="non" checked>Non
				</fieldset>
			</form>
		</div>

		<div id="dialog-formLicencier" title="Licencier un adhérent">
			<form id="formAddNewRow" action="#" title="Add new record">
				<fieldset>
					<legend>Etat Civil</legend>
					<label for="la_numlicence">Numéro de licence</label>
					<input type="text" name="la_numlicence" id="la_numlicence" disabled />
					<br/>
					<label for="la_nom">Nom</label>
					<input type="text" name="la_nom" id="la_nom" disabled />
					<label for="la_prenom">Prénom</label>
					<input type="text" name="la_prenom" id="la_prenom" size="30" disabled />
				</fieldset>
				<fieldset>
					<legend>Club</legend>
					<label for="la_club">Club</label>
					<select name="la_club" id="la_club">
					</select>
				</fieldset>
			</form>
		</div>

		<div id="dialog-formStatut" title="Ajouter un rôle à un adhérent">
			<form id="formAddNewRow" action="#" title="Add new record">
				<fieldset>
					<legend>Etat Civil</legend>
					<label for="sa_numlicence">Numéro de licence</label>
					<input type="text" name="sa_numlicence" id="sa_numlicence" disabled />
					<br/>
					<label for="sa_nom">Nom</label>
					<input type="text" name="sa_nom" id="sa_nom" disabled />
					<label for="sa_prenom">Prénom</label>
					<input type="text" name="sa_prenom" id="sa_prenom" size="30" disabled />
				</fieldset>
				<fieldset>
					<legend>Club</legend>
					<label for="sa_club">Club</label>
					<select name="sa_club" id="sa_club">
					</select>
					<br/>
					<label for="sa_statut">Rôle</label>
					<select name="sa_statut" id="sa_statut">
					</select>
				</fieldset>
			</form>
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
	
	<!-- FENETRE DE TRANSFERT -->
	
	<div id="dialog-formMove" title="Transfert d'adhérent">
		<p class="validateTips">Indiquez le numéro de licence. L'adhérent sera licencié à votre club pour la saison en cours.</p>
		<form id="formMove" action="#" title="Transfert">
			<fieldset>
				<legend>Etat Civil</legend>
				<label for="mv_numlicence">Numéro de licence</label>
				<input type="text" name="mv_numlicence" id="mv_numlicence" />
				<input type="hidden" name="mv_numlicence2" id="mv_numlicence2" />
				<img id="btnMovLookup" src="images/icons/search16px.png" /><span id="wngMovLookup"></span>
				<br/>
				<label for="mv_nom">Nom</label>
				<input type="text" name="mv_nom" id="mv_nom" disabled />
				<label for="mv_prenom">Prénom</label>
				<input type="text" name="mv_prenom" id="mv_prenom" size="30" disabled />
			</fieldset>
			<fieldset>
				<legend>Club</legend>
				<label for="mv_club">Club</label>
				<select name="mv_club" id="mv_club">
				</select>
			</fieldset>
		</form>
	</div>

	
  </body>
</html>