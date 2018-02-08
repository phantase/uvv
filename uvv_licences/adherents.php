<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Union Vovinam - Espace adhérent</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<script type="text/javascript" charset="utf8" src="js/jquery.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery-ui.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.jeditable.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.jeditable.datepicker.js"></script>
	<script type="text/javascript" charset="utf8" src="js/jquery.validate.js"></script>
	<script type="text/javascript" charset="utf8" src="js/script.adherents.js"></script>
  </head>
  <body>
	<img class="logoEspace" src="images/icons/address-book128px.png" alt="Espace Adhérents" title="Espace Adhérent > Adhérents" />
	<h1>Union Vovinam - Espace adhérent > Adhérents</h1>
	<div id="tableWrapper">
		<input type="button" value="Supprimer" id="delButton" disabled /> <input type="button" value="Ajouter" id="addButton" /> 
		| <b>Statut : </b>
		<select class="viewSelect" name="viewFilter" id="viewFilter" ></select>
		| <b>Club : </b>
		<select class="viewSelect" name="viewClub" id="viewClub" ></select>
		| <b>Saison : </b>
		<select class="viewSelect" name="viewSaison" id="viewSaison" ></select>
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
				</tr>
			</tfoot>
		</table>
		
		<div id="dialog-formAddNewRow" title="Ajouter un adhérent">
			<p class="validateTips">Tous les champs sont obligatoires.</p>
			<form id="formAddNewRow" action="#" title="Add new record">
				<fieldset>
					<legend>Etat Civil</legend>
					<label for="nom">Nom</label>
					<input type="text" name="nom" id="nom"/>
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
					<label for="mail">Courriel</label>
					<input type="text" name="mail" id="mail" size="60" />
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
					<label for="saison">Pour la saison</label>
					<select name="saison" id="saison" >
					</select>
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
					<br/>
					<label for="la_saison">Licencier pour la saison</label>
					<select name="la_saison" id="la_saison" >
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
					<br/>
					<label for="sa_saison">Pour la saison</label>
					<select name="sa_saison" id="sa_saison" >
					</select>
				</fieldset>
			</form>
		</div>

	</div>
  </body>
</html>
	