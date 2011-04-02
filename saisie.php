<?php
	require "entete.php";
	entete();
?>
	<br/>
	<br/>
	<form method="post" action="parseMoto85.php" >
	<fieldset>
	<legend> Site : moto85 (obsolete)</legend>
	<div> url : <input type="text" name="annonceUrl" maxlength=255 size=100 /> </div>
	<div> 
		<input type="radio" name="typeTarget" value=0 /> Liste Annonce<br/>
		<input type="radio" name="typeTarget" value=1 /> Annonce seule<br/>
		<input type="radio" name="typeTarget" value=2 /> Dossier contenant Listes Annonces (/var/www/offline)<br/>
	</div>
	<input type="submit" value="Annonce moto85" >
	</fieldset>
	</form>
	<br/>
	<br/>
	
	
	<form method="post" action="parseMotoLBC.php" enctype="multipart/form-data">
	<fieldset>
	<legend> Site : Le bon coin</legend>
	<table>
		<tr><td> url : </td><td> <input type="text" name="annonceUrl" maxlength=255 size=50 /> </td></tr>
		<tr><td> Type : </td><td> <input type="text" name="type" maxlength=255 size=50 /> </td></tr>
		<tr><td> Marque : </td><td> <input type="text" name="marque" maxlength=255 size=50 /> </td></tr>
		<tr><td> Model : </td><td> <input type="text" name="model" maxlength=255 size=50 /></td> </tr>
		<tr><td> Cylindrée : </td><td> <input type="text" name="cylindre" maxlength=255 size=50 /> </td></tr>
		<tr><td> Fichier : </td><td> <input type="file" name="fichier" size=50 /> </td></tr>
		</table>
			<input type="radio" name="typeTarget" value=0 /> Liste Annonce<br/>
			<input type="radio" name="typeTarget" value=1 /> Annonce seule<br/>
			<input type="radio" name="typeTarget" value=2 /> Fichier de listes (multiples URLS)<br/>
	<input type="submit" value="Annonce LBC" >
	</fieldset>
	</form>
	<br/>
	<br/>

	<fieldset>
	<legend> Gestion BDD</legend>
	<form method="post" action="purgeAnnonce.php">
		<input type="submit" value="Purger la Base de données" >
	</form>
	<br/>
	<form method="post" action="trierAnnonce.php">
		<input type="submit" value="supprimer annonce indésirables" >
	</form>
	<br/>
	<form method="post" action="saveLotAnnonce.php">
		<input type="submit" value="sauvegarder lot d'annonces" >
	</form>
	</fieldset>
	<br/>

<?php
	require "pied.php";
	pied();
?>
