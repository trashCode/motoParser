<?php
	$i =2324;
	echo preg_replace('/(\d+)\/(\d+)\/(\d+).*/','\3-\2-\1','31/12/2008')
	/* 	$dom = new DomDocument('1.0','utf-8');
	// $dom->encoding = 'utf-8';
	$dom->loadHTMLFile('http://maiev/moto/testDOM/test2.html');
	$dom->preserveWhiteSpace = 'fasle';
	
	$elems = $dom->getElementsByTagName('div');
	for($i=0;$i<$elems->length;$i++){
		$prems=$elems->item($i);
		echo $prems->nodeValue;
	}
	
	
	$dom->saveHTMLFile('/var/www/moto/testDOM/domOutput.html'); */
?>
