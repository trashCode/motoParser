<?php
	require "entete.php";
	entete();
	require "db.php";
	
	$tableName = 'save'.date(  "dmY");
	
	$result=@mysql_query("select * from $tableName limit 1"); //ne marche pas si la table est vide;
	//$result=mysql_query('show tables like \''.$tablename.'\'', $handle); 
	if ($result) {
		mysql_free_result($result);
		echo("<h1>la table $tableName existe deja.</h1>");
	}else{
		$rs = mysql_query("CREATE TABLE $tableName AS SELECT * FROM annonce;");
		echo "<h1>table $tableName créee.</h1>";
	}
	
	require 'pied.php';
	pied();
	sleep(3);
	echo '<META HTTP-EQUIV="Refresh" CONTENT="1;URL= saisie.php.php"> ';
?>
	