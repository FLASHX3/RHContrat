<script>
    let pass;
    do{
        pass = prompt("Entrer le mot de passe : ");
    }while(pass != "pass");

</script>


<?php
    try {
        require_once('login.php');
        $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $majbd = $connexion->prepare("UPDATE `services` SET `poste`= ? WHERE `poste` = ?");
        $majbd->execute(array("Agent Commercial", "Agent Commerciale"));
        //$contrats = $majbd->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die('Erreur: ' . $e->getMessage());
    }

?>


<!-- <?php
    try {
        require_once('login.php');
        $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $majbd = $connexion->prepare("SELECT * FROM contrats");
        $majbd->execute();
        $contrats = $majbd->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die('Erreur: ' . $e->getMessage());
    }

?> -->

<!-- <table> -->
    <!-- <?php foreach ($contrats as $contrat): ?> -->
        <!-- <tr>
            <td><?= htmlspecialchars($contrat['id']) ?></td>
            <td><?= htmlspecialchars($contrat['matricule']) ?></td>
            <td><?= htmlspecialchars($contrat['nom']) ?></td>
            <td><?= htmlspecialchars($contrat['prenom']) ?></td>
            <td><?= htmlspecialchars($contrat['type_contrat']) ?></td>
            <td><?= htmlspecialchars($contrat['entite']) ?></td>
            <td><?= htmlspecialchars($contrat['service']) ?></td>
            <td><?= htmlspecialchars($contrat['poste']) ?></td>
        </tr> -->
    <!-- <?php endforeach;
    $majbd->closeCursor(); ?>  -->
</table>   
