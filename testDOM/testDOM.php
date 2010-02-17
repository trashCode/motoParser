<?php
	$dom = new DomDocument('1.0','utf-8');
	// $dom->encoding = 'utf-8';
	$dom->load('http://maiev/moto/testDOM/test.html');
	$dom->preserveWhiteSpace = 'fasle';
	
	$elems = $dom->getElementsByTagName('div');
	$prems=$elems->item(0);
	echo $prems->nodeValue;
	
	$dom->saveHTMLFile('/var/www/moto/testDOM/domOutput.html');
?>
