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
//$s2->set_default_dot_style( new s_box('#63C3FF', 4) );
$s2->set_default_dot_style( new s_box('#63C3FF', 4) );

//=== $v est un tableau de scatter.==
$v = array();
for ($i=0;$i<100;$i++){
	$v[]=new scatter_value(rand(0,10000),rand(0,10000));
}
/*for( $i=0; $i<360; $i+=5 )
{
    $v[] = new scatter_value(
        number_format(sin(deg2rad($i)) *.9, 2, '.', ''),
        number_format(cos(deg2rad($i)) *.9, 2, '.', '') );    
}*/
$s2->set_values( $v );
$chart->add_element( $s2 );

$x = new x_axis();
$x->set_range( 0, 10000 );
$chart->set_x_axis( $x );

$y = new x_axis();
$y->set_range( 0, 10000 );
$chart->add_y_axis( $y );


echo $chart->toPrettyString();

?>