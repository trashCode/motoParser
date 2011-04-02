<?php
	require_once "annonce.class.php";
	$temps_debut = microtime(true);
	set_time_limit(600);// si c pas fini en 10 minutes, c'est que c'est planté?
	
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
	
	// ############## MAIN ####################
	// on recupere les données du formulaire

	
	foreach (extraireListes("./requete.txt") as $key => $val){
				echo 'parsing : ' .$val. "\n";
				//recuperation derniere page :
				$listeSearchUrl = extraireLastUrl($val);
				foreach($listeSearchUrl as $key => $val){
					parseMultiple($val);
				}
			}
		
	$temps_fin = microtime(true);
?>