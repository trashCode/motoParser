<?php
	print<<<_HTML_

	<?xml version="1.0" encoding="utf-8"?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr-FR" lang="fr-FR">
	<head>
		<title>Parser Annonce v0.1beta</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href="../styles.css" media="all" rel="stylesheet" type="text/css" />
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
			<a href="./saisie.php" title="Saisie manuelle d\'une annonce">Saisie manuelle</a>
		</li>
		<li style="display: inline">
			<a href="./nothing.php" title="Consultation">Consultation</a>
		</li>
		<li style="display: inline">
			<a href="./testSingleFunc.php" title="testSingleFunction">debug</a>
		</li>
	</ul>
	
	</div>
_HTML_;

	// le but de la fonction est de remplir un tableau $parsed, qui sera ensuite enregistrer dans la base.
	//
	error_reporting(1);
	function sansPonctuation($text){
		$ponctuation = array(',',';',':','!','?','.');
		return str_replace($ponctuation,'',$text);
	}
	
	function miseEnForme($parsedRaw) {
		$tmp = array();
		foreach ($parsedRaw as $key => $val) {
			switch (trim(sansPonctuation($key))) {
				case 'Prix':
				case 'prix':
					$tmp['prix']=preg_replace('/\D/','',$val); // on ne garde que les chiffres.
					break;
				case 'Date de mise à jour':
				case 'Date de mise Ã jour':
					$tmp['dateAnnonce'] = $val;
					break;
				case 'Type':
					$tmp['type'] = $val;
					break;
				case 'Marque':
					$tmp['Marque'] = $val;
					break;
				case 'Modèle':
					$tmp['model'] = $val;
					break;
				case 'Cylindrée':
					$tmp['cylindre'] = preg_replace('/(\d+).*/','\1',$val); //ne pas prendre le '3' de cm3 !
					break;
				case 'Mise en circulation':
					$tmp['annee'] = $val;
					break;
				case 'Kilométrage':
					$tmp['km'] = preg_replace('/\D/','',$val);
					break;
				case 'Garantie':
					$tmp['garantie'] = $val;
					break;
				case 'vendeur':
					$tmp['origine'] = $val;				
					break;
				case 'Adresse':
					$tmp['adresse'] = $val;
					break;
				case 'Code Postal':
					$tmp['CP'] = $val;
					break;
				case 'Ville':
					$tmp['ville'] = $val;
					break;
				case 'Téléphone':
					$tmp['tel'] = $val;
					break;
				default :
					if ((is_int(stripos($key,'date de mise'))) && (is_int(stripos($key,'jour')))) { //parce que parfois, le "à" est vraiment bizzare. probleme de detection de charset sur la page par DOM iirc
						$tmp['dateAnnonce'] = $val;
					} else {
						//echo '<div style="color:#FF9933;"> non parsée: '  . $key . ' -- <b>' . $val .'</b></div>';
					}
					break;
			}
		}
		return $tmp;
	}
	function parseMoto85($url) {
		$temps_1 = microtime(true);
		$dom = new DomDocument();
		$dom->encoding = 'utf-8';
		$dom->loadHTMLFile($url);
		$dom->preserveWhiteSpace = 'fasle';
		$temps_2 = microtime(true);
		echo '<div>temp de parsing DOM : '.round($temps_2 - $temps_1, 4) .'</div>';
		$tableRows = $dom->getElementsByTagName('tr');

		for($i=0;$i<$tableRows->length;$i++){
			$tableRow=$tableRows->item($i); //une tableRow peu contenir un th, et plusieur tr. il faut les differencier.
			
			for ($j=0; $j<$tableRow->childNodes->length;$j++) {
			
				switch ($tableRow->childNodes->item($j)->nodeName) {
					case 'th' :
						$key = $tableRow->childNodes->item($j)->nodeValue;
						if ($tableRow->childNodes->item($j)->hasAttributes()) {
							$attribut = $tableRow->childNodes->item($j)->attributes;
							if ($attribut = 'vendeur') { $val = $key; $key = 'vendeur'; $attribut='';};
						}	
						break;
					case 'td':
						$val = $tableRow->childNodes->item($j)->nodeValue;
						break;
					default:
						break;
				}		
				
			}
			$parsedRaw[$key]=$val;
		

		}
		$temps_3 = microtime(true);
		echo '<div>temp de mon parsing : '.round($temps_3 - $temps_2, 4) .'</div>';
		 
		 //// affichage tableau donnée brut
		 
		 // echo '<table>';
		 // foreach ($parsedRaw as $k=>$v) {echo '<tr><td>'. $k . '</td> <td>' . $v .'</td></tr>';}
		 // echo '</table>';
		
		$parsed = miseEnforme($parsedRaw);
		
		$temps_4 = microtime(true);
		echo '<div>temp de mise en Forme : '.round($temps_4 - $temps_3, 4) .'</div>';
		
		echo '<div style="display:inline-table;">nb=<b>' .preg_replace('/.*?(\d+).*?(\d+).*/','\2',$url) . '</b><br/><table>';
		// echo '<div style="display:inline-table;><table>';
		foreach ($parsed as $k=>$v) {echo '<tr><td>'. $k . '</td> <td>' . $v .'</td></tr>';}
		echo '</table></div>';
		$temps_5 = microtime(true);
		echo '<div>temp total : '.round($temps_5 - $temps_1, 4) .'</div>';
	}
		


//
//
//
// MAIN
		
		$temps_0 = microtime(true);
		$target = fopen('http://www.moto85.com/annonces-moto-occasion/tout/',r);
		while (!feof($target)) {
			$html .= fgets ($target);
		}
		fclose ($target);
		$number = preg_match_all ( '/annonce\/moto-occasion-annonce_[0-9]*\//' , $html , $resultat);
		// echo print_r(array_unique($lignes));
		$lignes = $resultat[0];
		$urls = array_unique($lignes);
		$done=0;
		foreach ($urls as $url) {
			parseMoto85('http://www.moto85.com/' .$url);
			$done++;
		}
		
		$temps_01 = microtime(true);
		echo '<div>temp total : '.round($temps_01 - $temps_0, 4) .'</div>'; 
		echo '<div><h2>annonce parsées : '. $done .'</h2></div>'; 
	
	/* parseMoto85('http://www.moto85.com/index.php?parametre=annonce/moto-occasion-annonce_2786208/'); */
	
	
?>
