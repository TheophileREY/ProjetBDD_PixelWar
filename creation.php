<?php
include("include/config.inc.php"); 
$bMauvaisMotDePasse = false;
$bMauvaisCompte = false;

if (isset($_POST["pseudo"])) {
    $email = QuoteStr($_POST["email"]);
    $pseudo = QuoteStr($_POST["pseudo"]);
    $password_poste = $_POST["password"];
    $hash_poste = hash("sha256", $password_poste);
    $sql = "INSERT INTO `Utilisateurs` (email, pseudo, password) VALUES ($email, $pseudo, '$hash_poste')";
    if (ExecuteSQL($sql)) 
    {
        $_SESSION['isConnected'] = true;
        $_SESSION['login'] = $_POST["pseudo"];
        header("Location: jeu.php"); 
        exit;
    } 
    else 
    {
        $bMauvaisCompte = true;
    }    
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <img src="img/polytech_dijon_logo.png" alt="Logo de Polytech Dijon">
    </header>
    <main>
        <?php if ($bMauvaisCompte) { ?>
            <div>
                <strong>Erreur!</strong> Impossible de créer le compte. Veuillez réessayer.
            </div>
        <?php } ?>
        <form method="POST">
            <h1>Créer un compte</h1>
            <div>
                <input type="email" name="email" id="floatingInput" placeholder="Adresse email" required>
                <input type="text" name="pseudo" id="floatingInput" placeholder="Pseudonyme" required>
                <input type="password" name="password" id="floatingPassword" placeholder="Mot de passe" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
    </main>
</body>
</html>


