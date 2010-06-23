<?php
	
	function randHexColor(){
	
		$h = rand(0,2)/3;
		echo $h . " ";
		$RGB = HSV_TO_RGB($h,1,0.5);
		// echo $RGB['R'] . '  -  ' . $RGB['G']  . '  -  ' . $RGB['B'] . '<br/>' ;
		//return '#' . dechex($RGB['R']).dechex($RGB['G']).dechex($RGB['B']); // ne marche pas ! car dechex(0) = 0, et non 00 ! 
		//return '#' . dechex($RGB['R']*256*256+$RGB['G']*256+$rgb[B]); //toujours pas ! si $RGB['R'] = 0, on as le meme probleme.
		return '#' . substr(dechex(pow(256,3)+$RGB['R']*256*256+$RGB['G']*256+$RGB['B']),1); //roh, je suis un truant !
		
	}
	
	function getXColors($x,$s=1,$v=1){
		$colors = array();
		for($H=0; $H < $x; $H++){
			$h = $H/$x;
			$RGB = HSV_TO_RGB($h,$s,$v);
			$colors[] = '#' . substr(dechex(pow(256,3)+(int)$RGB['R']*256*256+(int)$RGB['G']*256+(int)$RGB['B']),1); 
		}
		return $colors;
	}
	
	function getXColorsInAngle($x,$s=1,$v=1,$hmin=0,$hmax=1){
		//$hmin et hmax sont compris entre 0 et 1.
		
		$hmin = $hmin - (int)$hmin;
		$hmax = $hmax - (int)$hmax;
	
		if ($hmax==0) $hmax=1;
		
		$colors = array();
		if ($hmax-$hmin < 0) {$angle = 1+$hmax-$hmin; }
		else {$angle=(float)$hmax-(float)$hmin;}
		
		$pas=$angle/$x;
		
		for($H=0; $H <= $x; $H++){
			$h = $hmin + $H * $pas;
			
			$RGB = HSV_TO_RGB($h,$s,$v);
			$colors[] = '#' . substr(dechex(pow(256,3)+(int)$RGB['R']*256*256+(int)$RGB['G']*256+(int)$RGB['B']),1); 
		}
		return $colors;
	}
	
	function getXAlternateColors($x,$s=1,$v=1){
		$colors1 = (getXColorsInAngle($x,$s,$v,0,0.5));
		$colors2 = (getXColorsInAngle($x,$s,$v,0.5,1));
		$colors=array();
		for (;$x>0;$x--){
			if ($x%2 == 0 ) {
				$colors[]=$colors1[$x];
			}else{
				$colors[]=$colors2[$x];
			}
		}
		
		return $colors;
	}
	
		function getXAlternateColors3($x,$s=1,$v=1,$offset=0){
			$colors1 = (getXColorsInAngle($x,$s,$v,0+$offset,1/3+$offset));
			$colors2 = (getXColorsInAngle($x,$s,$v,1/3+$offset,2/3+$offset));
			$colors3 = (getXColorsInAngle($x,$s,$v,2/3+$offset,1+$offset));
			$colors=array();
			
			for (;$x>0;$x--){
					switch ($x%3) {
					case 0:
						$colors[]=$colors1[$x];
						break;
					case 1:
						$colors[]=$colors2[$x];
						break;
					case 2:
						$colors[]=$colors3[$x];
						break;
			}
			
		}
		
		return $colors;
	}
	
	
	function randHexColor2(){
		return '#' . (dechex(rand(50,240)).dechex(rand(50,240)).dechex(rand(50,241)));
	}
	
	function RGB_TO_HSV ($R, $G, $B){
	// RGB Values:Number 0-255
	// HSV Results:Number 0-1
	
		$HSL = array();

		$var_R = ($R / 255);
		$var_G = ($G / 255);
		$var_B = ($B / 255);

		$var_Min = min($var_R, $var_G, $var_B);
		$var_Max = max($var_R, $var_G, $var_B);
		$del_Max = $var_Max - $var_Min;

		$V = $var_Max;

		if ($del_Max == 0){
			
			$H = 0;
			$S = 0;
			
		}else{
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
		
		$H = $H - (int)$H;
		

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
	
	function tsv2rgb($T,$S,$V){
		$r = (double)0;
		$g = (double)0;
		$b =(double)0;
		$t = (double)$T;
		$s = (double)$S;
		$v = (double)$V;
	
		$h = floor($t/60)%6;
		
		$f = $t/60 - $h;
		$l=$v*(1-$s);
		$m=$v*(1-$f*$s);
		$n=$v*(1-(1-$f)*$s);
		
		switch ($h){
			case 0: 
				$r=$v;
				$g=$n;
				$b=$l;
				break;
				
			case 1: 
				$r=$m;
				$g=$v;
				$b=$l;
				break;
				
			case 2: 
				$r=$l;
				$g=$v;
				$b=$n;
				break;
				
			case 3: 
				$r=$l;
				$g=$m;
				$b=$v;
				break;
				
			case 4: 
				$r=$n;
				$g=$L;
				$b=$v;
				break;
				
			case 5: 
				$r=$v;
				$g=$l;
				$b=$m;
				break;
				
		}
		$RGB['r'] = (int)($r*255);
		$RGB['g'] = (int)($g*255);
		$RGB['b'] = (int)($b*255);
		return $RGB;
	}
	
	
	
	
?>