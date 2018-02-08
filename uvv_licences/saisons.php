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
	<script type="text/javascript" charset="utf8" src="js/script.saisons.js"></script>
  </head>
  <body>
	<img class="logoEspace" src="images/icons/calendar128px.png" alt="Espace Adhérents" title="Espace Adhérent > Saisons" />
	<h1>Union Vovinam - Espace adhérent > Saisons</h1>
	<div id="tableWrapper">
		<input type="button" value="Supprimer" id="delButton" disabled /> <input type="button" value="Ajouter" id="addButton" /> 
		<table id="saisonsList" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Numéro</th>
					<th>Nom</th>
					<th>Début</th>
					<th>Fin</th>
				</tr>
			</thead>
	 
			<tfoot>
				<tr>
					<th></th>
					<th>Numéro</th>
					<th>Nom</th>
					<th>Début</th>
					<th>Fin</th>
				</tr>
			</tfoot>
		</table>
		
		<div id="dialog-formAddNewRow" title="Ajouter une saison">
			<p class="validateTips">Tous les champs sont obligatoires.</p>
			<form id="formAddNewRow" action="#" title="Add new record">
				<fieldset>
					<legend>Saison</legend>
					<label for="nom">Nom</label>
					<input type="text" name="nom" id="nom"  size="30"/>
					<br />
					<label for="debut">Début</label>
					<input type="text" name="debut" id="debut" />
					<label for="fin">Fin</label>
					<input type="text" name="fin" id="fin" />
				</fieldset>
			</form>
		</div>
	</div>
  </body>
</html>
	