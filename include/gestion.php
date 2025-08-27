<?php
    require_once('login.php');

    try {
        $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $requete = $connexion->query("SELECT * FROM contrats");
        $contrats = $requete->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>

<h2><ion-icon name="layers" style="color: var(--primary-color);"></ion-icon>Gestion Contrats</h2>

<div id = "select-div">
    <h3>Service : </h3>
    <select name="service" id="service">
        <option value="Approvisionnement">Approvisionnement</option>
        <option value="Comptanilité">Comptabilité</option>
        <option value="Gestion Immobilière">Gestion Immobilière</option>
        <option value="Informatique">Informatique</option>
        <option value="Ressource Humaine">Ressource Humaine</option>
        <option value="Sécurité">Sécurité</option>
        <option value="Technique">Technique</option>
        <option value="Marketing">Marketing</option>
    </select>
</div>

<div id="table-contrats">
    <div class="contrat">
        <div id = "entête-contrat">
            <p id = "matricule"><ion-icon name="menu" size="small"></ion-icon>MAT88GTt5</p>
        </div>
        <p id = "nom_premon">
            NOUBISSIE GADEU BARBARA DONA
        </p>
        <p id = "poste">
            Assistante de Direction
        </p>
        <p id = "type_contrat">
            Type_contrat
        </p>
    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
    <div class="contrat">

    </div>
</div>