export function init() {
    console.log("Page Synthese prête !");

    const btn_search = document.querySelector('.page-synthese #action [name="search-outline"]');
    const search = document.querySelector('.page-synthese #action #search');

    const table = document.querySelector('.page-synthese #synthese tbody');
    const lignes = table.querySelectorAll('tr');

    const allContrats = document.querySelector('#allContrats');
    const dataContrat = JSON.parse(allContrats.getAttribute('data-resultat'));
    console.log("Tous les contrats en-cours: " + dataContrat.length);

    btn_search.addEventListener('click', () => {
        // search.style.display = 'block';
        search.style.width = '50%';
        search.style.paddingLeft = '8px';
        search.style.paddingRight = '8px';
        search.focus();
    });

    // 🔥 Crée un élément pour le message "Aucun résultat"
    const messageNoResult = document.createElement('tr');
    messageNoResult.innerHTML = `<td colspan="16" style="text-align:center; font-style:italic; color:gray;">Aucun résultat pour votre recherche...</td>`;
    messageNoResult.style.display = 'none'; // caché par défaut
    table.appendChild(messageNoResult); // l'ajouter à la fin du tbody

    // Écoute l'événement
    search.addEventListener('input', function () {
        const recherche = this.value.trim().toLowerCase();
        let matchCount = 0; // Compteur de lignes trouvées

        lignes.forEach(tr => {
            let matchFound = false;

            // Parcourir chaque cellule du tableau
            const nodes = tr.querySelectorAll('td:not(.etat):not(.edition)');
            nodes.forEach(node => {
                // Remettre le texte original avant de surligner
                node.innerHTML = node.textContent;

                if (recherche && node.textContent.toLowerCase().includes(recherche)) {
                    matchFound = true;
                    // Surligner uniquement la partie correspondante
                    const regex = new RegExp(`(${recherche})`, 'gi');
                    node.innerHTML = node.textContent.replace(regex, '<mark>$1</mark>');
                }
            });

            // Afficher ou cacher la ligne en fonction du résultat
            if (matchFound || recherche.length === 0) {
                tr.style.display = '';
                matchCount++;
            } else {
                tr.style.display = 'none';
            }
        });

        // 🔥 Affiche le message si aucune ligne visible
        if (matchCount === 0) {
            messageNoResult.style.display = '';
        } else {
            messageNoResult.style.display = 'none';
        }
    });

    document.querySelector('#export').addEventListener('click', () => {
        confirmExport();
    })

    document.querySelector('#excel').addEventListener('click', function () {
        exportToExcel("#synthese", "Recapitulatif");
        document.querySelector('.custom-confirm').style.display = "none";
    });

    document.querySelector('#pdf').addEventListener('click', function () {
        exportToPDF("#synthese", "Recapitulatif");
        document.querySelector('.custom-confirm').style.display = "none";
    });

    document.querySelector('.close').addEventListener('click', () => {
        document.querySelector('#customConfirm').style.display = "none";
    });

    function confirmExport() {
        document.querySelector('.custom-confirm').style.display = "flex";
    }

    function exportToExcel(tableId, filename) {
        var table = document.querySelector(tableId);
        var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(wb, filename + ".xlsx");
    }

    function exportToPDF(tableId, filename) {
        const table = document.querySelector(tableId);
        // Options pour html2pdf
        const options = {
            margin: 0.5,
            filename: filename,
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 2 },
            jsPDF: {
                unit: 'in',
                format: [table.offsetWidth / 96, table.offsetHeight / 96], // Utilise la largeur et la hauteur du tableau pour définir la taille de la page
                orientation: 'landscape' // Changez l'orientation en paysage si nécessaire
            }
        };

        // Utilise html2pdf pour générer le PDF
        html2pdf().from(table).set(options).save();
    }

    // Quand on clique sur l'icône de modification
    document.querySelectorAll('.edition ion-icon[name="create-outline"], .edition ion-icon[name="create"]').forEach(icon => {
        icon.addEventListener('click', function () {
            const idContrat = this.getAttribute('data-id_contrat');
            const tr = this.closest('tr');
            const tds = tr.querySelectorAll('td');
            const modification = document.getElementById('modification'); // ajoute ça pour être sûr

            let etatIcon = this.getAttribute('data-etat');

            if (etatIcon == "false") {
                console.log("Modification activée!");

                // ➔ D'abord désactiver toutes les icônes
                document.querySelectorAll('.edition ion-icon[name="create"], .edition ion-icon[name="create-outline"]').forEach(icon => {
                    desactiveIcon(icon);
                    icon.setAttribute('data-etat', 'false'); // remet leur état à "false"
                });

                // ➔ Activer seulement celle-ci
                activeIcon(this);
                this.setAttribute('data-etat', 'true');

                // ➔ Remplir les champs du formulaire
                document.querySelector('#modification #idM').value = idContrat;
                document.querySelector('#modification #matricule').value = tds[1].innerText.trim();
                document.querySelector('#modification #nom').value = tds[2].innerText.trim();
                document.querySelector('#modification #prenom').value = tds[3].innerText.trim();
                document.querySelector('#modification #typeContrat').value = tds[4].innerText.trim();
                document.querySelector('#modification #entite').value = tds[5].innerText.trim();
                document.querySelector('#modification #service').value = tds[6].innerText.trim();
                document.querySelector('#modification #poste').value = tds[7].innerText.trim();
                document.querySelector('#modification #nbContrat').value = tds[8].innerText.trim();
                document.querySelector('#modification #dureeContrat').value = parseInt(tds[9].innerText);
                document.querySelector('#modification #dateDebut').value = tds[10].innerText.trim();
                document.querySelector('#modification #dateEcheance').value = tds[11].innerText.trim();
                document.querySelector('#modification #dossierComplet').value = tds[12].innerText.trim();
                document.querySelector('#modification #reconductible').value = tds[13].innerText.trim();

                // ➔ Afficher le formulaire
                modification.style.display = 'block';

            } else if (etatIcon == "true") {
                // ➔ Si on reclique pour fermer
                modification.style.display = "none";
                desactiveIcon(this);
                this.setAttribute('data-etat', 'false');
            }
        });
    });

    // ➔ Fermer le formulaire quand on clique sur la croix
    document.getElementById('close-modification').addEventListener('click', function () {
        const modification = document.getElementById('modification');
        modification.style.display = 'none';

        // ➔ Désactiver toutes les icônes
        document.querySelectorAll('.edition ion-icon[name="create"], .edition ion-icon[name="create-outline"]').forEach(icon => {
            desactiveIcon(icon);
            icon.setAttribute('data-etat', 'false');
        });
    });

    const deleteIcons = document.querySelectorAll('#synthese [name="trash"]');
    deleteIcons.forEach(deleteIcon => {
        deleteIcon.addEventListener('click', async () => {
            var confirmationDelete = confirm("Voulez-vous vraiment supprimez ce dossier?");
            if (confirmationDelete) {
                const idContrat = deleteIcon.getAttribute('data-id_contrat');
                const type = deleteIcon.getAttribute('data-type');
                console.log("Suppression du contrat " + idContrat);
                activeIcon(deleteIcon);
                window.location = `../include/deleteContrat.php?id=${idContrat}&type=${type}`;
            }
        });
    });
}

