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


?>