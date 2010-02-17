<?php

include 'ofc/php-ofc-library/open-flash-chart.php';
include 'ofc/php-ofc-library/ofc_sugar.php';
include 'db.php';

function make_star($x, $y,$titre,$annee)
{
    $tmp = new solid_dot();
	$tmp->position($x, $y);
	
	$tmp->size(4);
	$tmp->tooltip("$titre<br>$x km<br>$y euros<br>annee $annee");
	return $tmp;
}

$chart = new open_flash_chart();

$title = new title( date("D M d Y") );
$chart->set_title( $title );
	$sql='select model,km,prix,annee from annonce';
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
			make_star( $row['km'], $row['prix'], $row['model'], $row['annee'])
			)
		);
	$chart->add_element( $scatter );
	}

$x_labels = new x_axis_labels();
$x_labels->set_steps( 2500 );
$x_labels->set_vertical();
$x_labels->set_colour( '#A2ACBA' );

$x = new x_axis();
$x->set_range( 0, 100000 );
$x->set_steps( 10000 );
$x->set_labels( $x_labels );
$chart->set_x_axis( $x );

$y = new x_axis();
$y->set_range( 0, 10000 );
$y->set_steps(1000);
$chart->add_y_axis( $y );


echo $chart->toPrettyString();
?>