<?php
	
	
	
	function randHexColor(){
	
		$h = rand(0,2)/3;
		echo $h . " ";
		$RGB = HSV_TO_RGB($h,1,0.5);
		// echo $RGB['R'] . '  -  ' . $RGB['G']  . '  -  ' . $RGB['B'] . '<br/>' ;
		//return '#' . dechex($RGB['R']).dechex($RGB['G']).dechex($RGB['B']); // ne marche pas ! car dechex(0) = 0, et non 00 ! 
		//return '#' . dechex($RGB['R']*256*256+$RGB['G']*256+$rgb[B]); //toujours pas ! si $RGB['R'] = 0, on as le meme probleme.
		return '#' . substr(dechex(pow(256,3)+$RGB['R']*256*256+$RGB['G']*256+$RGB['B']),1); //roh, je suis un truant !
		
	}
	
	function getXColors($x){
		$colors = array();
		for($H=0;$H<x;$H++){
			$h = $H/$x;
			echo $h;
			$RGB = HSV_TO_RGB($h,0.7,1);
			$colors[] = '#' . substr(dechex(pow(256,3)+(int)$RGB['R']*256*256+(int)$RGB['G']*256+(int)$RGB['B']),1); 
		}
		return $colors;
	}
	
	function randHexColor2(){
		
		return '#' . (dechex(rand(50,240)).dechex(rand(50,240)).dechex(rand(50,241)));
		
		
	}
	
	function RGB_TO_HSV ($R, $G, $B){
	// RGB Values:Number 0-255
	// HSV Results:Number 0-1
	
		$HSL = array();

		$var_R = ($R / 255);
		$var_G = ($G / 255);
		$var_B = ($B / 255);

		$var_Min = min($var_R, $var_G, $var_B);
		$var_Max = max($var_R, $var_G, $var_B);
		$del_Max = $var_Max - $var_Min;

		$V = $var_Max;

		if ($del_Max == 0){
			
			$H = 0;
			$S = 0;
			
		}else{
			$S = $del_Max / $var_Max;

			$del_R = ( ( ( $max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
			$del_G = ( ( ( $max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
			$del_B = ( ( ( $max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

			if ($var_R == $var_Max) $H = $del_B - $del_G;
			else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
			else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;

			if (H<0) $H++;
			if (H>1) $H--;
		}

		$HSL['H'] = $H;
		$HSL['S'] = $S;
		$HSL['V'] = $V;

		return $HSL;
	}

	function HSV_TO_RGB ($H, $S, $V){
		// HSV Values:Number 0-1
		// RGB Results:Number 0-255
		$RGB = array();

		if($S == 0)
		{
			$R = $G = $B = $V * 255;
		}
		else
		{
			$var_H = $H * 6;
			$var_i = floor( $var_H );
			$var_1 = $V * ( 1 - $S );
			$var_2 = $V * ( 1 - $S * ( $var_H - $var_i ) );
			$var_3 = $V * ( 1 - $S * (1 - ( $var_H - $var_i ) ) );

			if ($var_i == 0) { $var_R = $V ; $var_G = $var_3 ; $var_B = $var_1 ; }
			else if ($var_i == 1) { $var_R = $var_2 ; $var_G = $V ; $var_B = $var_1 ; }
			else if ($var_i == 2) { $var_R = $var_1 ; $var_G = $V ; $var_B = $var_3 ; }
			else if ($var_i == 3) { $var_R = $var_1 ; $var_G = $var_2 ; $var_B = $V ; }
			else if ($var_i == 4) { $var_R = $var_3 ; $var_G = $var_1 ; $var_B = $V ; }
			else { $var_R = $V ; $var_G = $var_1 ; $var_B = $var_2 ; }

			$R = $var_R * 255;
			$G = $var_G * 255;
			$B = $var_B * 255;
		}

		$RGB['R'] = $R;
		$RGB['G'] = $G;
		$RGB['B'] = $B;

		return $RGB;
	}
	
	function smartFloor($i, $rupture = 0.77) {
		if (log10($i) - (int)log10($i) < $rupture) {
			return ceil($i/pow(10,floor(log10($i)))) * pow(10,floor(log10($i)));
		} else {
			return ceil($i/pow(10,ceil(log10($i)))) * pow(10,ceil(log10($i)));
		}
	}
	
	// for ($i=0;$i<100;$i++) {
		// $colors[] = randHexColor();
		// $ucolors = array_unique ($colors);
	// }
	
	// print_r($ucolors);
		// unset($colors);
		// for ($i=0;$i<100;$i++) {
		// $colors[] = rand(0,2)/3;
		// $ucolors = array_unique ($colors);
	// }
	
	// print_r($ucolors);
	
	
	
	
	
	function tsv2rgb($T,$S,$V){
		$r = (double)0;
		$g = (double)0;
		$b =(double)0;
		$t = (double)$T;
		$s = (double)$S;
		$v = (double)$V;
	
		$h = floor($t/60)%6;
		
		$f = $t/60 - $h;
		$l=$v*(1-$s);
		$m=$v*(1-$f*$s);
		$n=$v*(1-(1-$f)*$s);
		
		switch ($h){
			case 0: 
				$r=$v;
				$g=$n;
				$b=$l;
				break;
				
			case 1: 
				$r=$m;
				$g=$v;
				$b=$l;
				break;
				
			case 2: 
				$r=$l;
				$g=$v;
				$b=$n;
				break;
				
			case 3: 
				$r=$l;
				$g=$m;
				$b=$v;
				break;
				
			case 4: 
				$r=$n;
				$g=$L;
				$b=$v;
				break;
				
			case 5: 
				$r=$v;
				$g=$l;
				$b=$m;
				break;
				
		}
		$RGB['r'] = (int)($r*255);
		$RGB['g'] = (int)($g*255);
		$RGB['b'] = (int)($b*255);
		return $RGB;
	}
	
	
	for ($i=0;$i<100;$i++){
		$values[] = HSV_TO_RGB(rand(0,2)/3 , 1 , 0.49);
		$values2[] = tsv2rgb(rand(0,2)/3*360 , 1 , 0.49);
	}
	
	echo print_r(array_unique($values));
	echo '<br/>';
	echo print_r(array_unique($values2));
	
	
	print_r(getXColors(3));
	
	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 /**
  * Libraire de "manipulation" des couleurs (RGB, Hexa)
  * @author M.Yvan.k <dighan@gmail.com>
  * @version 1.0b
  */
 
 
  /**
  * const MSB (Most Significant Bits) = 0xF0
  * masque de capture des bits de poids forts
  * @var integer(hexbase)
  */
  define('MSB', 0xF0);
 
  /**
  * const LSB (Least Significant Bits) = 0x0F
  * masque de capture des bits de poids faibles
  * @var integer(hexbase)
  */
  define('LSB', 0x0F);
 
  /**
  * const MAX = 255
  * valeur max. dans l'espace chromatique RGB
  * @var integer
  */
  define('MAX', 255);
 
  /**
  * const MIN = 0
  * valeur min. dans l'espace chromatique RGB
  * @var integer
  */
  define('MIN', 0);
 
  /**
  * function isHexFormat()
  * verification du format hexadecimal
  * @param string $sColor : couleur a verifier - ATTENTION doit impérativement commencer par le caractère '#'
  * @return bool : TRUE en cas de succes, FALSE sinon
  */
  function isHexFormat($sColor) {
  # Indications
  # #^\#[0-9a-f]{6}$ : commence par le caractere # suivi d'une sequence de 6 caracteres compris entre 0 et F (qui marquent la fin de la chaine)
  # #i : ne fait pas attention a la case
  return (bool) preg_match('#^\#[0-9a-f]{6}$#i', $sColor);
  }
 
  /**
  * function isRgbFormat()
  * verification du format RGB
  * @param string $sColor : couleur a verifier
  * @return bool : TRUE en cas de succes, FALSE sinon
  */
  function isRgbFormat($sColor) {
  $bRet = FALSE;
  # Indications
  # ^\d{1,3} *, : commence par un entier dont la taille varie de 1 a 3 caracteres suivi/ou pas d'espaces, le tout suivi d'une virgule
  # la sequence ci-dessus etant repetee 3 fois comme l'impose l'espace RGB
  if ( (bool) preg_match('#^(\d{1,3}) *, *(\d{1,3}) *, *(\d{1,3})$#', $sColor, $aMatches) )
  if ($aMatches[1] >= MIN && $aMatches[1] <= MAX)
  if ($aMatches[2] >= MIN && $aMatches[2] <= MAX)
  if ($aMatches[3] >= MIN && $aMatches[3] <= MAX) $bRet = TRUE;
  return $bRet;
  }
 
  /**
  * function HexToRgb()
  * conversion hexadecimal -> decimal(RGB)
  * @param string $sColor : couleur a convertir - ATTENTION doit impérativement commencer par le caractère '#'
  * @return mixed : une chaine du type 'RED,GREEN,BLUE' (decimal) en cas de succes, FALSE sinon
  */
  function HexToRgb($sColor) {
  if ( $mRet = IsHexFormat($sColor) ) {
  $sDecR = hexdec( substr($sColor, 1, 2) );
  $sDecG = hexdec( substr($sColor, 3, 2) );
  $sDecB = hexdec( substr($sColor, 5, 2) );
  $mRet = (string) $sDecR . ',' . $sDecG . ','. $sDecB;
  }
  return $mRet;
  }
 
  /**
  * function RgbToHex()
  * conversion decimal(RGB) -> hexadecimal
  * @param string $sColor : couleur a convertir
  * @param bool $bLower : TRUE pour un retour en minuscules, FALSE sinon
  * @return mixed : une chaine du type 'RED,GREEN,BLUE' (hexadecimal sur 6 digits) en cas de succes, FALSE sinon
  */
  function RgbToHex($sColor, $bLower = FALSE) {
  if ( $mRet = IsRgbFormat($sColor) ) {
  $sHexChar = '0123456789ABCDEF';
  $aComponents = explode(',', str_replace(' ', '', $sColor) );
  $sHexR = $sHexChar[ ($aComponents[0] & MSB) >> 4 ] . $sHexChar[ ($aComponents[0] & LSB) ];
  $sHexG = $sHexChar[ ($aComponents[1] & MSB) >> 4 ] . $sHexChar[ ($aComponents[1] & LSB) ];
  $sHexB = $sHexChar[ ($aComponents[2] & MSB) >> 4 ] . $sHexChar[ ($aComponents[2] & LSB) ];
  $sHexStr = $sHexR . $sHexG . $sHexB;
  $mRet = (string) (!$bLower) ? $sHexStr : strtolower($sHexStr);
  }
  return $mRet;
  }
 
  /**
  * function getColorComponents()
  * decomposition d'une couleur
  * @param string $sColor : couleur a decomposer (RGB ou Hexa)
  * @return mixed : un tableau du type ARRAY('red'=>'', 'green'=>'', 'blue'=>'') en cas de succes, FALSE sinon
  */
  function getColorComponents($sColor) {
  $mRet = FALSE;
  if ( IsHexFormat($sColor) ) {
  $mRet = (array) array('red'=>substr($sColor,1 ,2), 'green'=>substr($sColor,3 ,2), 'blue'=>substr($sColor,5 ,2));
  } else if ( IsRgbFormat($sColor) ) {
  $aComponents = explode(',', str_replace(' ', '', $sColor));
  $mRet = (array) array('red'=>$aComponents[0], 'green'=>$aComponents[1], 'blue'=>$aComponents[2]);
  }
  return $mRet;
  }
 
  # EXEMPLE
 
  // $color = '#c0c0c0';
 
  // # Verification du format
  // if ( isRgbFormat($color) ) echo $color . ' couleur RGB';
  // else if ( isHexFormat($color) ) echo $color . ' couleur HEXA';
  // else echo 'format inconnu : ' . $color;
 
  // echo '<hr />';
 
  // # Conversion RGB => Hexa , Hexa => RGB
  // if ( FALSE !== ($sRes = RgbToHex($color)) ) echo $color . ' conversion RGB => HEXA #' . $sRes;
  // else if ( FALSE !== ($sRes = HexToRgb($color)) ) echo $color . ' conversion HEXA=>RGB ' . $sRes;
  // else echo 'format inconnu : ' . $color;
 
  // echo '<hr />';
 
  // # Decomposition d'une couleur
  // if ( FALSE !== ($aRes = getColorComponents($color)) ) echo '<pre>' , print_r($aRes) , '</pre>';
  // else echo 'format inconnu : ' . $color; 
	
?>