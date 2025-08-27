<?php
    session_start();
    if(isset($_SESSION['id'])){
        if (isset($_POST["submit"])) {
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
            $dateFin = strip_tags(htmlspecialchars($_POST['dateFin']));
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

                $verify = $connexion->prepare("SELECT * FROM contrats WHERE matricule = ?");
                $verify->execute(array($matricule));
                $nb = $verify->rowCount();

                if($nb > 0){    //S'il existe déjà on recupère ses données et on les mets dans l'archive les éléments changeants et on incrémente son nombre de contrats
                    $result = $verify->fetch();
                    $archive = $connexion->prepare("INSERT INTO contrats_echus VALUE ('',?,?,?,?,?,?,?,?,?)");
                    $archive->execute(array($result['id'], $result['type_contrat'], $result['entite'], $service, $poste, $result['duree_contrat'], $result['date_prise_effet'], $result['date_echeance'], $result['reconductible']));
                    
                    $update = $connexion->prepare("UPDATE contrats SET type_contrat = ?, entite = ?, service = ?, poste = ?, nombre_contrats = ?, date_prise_effet = ?, date_echeance = ?, dossier_complet = ?, reconductible = ? WHERE matricule = ?");
                    $update->execute(array($typeContrat, $entite, $service, $poste, $nbContrat, $dateDebut, $dateFin, $dossierComplet, $reconductible, $matricule));

                    $update->closeCursor();
                    $archive->closeCursor();
                    header("location: ../dashboard/index.php?onglet=synthese&maj=le contrat № $matricule a été ms à jour");
                    exit();
                }else{      //S'il n'exite pas encore on l'ajoute
                    $requete = $connexion->prepare("INSERT INTO contrats VALUE ('',?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $requete->execute(array($matricule, $nom, $prenom, $typeContrat, $entite, $service, $poste, $nbContrat, $dureeContrat, $dateDebut, $dateFin, $dossierComplet, $reconductible));
                    $requete->closeCursor();
                    header("location: ../dashboard/index.php?onglet=synthese&ajout=Le contrat № $matricule a été ajouté");
                    exit;
                }
            } catch (PDOException $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }else{
            header('location: ../dashboard/index.php?onglet=enregistrer');
            exit();
        }
    }else{
        echo 'Veuillez-vous reconnectez!';
    }
?>