<?php
	
		include "./graphUtils.php";
	

	echo '<table>';
	
	// echo '<tr>';
	// $colors = (getXColorsInAngle(10,0.7,1,2,3));
	// foreach ($colors as $color) {
		// echo '<td style="color:' . $color . ';background-color:' . $color . ';">a</td>';
	// }
	// echo '</tr>';
	
	// echo '<tr><td> here </td></tr>';
	// echo '<tr>';
	
		// $colors = (getXColorsInAngle(10,0.7,1,0.75,0.25));
		// foreach ($colors as $color) {
		// echo '<td style="color:' . $color . ';background-color:' . $color . ';">a</td>' . "\n";
	// }
	// echo '</tr>';
	
	
	
	
	
	
	echo '<tr>';
	$offset=(float)$_GET['offset'];
		$colors = (getXColorsInAngle(5,0.7,1,0+$offset,1/3+$offset));
		foreach ($colors as $color) {
		echo '<td style="color:' . $color . ';background-color:' . $color . ';">a</td>' . "\n";
	}
echo '<tr></tr>';
		$colors = (getXColorsInAngle(5,0.7,1,1/3+$offset,2/3+$offset));
		foreach ($colors as $color) {
		echo '<td style="color:' . $color . ';background-color:' . $color . ';">b</td>'. "\n";
	}
echo '<tr></tr>';
	
		$colors = (getXColorsInAngle(5,0.7,1,2/3+$offset,1+$offset));
		foreach ($colors as $color) {
		echo '<td style="color:' . $color . ';background-color:' . $color . ';">c</td>'. "\n";
	}
	
	
	echo '</tr><tr>';
	$colors = (getXAlternateColors3(5,0.7,1,$offset));
	foreach ($colors as $color) {
		echo '<td style="color:' . $color . ';background-color:' . $color . ';">a</td>'. "\n";
	}
	echo '</tr>';
	
	
	echo '<table>';
	
	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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