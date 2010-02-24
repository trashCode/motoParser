<?php
	function  entete($avecJs = false, $charts = '') {
?>
	<?xml version="1.0" encoding="utf-8"?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr-FR" lang="fr-FR">
	<head>
	
	<?php 
		if ($avecJs) { 
			foreach($charts as $titre => $dataFile) {
	?>
		<script type="text/javascript" src="swfobject/swfobject.js"></script>
			<script type="text/javascript">
		swfobject.embedSWF("open-flash-chart.swf", "<?php echo $titre; ?>", "600", "300", "9.0.0","expressInstall.swf",{"data-file":"<?php echo $dataFile;?>"});
		</script>
	<?php	
			}
		}
	?>

	<title>Parser Annonce v0.2beta</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href="styles.css" media="all" rel="stylesheet" type="text/css" />
		

		
	</head>
	<body>
	<div class="bandeauFond">
	<p class="bandeauTitre"> Parser Annonce </p>
	<br/>
	<ul id="menu">
		<li style="display: inline">
			<a href="./" title="liste des annonces">Accueil</a>
		</li>
		<li style="display: inline">
			<a href="./saisie.php" title="Saisie d\' annonce">Saisie</a>
		</li>
		<li style="display: inline">
			<a href="./saisieManuelle.php" title="Saisie d\' annonce">Saisie Manuelle</a>
		</li>
		<li style="display: inline">
			<a href="./consultation.php?ofc=ofcGraph8.php" title="Consultation">Consultation</a>
		</li>
		<li style="display: inline">
			<a href="./consultation2.php" title="Graph / Types">Graph par Types</a>
		</li>
		<li style="display: inline">
			<a href="./testSingleFunc.php" title="testSingleFunction">debug</a>
		</li>
	</ul>
	
	</div>
<?php 
	}//fin de fonction entete
?>
