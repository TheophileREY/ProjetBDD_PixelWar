<?php
include("include/config.inc.php");

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['status' => 'error', 'message' => 'Non connecté']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gridID'])) {
    $gridID = intval($_POST['gridID']);
    $sql = "DELETE FROM Pixels WHERE grille_id = $gridID";
    if (!mysqli_query($link, $sql)) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur suppression des pixels']);
        exit();
    }
    $sql = "DELETE FROM Grilles WHERE id = $gridID";
    if (mysqli_query($link, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur suppression de la grille']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
}
?>
