<?php
    require_once('login.php');

    $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    $id = isset($_GET['id']) ? strip_tags(htmlspecialchars($_GET['id'])) : null;

    if ($id == null || empty($id)) {
        header('location: ../dashboard/index.php?onglet=synthese&delete=Erreur lors de la suppression du contrat');
    }

    $delete = $connexion->prepare("DELETE FROM contrats WHERE id = ?");
    $res = $delete->execute(array($id));

    if ($res) {
        header("location: ../dashboard/index.php?onglet=synthese&delete=Suppression du contrat № $id réussie");
    }else {
        header("location: ../dashboard/index.php?onglet=synthese&delete=Erreur lors de la suppression du contrat № $id");
    }
