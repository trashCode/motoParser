<?php
	require "entete.php";
	entete();
?>
	<br/>
	<br/>
	<form method="post" action="manuelle.php">
	<table>
	<tr> <td> Type :</td><td> <input type="text" name="type" maxlength=255 size=100 /></td> </tr>
	<tr> <td> Marque : </td><td> <input type="text" name="marque" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> Model : </td><td> <input type="text" name="model" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> cylindrée : </td><td> <input type="text" name="cylindree" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> Annee :  </td><td> <input type="text" name="annee" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> km : </td><td> <input type="text" name="km" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> prix : </td><td> <input type="text" name="prix" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> departement : </td><td> <input type="text" name="cp" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> url details : </td><td> <input type="text" name="annonceUrl" maxlength=255 size=100 /> </td> </tr>
	<tr> <td> date annonce : </td><td> <input type="text" name="dateAnnonce" maxlength=255 size=100 /> </td> </tr>
	</table>	
	<input type="submit" value="Ok" >
	<br/>

<?php
	require "pied.php";
?>
