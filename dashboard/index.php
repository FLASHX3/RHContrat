<?php
session_start();
if (isset($_SESSION['id'])) {
    $session = $_SESSION['type'];
    $ongletActif = isset($_GET['onglet']) ? $_GET['onglet'] : 'enregistrer';
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RHContrat</title>
        <link rel="shortcut icon" href="../img/logo_sci_sotradic.png" type="image/x-icon">
        <link rel="stylesheet" href="../css/dashboard.css">
        <script src="../js/dashboard.js" defer></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js" defer></script> <!--bibliothèque d'exportation Excel-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js" defer></script> <!--bibliothèque d'exportation JsPDF-->
    </head>

    <body>
        <div id="container">
            <nav>
                <section>
                    <h1>RHContrat</h1>
                </section>
                <div id="navbar">
                    <ul>
                        <li onclick="activeLi(this);"><a href="#" data-page="enregistrer"><ion-icon name="add-circle" size="small"></ion-icon>Enregistrer un contrat</a></li>
                        <li onclick="activeLi(this);"><a href="#" data-page="synthese"><ion-icon name="clipboard-outline" size="small"></ion-icon>Synthèse des contrats</a></li>
                        <li onclick="activeLi(this);"><a href="#" data-page="echeances"><ion-icon name="newspaper-outline" size="small"></ion-icon>Contrats Expirés</a></li>
                        <li onclick="activeLi(this);"><a href="#" data-page="gestion"><ion-icon name="layers-outline" size="small"></ion-icon>Dossiers Personels</a></li>
                        <li onclick="activeLi(this);"><a href="#" data-page="employes"><ion-icon name="library-outline" size="small"></ion-icon>Employés & Attributions</a></li>
                    </ul>
                    <a href="logout.php" id="logout"><ion-icon name="log-out" size="small"></ion-icon>Se déconnecter</a>
                </div>
            </nav>
            <div id="loader" class="hidden"></div>
            <aside class="page-<?= $ongletActif ?>">
                <?php
                switch ($ongletActif) {
                    case 'synthese':
                        include('../include/synthese.php'); // ou inclure le bon fichier
                        break;
                    case 'gestion':
                        include('../include/gestion.php'); // ou inclure le bon fichier
                        break;
                    case 'echeances':
                        include('../include/echeances.php');
                        break;
                    case 'employes':
                        include('../include/employes.php');
                        break;
                    default:
                        include('../include/enregistrer.php');
                        break;
                }
                ?>
            </aside>
        </div>
        
    </body>

    </html>

<?php
} else {
    header('Location: ../index.php');
}
?>