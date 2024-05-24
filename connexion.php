<?php 
include ("include/config.inc.php");
$bMauvaisMotDePasse = $bMauvaisCompte = false;

if (isset($_POST["login"])){
    $login = QuoteStr($_POST["login"]);
    $sql_id = "SELECT id FROM `Utilisateurs` WHERE pseudo = $login";
    $result_id = mysqli_query($link, $sql_id);
    if ($result_id && mysqli_num_rows($result_id) > 0){
        $userID = mysqli_fetch_assoc($result_id)['id'];
        $sql_password = "SELECT password FROM `Utilisateurs` WHERE id = $userID";
        $result_password = mysqli_query($link, $sql_password);
        if ($result_password && mysqli_num_rows($result_password) > 0){
            $hash = mysqli_fetch_assoc($result_password)['password'];
            $password_poste = $_POST["mdp"];
            $hash_poste = hash('sha256', $password_poste);
            if ($hash == $hash_poste){
                $_SESSION['isConnected'] = true;
                $_SESSION['login'] = $_POST["login"];
                $_SESSION['UserID'] = $userID;
                header("location: jeu.php"); 
            } else {
                $bMauvaisMotDePasse = true;
            }
        } else {
            $bMauvaisCompte = true;
        }
    } else { 
        $bMauvaisCompte = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Se Connecter</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <img src="img/polytech_dijon_logo.png" alt="Logo de Polytech Dijon">
    </header>
    <main>
        <?php if ($bMauvaisMotDePasse) { ?>
            <div>
                <strong>Attention!</strong> Vous avez saisi un mauvais mot de passe.
            </div>
        <?php } ?>

        <?php if ($bMauvaisCompte) { ?>
            <div>
                <strong>Attention!</strong> Le compte n'existe pas.
            </div>
        <?php } ?>

        <form method="POST">
            <h1>Se Connecter</h1>
            <div>
                <input type="text" name="login" id="login" placeholder="Pseudo" required>
                <input type="password" name="mdp" id="mdp" placeholder="Mot De Passe" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </main>
</body>
</html>
