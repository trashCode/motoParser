<?php
	require_once('./annonce.class.php');
	$test0=new annonce('sportive','peugeot','103 SP','49','http://images03.olx.fr/ui/1/40/98/1403298_1.jpg','particuliere','1000','50000','1965','69','2009:09:28','http://www.google.fr');
	$test1=new annonce('sportive','HONDA','CBR F IE','600','http://www.moto85.com/fichiers/Images/annonces/zoom/2564670_11252774393.jpg','pro','1800','84499','1987','85','2009-10-02','http://www.moto85.com/annonce/moto-occasion-honda-cbr-f-ie_2564670/');
	$test2=new annonce('scooter','SUZUKI','BURGMAN AN','400','http://www.moto85.com/fichiers/Images/annonces/zoom/2608193_11253707688.jpg','pro','3290','24000','2005','35','2009:10:02','http://www.moto85.com/annonce/moto-occasion-suzuki-burgman-an_2608193/');
	$test3=new annonce('roadster','KAWAZAKI','Z 750','750','http://www.moto85.com/fichiers/Images/annonces/zoom/2584451_11253200277.jpg','pro','5900','24500','2007','42','2009-10-02','http://www.moto85.com/annonce/moto-occasion-kawasaki-z-750-n_2584451/');
	$test0->storeToDB();
	$test1->storeToDB();
	$test2->storeToDB();
	$test3->storeToDB();
	echo 'ok';
?>