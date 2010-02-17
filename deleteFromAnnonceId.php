<?php
	require "entete.php";
	require "db.php";
	
	$sql='delete from annonce where id = ' . mysql_real_escape_string($_GET["id"]) . ';';

	$rs = mysql_query($sql);
	if (rs) {
		echo 'nombre de lignes affectées : ' . mysql_affected_rows();
	} else {
		echo '[ERREUR] la requete a échoué';
	}
	echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL= index.php"> ';


	require "pied.php";

?>
