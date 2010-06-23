<?php
	
	include 'ofc/php-ofc-library/open-flash-chart.php';
	include 'ofc/php-ofc-library/ofc_sugar.php';
	include 'db.php';
	include 'graphUtils.php';
	
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
	$nbModels=0;
	$sql = 'SELECT distinct type FROM annonce order by type;';
	$rs= mysql_query($sql);
	$models = array();
	while ($row = mysql_fetch_assoc($rs)) {
		$models[] = $row['type'];
		$nbModels+=1;
	}
	
	//on genere une couleur par model;
	$colors = getXAlternateColors3($nbModels,0.66,1,0.07);
	
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
		$bar->set_alpha(0.8);
		$bar->colour( $colors[$nbModels-1]);
		$nbModels-=1;
		
		$bar->key($model, 12);
		
		if ($_GET['type'] == 'nb') {$bar->set_values($nbs );}
		else if ($_GET['type'] == 'prix') {$bar->set_values($prixs );}
		else if ($_GET['type'] == 'km') {$bar->set_values($kms );}
		
		$chart->add_element( $bar ); //ajout de la serie au graph
		
	}
	
	
	
	
	
	
	$x = new x_axis();
	$x->set_labels_from_array($annees);
	$chart->set_x_axis( $x );
	
	$y = new x_axis();
	//$maxKm=round($maxKm/pow(10,floor(log10($maxKm))),1)*pow(10,floor(log10($maxKm)));
	//$maxPrix=round($maxPrix/pow(10,floor(log10($maxPrix))),1)*pow(10,floor(log10($maxPrix)));
	
	
	if ($_GET['type'] == 'nb') {
		$y->set_range( 0, smartFloor($maxNb) );
		$chart->set_title(new title('nombre d annonces par model et par an'));
	}
	else if ($_GET['type'] == 'prix') {
		$y->set_range( 0, smartFloor($maxPrix) );
		$chart->set_title(new title('prix moyen par model et par an'));
	}
	else if ($_GET['type'] == 'km') {
		$y->set_range( 0, smartFloor($maxKm) );
		$chart->set_title(new title('kilometrage moyen par model et par an'));
	}
	
	$y->set_steps(10);
	$chart->set_y_axis( $y );
	$chart->set_bg_colour( '#666666' );
	
	echo $chart->toString();

?>


