<?php
// Initialiser la session
session_start();
 
// Annule toutes les variables de session
$_SESSION = array();
 
// Détruisez la session.
session_destroy();
 
// Rediriger vers la page de connexion
header("location: login.php");
exit;