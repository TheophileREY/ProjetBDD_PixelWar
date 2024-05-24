<?php
include("include/config.inc.php");
$data = json_decode(file_get_contents('php://input'), true);

$grid_ID = intval($data['gridID']);
$row = intval($data['row']);
$col = intval($data['col']);
$couleur = mysqli_real_escape_string($link, $data['couleur']);

$userID = $_SESSION['UserID'];

$sql = "SELECT * FROM `Pixels` WHERE grille_id = $grid_ID AND position_x = $row AND position_y = $col";
$result = mysqli_query($link, $sql);
$resultrow = mysqli_num_rows($result);

if ($result && $resultrow > 0){
    $sql = "UPDATE `Pixels` SET couleur = '$couleur', proprietaire_id = '$userID' WHERE grille_id = $grid_ID AND position_x = $row AND position_y = $col";
} else {
    $sql = "INSERT INTO `Pixels` (`couleur`, `proprietaire_id`, `grille_id`, `position_x`, `position_y`) VALUES ('$couleur', '$userID', '$grid_ID', '$row', '$col')";
}
mysqli_query($link, $sql);
?>