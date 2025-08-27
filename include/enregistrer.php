<?php
    require_once('login.php');
    $connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $requeteService = $connexion->prepare("SELECT DISTINCT service FROM services ORDER BY service ASC");
    $requeteService->execute();
    $services = $requeteService->fetchAll(PDO::FETCH_ASSOC);

    $requetePoste = $connexion->prepare("SELECT DISTINCT poste FROM services ORDER BY poste ASC");
    $requetePoste->execute();
    $postes = $requetePoste->fetchAll(PDO::FETCH_ASSOC);

?>

<form action="../include/save.php" method="post" id="form">
    <h2>Contrat Employé</h2>
    <span class="message">Les champs avec le symbole * sont obligatoires</span>
    <div class="progressbar">
        <div class="progress" id="progress"></div>
        <div class="progress-step progress-step-active" data-title="Info"></div>
        <div class="progress-step" data-title="Métier"></div>
        <div class="progress-step" data-title="Durée"></div>
    </div>
    <div id="wrapper-list">
        <div class="wrapper" id="wrapper1">
            <div class="input-group">
                <label for="matricule">Matricule <span class="obligatoire">*</span></label>
                <input type="text" name="matricule" id="matricule" placeholder="Entrez le matricule" required>
                <span id="erreurMatricule" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="nom">Nom Employé <span class="obligatoire">*</span></label>
                <input type="text" name="nom" id="nom" placeholder="Entrez le nom" required >
                <span id="erreurNom" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="prenom">Prénom employé <span class="obligatoire">*</span></label>
                <input type="text" name="prenom" id="prenom" placeholder="Entrez le prénom" required>
                <span id="erreurPrenom" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="typeContrat">Type de contrat <span class="obligatoire">*</span></label>
                <select name="typeContrat" id="typeContrat" required>
                    <option value="none" selected disabled>--Choisissez le type de contrat--</option>
                    <!-- <option value="autre">Autre</option> -->
                    <option value="CDD" selected>CDD</option>
                    <option value="CDI">CDI</option>
                    <option value="Essaie">Essaie</option>
                    <option value="Stage Académique">Stage Académique</option>
                    <option value="Stage Professionnel">Stage Professionnel</option>
                    <option value="Stage Vacances">Stage Vacances</option>
                </select>
                <span id="erreurTypecontrat" class="erreur"></span>
            </div>
            <div class="">
                <a href="#" id="next1" class="btn btn-next width-50 ml-auto">Next<ion-icon name="chevron-forward" size="large"></ion-icon></a>
            </div>
        </div>
        <div class="wrapper" id="wrapper2">
            <div class="input-group">
                <label for="entite">Entité <span class="obligatoire">*</span></label>
                <select name="entite" id="entite">
                    <option value="none" disabled>--Sélectionnez l'entité--</option>
                    <option value="WORLD HR">WORLD HR</option>
                    <option value="SCI SOTRADIC" selected>SCI SOTRADIC</option>
                    <option value="SOREPCO">SOREPCO</option>
                    <!-- <option value="autre">Autre</option> -->
                </select>
                <span id="erreurEntite" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="service">Service <span class="obligatoire">*</span></label>
                <select name="service" id="service">
                    <option value="none" disabled>--Sélectionnez le service--</option>
                    <?php foreach ($services as $service) {
                    ?>
                        <option value="<?= $service['service'] ?>"><?= $service['service'] ?></option>
                    <?php
                    }
                    ?>
                    <option value="autre">Autre</option>
                </select>
                <span id="erreurService" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="poste">Poste <span class="obligatoire">*</span></label>
                <select name="poste" id="poste">
                    <option value="none" disabled>--Sélectionnez le poste--</option>
                    <?php foreach ($postes as $poste) {
                    ?>
                        <option value="<?= $poste['poste'] ?>"><?= $poste['poste'] ?></option>
                    <?php
                    }
                    ?>
                    <option value="autre">Autre</option>
                </select>
                <span id="erreurPoste" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="nbContrat">Nombre de contrats <span class="obligatoire">*</span></label>
                <input type="number" min="0" name="nbContrat" id="nbContrat" placeholder="Entrez le nombre de contrat" required>
                <span id="erreurNbContrat" class="erreur"></span>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev" id="prev1"><ion-icon name="chevron-back" size="large"></ion-icon>Previous</a>
                <a href="#" class="btn btn-next" id="next2">Next<ion-icon name="chevron-forward" size="large"></ion-icon></a>
            </div>
        </div>
        <div class="wrapper" id="wrapper3">
            <div class="input-group">
                <label for="dureeContrat">Durée du contrat (en mois) <span class="obligatoire">*</span></label>
                <input type="number" min="0" name="dureeContrat" id="dureeContrat" placeholder="Durée du contrat ex : 12" required>
                <span id="erreurDureeContrat" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="dateDebut">Date de prise effet <span class="obligatoire">*</span></label>
                <input type="date" name="dateDebut" id="dateDebut" required>
                <span id="erreurDateDebut" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="dateFin">Date d'échéance <span class="obligatoire">*</span></label>
                <input type="date" name="dateFin" id="dateFin" required >
                <span id="erreurDateFin" class="erreur"></span>
            </div>
            <div class="input-group">
                <label for="dossierComplet">Dossier Complet <span class="obligatoire">*</span></label>
                <select name="dossierComplet" id="dossierComplet" required>
                    <option value="oui">oui</option>
                    <option value="non" selected>non</option>
                </select>
                <span id="erreurDossierComplet" class="erreur"></span>
                <input type="hidden" name="reconductible" id="reconductible">
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev" id="prev3"><ion-icon name="chevron-back" size="large"></ion-icon>Previous</a>
                <input type="button" class="btn" id="btn-action" style="color: white;"/>
            </div>
        </div>
    </div>
    <!-- Overlay (arrière-plan semi-transparent) -->
    <div id="overlay"></div>
    <!-- Boîte de dialogue -->
    <div id="boite-confirm" class="boite">
        <p>Ce contrat est-il reconductible ?</p>
        <button type="submit" id="btn-oui" name="submit" value="Submit">Oui</button>
        <button type="submit" id="btn-non" name="submit" value="Submit">Non</button>
    </div>
</form>