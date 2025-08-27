<?php
session_start();

if (isset($_POST['Modifiez']) && !empty($_POST["Modifiez"])) {
    $idM = strip_tags(htmlspecialchars($_POST['idM']));
    $matricule = strip_tags(htmlspecialchars($_POST['matricule']));
    $nom = strip_tags(htmlspecialchars($_POST['nom']));
    $prenom = strip_tags(htmlspecialchars($_POST['prenom']));
    $typeContrat = strip_tags(htmlspecialchars($_POST['typeContrat']));
    $entite = strip_tags(htmlspecialchars($_POST['entite']));
    $service = isset($_POST['service'])? strip_tags(htmlspecialchars($_POST['service'])) : null;
    $newservice = isset($_POST['newservice']) ? strip_tags(htmlspecialchars($_POST['newservice'])) : null;
    $poste = isset($_POST['poste'])? strip_tags(htmlspecialchars($_POST['poste'])) : null;
    $newposte = isset($_POST['newposte']) ? strip_tags(htmlspecialchars($_POST['newposte'])) : null;
    $nbContrat = strip_tags(htmlspecialchars($_POST['nbContrat']));
    $dureeContrat = strip_tags(htmlspecialchars($_POST['dureeContrat']));
    $dateDebut = strip_tags(htmlspecialchars($_POST['dateDebut']));
    $dateFin = strip_tags(htmlspecialchars($_POST['dateEcheance']));
    $dossierComplet = strip_tags(htmlspecialchars($_POST['dossierComplet']));
    $reconductible = strip_tags(htmlspecialchars($_POST['reconductible']));

    try {
        require_once('login.php');
        $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        if ($newservice) {
            $service = $newservice;
            if($newposte){
                $poste = $newposte;
            }
            echo "nouveau service <br>".$service." ".$poste."<br>";
            $add = $connexion->prepare("INSERT INTO services VALUE(?,?)");
            $add->execute(array($service, $poste));
            $add->closeCursor();
        }else if ($newposte) {
            $poste = $newposte;
            echo "nouveau poste <br>".$service." ".$poste;
            $add = $connexion->prepare("INSERT INTO services VALUE(?,?)");
            $add->execute(array($service, $poste));
            $add->closeCursor();
        }

        $update = $connexion->prepare("UPDATE contrats SET matricule = ?, nom = ?, prenom = ?, type_contrat = ?, entite = ?, service = ?, poste = ?, nombre_contrats = ?, duree_contrat = ?, date_prise_effet = ?, date_echeance = ?, dossier_complet = ?, reconductible = ? WHERE id = ?");
        $update->execute(array($matricule, $nom, $prenom, $typeContrat, $entite, $service, $poste, $nbContrat, $dureeContrat, $dateDebut, $dateFin, $dossierComplet, $reconductible, $idM));

        $update->closeCursor();
        header("location: ../dashboard/index.php?onglet=synthese&modif=Modification du contrat № $matricule effectuée");
        exit();
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    header('location: ../dashboard/index.php?onglet=synthese');
}

