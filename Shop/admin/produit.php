<?php

// Initialiser la session
session_start();

// Vérifiez si l'utilisateur est un administrateur, sinon redirigez-le vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) &&  $_SESSION["role"] !== 'admin') {
    header("location: ../index.php");
    exit;
}

require_once("../includes/connect.php");

function creer_produit($link, $produit_nom, $produit_prix, $produit_quantite, $produit_image, $id_categorie)
{
    // Préparer une instruction insert
    $sql = "INSERT INTO produit (p_nom, prix, quantite, image, id_categorie) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Lier des variables à l'instruction préparée en tant que paramètres
        mysqli_stmt_bind_param($stmt, "sddsi", $produit_nom, $produit_prix, $produit_quantite, $produit_image, $id_categorie);

        // Tentative d'exécution de l'instruction préparée
        if (mysqli_stmt_execute($stmt)) {
            // Actualiser la page
            header("Refresh:0");
            exit;
        } else {
            echo "Quelque chose a mal tourné. Veuillez réessayer.";
        }

        // Clôture de l'instruction
        mysqli_stmt_close($stmt);
    }
}

function modifier_produit($link, $id_produit, $produit_nom, $produit_prix, $produit_quantite, $produit_image, $id_categorie)
{
    // Préparer une instruction update
    $sql = "UPDATE produit SET p_nom = ?, prix = ?, quantite = ?, id_categorie = ? WHERE id_produit = ?";
    if (!empty($produit_image)) {
        $sql = "UPDATE produit SET p_nom = ?, prix = ?, quantite = ?, image = ?, id_categorie = ? WHERE id_produit = ?";
    }

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Lier des variables à l'instruction préparée en tant que paramètres
        if (empty($produit_image)) {
            mysqli_stmt_bind_param($stmt, "sddii", $produit_nom, $produit_prix, $produit_quantite, $id_categorie, $id_produit);
        } else {
            mysqli_stmt_bind_param($stmt, "sddsii", $produit_nom, $produit_prix, $produit_quantite, $produit_image, $id_categorie, $id_produit);
        }

        // Tentative d'exécution de l'instruction préparée
        if (mysqli_stmt_execute($stmt)) {
            // Actualiser la page
            header("Refresh:0");
            exit;
        } else {
            echo "Quelque chose a mal tourné. Veuillez réessayer.";
        }

        // Clôture de l'instruction
        mysqli_stmt_close($stmt);
    }
}

function supprimer_produit($link, $id_produit)
{
    // Préparer une instruction insert
    $sql = "DELETE FROM produit WHERE id_produit = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Lier des variables à l'instruction préparée en tant que paramètres
        mysqli_stmt_bind_param($stmt, "i", $id_produit);

        // Tentative d'exécution de l'instruction préparée
        if (mysqli_stmt_execute($stmt)) {
            // Actualiser la page
            header("Refresh:0");
            exit;
        } else {
            echo "Quelque chose a mal tourné. Veuillez réessayer.";
        }

        // Clôture de l'instruction
        mysqli_stmt_close($stmt);
    }
}

$produit_nom = $produit_prix = $produit_quantite = $produit_image = "";
$produit_nom_err = $produit_prix_err = $produit_quantite_err = $produit_image_err = "";
$isValid = false;
$isPOST = $_SERVER["REQUEST_METHOD"] == "POST";

// Traitement des données du formulaire lors de la soumission du formulaire
if ($isPOST) {
    if (isset($_POST['ajouter_produit']) || isset($_POST['modifier_produit'])) {
        // Vérifier si le nom est vide
        if (empty(trim($_POST["produit_nom"]))) {
            $produit_nom_err = "Veuillez saisir votre nom de produit.";
        } else {
            $produit_nom = trim($_POST["produit_nom"]);
        }

        // Vérifier si le prix est valide
        if (empty(trim($_POST["produit_prix"]))) {
            $produit_prix_err = "Veuillez saisir votre prix de produit.";
        } else if (!is_numeric($_POST["produit_prix"])) {
            $produit_prix_err = "Veuillez saisir un prix valide.";
        } else {
            $produit_prix = trim($_POST["produit_prix"]);
        }

        // Vérifier si la quantite est valide
        if (empty(trim($_POST["produit_quantite"]))) {
            $produit_quantite_err = "Veuillez saisir votre quantite de produit.";
        } else if (!is_numeric($_POST["produit_quantite"])) {
            $produit_quantite_err = "Veuillez saisir une quantite valide.";
        } else {
            $produit_quantite = trim($_POST["produit_quantite"]);
        }

        // Vérifier si l'image est valide
        if (empty($_FILES["produit_image"]) && isset($_POST['ajouter_produit'])) {
            $produit_image_err = "Veuillez télécharger une image de produit.";
        } else if (empty($_FILES["produit_image"]) && isset($_POST['modifier_produit'])) {
            $produit_image = '';
        } else {
            $produit_image = $_FILES['produit_image']['name'];
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["produit_image"]["name"]);

            // Select file type
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            // Check extension
            if (in_array($imageFileType, $extensions_arr)) {
                // Upload file
                move_uploaded_file($_FILES['produit_image']['tmp_name'], $target_dir . $produit_image);
            }
        }

        if (isset($_POST['ajouter_produit'])) { // Ajouter un produit
            $id_categorie = intval($_POST["categorie"]);

            // Valider les informations d'identification
            if (empty($produit_nom_err) && empty($produit_prix_err) && empty($produit_quantite_err) && empty($produit_image_err)) {
                creer_produit($link, $produit_nom, $produit_prix, $produit_quantite, $produit_image, $id_categorie);
            }
        } else if (isset($_POST['modifier_produit'])) { // Modifier un produit

            $id_categorie = intval($_POST["produit_categorie"]);
            $id_produit = intval($_POST['id_produit']);

            // Valider les informations d'identification
            if (empty($produit_nom_err) && empty($produit_prix_err) && empty($produit_quantite_err) && empty($produit_image_err)) {
                modifier_produit($link, $id_produit, $produit_nom, $produit_prix, $produit_quantite, $produit_image, $id_categorie);
            }
        }
    } else if (isset($_POST['supprimer_produit'])) {
        $id_produit = intval($_POST['id_produit']);

        supprimer_produit($link, $id_produit);
    }
}

?>

<!-- Header -->
<?php include "../includes/header.php"; ?>

<div class="hero-wrap hero-bread" style="background-image: url('public/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">Produits</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                class="bg-white p-5 contact-form" enctype="multipart/form-data">

                <?php
                if ($isPOST && $isValid === false) {
                    echo '<div class="alert alert-danger">Veuillez corriger toutes les erreurs avant de continuer.</div>';
                }
                ?>
                <div class="form-group">
                    <label for="produit_nom">Nom de produit:</label>
                    <input type="text"
                        class="form-control <?php echo (!empty($produit_nom_err)) ? 'is-invalid' : ''; ?>"
                        placeholder="Orange" name="produit_nom" value="<?php echo $produit_nom; ?>">
                    <div class="invalid-feedback"><?php echo $produit_nom_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="produit_prix">Prix de produit:</label>
                    <input type="text"
                        class="form-control <?php echo (!empty($produit_prix_err)) ? 'is-invalid' : ''; ?>"
                        placeholder="150.00" name="produit_prix" value="<?php echo $produit_prix; ?>">
                    <div class="invalid-feedback"><?php echo $produit_prix_err; ?></div>
                </div>
                <div class="form-group">
                    <label for="produit_quantite">Quantité de produit:</label>
                    <input type="text"
                        class="form-control <?php echo (!empty($produit_quantite_err)) ? 'is-invalid' : ''; ?>"
                        placeholder="10" name="produit_quantite" value="<?php echo $produit_quantite; ?>">
                    <div class="invalid-feedback"><?php echo $produit_quantite_err; ?></div>
                </div>
                <?php
                // Tentative d'exécution de la requête de sélection
                $sql = "SELECT * FROM categorie";
                if ($result = mysqli_query($link, $sql)) :
                    if (mysqli_num_rows($result) > 0) :
                ?>
                <div class="form-group">
                    <label for="categorie">Categorie de produit:</label>
                    <select name="categorie" class="form-control">
                        <?php
                                while ($row = mysqli_fetch_array($result)) :
                                ?>
                        <option value="<?php echo $row['ID_CATEGORIE']; ?>"><?php echo $row['C_NOM']; ?></option>
                        <?php
                                endwhile;
                                ?>
                    </select>
                </div>
                <?php
                    endif;
                endif;
                ?>

                <div class="form-group">
                    <label for="produit_image">Image de produit:</label>
                    <input type="file"
                        class="form-control <?php echo (!empty($produit_image_err)) ? 'is-invalid' : ''; ?>"
                        name="produit_image">
                    <div class=" invalid-feedback"><?php echo $produit_image_err; ?></div>
                </div>

                <div class="form-group">
                    <button type="submit" name="ajouter_produit" class="btn btn-primary py-3 px-5">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <?php

    // Tentative d'exécution de la requête de sélection
    $sql = "SELECT * FROM produit ORDER BY id_produit DESC";
    if ($result = mysqli_query($link, $sql)) :

    ?>
    <div class="row">
        <div class="col-md-12 ftco-animate fadeInUp ftco-animated">
            <div class="cart-list">
                <div class="table">
                    <div class="thead-primary">
                        <div>Produit Image</div>
                        <div>Produit Nom</div>
                        <div>Produit Prix</div>
                        <div>Produit Quantité</div>
                        <div>Produit Categorie</div>
                        <div>Actions</div>
                    </div>
                    <div class="products-table">
                        <?php
                            if (mysqli_num_rows($result) > 0) :
                                while ($row = mysqli_fetch_array($result)) : ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="entry-row">
                                <div class="produit-image image-prod">
                                    <?php $produit_image = UPLOAD_URI . "" . $row['IMAGE']; ?>
                                    <div class="img" style="background-image:url(<?php echo $produit_image; ?>);"></div>
                                    <input type="file" name="produit_image">
                                </div>
                                <div class="produit-nom">
                                    <input type="text" name="produit_nom" value="<?php echo $row['P_NOM']; ?>"
                                        size="15">
                                </div>
                                <div class="produit-prix">
                                    <input type="text" name="produit_prix" value="<?php echo $row['PRIX']; ?>"
                                        size="10">
                                </div>
                                <div class="produit-quantite">
                                    <input type="text" name="produit_quantite" value="<?php echo $row['QUANTITE']; ?>"
                                        size="10">
                                </div>
                                <div class="produit-categorie">
                                    <?php
                                                $categories_sql = "SELECT * FROM categorie";
                                                if ($categories_result = mysqli_query($link, $categories_sql)) :
                                                    if (mysqli_num_rows($categories_result) > 0) :
                                                ?>
                                    <select name="produit_categorie" class="categories-select form-control">
                                        <?php while ($categories_row = mysqli_fetch_array($categories_result)) : ?>
                                        <option value="<?php echo $categories_row['ID_CATEGORIE']; ?>"
                                            <?php echo ($categories_row['ID_CATEGORIE'] === $row['ID_CATEGORIE']) ? "selected" : "" ?>>
                                            <?php echo $categories_row['C_NOM']; ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <?php
                                                    endif;
                                                endif; ?>
                                </div>
                                <div class="table-actions produit-actions">
                                    <input type="hidden" name="id_produit" value="<?php echo $row['ID_PRODUIT']; ?>">
                                    <button type="submit" name="modifier_produit"><span
                                            class="ion-md-create"></span></button>
                                    <button type="submit" name="supprimer_produit"><span
                                            class="ion-md-trash"></span></button>
                                </div>
                            </div>
                        </form>
                        <?php
                                endwhile;
                                mysqli_free_result($result);
                            else :
                                ?>
                        <div class="entry-row">
                            Aucun enregistrement n'a été trouvé.
                        </div>
                        <?php
                            endif;
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    endif;

    // Fermer la connexion
    mysqli_close($link);

    ?>
</div>

<!-- Footer -->
<?php include "../includes/footer.php"; ?>