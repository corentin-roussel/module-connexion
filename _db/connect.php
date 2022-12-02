<?php
session_start();

$host = 'localhost';
$name = 'moduleconnexion';
$user = 'root';
$password = '';

$mysqli = new mysqli("$host", "$user", "$password", "$name"); // Connexion a la base de données en localhost


//$mysqli = new mysqli("localhost, corentin, Mldsr.0202, corentin-roussel_moduleconenxion"); // Connexion a la base de données pour plesk

if($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL " . $mysqli -> connect_error;
    exit();
} // if connection error echo une phrase et exit

$sql = ("SELECT prenom, nom, password, login FROM `utilisateurs`"); // Stocké dans une variable selectionné  tous les champ pour utilisateurs
$result = $mysqli -> query($sql); // Stocké le résultat dans la variable result = a la connexion a la base de données et on fetch la variable sql
$table = $result -> fetch_all();

?>