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
	<script type="text/javascript" charset="utf8" src="js/script.clubs.js"></script>
  </head>
  <body>
	<img class="logoEspace" src="images/icons/calendar128px.png" alt="Espace Adhérents" title="Espace Adhérent > Clubs" />
	<h1>Union Vovinam - Espace adhérent > Clubs</h1>
	<div id="tableWrapper">
		<input type="button" value="Supprimer" id="delButton" disabled /> <input type="button" value="Ajouter" id="addButton" /> 
		<table id="clubsList" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Numéro</th>
					<th>Nom</th>
					<th>Comité</th>
				</tr>
			</thead>
	 
			<tfoot>
				<tr>
					<th></th>
					<th>Numéro</th>
					<th>Nom</th>
					<th>Comité</th>
				</tr>
			</tfoot>
		</table>
		
		<div id="dialog-formAddNewRow" title="Ajouter un club">
			<p class="validateTips">Tous les champs sont obligatoires.</p>
			<form id="formAddNewRow" action="#" title="Add new record">
				<fieldset>
					<legend>Club</legend>
					<label for="nom">Nom</label>
					<input type="text" name="nom" id="nom"  size="30"/>
					<label for="debut">Mail</label>
					<input type="text" name="mail" id="mail" />
					<br/>
					<label for="appartenance">Appartient au comité</label>
					<select name="appartenance" id="appartenance">
					</select>
					<br/>
					<label for="estcomite">Est un comité ?</label>
					<input type="radio" name="estcomite" id="estcomite_oui" value="oui">Oui | 
					<input type="radio" name="estcomite" id="setcomite_non" value="non" checked>Non
				</fieldset>
			</form>
		</div>
	</div>
  </body>
</html>
	