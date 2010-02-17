<?php

include 'ofc/php-ofc-library/open-flash-chart.php';
// also include the sugar (helper funtions)
include 'ofc/php-ofc-library/ofc_sugar.php';


function make_star($x, $y)
{
    $tmp = new anchor();
    $tmp->position($x, $y);
	$tmp->sides(4);
	//$tmp->hollow(FALSE);
	$tmp->size(4);
	$tmp->tooltip('point<br>#x#<br>#y#');
	return $tmp;
}

$chart = new open_flash_chart();

$title = new title( date("D M d Y") );
$chart->set_title( $title );

for ($i=0;$i<50;$i++) {
	$scatter = new scatter( '#000000', 4 );
	$scatter->set_default_dot_style( new s_star('#'.dechex(rand(0,16777215)), 4) );
	$scatter->set_values(
		array(
			make_star( rand(0,100), rand(0,100) )
			)
		);

	$chart->add_element( $scatter );
}



$x = new x_axis();
$x->set_range( 0, 100 );
$chart->set_x_axis( $x );

$y = new x_axis();
$y->set_range( 0, 100 );
$chart->add_y_axis( $y );


echo $chart->toPrettyString();
?>