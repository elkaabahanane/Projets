<?php

// Initialiser la session
session_start();

// Vérifiez si l'utilisateur est déjà connecté, si oui, redirigez-le vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

require_once("includes/connect.php");

// Définissez les variables et initialisez avec des valeurs vides
$email = $password = "";
$email_err = $password_err = "";
$isValid = false;
$isPOST = $_SERVER["REQUEST_METHOD"] == "POST";

// Traitement des données du formulaire lors de la soumission du formulaire
if ($isPOST && isset($_POST["login"])) {

    // Vérifier si l'email est vide
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez saisir votre email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Vérifier si le mot de passe est vide
    if (empty(trim($_POST["password"]))) {
        $password_err = "S'il vous plait entrez votre mot de passe.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Valider les informations d'identification
    if (empty($email_err) && empty($password_err)) {
        // Préparer une instruction select
        $sql = "SELECT id_client, email, password, role FROM client WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $email);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // Stocker le résultat
                mysqli_stmt_store_result($stmt);

                // Vérifier si l'e-mail existe, si oui, vérifier le mot de passe
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Lier les variables de résultat
                    mysqli_stmt_bind_result($stmt, $id_client, $email, $hashed_password, $role);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            $isValid = true;

                            // Le mot de passe est correct, alors commencez une nouvelle session
                            session_start();

                            // Stocke les données dans des variables de session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id_client;
                            $_SESSION["role"] = $role;

                            // Redirige l'utilisateur vers la page d'accueil
                            header("location: index.php");
                        } else {
                            // Affiche un message d'erreur si le mot de passe n'est pas valide
                            $password_err = "Le mot de passe que vous avez entré n'est pas valide.";
                        }
                    }
                } else {
                    // Affiche un message d'erreur si l'email n'existe pas
                    $email_err = "Aucun compte trouvé avec cet e-mail.";
                }
            } else {
                echo "Oops! Quelque chose a mal tourné. Veuillez réessayer.";
            }

            // Clôture de l'instruction
            mysqli_stmt_close($stmt);
        }
    }

    // Fermer la connexion
    mysqli_close($link);
}
?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<div class="hero-wrap hero-bread" style="background-image: url('public/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">login</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-lg-8 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            class="bg-white p-5 contact-form">
            <?php
            if ($isPOST && $isValid === false) {
                echo '<div class="alert alert-danger">Veuillez corriger toutes les erreurs avant de continuer.</div>';
            }
            ?>
            <div class="form-group">
                <label for="email">Votre email :</label>
                <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    placeholder="exemple@exemple.com" name="email" value="<?php echo $email; ?>">
                <div class="invalid-feedback"><?php echo $email_err; ?></div>
            </div>
            <div class="form-group">
                <label for="password">Votre password :</label>
                <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    placeholder="******" name="password" value="<?php echo $password; ?>">
                <div class="invalid-feedback"><?php echo $password_err; ?></div>
            </div>
            <div class="form-group">
                <button type="submit" name="login" class="btn btn-primary py-3 px-5">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<?php include "includes/footer.php"; ?>