<?php
	require "entete.php";
	require "db.php";
	
	//////////
	// todo : validation plus complete des données : nombre , url , etc.
	//
	//
	////////
	
	$type = mysql_real_escape_string($_POST["type"]);
	$marque = mysql_real_escape_string($_POST["marque"]);
	$model = mysql_real_escape_string($_POST["model"]);
	$cylindree = mysql_real_escape_string($_POST["cylindree"]);
	$annee = mysql_real_escape_string($_POST["annee"]);
	$km = mysql_real_escape_string($_POST["km"]);
	$prix = mysql_real_escape_string($_POST["prix"]);
	$cp = mysql_real_escape_string($_POST["cp"]);
	$annonceUrl = mysql_real_escape_string($_POST["annonceUrl"]);
	$dateAnnonce = mysql_real_escape_string($_POST["dateAnnonce"]);
	
	$sql='INSERT INTO annonce (type,marque,model,cylindre,prix,km,annee,cp,detailsURL) VALUES (';
	$sql = $sql . '\'' . $type . '\' , ';
	$sql = $sql . '\'' . $marque . '\' , ';
	$sql = $sql . '\'' . $model . '\' , ';
	$sql = $sql .  $cylindree . ' , ';
	$sql = $sql .  $prix . ' , ';
	$sql = $sql .  $km . ' , ';
	$sql = $sql .  $annee . ', ';
	$sql = $sql .  $cp . ', ';
	$sql = $sql . '\'' . $annonceUrl . '\' ) ;';
	echo '<br/>' . $sql ; //debug
	
	$rs = mysql_query($sql);
	if (rs) {
		echo 'nombre de lignes affectées : ' . mysql_affected_rows();
	} else {
		echo '[ERREUR] la requete a échoué';
	}
		
	require "pied.php";
?>