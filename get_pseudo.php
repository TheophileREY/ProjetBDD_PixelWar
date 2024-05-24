<?php
include("include/config.inc.php");

$data = json_decode(file_get_contents('php://input'), true);
$userID = $data['userID'];

$sql = "SELECT `pseudo` FROM `Utilisateurs` WHERE `id` = $userID";
$username = GetSQLValue($sql);
echo "$username";
?>