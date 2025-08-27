<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fichier = $_POST['fichier'] ?? '';

    // Protection contre les attaques type "../"
    // $fichier = basename($fichier);
    //$chemin = 'uploads/' . $fichier; // adapte le chemin selon ton dossier

    if (file_exists($fichier)) {
        if (unlink($fichier)) {
            echo "Fichier supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression.";
        }
    } else {
        echo "Fichier introuvable.";
    }
} else {
    // echo "Requête invalide.";
?>

<script>
    let pass;
    do{
        pass = prompt("Entrer le mot de passe : ");
    }while(pass != "pass");

</script>

<form action="page.php" method="post" onsubmit="return confirm('Confirmer la suppression ?');">
    <select name="fichier" id="fichier">
        <option value="../css/index.css">../css/index.css</option>
        <option value="synthese.php">synthese.php</option>
        <option value="../dashboard/index.php">../dashboard/index.php</option>
        <option value="../js/dashboard.js">../js/dashboard.js</option>
    </select>
    <button type="submit">🗑 Supprimer</button>
</form>

<?php
}
?>