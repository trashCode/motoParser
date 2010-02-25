<?php
	require "entete.php";
	$charts=array();
	$charts['parNb'] = 'ofcCompare1.php?type=nb';
	$charts['parPrix'] = 'ofcCompare1.php?type=prix';
	$charts['parKm'] = 'ofcCompare1.php?type=km';
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
