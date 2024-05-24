<?php
session_start();
include("include/config.inc.php");

$data = json_decode(file_get_contents('php://input'), true);
$grid_ID = intval($data['gridID']);
$pixels = [];

$sql = "SELECT position_x AS row, position_y AS col, couleur AS couleur, proprietaire_id AS UserID FROM Pixels WHERE grille_id = $grid_ID";
$result = mysqli_query($link, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pixels[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($pixels);
?>
