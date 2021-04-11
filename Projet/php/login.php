<?php

session_start();

$dbLink = mysqli_connect('localhost', 'root', '')
or die('Erreur de connexion au serveur : ' . mysqli_connect_error());
mysqli_select_db($dbLink, 'js_projet')
or die('Erreur dans la sélection de la base : ' . mysqli_error($dbLink));

$obj = new stdClass();
$obj->result = true;

if(isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = 'SELECT mdp FROM utilisateur WHERE pseudo =\'' . $username . '\'';



    if(!($dbResult = mysqli_query($dbLink, $query)))
    {
        echo 'Erreur de requête<br/>';
        echo 'Erreur : ' . mysqli_error($dbLink) . '<br/>';
        echo 'Requête : ' . $query . '<br/>';
        exit();
    }

    if (mysqli_num_rows($dbResult) != 0) {
        $db_row = mysqli_fetch_assoc($dbResult);
        $pwd = $db_row['mdp'];

        if ($password == $pwd) { // password_verify($password, $pwd)
            $query = 'SELECT * FROM utilisateur WHERE pseudo = \'' . $username . '\'';
            if(!($dbResult = mysqli_query($dbLink, $query)))
            {
                echo 'Erreur de requête<br/>';
                echo 'Erreur : ' . mysqli_error($dbLink) . '<br/>';
                echo 'Requête : ' . $query . '<br/>';
                exit();
            }
            $db_row = mysqli_fetch_assoc($dbResult);
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['pseudo'] = $db_row['pseudo'];
        }

        else {
            $obj->result = false;
            $obj->message = "user or password incorrect";
        }

    }

    else {
        $obj->result = false;
        $obj->message = "user or password incorrect";
    }


} else {
    $obj->result = false;
    $obj->message = "username and password are mandatory!";
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($obj); // {"result": true}

mysqli_close($dbLink);