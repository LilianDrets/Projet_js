<?php

session_start();

$dbLink = mysqli_connect('localhost', 'root', '')
or die('Erreur de connexion au serveur : ' . mysqli_connect_error());
mysqli_select_db($dbLink, 'js_projet')
or die('Erreur dans la sélection de la base : ' . mysqli_error($dbLink));

$obj = new stdClass();
$obj->result = true;

$query = 'SELECT * FROM cocktail';


if(!($dbResult = mysqli_query($dbLink, $query)))
{
    echo 'Erreur de requête<br/>';
    echo 'Erreur : ' . mysqli_error($dbLink) . '<br/>';
    echo 'Requête : ' . $query . '<br/>';
    exit();
}
else {
    $obj->message = "Erreur1";
}

if (mysqli_num_rows($dbResult) != 0) {
    $i = 0;
    while ($db_row = mysqli_fetch_assoc($dbResult)) {
        $tab[$i] = $db_row['nom'];
        $ing[$i] = $db_row['ingredient1'];
        $i = $i + 1;
        $ing[$i] = $db_row['ingredient2'];
        $i = $i + 1;
        $ing[$i] = $db_row['ingredient3'];
        $i = $i + 1;



    }
}
else { 		$obj->message = "Erreur2";}

$obj->tableau = $tab;
$obj->ing = $ing;


header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($obj); // {"result": true}

mysqli_close($dbLink);