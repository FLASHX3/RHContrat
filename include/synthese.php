<?php
session_start();
require_once('login.php');

try {
    $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $requete = $connexion->query("SELECT * FROM contrats  ORDER BY id DESC");
    $contrats = $requete->fetchAll(PDO::FETCH_ASSOC);

    $requeteService = $connexion->prepare("SELECT DISTINCT service FROM services ORDER BY service ASC");
    $requeteService->execute();
    $services = $requeteService->fetchAll(PDO::FETCH_ASSOC);

    $requetePoste = $connexion->prepare("SELECT DISTINCT poste FROM services ORDER BY poste ASC");
    $requetePoste->execute();
    $postes = $requetePoste->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<h2><ion-icon name="clipboard" style="color: var(--primary-color);"></ion-icon>Tableau de Synthèse des Contrats</h2>

<div id="allContrats" data-resultat=" <?php echo htmlspecialchars(json_encode($contrats)); ?>"></div>

<div id="action">
    <ion-icon name="search-outline" title="cliquez pour recherchez"></ion-icon>
    <input type="search" id="search" placeholder="Saisissez votre recherche">
    <label for="export">Exporter</label>
    <button type="button" id="export" title="Exporter le tableau"><ion-icon name="download-outline"></ion-icon></button>
    <div id="customConfirm" class="custom-confirm">
        <div class="message"><ion-icon name="print-outline" color="var(--primary-color)"></ion-icon>Exportez au format : </div><span class="close">&times;</span>
        <div id="buttonconfirm">
            <button type="button" id="excel" title="Exporter au format excel"><img src="../img/logo excel.png" alt="logo excel">EXCEL</button>
            <button type="button" id="pdf" title="Exporter au format PDF"><img src="../img/logo pdf.jfif" alt="logo pdf">PDF</button>
        </div>
    </div>
</div>

<table id="synthese">
    <thead>
        <tr>
            <th>№</th>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>type_contrat</th>
            <th>Entité</th>
            <th>Service</th>
            <th>Poste</th>
            <th>Nombre_contrat</th>
            <th>Durée_contrat</th>
            <th>Début_contrat</th>
            <th>Fin_contrat</th>
            <th>Dossier_complet</th>
            <th>reconductible</th>
            <th>Etat</th>
            <th>Action_rapide</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($contrats) === 0): ?>
            <tr>
                <td colspan="16" style="text-align: center; font-style: italic; padding: 20px;">
                    Aucun contrat enregistré.
                </td>
            </tr>
        <?php else: ?>
        <?php foreach ($contrats as $contrat): ?>
            <?php
            $dateFin = new DateTime($contrat['date_echeance']);
            $aujourdhui = new DateTime();

            $interval = $aujourdhui->diff($dateFin);
            $expiré = $dateFin < $aujourdhui;
            $bientot = $dateFin >= $aujourdhui && $interval->m < 2 && $interval->invert == 0;
            ?>
            <tr>
                <td><?= htmlspecialchars($contrat['id']) ?></td>
                <td><?= htmlspecialchars($contrat['matricule']) ?></td>
                <td><?= htmlspecialchars($contrat['nom']) ?></td>
                <td><?= htmlspecialchars($contrat['prenom']) ?></td>
                <td><?= htmlspecialchars($contrat['type_contrat']) ?></td>
                <td><?= htmlspecialchars($contrat['entite']) ?></td>
                <td><?= htmlspecialchars($contrat['service']) ?></td>
                <td><?= htmlspecialchars($contrat['poste']) ?></td>
                <td><?= htmlspecialchars($contrat['nombre_contrats']) ?></td>
                <td><?= htmlspecialchars($contrat['duree_contrat']) ?> mois</td>
                <td><?= htmlspecialchars($contrat['date_prise_effet']) ?></td>
                <td><?= htmlspecialchars($contrat['date_echeance']) ?></td>
                <td><?= htmlspecialchars($contrat['dossier_complet']) ?></td>
                <td><?= htmlspecialchars($contrat['reconductible']) ?></td>
                <td class="etat">
                    <?php
                    if ($expiré) {
                        echo '<span class="badge badge-expire" title = "Expire le ' . $contrat['date_echeance'] . '">Expiré</span>';
                    } elseif ($bientot) {
                        echo '<span class="badge badge-bientot">Bientôt expiré</span>';
                    } else {
                        echo '<span class="badge badge-ok">Valide</span>';
                    }
                    ?>
                </td>
                <td class="edition">
                    <ion-icon name="create-outline" size="small" title="Modifiez" data-id_contrat="<?= htmlspecialchars($contrat['id']); ?>" data-etat="false"></ion-icon>
                    <?php
                    if ($_SESSION['type'] == "super admin") { ?>
                        <ion-icon name="trash" size="small" title="Supprimez" data-id_contrat="<?= htmlspecialchars($contrat['id']); ?>"></ion-icon>
                    <?php }
                    ?>
                </td>
            </tr>
        <?php endforeach;
        $requete->closeCursor(); ?>
        <?php endif; ?>
    </tbody>
</table>

<div id="modification">
    <form action="../include/updateContrat.php" method="post">
        <h2>Modification contrat<span id="close-modification" title="fermer">&times;</span></h2>
        <hr noshade="">
        <div class="champs">
            <div class="input-group"><label for="matricule">Matricule <span class="obligatoire">*</span></label><input type="text" name="matricule" id="matricule" placeholder="Entrez le matricule" required><span id="erreurMatricule" class="erreur"></span></div>
            <div class="input-group"><label for="nom">Nom <span class="obligatoire">*</span></label><input type="text" name="nom" id="nom" placeholder="Entrez le Nom" required><span id="erreurNom" class="erreur"></span></div>
            <div class="input-group"><label for="prenom">Prénom <span class="obligatoire">*</span></label><input type="text" name="prenom" id="prenom" placeholder="Entrez le prénom" required><span id="erreurPrenom" class="erreur"></span></div>
            <div class="input-group"><label for="typeContrat">Type contrat <span class="obligatoire">*</span></label>
                <select name="typeContrat" id="typeContrat">
                    <option value="none" selected disabled>--Choisissez le type de contrat--</option>
                    <option value="CDD" selected>CDD</option>
                    <option value="CDI">CDI</option>
                    <option value="Essaie">Essaie</option>
                    <option value="Stage Académique">Stage Académique</option>
                    <option value="Stage Professionnel">Stage Professionnel</option>
                    <option value="Stage Vacances">Stage Vacances</option>
                </select>
                <span id="erreurTypeContrat" class="erreur"></span>
            </div>
            <div class="input-group"><label for="entite">Entite <span class="obligatoire">*</span></label>
                <select name="entite" id="entite">
                    <option value="none" disabled>--Sélectionnez l'entité--</option>
                    <option value="WORLD HR">WORLD HR</option>
                    <option value="SCI SOTRADIC" selected>SCI SOTRADIC</option>
                    <option value="SOREPCO">SOREPCO</option>
                    <!-- <option value="autre">Autre</option> -->
                </select>
                <span id="erreurEntite" class="erreur"></span>
            </div>
            <div class="input-group"><label for="service">Service <span class="obligatoire">*</span></label>
                <select name="service" id="service">
                    <option value="none" disabled>--Sélectionnez le service--</option>
                    <!-- <option value="autre">Autre</option> -->
                    <?php foreach ($services as $service) {
                    ?>
                        <option value="<?= $service['service'] ?>"><?= $service['service'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <span id="erreurService" class="erreur"></span>
            </div>
            <div class="input-group"><label for="poste">Poste <span class="obligatoire">*</span></label>
                <select name="poste" id="poste" oninput="autre();">
                    <option value="none" disabled>--Sélectionnez le poste--</option>
                    <!-- <option value="autre">Autre</option> -->
                    <?php foreach ($postes as $poste) {
                    ?>
                        <option value="<?= $poste['poste'] ?>"><?= $poste['poste'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <span id="erreurPoste" class="erreur"></span>
            </div>
            <div class="input-group"><label for="nbContrat">Nombre contrat <span class="obligatoire">*</span></label><input type="number" name="nbContrat" id="nbContrat" placeholder="Entrez le nombre de contrat" required><span id="erreurNbContrat" class="erreur"></span></div>
            <div class="input-group"><label for="dureeContrat">Durée contrat <span class="obligatoire">*</span></label><input type="number" name="dureeContrat" id="dureeContrat" placeholder="Entrez la durée du contrat" required><span id="erreurDureeContrat" class="erreur"></span></div>
            <div class="input-group"><label for="dateDebut">Date debut <span class="obligatoire">*</span></label><input type="date" name="dateDebut" id="dateDebut" required><span id="erreurDateDebut" class="erreur"></span></div>
            <div class="input-group"><label for="dateEcheance">Date fin <span class="obligatoire">*</span></label><input type="date" name="dateEcheance" id="dateEcheance" required><span id="erreurDateEcheance" class="erreur"></span></div>
            <div class="input-group"><label for="dossierComplet">Dossier Complet <span class="obligatoire">*</span></label>
                <select name="dossierComplet" id="dossierComplet">
                    <option value="oui">oui</option>
                    <option value="non" selected>non</option>
                </select>
                <span id="erreurService" classs="erreur"></span>
            </div>
            <div class="input-group"><label for="reconductible">Reconductible <span class="obligatoire">*</span></label>
                <select name="reconductible" id="reconductible">
                    <option value="oui">oui</option>
                    <option value="non">non</option>
                </select>
                <span id="erreurService" classs="erreur"></span>
            </div>
            <input type="hidden" name="idM" id="idM">
        </div>
        <input type="submit" name="Modifiez" id="Modif" value="Modifiez">
    </form>
</div>

<?php
    if (isset($_GET['delete'])) {
    ?>
        <div id="delete" class="popup">
            <?php echo $_GET['delete']; ?>
        </div>
    <?php
    }
    if (isset($_GET['ajout'])) {
    ?>
        <div id="ajout" class="popup">
            <?php echo $_GET['ajout']; ?>
        </div>
    <?php
    }
    if (isset($_GET['maj'])) {
    ?>
        <div id="maj" class="popup">
            <?php echo $_GET['maj']; ?>
        </div>
    <?php
    }
    if (isset($_GET['modif'])) {
    ?>
        <div id="modif" class="popup">
            <?php echo $_GET['modif']; ?>
        </div>
    <?php
    }
?>