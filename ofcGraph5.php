<?php

include 'ofc/php-ofc-library/open-flash-chart.php';
include 'ofc/php-ofc-library/ofc_sugar.php';
include 'moto85db.php';

function make_star($x, $y,$titre,$annee)
{
    $tmp = new solid_dot();
    $tmp->position($x, $y);
	//$tmp->sides(4);
	$tmp->size(4);
	$xx=$x*1000;
	$yy=$y*1000;
	$tmp->tooltip("$titre<br>$xx km<br>$yy euros<br>annee $annee");
	return $tmp;
}

$chart = new open_flash_chart();

$title = new title( date("D M d Y") );
$chart->set_title( $title );
	$sql='select titre,km,prix,annee from moto85';
	$rs = mysql_query($sql);

	while ($row = mysql_fetch_assoc($rs)) {
	
	switch ($row['annee']) {
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
	default:
		$couleur='#000000';
		break;
	}
	 $scatter = new scatter( '#000000', 4 );
	 $scatter->set_default_dot_style( new s_star($couleur, 4) );
	$scatter->set_values(
		array(
			make_star( $row['km']/1000, $row['prix']/1000, $row['titre'], $row['annee'])
			)
		);
	$chart->add_element( $scatter );
	}


$x = new x_axis();
$x->set_range( 0, 50 );
$chart->set_x_axis( $x );

$y = new x_axis();
$y->set_range( 0, 10 );
$chart->add_y_axis( $y );


echo $chart->toPrettyString();
?>