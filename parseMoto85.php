<?php
	// page appelée par saisie.php 
	// on recupere les données du formulaire 
	require "entete.php";
	require_once "annonce.class.php";
	$temps_debut = microtime(true);
	
	
	
	function extraireUrls($inputUrl){
		
		$source= fopen($inputUrl,r);
		while (!feof($source)) {
				$html .= fgets ($source);
			}
		fclose ($source);
		
		$number = preg_match_all ( '/annonce\/moto-occasion-annonce_[0-9]*\//' , $html , $resultat);
		// echo print_r(array_unique($lignes));
		$lignes = $resultat[0];
		return array_unique($lignes);
		
	}
	
	
	$url = htmlspecialchars($_POST['annonceUrl']);
	echo '<h1>'. (int)$_POST['typeTarget'].'</h1>';
	switch ((int)$_POST['typeTarget']) {
		case 1:
		{
		// Parsing d'un url contenant une seule annnonce
		//
		//
		//
			$annonce = new annonce($url);
			$annonce->storeToDB();
			
			
		} 
		break;
	case 0 :
		{
		// parsing d'une url contenant une liste d'annonce.
		//
		//pour le momment : uniquement moto85
		//		
			echo '<h1>' . $_POST['annonceUrl'] .'</h1>';
			$urls=extraireUrls($_POST['annonceUrl']);
			foreach ($urls as $url) {
				$annonce = new annonce('http://moto85.com/' .$url);
				$annonce->storeToDB();
			}
		}
		break;
	
	case 2 :
		{
		// parsing de tous les fichiers htm html source d'un dossier.
		//
		//pour le momment : uniquement moto85
		//
		$MyDirectory = opendir('/var/www/moto/offline') or die('Erreur');
			echo 'opendir ok <br/>';
			while($Entry = @readdir($MyDirectory)) {
				if(is_dir($Directory.'/'.$Entry)) {
				//gerer l'erreur
				}
				else {
					echo 'Traitement de : <b>'. $Entry.'</b> <br/>';
					$urls=extraireUrls('/var/www/moto/offline/'.$Entry);
					foreach ($urls as $url) {
						$annonce = new annonce('http://moto85.com/' .$url);
						$annonce->storeToDB();
					}
					
				}
			}
			closedir($MyDirectory);
		}
		break;
	}
	
	$temps_fin = microtime(true);
	echo '<div class="piedFond" style="text-align: right; font-size: 0.7em;"> Temps d\'execution : '.round($temps_fin - $temps_debut, 4) . ' secondes </div>';
	require "pied.php";
?>