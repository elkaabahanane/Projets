<?php
define('db_host', 'localhost:3307');
define('db_user', 'root');
define('db_password', 'root');
define('db_name', 'shop');

// Tentative de connexion à la base de données MySQL
$link = mysqli_connect(db_host, db_user, db_password, db_name);

// Vérifier la connexion
if ($link === false) {
    die("Impossible de se connecter à la base de données"  . mysqli_connect_error());
}

define("UPLOAD_URI", "http://" . $_SERVER['SERVER_NAME'] . "/Shop/upload/");