<?php
	require_once "db.php";
	
class annonce {	
	private $id;
	private $type;
	private $marque;
	private $model;
	private $cylindre;
	private $imageURL;
	private $origine;
	private $prix;
	private $km;
	private $annee;
	private $cp;
	private $dateAnnonce;
	private $detailURL;
	
	private $htmlSource;
	
	public function __construct() {
		$arg_list = func_get_args();
		
		if (count($arg_list)==1){
			$this->detailURL=$arg_list[0];
			$rs = parse_url($this->detailURL);
			
			switch ($rs["host"]) {
			case 'moto85.com' : 
				$this->miseEnForme($this->parseMoto85($this->detailURL));
				break;
			case 'www.leboncoin.fr':
				$this->parseLBC($this->detailURL);
				break;
			default:
				echo 'ERREUR: Le site : ' .  $rs["host"] . ' n est pas pris en charge <br/>';
			}
			return $this;
		}
		
		elseif (count($arg_list)==12) {
			$this->type=$arg_list[0];
			$this->marque=$arg_list[1];
			$this->model=$arg_list[2];
			$this->cylindre=$arg_list[3];
			$this->imageURL=$arg_list[4];
			$this->origine=$arg_list[5];
			$this->prix=$arg_list[6];
			$this->km=$arg_list[7];
			$this->annee=$arg_list[8];
			$this->cp=$arg_list[9];
			$this->dateAnnonce=$arg_list[10];
			$this->detailURL=$arg_list[11];
			return $this;
		}
		else {
			//todo gestion des exceptions.
			die("Erreur d'appel au constructeur : nombre d'arguements = count($arg_list);");
		}
	}
	
	public function sansPonctuation($text){
		$ponctuation = array(',',';',':','!','?','.');
		return str_replace($ponctuation,'',$text);
	}
	
	public function parseURLmoto85(){//depreciée
		$dom = new domdocument('1.0','utf-8');
		// $dom->encoding = 'utf-8';
		$dom->loadHTMLFile($this->detailURL);
		// $dom->preserveWhiteSpace = 'fasle';
		$dom->saveHTMLFile('/var/www/moto/offline/domOutput.html');
		
		// La pluspart des infos recherchées sont dans des tableaux.
		// Toutes les infos parsées sont d'abord inscrites dans un tableau de resultat final $parsed
		//
		//
		
		$tables = $dom->getElementsByTagName('table'); //renvois un DOMNodeList
		
		for ($i=0;$i<$tables->length;$i++){
			$lignes=$tables->item($i)->getElementsByTagName('tr');
			for ($j=0;$j<$lignes->length;$j++){
				$entete=$lignes->item($j)->getElementsByTagName('th');
				$contenu=$lignes->item($j)->getElementsByTagName('td');
			
				if ($entete->length > 0 && $entete->item(0)->hasAttribute('class')) {
					$key = 'vendeur'; //on est dans le <th class="vendeur">, pas de TR
					$val = $entete->item(0)->nodeValue; 
				} else {
					//on possede a priori un <th> et un <tr> (parfois juste un TR)
					// echo '<div style="color:#FFB642">' .$entete->item(0)->nodeValue . '</div>'; //DEBUG
					$key=trim($this->sansPonctuation($entete->item(0)->nodeValue));
					
					switch (strtolower($key)) {
						case 'prix' :
						case 'kilométrage':
						case 'code postal':
						//case 'téléphone': //pas de mise en forme pour l'instant.
						//case 'fax':
							$val=preg_replace('/\D/','',$contenu->item(0)->nodeValue); // on ne garde que les chiffres.
							break;
						case 'cylindrée':
							$val=preg_replace('/(\d+).*/','\1',$contenu->item(0)->nodeValue); //ne pas prendre le '3' de cm3 !
							break;
						case 'date de mise à jour':
						case 'mise en circulation':
							$val=trim($this->sansPonctuation($contenu->item(0)->nodeValue));
							break;
						default :
							echo '<div style="color:#CC3333;">[Erreur] impossible de parser <b>' .$key . '</b></div>';
							$val=trim($this->sansPonctuation($contenu->item(0)->nodeValue));
							break;
					}
					
				}

				$parsed[$key] = $val;
			}
		}
		// Les images sont stockées ailleurs. 
		//
		//
		$div = $dom->getElementById('grandePhoto'); //renvois un DOMElement
		//le html de la page n'est pas valide : 3 elements contiennent l'id grandePhoto. mais on ne recupere que le premier. ouf
		// pour utiliser hasAttribute, il faut au préalable valider le document.
		// if ($div->hasAttribute('src')) {
			// $parsed['imageURL']=$div->getAttribute('src');
		// }
		
		$this->remplirChamp($parsed);
	}
    
	private function remplirChamp($tableau){//depreciée
		
		if (isset($tableau['Type'])) { $this->type = $tableau['Type'];} else {echo '[Erreur] type non parsé <br/>';}
		if (isset($tableau['Marque'])) { $this->marque = $tableau['Marque'];} else {echo '[Erreur] marque non parsé <br/>';}
		if (isset($tableau['Modèle'])) { $this->model = $tableau['Modèle'];} else {echo '[Erreur] model non parsé <br/>';}
		if (isset($tableau['Cylindrée'])) { $this->cylindre = $tableau['Cylindrée'];} else {echo '[Erreur] cylindrée non parsée <br/>';}
		if (isset($tableau['imageURL'])) { $this->imageURL = $tableau['imageURL'];} else {echo '[Erreur] image non parsée <br/>';}
		if (isset($tableau['vendeur'])) { $this->origine = $tableau['vendeur'];} else {echo '[Erreur] vendeur non parsé <br/>';}
		if (isset($tableau['Prix'])) { $this->prix = $tableau['Prix'];} else {echo '[Erreur] prix non parsé <br/>';}
		if (isset($tableau['Kilométrage'])) { $this->km = $tableau['Kilométrage'];} else {echo '[Erreur] km non parsé <br/>';}
		if (isset($tableau['Mise en circulation'])) { $this->annee = substr($tableau['Mise en circulation'],-4);} else {echo '[Erreur] annee non parsé <br/>';}//on ne recupere que les 4 dernier chiffres. si l'année est codée sur 2 chiffre, ca va mal aller.
		if (isset($tableau['Code Postal'])) { $this->cp = $tableau['Code Postal'];} else {echo '[Erreur] cp / code postal non parsé <br/>';}
		if (isset($tableau['Date de mise à jour'])) { $this->dateAnnonce = $tableau['Date de mise à jour'];} else {echo '[Erreur] dateAnnonce non parsé <br/>';}

	}
	
	//parsing d'une annonce simple du site moto85
	//input: l'url de l'annonce 
	//output : parsedRaw un tableau contenant les information extraites de l'url
	private function parseMoto85($url) {
		error_reporting(1);//on masque les erreur DOM du a un HTML incorrect.
		$dom = new DomDocument();
		$dom->encoding = 'utf-8';
		$dom->loadHTMLFile($url);
		$dom->preserveWhiteSpace = 'fasle';

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
		 //debug : la table avant
		 // echo '<table>';
		 // foreach ($parsedRaw as $k=>$v) {echo '<tr><td>'. $k . '</td> <td>' . $v .'</td></tr>';}
		 // echo '</table>';
		return $parsedRaw;
	}
	
	//parsing d'une annonce simple du site moto85
	//input: l'url de l'annonce 
	//output : parsedRaw un tableau contenant les information extraites de l'url
	// TODO : parser la date de l'annonce;
	private function parseLBC($url) {
		error_reporting(1);//on masque les erreur DOM du a un HTML incorrect.
		$_debut = microtime(true);
			
		$dom = new DomDocument();
		$dom->encoding = 'iso-8859-15';
		$dom->loadHTMLFile($url);
		$dom->preserveWhiteSpace = 'fasle';
		
		$_domLoad = microtime(true);

		$tableRows = $dom->getElementsByTagName('span'); //$tableRows est DOMNodeList
		
		$_getElems = microtime(true);
		
		for($i=0;$i<$tableRows->length;$i++){ 

			$tableRow=$tableRows->item($i); //TableRow est DOMNode

			if (($tableRow->attributes->item(0)->value == 'ad_details') || ($tableRow->attributes->item(0)->value == 'ad_details_400')) {
				$donneeBrute = $tableRow->nodeValue  ; //exemple : Année-modèle: 2005
				
				switch (substr(trim($donneeBrute),0,2)){
					case 'Pr':
						$this->prix = preg_replace('/\D/','',$donneeBrute); // on ne garde que les chiffres.				
						break;
					
					case 'Co': //pour Code Postal
					case 'Vi' : //Pour ville
						$this->cp = preg_replace('/\D/','',$donneeBrute); // on ne garde que les chiffres.
						break;
					
					case 'Cy':
						$this->cylindre =preg_replace('/\D/','',preg_replace('/cm3/','',$donneeBrute));//on supprime le cm3, ensuite on ne garde que les chiffres 
						break;	
					
					case 'Ki':
						$this->km = preg_replace('/\D/','',$donneeBrute); // on ne garde que les chiffres.
						break;
						
					case 'An':
						$this->annee = preg_replace('/\D/','',$donneeBrute); // on ne garde que les chiffres.
						break;
					
				}
			}
		}
		$_parsing = microtime(true);
		$titleNodeList = $dom->getElementsByTagName('title');
		
		
		$titleNode = $titleNodeList->item(0);
		$title = $titleNode->nodeValue;
		$_getElems2 = microtime(true);
		$title = mysql_real_escape_string($title);
		$title = str_ireplace('- leboncoin.fr ','',$title);
		$title = str_ireplace(' Motos ',' - ',$title);
		$this->model=$title;
		$_end = microtime(true);
		
		$sql = 'INSERT INTO times (url,domLoad,getElem,parsing,getElem2) VALUES (\''. $this->detailURL . '\' ,' . (string)($_domLoad - $_debut) . ',' . (string)($_getElems - $_domLoad) . ',' . (string)($_parsing - $_getElems) . ',' . (string)($_getElems2 - $_parsing) .');';
		$ignored = mysql_query($sql);
		
		
		 //debug : la table avant
		 // echo '<table>';
		 // foreach ($parsedRaw as $k=>$v) {echo '<tr><td>'. $k . '</td> <td>' . $v .'</td></tr>';}
		 // echo '</table>';
		
		//return $parsedRaw; //ne sert a rien, on as deja mis a jour les donnée de l'objet 
	}
		
	//mise en forme des données parsée par une fontion spécifique a un site.
	//input : $parsedRaw : tableau brut des données parsée.
	//output: parsed : tableau mis en forme ne contenant que les données utiles.
	private function miseEnForme($parsedRaw) {
		$tmp = array();
		foreach ($parsedRaw as $key => $val) {
			switch (trim($this->sansPonctuation($key))) {
				case 'Prix':
				case 'prix':
					$this->prix = preg_replace('/\D/','',$val); // on ne garde que les chiffres.
					break;
				case 'Date de mise à jour':
					$this->dateAnnonce = preg_replace('/(\d+)\/(\d+)\/(\d+).*/','\3-\2-\1',$val);
					break;
				case 'Type':
					$this->type = trim($val);
					break;
				case 'Marque':
					$this->marque = $val;
					break;
				case 'Modèle':
					$this->model = $val;
					break;
				case 'Cylindrée':
					$this->cylindre = preg_replace('/(\d+).*/','\1',$val); //ne pas prendre le '3' de cm3 !
					break;
				case 'Mise en circulation':
					$this->annee = preg_replace('/(\d+)\/(\d+)\/(\d+).*/','\3-\2-\1',$val);
					break;
				case 'Kilométrage':
					$this->km = preg_replace('/\D/','',$val);
					break;
				case 'Garantie':
					//$this->garantie = $val; //ignorée pour l'instant.
					break;
				case 'vendeur':
					$this->origine = $val;				
					break;
				case 'Adresse':
					//$this->adresse = $val; //ignorée pour l'instant.
					break;
				case 'Code Postal':
					$this->cp = $val;
					break;
				case 'Ville':
					$this->ville = $val;
					break;
				case 'Téléphone':
					//$this->tel = $val; //ignorée pour l'instant.
					break;
				default :
					if ((is_int(stripos($key,'date de mise'))) && (is_int(stripos($key,'jour')))) { //parce que parfois, le "à" est vraiment bizzare. probleme de detection de charset sur la page par DOM iirc
						$this->dateAnnonce = $val;
					} else {
						//echo '<div style="color:#FF9933;"> non parsée: '  . $key . ' -- <b>' . $val .'</b></div>';
					}
					break;
			}
		}
		return $tmp;
	}

	public function storeToDB() {
	    $sql = "insert into `annonce` ( `type` , `marque` , `model` , `cylindre` , `imageURL` , `origine` , `prix` , `km` , `annee` , `cp` , `dateAnnonce` ,`detailsURL` ) ";
	    $sql = $sql."VALUES ('$this->type', '$this->marque','$this->model','$this->cylindre','$this->imageURL', '$this->origine', '$this->prix', '$this->km', '$this->annee', '$this->cp', '$this->dateAnnonce', '$this->detailURL');";
	    $rs = mysql_query($sql);
	    if (!$rs) {echo "ERREURE impossible d'inserer la ligne dans la table sql";}
	}
	
	public function getType() { return $this->type; }
	
	public function getMarque() { return $this->marque; }
	
	public function getModel() { return $this->model; }
	
	public function getCylindre() { return $this->cylindre; }
	
	public function getImageURL() { return $this->imageURL; }
	
	public function getOrigine() { return $this->origine; }
	
	public function getPrix() { return $this->prix; }
	
	public function getKm() { return $this->km; }
	
	public function getAnnee() { return $this->annee; }
	
	public function getCp() { return $this->cp; }
	
	public function getDateAnnonce() { return $this->dateAnnonce; }
	
	public function getDetailURL() { return $this->detailURL; }
    	
	public function setType($input) { $this->type = $input;}
	
	public function setMarque($input) { $this->marque = $input;}
	
	public function setModel($input) { $this->model = $input;}
	
	public function setCylindre($input) { $this->cylindre = $input;}
	
	public function setImageURL($input) { $this->imageURL = $input;}
	
	public function setOrigine($input) { $this->origine = $input;}
	
	public function setPrix($input) { $this->prix = $input;}
	
	public function setKm($input) { $this->km = $input;}
	
	public function setAnnee($input) { $this->annee = $input;}
	
	public function setCp($input) { $this->cp =$input;}
	
	public function setDateAnnonce($input) { $this->dateAnnonce = $input;}
	
	public function setDetailURL($input) { $this->detailURL = $input;}
	
	
}	
	
?>
