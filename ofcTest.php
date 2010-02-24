<?php
	
	include 'ofc/php-ofc-library/open-flash-chart.php';
	include 'ofc/php-ofc-library/ofc_sugar.php';
	function RGB_TO_HSV ($R, $G, $B) { 
	// HSV Results:Number 0-1
	// RGB Values:Number 0-255
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

	function HSV_TO_RGB ($H, $S, $V) { 
			// RGB Results:Number 0-255
			 // HSV Values:Number 0-1
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
	//initialisation du graphique.
	$chart = new open_flash_chart();
	$chart->set_title( $title );
	
		
		
		
		for( $i=1; $i<1000; $i+=1 ){
		
			$data_1[] = pow(10,(log10($i)));
			//$data_2[] = pow(10,round(log10($i)));
			$data_2[] = ceil($i/pow(10,floor(log10($i)))) * pow(10,floor(log10($i)));
			//$data_3[] = pow(10,ceil(log10($i)*10)/10);
			if (log10($i) - (int)log10($i) < 0.77) {
				$data_4[] = ceil($i/pow(10,floor(log10($i)))) * pow(10,floor(log10($i)));
			} else {
				$data_4[] = ceil($i/pow(10,ceil(log10($i)))) * pow(10,ceil(log10($i)));
			}
			
			if (log10($i) - (int)log10($i) > 0.5) {
				$data_5[] = 4;
			} else {
				$data_5[] = -20;
			}
			
			
			  
		}
			

		
	
	$line_1_default_dot = new dot();
	$line_1_default_dot->colour('#0000f0');

	$line_1 = new line();
	$line_1->set_default_dot_style($line_1_default_dot);
	$line_1->set_values( $data_1 );
	$line_1->set_width( 1 );
	
	$chart->add_element( $line_1 );
	
	$line_2_default_dot = new dot();
	$line_2_default_dot->colour('#00ff00');

	$line_2 = new line();
	$line_2->set_default_dot_style($line_2_default_dot);
	$line_2->set_values( $data_2 );
	$line_2->set_width( 1 );
	$line_2->set_colour( '#00f000' );
	
	$chart->add_element( $line_2 );
	
	
	$line_3_default_dot = new dot();
	$line_3_default_dot->colour('#f00000');

	$line_3 = new line();
	$line_3->set_default_dot_style($line_3_default_dot);
	$line_3->set_values( $data_3 );
	$line_3->set_width( 1 );
	$line_3->set_colour( '#f00000' );
	
	$chart->add_element( $line_3 );
	
	$line_4_default_dot = new dot();
	$line_4_default_dot->colour('#f00000');

	$line_4 = new line();
	$line_4->set_default_dot_style($line_4_default_dot);
	$line_4->set_values( $data_4 );
	$line_4->set_width( 1 );
	$line_4->set_colour( '#d000D0' );
	
	$chart->add_element( $line_4 );
	
	$line_5_default_dot = new dot();
	$line_5_default_dot->colour('#f00000');

	$line_5 = new line();
	$line_5->set_default_dot_style($line_5_default_dot);
	$line_5->set_values( $data_5 );
	$line_5->set_width( 1 );
	$line_5->set_colour( '#000000' );
	
	$chart->add_element( $line_5 );
	
	
	$title = new title( date("D M d Y") );

	
	$x = new x_axis();
	$x->set_range( 0,1000 );
	$x->set_steps(100);
	$chart->set_x_axis( $x );
	
	$y = new x_axis();
	//$maxKm=round($maxKm/pow(10,floor(log10($maxKm))),1)*pow(10,floor(log10($maxKm)));
	//$maxPrix=round($maxPrix/pow(10,floor(log10($maxPrix))),1)*pow(10,floor(log10($maxPrix)));
	$y->set_range( 0,1000 );
	$y->set_steps(100);
	$chart->set_y_axis( $y );
	
	echo $chart->toString();
	


?>


