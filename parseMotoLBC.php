<?php
	// page appelée par saisie.php 
	// on recupere les données du formulaire 
	require "entete.php";
	entete();
	require_once "annonce.class.php";
	$temps_debut = microtime(true);
	
	
	function extraireLastUrl($inputUrl){
		//liste toutes les urls d'un resultat de recherche pour pouvoir les parser page par page
		//sinon, on ne traite que les 50 premiers...
		
		//recuperation page HTML
		$source= fopen($inputUrl,r);
		while (!feof($source)) {
				$html .= fgets ($source);
			}
		fclose ($source);
		
		//recherche derniere page.
		$nb = preg_match ( '/href="(.+)"\>Derni&egrave;re page/' , $html , $resultat);
		$lastUrl = $resultat[1];

		//extraction numero page
		
		$nb = preg_match('/(.+\?o=)(\d+)(\&.+)/' , $lastUrl , $resultat);
		
		//extraction parametres de la requete (pour renseigner le type moto dans l'annonce)
		parse_str($lastUrl,$rs);
		$q= $rs['amp;q'];
		$ccs= $rs['amp;ccs'];//ccs = mini
		$cce= $rs['amp;cce'];//cce=maxi
		
		$_POST['type']=$q.'-'.$ccs;
		
		
		//$chaineComplete =$resultat[0];
		$debut=$resultat[1];
		$numeroLastPage=$resultat[2];
		$fin=$resultat[3];
		
		//generation toutes pages.
		$return=array();
		for ($numeroLastPage;$numeroLastPage>0;$numeroLastPage--){
			$return[] = htmlspecialchars_decode($debut.$numeroLastPage.$fin);
		}

		return $return;
		
	}
	
	function extraireUrls($inputUrl){
		//recupere les urls des annonces a partir de l'url des resultat de recherche
		echo 'extraireUrls Called : ' . $inputUrl .'<br/>';
		$source= fopen($inputUrl,r);
		while (!feof($source)) {
				echo '*';
				$html .= fgets ($source);
			}
		fclose ($source);
		
		// $number = preg_match_all ( '/vi\/(\d+)\.htm/' , $html , $resultat);
		$number = preg_match_all ( '/motos\/(\d+)\.htm/' , $html , $resultat);
		// echo print_r(array_unique($lignes));
		$lignes = $resultat[0];
		
		return array_unique($lignes);
		
	}
	
	function extraireListes($file){
		//recupere les urls de resultat de recherche a partir d'un fichier
		$source = fopen($file,r);
		$listes = array();
		while (!feof($source)){
			$line = fgets($source);
			//$line = trim($line); //marche, sauf peu etre pour les mac (fgets a un comportement bizzard)
			$line = str_replace(array("\n" , "\r"), "" , $line); //les retour charriot n'ont pas leur place dans une URL, il font echouer la requete HTTP GET
			
			if (!empty($line)){
				$listes[] = $line;
				var_dump($line);
			}
		}
		fclose ($source);
		return $listes;
	}
	
	function parseSingle($url){
		//traite l'url d'une annonce simple
				$annonce = new annonce($url);
				
				if ($annonce->getType() == '') { $annonce->setType(mysql_real_escape_string($_POST['type']));}
				if ($annonce->getMarque() == '') {$annonce->setMarque(mysql_real_escape_string($_POST['marque']));}
				if ($annonce->getModel() == '') {$annonce->setModel(mysql_real_escape_string($_POST['model']));}
				if ($annonce->getCylindre() == '' || $annonce->getCylindre() == 0) {$annonce->setCylindre(mysql_real_escape_string($_POST['model']));}
				
				if ($annonce->getCp() != '' && $annonce->getPrix() != '' && $annonce->getKm() != '' && $annonce->getAnnee() != ''){
					$annonce->storeToDB();
				echo '</div>' ."\n";
				} else {
					echo '<table> <tr> <td> Erreur:</td><td>';
					echo '<a href="'.$annonce->getDetailURL() .'"> URL  </a> </td> </tr>';
					echo '<tr><td>Code postal: </td><td> '.$annonce->getCp() .'</td></tr>';
					echo '<tr><td>Prix: </td><td>'.$annonce->getPrix() .'</td></tr>';
					echo '<tr><td>Km: </td><td>'.$annonce->getKm() .'</td></tr>';
					echo '<tr><td>Annee: </td><td>'.$annonce->getAnnee() .'</td></tr></table>';
					echo '</div>';
				}
	}
	
	function parseMultiple($urlsearch){
		//traite toute les urls d'annonces simple a partir de l'url d'un resultat de recherche
		echo 'parseMultiple Called : ' . $urlsearch .'<br/>';
		$urls=extraireUrls($urlsearch);
		echo 'annonce trouvées: <b>' .sizeof($urls) . '</b><br/>';
			foreach ($urls as $url) {
				echo  '<div> parsing : ' . $url . '<br/>';
				parseSingle('http://www.leboncoin.fr/' .$url);
			}
	}
	
	
	$url = htmlspecialchars($_POST['annonceUrl']);
	echo '<h1>'. (int)$_POST['typeTarget'].'</h1>';
	
	switch ((int)$_POST['typeTarget']) {
		
		
		case 1:
		{
		// Parsing d'un url contenant une seule annnonce
	
			parseSingle('http://www.leboncoin.fr/' .$url);
			
		} 
		break;
	case 0 :
		{
		// parsing d'une url contenant une liste d'annonce.
		
			parseMultiple($_POST['annonceUrl']);
			
		}
		break;
	
	case 2 :
		{
			//reception d'un fichier contenant des URLS a parser.
			var_dump($_FILES['fichier']['tmp_name']);
			foreach (extraireListes($_FILES['fichier']['tmp_name']) as $key => $val){
				echo '<h3>parsing : ' .$val. '</h3>';
				//recuperation derniere page :
				$listeSearchUrl = extraireLastUrl($val);
				foreach($listeSearchUrl as $key => $val){
					parseMultiple($val);
				}
			}
		//// parsing de tous les fichiers htm html source d'un dossier.
		
		// $MyDirectory = opendir('/var/www/moto/offline') or die('Erreur');
			// echo 'opendir ok <br/>';
			// while($Entry = @readdir($MyDirectory)) {
				// if(is_dir($Directory.'/'.$Entry)) {
				////gerer l'erreur
				// }
				// else {
					// echo 'Traitement de : <b>'. $Entry.'</b> <br/>';
					// $urls=extraireUrls('/var/www/moto/offline/'.$Entry);
					// foreach ($urls as $url) {
						// $annonce = new annonce('http://moto85.com/' .$url);
						// $annonce->storeToDB();
					// }
					
				// }
			// }
			// closedir($MyDirectory);
		}
		break;
	}
	
	$temps_fin = microtime(true);
	echo '<div class="piedFond" style="text-align: right; font-size: 0.7em;"> Temps d\'execution : '.round($temps_fin - $temps_debut, 4) . ' secondes </div>';
	require "pied.php";
	pied();
?>
