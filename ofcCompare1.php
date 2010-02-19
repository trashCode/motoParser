<?php
	
	include 'ofc/php-ofc-library/open-flash-chart.php';
	include 'ofc/php-ofc-library/ofc_sugar.php';
	include 'db.php';
	
	function randHexColor(){
		
		$RGB = HSV_TO_RGB(rand(0,360)/360,1,0.4);
		// echo $RGB['R'] . '  -  ' . $RGB['G']  . '  -  ' . $RGB['B'] . '<br/>' ;
		//return '#' . dechex($RGB['R']).dechex($RGB['G']).dechex($RGB['B']); // ne marche pas ! car dechex(0) = 0, et non 00 ! 
		//return '#' . dechex($RGB['R']*256*256+$RGB['G']*256+$rgb[B]); //toujours pas ! si $RGB['R'] = 0, on as le meme probleme.
		return '#' . substr(dechex(pow(256,3)+$RGB['R']*256*256+$RGB['G']*256+$rgb[B]),1); //roh, je suis un truant !
		
	}
	
	function randHexColor2(){
		
		return '#' . (dechex(rand(50,240)).dechex(rand(50,240)).dechex(rand(50,241)));
		
		
	}
	
	function RGB_TO_HSV ($R, $G, $B) // RGB Values:Number 0-255
	{ // HSV Results:Number 0-1
		$HSL = array();

		$var_R = ($R / 255);
		$var_G = ($G / 255);
		$var_B = ($B / 255);

		$var_Min = min($var_R, $var_G, $var_B);
		$var_Max = max($var_R, $var_G, $var_B);
		$del_Max = $var_Max - $var_Min;

		$V = $var_Max;

		if ($del_Max == 0)
		{
			$H = 0;
			$S = 0;
		}
		else
		{
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
		// echo randHexColor() . '<br/>';
	// }
	
	//initialisation du graphique.
	$chart = new open_flash_chart();
	$chart->set_title( $title );
	
	
	
	
	
	//recuparation de toutes les annees contenant des annonces;
	$sql = 'SELECT distinct annee FROM annonce ORDER BY annee;';
	$rs= mysql_query($sql);
	$annees = array();
	while ($row = mysql_fetch_assoc($rs)) {
		$annees[] = $row['annee'];
	}
	
	//recuparation de tous les models 
	$sql = 'SELECT distinct type FROM annonce order by type;';
	$rs= mysql_query($sql);
	$models = array();
	while ($row = mysql_fetch_assoc($rs)) {
		$models[] = $row['type'];
	}
	
	//compteur pour mise a l echelle du graph
	$maxNb=0;
	$maxPrix=0;
	$maxKm=0;

	
	//recuperation des données
	foreach ($models as $model){

		//init	
		$nbs = array();
		$prixs=array();
		$kms=array();
		
		foreach ($annees as $annee) {
			
			$sql = 'SELECT count(*),avg(prix),avg(km) FROM annonce WHERE annee =' . $annee . ' and type=\'' . $model . '\';';
			$rs = mysql_query($sql);
			$row= mysql_fetch_assoc($rs);
			
			$nbs[] = (int)$row['count(*)'];
			if ( (int)$row['count(*)'] >= $maxNb ) { $maxNb = (int)$row['count(*)'];}
			
			$prixs[] = (double)$row['avg(prix)'];
			if ( (double)$row['avg(prix)'] >= $maxPrix ) { $maxPrix = (int)$row['avg(prix)'];}
			
			$kms[] = (double)$row['avg(km)'];
			if ( (double)$row['avg(km)'] >= $maxKm ) { $maxKm = (int)$row['avg(km)'];}
			

		}
		
		$bar = new bar();
		if (($_GET["couleur"]) == 'black') {$bar->colour('#000000');}
		else {
			$bar->colour( randHexColor());
			}
		$bar->key($model, 12);
		$bar->set_values($nbs );
		
		$chart->add_element( $bar ); //ajout de la serie au graph
		
	}
	
	
	
	
/* 	$sql = 'SELECT distinct type as \'type\' FROM annonce;';
	$rs = mysql_query($sql);
	
	while ($row = mysql_fetch_assoc($rs)) {
		
		$sql_model = 'SELECT type,count(*) as nb,annee,avg(prix) as \'prix moyen\',avg(km) as \'km moyen\' FROM annonce WHERE type=\'' . $row['type'] . '\' GROUP BY annee ;';
		$rs_model = mysql_query($sql_model);
		
		echo '<table><caption> 1 requete</caption>';
		
		while ($row_model = mysql_fetch_assoc($rs_model)) {
			echo '<tr>';
			echo '<td>' . $row_model['type'] . '</td>';
			echo '<td>' . $row_model['annee'] . '</td>';
			echo '<td>' . $row_model['nb'] . '</td>';
			echo '<td>' . $row_model['prix moyen'] . '</td>';
			echo '<td>' . $row_model['km moyen'] . '</td>';
			echo '</tr>';
		}
		
		echo '</table>';
	
	}  */
	
	
	$title = new title( date("D M d Y") );

	/* $data = array(9,8,7,6,5,4,3,2,1);
	$bar = new bar();
	$bar->colour( '#BF3B69');
	$bar->key('Last year', 12);
	$bar->set_values( $data );

	
	$data2 = array(10,9,8,7,6,5,4,3,2);
	$bar2 = new bar();
	$bar2->colour( '#5E0722' );
	$bar2->key('This year', 12);
	$bar2->set_values( $data2 );

	
	$chart->add_element( $bar );
	$chart->add_element( $bar2 ); */
	
	$x = new x_axis();
	$x->set_labels_from_array($annees);
	$chart->set_x_axis( $x );
	
	$y = new x_axis();
	//$maxKm=round($maxKm/pow(10,floor(log10($maxKm))),1)*pow(10,floor(log10($maxKm)));
	//$maxPrix=round($maxPrix/pow(10,floor(log10($maxPrix))),1)*pow(10,floor(log10($maxPrix)));
	$y->set_range( 0, smartFloor($maxNb) );
	$y->set_steps(10);
	$chart->set_y_axis( $y );
	
	echo $chart->toString();

?>


