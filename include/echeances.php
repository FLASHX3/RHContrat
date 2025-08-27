<?php
    require_once('login.php');

    try {
        $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $requete = $connexion->query("SELECT contrats.id, contrats.matricule, contrats.nom, contrats.prenom, contrats_echus.type_contrat, contrats_echus.entite, contrats_echus.service, contrats_echus.poste, contrats_echus.duree_contrat, contrats_echus.date_prise_effet, contrats_echus.date_echeance, contrats.dossier_complet, contrats_echus.reconductible FROM contrats, contrats_echus WHERE contrats.id = contrats_echus.id_contrat ORDER BY contrats_echus.id DESC");
        $contrats = $requete->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>

<h2><ion-icon name="layers" style="color: var(--primary-color);"></ion-icon>Contrats Expirés</h2>

<div id="allContrats" data-resultat=" <?php echo htmlspecialchars(json_encode($contrats)); ?>"></div>

<table>
    <thead>
        <tr>
            <th>№</th>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Type</th>
            <th>Entité</th>
            <th>Service</th>
            <th>Poste</th>
            <th>Durée_contrat</th>
            <th>Début_contrat</th>
            <th>Fin_contrat</th>
            <th>Dossier_complet</th>
            <th>Reconductible</th>
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
            <tr>
                <td><?= htmlspecialchars($contrat['id']) ?></td>
                <td><?= htmlspecialchars($contrat['matricule']) ?></td>
                <td><?= htmlspecialchars($contrat['nom']) ?></td>
                <td><?= htmlspecialchars($contrat['prenom']) ?></td>
                <td><?= htmlspecialchars($contrat['type_contrat']) ?></td>
                <td><?= htmlspecialchars($contrat['entite']) ?></td>
                <td><?= htmlspecialchars($contrat['service']) ?></td>
                <td><?= htmlspecialchars($contrat['poste']) ?></td>
                <td><?= htmlspecialchars($contrat['duree_contrat']) ?> mois</td>
                <td><?= htmlspecialchars($contrat['date_prise_effet']) ?></td>
                <td><?= htmlspecialchars($contrat['date_echeance']) ?></td>
                <td><?= htmlspecialchars($contrat['dossier_complet']) ?></td>
                <td><?= htmlspecialchars($contrat['reconductible']) ?></td>
            </tr>
        <?php endforeach; $requete->closeCursor();?>
        <?php endif; ?>
    </tbody>
</table>
