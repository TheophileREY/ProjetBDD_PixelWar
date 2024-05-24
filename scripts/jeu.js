document.addEventListener("DOMContentLoaded", function() {
    fetch('verification.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = 'index.html';
            }
        });

    document.getElementById('logoutButton').addEventListener('click', function() {
        window.location.href = 'deconnexion.php'; 
    });

    document.getElementById('gridSelector').addEventListener('change', function() {
        const selectedGridID = this.value;
        window.location.href = `jeu.php?grid_id=${selectedGridID}`;
    });

    document.getElementById('createGridButton').addEventListener('click', function() {
        const gridTitle = document.getElementById('newGridTitle').value;
        if (gridTitle) {
            fetch('create_grid.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `gridTitle=${encodeURIComponent(gridTitle)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const gridSelector = document.getElementById('gridSelector');
                    const newOption = document.createElement('option');
                    newOption.value = data.grid_id;
                    newOption.textContent = data.grid_title;
                    gridSelector.appendChild(newOption);
                    gridSelector.value = data.grid_id;
                    window.location.href = `jeu.php?grid_id=${data.grid_id}`;
                } else {
                    alert('Erreur avec la création de la grille');
                }
            })
        } else {
            alert('Il faut un nom pour la nouvelle grille.');
        }
    });

    document.getElementById('deleteGridButton').addEventListener('click', function() {
        const selectedGridID = document.getElementById('gridSelector').value;
        if (confirm('Voulez-vous vraiment supprimer cette grille ?')) {
            fetch('delete_grid.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `gridID=${encodeURIComponent(selectedGridID)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const gridSelector = document.getElementById('gridSelector');
                    gridSelector.removeChild(gridSelector.querySelector(`option[value="${selectedGridID}"]`));
                    if (gridSelector.options.length > 0) {
                        gridSelector.value = gridSelector.options[0].value;
                        window.location.href = `jeu.php?grid_id=${gridSelector.options[0].value}`;
                    } else {
                        window.location.href = `jeu.php`;
                    }
                } else {
                    alert('Erreur avec la suppression de la grille');
                }
            })
        }
    });
});
