<?php

session_start();

require_once("includes/connect.php");

?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<div class="container">
    <div class="row">
        <?php

        // Tentative d'exécution de la requête de sélection
        $sql = "SELECT * FROM produit WHERE quantite > 0 ORDER BY id_produit DESC";
        if ($result = mysqli_query($link, $sql)) :
            if (mysqli_num_rows($result) > 0) :
                while ($row = mysqli_fetch_array($result)) :
        ?>
        <div class="col-md-6 col-lg-3 ftco-animate fadeInUp ftco-animated">
            <div class="product" id="product-<?php echo $row['ID_PRODUIT']; ?>">
                <span style='display:none' class='product-id'><?php echo $row['ID_PRODUIT']; ?></span>
                <a href="#" class="img-prod">
                    <?php $produit_image = UPLOAD_URI . "" . $row['IMAGE']; ?>
                    <img class="product-image img-fluid" src="<?php echo $produit_image; ?>"
                        alt="<?php echo $row['P_NOM']; ?>">
                    <div class="overlay"></div>
                </a>
                <div class="text py-3 pb-4 px-3 text-center">
                    <h3><a href="#" class='product-title'><?php echo $row['P_NOM']; ?></a></h3>
                    <div class="d-flex">
                        <div class="pricing">
                            <p class="price">
                                <span>$<?php echo $row['PRIX']; ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="bottom-area d-flex px-3">
                        <div class="product-action m-auto d-flex">
                            <input class="product-quantity" type="number" value="1" min="1"
                                max="<?php echo $row['QUANTITE']; ?>">
                            <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1 addToCart">
                                <span><i class="ion-ios-cart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
                endwhile;
                mysqli_free_result($result);
            endif;
        endif;

        // Fermer la connexion
        mysqli_close($link);

        ?>
    </div>
</div>

<!-- Footer -->
<?php include "includes/footer.php"; ?>