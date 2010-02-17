<?php
	require "entete.php";
	require "db.php";
	
	$sql = 'DELETE FROM annonce;';
	if (mysql_query($sql)) {
		echo '<h1> La Base de données a été purgée</h1>';
		echo 'nombre de lignes affectées : ' . mysql_affected_rows();
	} else {
		echo '<h1> Erreure : impossible de vider la base.</h1>';
	}
	
	require 'pied.php';
?>
	