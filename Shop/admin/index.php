<?php

// Initialiser la session
session_start();

// Vérifiez si l'utilisateur est un administrateur, sinon redirigez-le vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) &&  $_SESSION["role"] !== 'admin') {
    header("location: ../index.php");
    exit;
}

require_once("../includes/connect.php");

?>

<!-- Header -->
<?php include "../includes/header.php"; ?>

<div class="hero-wrap hero-bread" style="background-image: url('public/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">ADMIN</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto p-5 text-center">

            <a href="admin/produit.php" class="btn btn-primary py-3 px-5 mr-2">Gestion Produits</a>
            <a href="admin/categorie.php" class="btn btn-primary py-3 px-5 ml-2">Gestion Categories</a>

        </div>
    </div>
</div>


<!-- Footer -->
<?php include "../includes/footer.php"; ?>