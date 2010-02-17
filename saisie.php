<?php
	require "entete.php";
?>
	<br/>
	<br/>
	<form method="post" action="parseMoto85.php">
	<div> url : <input type="text" name="annonceUrl" maxlength=255 size=100 /> </div>
	<div> 
		<input type="radio" name="typeTarget" value=0 /> Liste Annonce<br/>
		<input type="radio" name="typeTarget" value=1 /> Annonce seule<br/>
		<input type="radio" name="typeTarget" value=2 /> Dossier contenant Listes Annonces (/var/www/offline)<br/>
	</div>
	<input type="submit" value="Annonce moto85" >
	</form>
	<br/>
	<br/>
	
	
	<form method="post" action="parseMotoLBC.php">
	<table>
		<tr><td> url : </td><td> <input type="text" name="annonceUrl" maxlength=255 size=50 /> </td></tr>
		<tr><td> Type : </td><td> <input type="text" name="type" maxlength=255 size=50 /> </td></tr>
		<tr><td> Marque : </td><td> <input type="text" name="marque" maxlength=255 size=50 /> </td></tr>
		<tr><td> Model : </td><td> <input type="text" name="model" maxlength=255 size=50 /></td> </tr>
		<tr><td> Cylindrée : </td><td> <input type="text" name="cylindre" maxlength=255 size=50 /> </td></tr>
		</table>
			<input type="radio" name="typeTarget" value=0 /> Liste Annonce<br/>
			<input type="radio" name="typeTarget" value=1 /> Annonce seule<br/>
			<input type="radio" name="typeTarget" value=2 /> Dossier contenant Listes Annonces (/var/www/offline)<br/>
	<input type="submit" value="Annonce LBC" >
	</form>
	<br/>
	<br/>

	
	<form method="post" action="purgeAnnonce.php">
	<input type="submit" value="Purger la Base de données" >
	</form>
	<br/>
	<br/>

<?php
	require "pied.php";
?>
