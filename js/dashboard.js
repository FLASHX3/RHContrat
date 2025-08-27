function activeIcon(icon) {
    var name = icon.getAttribute('name').split("-outline");
    var newName = name[0];
    icon.setAttribute('name', newName);
    return newName;
}

function desactiveIcon(icon) {
    var name = icon.getAttribute('name').split("-outline");
    var newName = name[0] + '-outline';
    icon.setAttribute('name', newName);
    return newName;
}

function desactiveLi() {
    var liste = document.querySelectorAll('nav li');
    Array.from(liste).forEach(li => {
        li.classList.remove("actif");
        li.querySelector('a')?.classList.remove("on");
        desactiveIcon(li.querySelector('ion-icon'));
    });
}

function activeLi(li) {
    desactiveLi();
    li.classList.add("actif");
    const lien = li.querySelector('a');
    lien.classList.add("on");
    console.log("Menu: " + lien.textContent);
}

// 🔁 Charge dynamiquement le fichier CSS de la page
function loadPageStyle(page) {
    // Créer le nouveau lien CSS
    const newLink = document.createElement('link');
    newLink.rel = 'stylesheet';
    newLink.href = `/RHContrat/css/${page}.css`;
    newLink.setAttribute('data-page-style', 'true');

    // Dès que le nouveau CSS est chargé, on supprime l'ancien
    newLink.onload = () => {
        document.querySelectorAll('link[data-page-style="true"]:not([href$="' + page + '.css"])').forEach(link => link.remove());
    };

    document.head.appendChild(newLink);
}

// 🔁 Charge dynamiquement le contenu PHP, JS et CSS de la page
function chargerPage(page) {
    const content = document.querySelector('aside');
    const loader = document.querySelector('#loader');

    // 👉 Masquer immédiatement le contenu actuel
    content.style.visibility = 'hidden';  // ou display: none;

    content.className = `page-${page}`;
    content.classList.add('fade-out');
    loader.classList.remove('hidden');

    // Charger le style CSS spécifique à la page
    loadPageStyle(page);

    setTimeout(() => {
        fetch(`../include/${page}.php`)
            .then(response => response.text())
            .then(data => {
                content.innerHTML = data;

                // Charger le JS spécifique à la page
                import(`../js/${page}.js`)
                    .then(module => {
                        if (module.init) module.init();
                    })
                    .catch(err => {
                        console.warn(`Aucun JS spécifique pour la page ${page}`, err);
                    });

                // ✅ Réafficher le contenu après chargement
                content.style.visibility = 'visible';

                // Gestion des animations
                loader.classList.add('hidden');
                content.classList.remove('fade-out');
                content.classList.add('fade-in');
                setTimeout(() => {
                    content.classList.remove('fade-in');
                }, 300);
            })
            .catch(err => {
                loader.classList.add('hidden');
                content.innerHTML = "<p>Erreur lors du chargement.</p>";
                content.classList.remove('fade-out');
                content.classList.add('fade-in');
            });
    }, 300);
}

// 🔗 Gestion des clics sur les liens du menu
document.querySelectorAll('#navbar ul li a').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        const li = this.closest('li');
        activeLi(li);

        chargerPage(page);
        history.pushState(null, '', `?onglet=${page}`);
    });
});

// 🧠 Corrige l’onglet actif au chargement selon l’URL
window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const onglet = params.get('onglet') || 'enregistrer';

    const lienActif = document.querySelector(`#navbar a[data-page="${onglet}"]`);
    if (lienActif) {
        const li = lienActif.closest('li');
        activeLi(li);
        chargerPage(onglet);
    }
});
