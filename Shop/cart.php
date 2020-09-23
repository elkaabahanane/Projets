<?php

// Initialiser la session
session_start();

// Vérifiez si l'utilisateur est déjà connecté, si oui, redirigez-le vers la page d'accueil
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once("includes/connect.php");

$cc_num = $cc_exp = $cc_cvv = "";
$cc_num_err = $cc_exp_err = $cc_cvv_err = "";
$isValid = false;
$isPOST = $_SERVER["REQUEST_METHOD"] == "POST";

// Traitement des données du formulaire lors de la soumission du formulaire
if ($isPOST && isset($_POST["commander"])) {
    // Vérifier si le numéro de carte est valide
    if (empty(trim($_POST["cc_num"]))) {
        $cc_num_err = "Veuillez saisir votre numero de carte.";
    } else if (!is_numeric($_POST["cc_num"]) || strlen($_POST["cc_num"]) !== 16) {
        $cc_num_err = "Veuillez saisir une numero de carte valide.";
    } else {
        $cc_num = trim($_POST["cc_num"]);
    }

    // Vérifier si le date d'expiration est vide
    if (empty(trim($_POST["cc_exp"]))) {
        $cc_exp_err = "Veuillez saisir votre numero de carte.";
    } else if (strlen($_POST["cc_exp"]) !== 5) {
        $cc_exp_err = "Veuillez saisir une date d'expiration valide.";
    } else {
        $cc_exp = trim($_POST["cc_exp"]);
    }

    // Vérifier si le date d'expiration est vide
    if (empty(trim($_POST["cc_cvv"]))) {
        $cc_cvv_err = "Veuillez saisir votre carte CVV.";
    } else if (!is_numeric($_POST["cc_cvv"]) || strlen($_POST["cc_cvv"]) !== 3) {
        $cc_cvv_err = "Veuillez saisir une CVV valide.";
    } else {
        $cc_cvv = trim($_POST["cc_cvv"]);
    }

    $id_client = intval($_SESSION['id']);

    $prix_totale = floatval($_POST["prix_totale"]);

    if (empty($cc_num_err) && empty($cc_exp_err) && empty($cc_cvv_err)) {
        $sql1 = "INSERT INTO commande (id_client, cc_num, cc_exp, cc_cvv, prix_totale) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql1)) {

            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "isssd", $id_client, $cc_num, $cc_exp, $cc_cvv, $prix_totale);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                $id_commande = mysqli_stmt_insert_id($stmt);
                $isAdded = false;

                foreach ($_POST['produit'] as $key => $produit) {
                    $id_produit = intval($produit['id']);
                    $prix_produit = floatval($produit['prix']);
                    $quantite_produit = floatval($produit['quantite']);
                    $isAdded = false;

                    $sql2 = "INSERT INTO commande_produit (id_produit, id_commande, prix_produit, quantite_produit) VALUES (?, ?, ?, ?)";

                    if ($stmt = mysqli_prepare($link, $sql2)) {

                        // Lier des variables à l'instruction préparée en tant que paramètres
                        mysqli_stmt_bind_param($stmt, "iidd", $id_produit, $id_commande, $prix_produit, $quantite_produit);

                        // Tentative d'exécution de l'instruction préparée
                        if (mysqli_stmt_execute($stmt)) {

                            $sql3 = "UPDATE produit SET quantite = quantite - ? WHERE id_produit = ?";

                            if ($stmt = mysqli_prepare($link, $sql3)) {

                                // Lier des variables à l'instruction préparée en tant que paramètres
                                mysqli_stmt_bind_param($stmt, "di", $quantite_produit, $id_produit);

                                // Tentative d'exécution de l'instruction préparée
                                if (mysqli_stmt_execute($stmt)) {
                                    $isAdded = true;
                                } else {
                                    echo mysqli_error($link);
                                }
                            }
                        } else {
                            echo mysqli_error($link);
                        }
                    }
                }

                // Actualiser la page
                if ($isAdded) {
                    header("location: index.php");
                    exit;
                }
            } else {
                echo "Quelque chose a mal tourné. Veuillez réessayer.";
                echo mysqli_error($link);
            }

            // Clôture de l'instruction
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<div class="hero-wrap hero-bread" style="background-image: url('public/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">Cart</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <div class="table">
                        <div class="thead-primary">
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>Nom Produit</div>
                            <div>Prix</div>
                            <div>Quantité</div>
                            <div>Prix Totale</div>
                        </div>
                        <div id="cart-products">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end" style="width:100%">
                <div class="col-6 mt-5 cart-wrap ftco-animate">
                    <div class="cart-total mb-3">
                        <h3>Détails de paiment</h3>
                        <p>Entrez les détails de votre carte de crédit</p>
                        <form id="orderForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="POST" class="info">
                            <?php
                            if ($isPOST && $isValid === false) {
                                echo '<div class="alert alert-danger">Veuillez corriger toutes les erreurs avant de continuer.</div>';
                            }
                            ?>
                            <div class="form-group">
                                <label for="">Numéro de carte</label>
                                <input type="text"
                                    class="form-control text-left px-3 <?php echo (!empty($cc_num_err)) ? 'is-invalid' : ''; ?>"
                                    name="cc_num" placeholder="1234 1234 1234 1234" value="<?php echo $cc_num; ?>">
                                <div class="invalid-feedback"><?php echo $cc_num_err; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="country">Date d'expiration</label>
                                <input type="text"
                                    class="form-control text-left px-3 <?php echo (!empty($cc_exp_err)) ? 'is-invalid' : ''; ?>"
                                    name="cc_exp" placeholder="12/22" value="<?php echo $cc_exp; ?>">
                                <div class="invalid-feedback"><?php echo $cc_exp_err; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="country">CVV</label>
                                <input type="text"
                                    class="form-control text-left px-3 <?php echo (!empty($cc_cvv_err)) ? 'is-invalid' : ''; ?>"
                                    name="cc_cvv" placeholder="123" value="<?php echo $cc_cvv; ?>">
                                <div class="invalid-feedback"><?php echo $cc_cvv_err; ?></div>
                            </div>
                            <button type="submit" name="commander" class="btn btn-primary py-3 px-4"
                                id="commander">Commander</button>
                        </form>
                    </div>
                </div>
                <div class="col-6 mt-5 cart-wrap ftco-animate">
                    <div class="cart-total mb-3">
                        <h3>Cart Totals</h3>
                        <p class="d-flex total-price">
                            <span>Total</span>
                            <span id="total-price">$0.00</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include "includes/footer.php"; ?>

<script>
$(document).ready(function() {

    // Afficher les produits dans la carte
    let cartItems = localStorage.getItem("items");
    let products = "";
    let products_order = "";
    let totalPrice = 0;
    if (cartItems !== null) {
        cartItems = JSON.parse(cartItems);
        for (product of cartItems) {
            totalPrice += parseFloat(product.price * product.quantity);
            let productPrice = parseFloat(product.price * product.quantity);

            products += `<div class="entry-row">
                    <div class="product-remove"><a href="#" data-id="${product.id}"><span class="ion-ios-close"></span></a></div>
                    <div class="image-prod"><div class="img" style="background-image:url(${product.image});"></div></div>
                    <div class="product-name">
                        <h3>${product.name}</h3>
                    </div>
                    <div class="price">$${product.price}</div>
                    <div class="quantity">${product.quantity}</div>
                    <div class="total">$${productPrice}</div>
                  </div><!-- END ENTRY -->`;

            products_order +=
                `<input type="hidden" name="produit[${product.id}][id]" value="${product.id}"/><input type="hidden" name="produit[${product.id}][prix]" value="${product.price}"/><input type="hidden" name="produit[${product.id}][quantite]" value="${product.quantity}"/>`;
        }
    } else {
        products =
            "<div class='text-center p-5'>Vous n'avez actuellement aucun produit dans votre panier</div>"
    }

    $("#cart-products").html(products);
    $("#total-price").text("$" + totalPrice);
    $("#orderForm").append('<input type="hidden" name="prix_totale" value="' + totalPrice + '"/>' +
        products_order);

    $(document).on('click', '#commander', function(e) {
        localStorage.removeItem('items');
    });

    $(document).on('click', '.product-remove a', function(e) {
        e.preventDefault();

        let id_produit = $(this).data('id');
        let products = localStorage.getItem("items");
        if (products !== null) {
            products = JSON.parse(products);
        } else {
            products = [];
        }

        for (let i = 0; i < products.length; i++) {
            if (id_produit == products[i]['id']) {
                products.splice(i, 1);
                $(this).parents('.entry-row').remove();
            }
        }

        if (products.length > 0) {
            localStorage.setItem("items", JSON.stringify(products));
        } else {
            localStorage.removeItem("items");
        }

    })

});
</script>