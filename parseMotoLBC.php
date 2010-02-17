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
		
		$number = preg_match_all ( '/vi\/(\d+)\.htm/' , $html , $resultat);
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
		
			$annonce = new annonce($url);
			$annonce->storeToDB();
			
			
		} 
		break;
	case 0 :
		{
		// parsing d'une url contenant une liste d'annonce.
		
			echo '<p>' . $_POST['annonceUrl'] .'</p>';
			$urls=extraireUrls($_POST['annonceUrl']);
			foreach ($urls as $url) {
				echo  '<div>' . $url . '<br/>';
				$annonce = new annonce('http://www.leboncoin.fr/' .$url);
				
				if ($annonce->getType() == '') { $annonce->setType(mysql_real_escape_string($_POST['type']));}
				if ($annonce->getMarque() == '') {$annonce->setMarque(mysql_real_escape_string($_POST['marque']));}
				if ($annonce->getModel() == '') {$annonce->setModel(mysql_real_escape_string($_POST['model']));}
				if ($annonce->getCylindre() == '' || $annonce->getCylindre() == 0) {$annonce->setCylindre(mysql_real_escape_string($_POST['model']));}
				
				if ($annonce->getCp() != '' && $annonce->getPrix() != '' && $annonce->getKm() != '' && $annonce->getAnnee() != ''){
					$annonce->storeToDB();
				echo '</div>' ."\n";
				} else {
					echo 'Erreur:<br/>';
					echo '<a href="'.$annonce->getDetailURL() .'"> URL  </a> <br/>';
					echo 'Code postal: '.$annonce->getCp() .'<br/>';
					echo 'Prix: '.$annonce->getPrix() .'<br/>';
					echo 'Km: '.$annonce->getKm() .'<br/>';
					echo 'Annee: '.$annonce->getAnnee() .'<br/>';
					echo '</div>';
				}
			}
		}
		break;
	
	case 2 :
		{
		// parsing de tous les fichiers htm html source d'un dossier.
		
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
