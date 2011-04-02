<?php
	$temps_debut = microtime(true);
	require_once "annonce.class.php";
	require_once "db.php";
	require "entete.php";
	entete();

	$sql = 'SELECT count(*) FROM annonce;';
	$rs = mysql_query($sql);
	$count = mysql_fetch_array($rs);
	echo '<table>';
	echo '<caption>annonces de la base : '. $count[0] .'</caption>';
	echo '<tr>';
//	echo '<th>ID</th>';
	echo '<th>type</th>';
	echo '<th>marque</th>';
	echo '<th>model</th>';
	echo '<th>cylindre</th>';
	echo '<th>image</th>';
	echo '<th>origine</th>';
	echo '<th>prix</th>';
	echo '<th>km</th>';
	echo '<th>annee</th>';
	echo '<th>Code postal</th>';
	echo '<th>date de l\'annonce</th>';
	echo '<th>en Savoir plus</th>';
	echo '<th>Supprimer</th>';
	echo '</tr>';

	$sql = 'select type,marque,model,cylindre,imageURL,origine,prix,km,annee,cp,dateAnnonce,detailsURL,id from annonce;';
	$rs = mysql_query($sql);
	$i=0;


	//Affichage du tableau
	while ($row = mysql_fetch_array($rs)) {
		printf("\n");
		if ($i==0) {
			$i++;
			printf('<tr class="ligne" align="center">
					<td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s€ </td> <td> %s km </td> <td> %s </td> <td> %s </td> <td> %s </td>
					<td><div class="buttons"> <a href="%s"> lien</a> </div></td>
					<td><div class="buttons"> <a href="deleteFromAnnonceId.php?id=%s"> X</a> </div></td>
					</tr>'
					,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12]);
		} else {
			$i--;
			printf('<tr class="ligne2" align="center">
					<td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s€ </td> <td> %s km</td> <td> %s </td> <td> %s </td> <td> %s </td>
					<td> <div class="buttons"> <a href="%s"> lien</a> </div> </td>
					<td><div class="buttons"> <a href="deleteFromAnnonceId.php?id=%s"> X</a> </div></td>
					</tr>'
					,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12]);
		}
	}

	mysql_free_result($rs);
	echo '</table>';



	require "pied.php";
	pied();
	$temps_fin = microtime(true);
	echo "<!-- Temps d\'execution : ".round($temps_fin - $temps_debut, 4) . " secondes -->";

?>
