<?php
	require "entete.php";
	$charts=array();
	$charts['parNb'] = 'ofcCompare.php?type=nb';
	$charts['parPrix'] = 'ofcCompare.php?type=prix';
	$charts['parKm'] = 'ofcCompare.php?type=km';
	entete(true,$charts);
?>
<p>Comparaisons basées sur le types</p>

<?php 
	foreach($charts as $titre => $dataFile) {
		echo '<div id='  . $titre . '></div>';
	}
?>

 

<?php
	require "pied.php";
	pied();
?>
