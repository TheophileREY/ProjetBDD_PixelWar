<?php
session_start();
include("include/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gridTitle = mysqli_real_escape_string($link, $_POST['gridTitle']);

    $sql = "INSERT INTO Grilles (titre) VALUES ('$gridTitle')";
    if (mysqli_query($link, $sql)) {
        echo json_encode(['status' => 'success', 'grid_id' => mysqli_insert_id($link), 'grid_title' => $gridTitle]);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($link)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
