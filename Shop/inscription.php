<?php

// Initialiser la session
session_start();

// Vérifiez si l'utilisateur est déjà connecté, si oui, redirigez-le vers la page d'accueil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

require_once("includes/connect.php"); ?>

<?php

// Définissez les variables et initialisez avec des valeurs vides
$nom = $prenom = $email = $password = "";
$nom_err = $prenom_err = $email_err = $password_err = "";
$isValid = false;
$isPOST = $_SERVER["REQUEST_METHOD"] == "POST";

// Traitement des données du formulaire lors de la soumission du formulaire
if ($isPOST && isset($_POST['inscription'])) {

    // Validez le nom
    if (empty(trim($_POST["nom"]))) {
        $nom_err = "Veuillez saisir un nom.";
    } else {
        $nom = trim($_POST["nom"]);
    }

    // Validez le prenom
    if (empty(trim($_POST["prenom"]))) {
        $prenom_err = "Veuillez saisir un prenom.";
    } else {
        $prenom = trim($_POST["prenom"]);
    }

    // Validez l'email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez saisir un email.";
    } elseif (strpos(trim($_POST["email"]), '@') === false) {
        $email_err = "L'email doit être une adresse email valide.";
    } else {
        // Préparer une instruction select
        $sql = "SELECT id_client FROM client WHERE email = ?";
        $email = trim($_POST["email"]);

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $email);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // stocker le résultat
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) >= 1) {
                    $email_err = "Cet e-mail est déjà utilisé.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Quelque chose a mal tourné. Veuillez réessayer.";
            }

            // Clôture de l'instruction
            mysqli_stmt_close($stmt);
        }
    }

    // Validez le password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Le mot de passe doit comporter au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
        $password = password_hash($password, PASSWORD_DEFAULT); // Crée un hachage de mot de passe
    }

    // Check input errors before inserting in database
    if (empty($nom_err) && empty($prenom_err) && empty($email_err) && empty($password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO client (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            $role = "user";
            mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $email, $password, $role);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                $isValid = true;
                // Rediriger vers la page de connexion
                header("location: login.php");
            } else {
                echo "Quelque chose a mal tourné. Veuillez réessayer.";
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
                <h1 class="mb-0 bread">Inscription</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-lg-8 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            class="bg-white p-5 contact-form <?php echo ($isPOST) ? 'was-validated' : ''; ?>">
            <?php
            if ($isPOST && $isValid === false) {
                echo '<div class="alert alert-danger">Veuillez corriger toutes les erreurs avant de continuer.</div>';
            }
            ?>
            <div class=" form-group">
                <label for="prenom">Votre nom:</label>
                <input type="text" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" name="nom"
                    placeholder="John" value="<?php echo $nom; ?>">
                <div class="invalid-feedback"><?php echo $nom_err; ?></div>
            </div>
            <div class="form-group">
                <label for="prenom">Votre prenom:</label>
                <input type="text" class="form-control <?php echo (!empty($prenom_err)) ? 'is-invalid' : ''; ?>"
                    name="prenom" placeholder="Doe" value="<?php echo $prenom; ?>">
                <div class="invalid-feedback"><?php echo $prenom_err; ?></div>
            </div>
            <div class="form-group">
                <label for="email">Votre email:</label>
                <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    name="email" placeholder="exemple@exemple.com" value="<?php echo $email; ?>">
                <div class="invalid-feedback"><?php echo $email_err; ?></div>
            </div>
            <div class="form-group">
                <label for="password">Votre password:</label>
                <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    name="password" placeholder="******" value="<?php echo $password; ?>">
                <div class="invalid-feedback"><?php echo $password_err; ?></div>
            </div>
            <div class="form-group">
                <button type="submit" name="inscription" class="btn btn-primary py-3 px-5">S'inscrire</button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<?php include "includes/footer.php"; ?>