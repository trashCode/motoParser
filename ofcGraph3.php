<?php

include 'ofc/php-ofc-library/open-flash-chart.php';
// also include the sugar (helper funtions)
include 'ofc/php-ofc-library/ofc_sugar.php';



$chart = new open_flash_chart();

$title = new title( date("D M d Y") );
$chart->set_title( $title );




//
// plot a circle
//
$s2 = new scatter( '#D600FF', 3 );
$s2->set_default_dot_style( new s_box('#'.dechex(rand(0,16777215)), 4) );

//=== $v est un tableau de scatter.==
$v = array();
for ($i=0;$i<100;$i++){
	$tmp=new scatter_value(rand(0,100),rand(0,100));
	$v[]=$tmp;
}

$s2->set_values( $v );
$chart->add_element( $s2 );

$x = new x_axis();
$x->set_range( 0, 100 );
$chart->set_x_axis( $x );

$y = new x_axis();
$y->set_range( 0, 100 );
$chart->add_y_axis( $y );


echo $chart->toPrettyString();

?>