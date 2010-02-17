<?php

include 'ofc/php-ofc-library/open-flash-chart.php';
include 'ofc/php-ofc-library/ofc_sugar.php';
include 'db.php';
//error_reporting(0);
function make_star($x, $y,$titre,$annee)
{
    $tmp = new solid_dot();
	$tmp->position($x, $y);
	
	$tmp->size(4);
	$tmp->tooltip("$titre<br>$x km<br>$y euros<br>annee $annee");
	return $tmp;
}

function getCouleur($annee) {
	switch ($annee) {
		case 2000:
			$couleur='#FF0000';
			break;
		case 2001:
			$couleur='#FF3300';
			break;
		case 2002:
			$couleur='#FF6600';
			break;
		case 2003:
			$couleur='#FF9900';
			break;
		case 2004:
			$couleur='#FFCC00';
			break;
		case 2005:
			$couleur='#FFFF00';
			break;
		case 2006:
			$couleur='#CCFF00';
			break;
		case 2007:
			$couleur='#99FF00';
			break;
		case 2008:
			$couleur='#66FF00';
			break;
		case 2009:
			$couleur='#33FF00';
			break;
		case 2010:
			$couleur='#00FF00';
			break;
		case 1999:
			$couleur='#A0A0A0';
			break;
		case 1998:
			$couleur='#808080';
			break;
		case 1997:
			$couleur='#404040';
			break;
		default:
			$couleur='#000000';
			break;
		}
		return $couleur;
}
$maxX=0;
$maxY=0;
$chart = new open_flash_chart();
$chart->set_bg_colour( '#444444' );

$title = new title( date("D M d Y") );
$chart->set_title( $title );
	$sql='select model,km,prix,annee from annonce';
	$rs = mysql_query($sql);

	while ($row = mysql_fetch_assoc($rs)) {
		
		if ($row['km']>$maxX) {$maxX=$row['km'];}
		if ($row['prix']>$maxY) {$maxY=$row['prix'];}
		
		$couleur=getCouleur($row['annee']);
		
		$scatter = new scatter( '#000000', 4 );
		$scatter->set_default_dot_style( new s_star($couleur, 4) );
		$scatter->set_values(
			array(
				make_star( $row['km'], $row['prix'], $row['model'], $row['annee'])
				)
		);
	$chart->add_element( $scatter );
	}

if ($maxX == 0) {$maxX = 10;}
if ($maxY == 0) {$maxY = 10;}

$x = new x_axis();
$x->set_range( 0, $maxX );
$x->set_steps( 5000 );
$x->tick_height(5);
//$x->colour('#FF0000');
$chart->set_x_axis( $x );

$y = new y_axis();
$y->set_range( 0, $maxY );
$y->set_steps(1000);
$chart->add_y_axis( $y );


echo $chart->toPrettyString();
?>