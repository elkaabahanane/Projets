<?php

// Initialiser la session
session_start();

// Vérifiez si l'utilisateur est un administrateur, sinon redirigez-le vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"]) &&  $_SESSION["role"] !== 'admin') {
    header("location: ../index.php");
    exit;
}

require_once("../includes/connect.php");

// Définissez les variables et initialisez avec des valeurs vides
$categorie = "";
$categorie_err = "";
$isValid = false;
$isPOST = $_SERVER["REQUEST_METHOD"] == "POST";

// Traitement des données du formulaire lors de la soumission du formulaire
if ($isPOST) {

    if (isset($_POST['ajouter_categorie'])) { // Ajouter une catégorie

        // Vérifier si le categorie est vide
        if (empty(trim($_POST["categorie"]))) {
            $categorie_err = "Veuillez saisir votre categorie.";
        } else {
            $categorie = trim($_POST["categorie"]);
        }

        // Valider les informations d'identification
        if (empty($categorie_err)) {
            // Préparer une instruction select
            $sql = "INSERT INTO categorie (c_nom) VALUES (?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Lier des variables à l'instruction préparée en tant que paramètres
                mysqli_stmt_bind_param($stmt, "s", $categorie);

                // Tentative d'exécution de l'instruction préparée
                if (mysqli_stmt_execute($stmt)) {
                    $isValid = true;
                    // Actualiser la page
                    header("Refresh:0");
                } else {
                    echo "Quelque chose a mal tourné. Veuillez réessayer.";
                }

                // Clôture de l'instruction
                mysqli_stmt_close($stmt);
            }
        }
    } else if (isset($_POST['modifier_categorie'])) { // Modification d'une catégorie
        $id_categorie = intval($_POST['id_categorie']);
        $categorie = trim($_POST['categorie']);

        // Valider les informations d'identification
        if (!empty($categorie)) {
            // Préparer une instruction select
            $sql = "UPDATE categorie SET c_nom = ? WHERE id_categorie = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Lier des variables à l'instruction préparée en tant que paramètres
                mysqli_stmt_bind_param($stmt, "si", $categorie, $id_categorie);

                // Tentative d'exécution de l'instruction préparée
                if (mysqli_stmt_execute($stmt)) {
                    $isValid = true;
                    // Actualiser la page
                    header("Refresh:0");
                } else {
                    echo "Quelque chose a mal tourné. Veuillez réessayer.";
                }

                // Clôture de l'instruction
                mysqli_stmt_close($stmt);
            }
        }
    } else if (isset($_POST['supprimer_categorie'])) { // Suppression d'une catégorie
        $id_categorie = intval($_POST['id_categorie']);

        // Valider les informations d'identification
        if (empty($categorie_err)) {
            // Préparer une instruction select
            $sql = "DELETE FROM categorie WHERE id_categorie = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Lier des variables à l'instruction préparée en tant que paramètres
                mysqli_stmt_bind_param($stmt, "i", $id_categorie);

                // Tentative d'exécution de l'instruction préparée
                if (mysqli_stmt_execute($stmt)) {
                    $isValid = true;
                    // Actualiser la page
                    header("Refresh:0");
                } else {
                    echo "Quelque chose a mal tourné. Veuillez réessayer.";
                }

                // Clôture de l'instruction
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>

<!-- Header -->
<?php include "../includes/header.php"; ?>

<div class="hero-wrap hero-bread" style="background-image: url('public/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">Categories</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                class="bg-white p-5 contact-form">

                <?php
                if ($isPOST && $isValid === false) {
                    echo '<div class="alert alert-danger">Veuillez corriger toutes les erreurs avant de continuer.</div>';
                }
                ?>
                <div class="form-group">
                    <label for="categorie">Nom de catégorie:</label>
                    <input type="text" class="form-control <?php echo (!empty($categorie_err)) ? 'is-invalid' : ''; ?>"
                        placeholder="Fruit" name="categorie" value="<?php echo $categorie; ?>">
                    <div class="invalid-feedback"><?php echo $categorie_err; ?></div>
                </div>
                <div class="form-group">
                    <button type="submit" name="ajouter_categorie" class="btn btn-primary py-3 px-5">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <?php

    // Tentative d'exécution de la requête de sélection
    $sql = "SELECT * FROM categorie";
    if ($result = mysqli_query($link, $sql)) :

    ?>
    <div class="row">
        <div class="col-md-12 ftco-animate fadeInUp ftco-animated">
            <div class="cart-list">
                <div class="table">
                    <div class="thead-primary">
                        <div>Categorie ID</div>
                        <div>Categorie Nom</div>
                        <div>Actions</div>
                    </div>
                    <div class="categories-table">
                        <?php
                            if (mysqli_num_rows($result) > 0) :
                                while ($row = mysqli_fetch_array($result)) : ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="entry-row">
                                <div class="categorie-id"><?php echo $row['ID_CATEGORIE']; ?></div>
                                <div class="categorie-nom">
                                    <input type="text" name="categorie" value="<?php echo $row['C_NOM']; ?>">
                                </div>
                                <div class="table-actions categorie-actions">
                                    <input type="hidden" name="id_categorie"
                                        value="<?php echo $row['ID_CATEGORIE']; ?>">
                                    <button type="submit" name="modifier_categorie"><span
                                            class="ion-md-create"></span></button>
                                    <button type="submit" name="supprimer_categorie"><span
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