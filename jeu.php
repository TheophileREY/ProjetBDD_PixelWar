<?php
include("include/config.inc.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: index.html");
    exit();
}

$grids = [];
$sql = "SELECT id, titre FROM Grilles";
$result = mysqli_query($link, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $grids[] = $row;
    }
} else {
    echo "Erreur SQL";
    exit();
}

$selectedGridID = isset($_GET['grid_id']) ? intval($_GET['grid_id']) : (count($grids) > 0 ? $grids[0]['id'] : 0);
$pixels = [];

if ($selectedGridID) {
    $sql = "SELECT position_x AS row, position_y AS col, couleur AS couleur, COALESCE(proprietaire_id, 'null') AS UserID FROM Pixels WHERE grille_id = $selectedGridID";
    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pixels[] = $row;
        }
    } else {
        echo "Erreur SQL";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Pixel War</title>
    <link rel="stylesheet" href="styles/grille.css">
    <script src="scripts/app.js" defer></script>
    <script src="scripts/jeu.js" defer></script>
</head>
<body>
    <div class="grid-actions">
        <button id="logoutButton">Se déconnecter</button>
        <select id="gridSelector">
            <?php foreach ($grids as $grid): ?>
                <option value="<?php echo $grid['id']; ?>" <?php if ($grid['id'] == $selectedGridID) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($grid['titre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" id="newGridTitle" placeholder="Nom de la nouvelle grille">
        <button id="createGridButton">Créer une nouvelle grille</button>
        <button id="deleteGridButton">Supprimer la grille</button>
    </div>
    <div class="main-container">
        <div class="color-selector">
            <div class="color-swatch" data-color="#000000" style="background-color: #000000;"></div>
            <div class="color-swatch" data-color="#FF5733" style="background-color: #FF5733;"></div>
            <div class="color-swatch" data-color="#3333FF" style="background-color: #3333FF;"></div>
            <div class="color-swatch" data-color="#33FF57" style="background-color: #33FF57;"></div>
            <div class="color-swatch" data-color="#FFFF33" style="background-color: #FFFF33;"></div>
            <div class="color-swatch" data-color="#FF33FF" style="background-color: #FF33FF;"></div>
            <div class="color-swatch" data-color="#33FFFF" style="background-color: #33FFFF;"></div>
        </div>
        <div id="grid" class="grid-container" data-grid-id="<?php echo $selectedGridID; ?>" data-pixels='<?php echo json_encode($pixels); ?>'>
            <?php
            for ($row = 0; $row < 30; $row++) {
                for ($col = 0; $col < 30; $col++) {
                    echo "<div class='cell' data-row='$row' data-col='$col'></div>";
                }
            }
            ?>
        </div>
    </div>
    <div id="userStatus">Pixel vide</div>
</body>
</html>
