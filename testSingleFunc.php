<?php
	/*
		pour le site 85, les elements a parser sont dans 2 divs :
		<div id="sb-caracs">
		<div id="sb-description">
		<div id="sb-vendeur">

	*/
	

	$temps_debut = microtime(true);
	
	require "entete.php";
	require_once "annonce.class.php";
	error_reporting(E_ALL | E_STRICT);
	

	
		
	//$annonceTest = new annonce('http://www.moto85.com/index.php?parametre=annonce/moto-occasion-annonce_2663771/');
	$annonceTest = new annonce('http://www.leboncoin.fr/vi/68009959.htm');
	
	$temps_fin = microtime(true);
	
	echo '<br/>';
	echo 'type : ' . $annonceTest->getType() . '<br/>';
	echo 'marque : ' . $annonceTest->getMarque() . '<br/>';
	echo 'model : ' . $annonceTest->getModel() . '<br/>';
	echo 'cylindre : ' . $annonceTest->getCylindre() . '<br/>';
	echo 'imageURL : ' . $annonceTest->getImageURL() . '<br/>';
	echo 'origine : ' . $annonceTest->getOrigine() . '<br/>';
	echo 'prix : ' . $annonceTest->getPrix() . '<br/>';
	echo 'km : ' . $annonceTest->getKm() . '<br/>';
	echo 'annee : ' . $annonceTest->getAnnee() . '<br/>';
	echo 'code postal : ' . $annonceTest->getCp() . '<br/>';
	echo 'dateAnnonce : ' . $annonceTest->getDateAnnonce() . '<br/>';
	echo 'detailURL : ' . $annonceTest->getDetailURL() . '<br/>';
	$annonceTest->storeToDb();

	echo '<div class="piedFond" style="text-align: right; font-size: 0.7em;"> Temps d\'execution : '.round($temps_fin - $temps_debut, 4) . ' secondes </div>';
	require "pied.php";
?>
