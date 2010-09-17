<?php
	require "entete.php";
	entete();
	require "db.php";
		
	//recuparation de tous les models 
	$nbModels=0;
	$sql = 'SELECT distinct type FROM annonce order by type;';
	$rs= mysql_query($sql);
	$models = array();
	while ($row = mysql_fetch_assoc($rs)) {
		$models[] =  $row['type'];
		$nbModels+=1;
	}
	
	foreach($models as $model){
		echo '<h3>' .$model. '</h3>';
		
		$sql = 'DELETE FROM annonce WHERE type="' .$model. '" and model not like "%' .preg_replace('/-\d+/' , '' ,$model). '%";'  ;//il faut supprimer la cylindrée a la fin du model
		$rs= mysql_query($sql);
		echo 'motos d un autre genre : (mot clefs trompeurs dans le corps de l\'annonce) ' . mysql_affected_rows();
	}
	
	echo '<h3> tous models</h3>';
	
	$sql = 'DELETE FROM annonce WHERE model LIKE "%accid%";'  ;
	$rs= mysql_query($sql);
	echo 'accidentées : ' . mysql_affected_rows() ."<br/>";
	
	$sql = 'DELETE FROM annonce WHERE model LIKE "%piste%" and model NOT LIKE "%route%";'  ;
	$rs= mysql_query($sql);
	echo 'motos piste : ' . mysql_affected_rows()."<br/>";
	
	require 'pied.php';
	pied();
?>
	