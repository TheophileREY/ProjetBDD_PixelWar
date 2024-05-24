document.addEventListener("DOMContentLoaded", function() {
    const grid = document.getElementById("grid");
    const gridID = grid.getAttribute("data-grid-id");
    const userStatus = document.getElementById("userStatus");
    let selectedColor = '#000000'; // Noir par défaut
    userStatus.textContent = "Pixel vide";

    document.querySelectorAll('.color-swatch').forEach(swatch => {
        swatch.addEventListener('click', function() {
            selectedColor = swatch.dataset.color;
        });
    });

    grid.addEventListener('click', function(event) {
        const cell = event.target;
        if (cell.classList.contains('cell')) {
            const row = cell.dataset.row;
            const col = cell.dataset.col;
            cell.style.backgroundColor = selectedColor;
            fetch('update_pixel.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    gridID: gridID,
                    row: row,
                    col: col,
                    couleur: selectedColor,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    console.error('Error updating pixel:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    function afficherPixels(pixels) {
        pixels.forEach(pixel => {
            const row = pixel.row;
            const col = pixel.col;
            const couleur = pixel.couleur;
            const userID = pixel.UserID || null;
            const cell = grid.querySelector(`.cell[data-row="${row}"][data-col="${col}"]`);
            if (cell) {
                cell.style.backgroundColor = couleur;
                cell.dataset.userID = userID;
            }
        });
    }

    const pixels = JSON.parse(grid.dataset.pixels);
    afficherPixels(pixels);

    setInterval(refreshGrid, 5000);

    function refreshGrid() {
        fetch(`get_updated_pixels.php?grid_id=${gridID}`)
            .then(response => response.json())
            .then(updatedPixels => {
                afficherPixels(updatedPixels);
            })
            .catch(error => console.error('Error fetching updated pixels:', error));
    }

    grid.addEventListener('mouseover', function(event) {
        const cell = event.target;
        if (cell.classList.contains('cell') && cell.dataset.userID) {
            const userID = cell.dataset.userID;
            if (userID !== 'null' && userID !== null) {
                fetch('get_pseudo.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ userID: userID })
                })
                .then(response => response.text())
                .then(username => {
                    userStatus.textContent = `Pixel de ${username}`;
                })
                .catch(error => console.error('Error:', error));
            } else {
                userStatus.textContent = "Pixel vide";
            }
        }
    });

    grid.addEventListener('mouseout', function(event) {
        userStatus.textContent = "Pixel vide";
    });
});
