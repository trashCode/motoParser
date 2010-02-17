<?php
// **************************************
//       PARAMETRES de CONNEXION 
//         a la BASE de DONNEES
// **************************************

$host = '192.168.1.118:3306'; 
$user = 'root'; 
$pass = 'butterfly'; 
$dbase = 'moto';

// Connexion au serveur
$connexion_db = mysql_connect($host,$user,$pass) or die ('Erreur de parametres de connexion a la BD');
mysql_select_db($dbase,$connexion_db)or die ('Erreur de connexion a la BD');

?>