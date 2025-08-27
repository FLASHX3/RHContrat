export function init() {
    console.log("Page enregistrer prête !");

    const prevBtns = document.querySelectorAll(".btn-prev");
    const nextBtns = document.querySelectorAll(".btn-next");
    const wrapperList = document.querySelector("#wrapper-list");
    const progress = document.querySelector("#progress");
    const progressSteps = document.querySelectorAll(".progress-step");
    const inputDuree = document.querySelector("#dureeContrat");
    const inputDateDebut = document.querySelector("#dateDebut");
    const inputDateFin = document.querySelector("#dateFin");
    const spanErreurDateFin = document.querySelector("#erreurDateFin");
    const btn_action = document.querySelector("#btn-action");
    var formContrat = document.querySelector('#form');
    const boite = document.querySelector('#boite-confirm');
    const overlay = document.querySelector('#overlay');
    const btnOui = document.querySelector('#btn-oui');
    const btnNon = document.querySelector('#btn-non');
    let formulaireASoumettre = null;

    let translate = 0;
    let formStepsNum = 0;

    const STEP_WIDTH = 376;
    const MAX_TRANSLATE = -1128;

    function surligne(champ, erreur) {
        champ.style.borderColor = erreur ? "red" : "";
        return erreur;
    }

    const post = document.querySelector('.page-enregistrer #poste');
    const entite = document.querySelector('.page-enregistrer  #entite');
    const service = document.querySelector('.page-enregistrer #service');

    post.addEventListener('change', () => {
        autre(post);
    });
    service.addEventListener('change', () => {
        autre(service);
    });
    entite.addEventListener('change', () => {
        autre(entite);
    });

    function autre(select) {
        if (select.value == "autre") {
            const input_groupe = select.parentElement;
            const id = select.id;
            const name = select.name;
            const erreurspan = select.nextElementSibling;
            select.remove();
            const input = document.createElement('input');
            input.type = "text";
            input.id = 'new' + id;
            input.name = 'new' + name;
            input.placeholder = "Saisissez " + id;
            input.addEventListener('blur', function () {
                verifChampVide(this, '#' + erreurspan.id);
            });
            input_groupe.insertBefore(input, erreurspan);
            input.focus();
            console.log("new " + id);
        }
    }

    function verifChampVide(champ, idChampErreur) {
        const champErreur = document.querySelector(idChampErreur);
        if (champ.value == "") {
            surligne(champ, true);
            if (champErreur) {
                champErreur.innerHTML = `Veuillez remplir ${champ.id}`;
                console.log(`Veuillez remplir ${champ.id}`);
            }
            return false;
        } else {
            surligne(champ, false);
            if (champErreur) {
                champErreur.innerHTML = "";
                console.log("Le champ " + champ.id + " est correcte!");
            }
            return true;
        }
    }

    function verifNom(nom, idChampErreur) {
        var regex = /^[a-zA-Zéèêâôï -]{3,}$/;
        const champErreur = document.querySelector(idChampErreur);
        if (nom.value == "") {
            surligne(nom, true);
            champErreur.innerHTML = `Veuillez entrer un ${nom.id} valide!`;
            console.log(`Veuillez entrez un ${nom.id} valide!`);
            return false;
        } else {
            if (!regex.test(nom.value)) {
                surligne(nom, true);
                champErreur.innerHTML = `${nom.id} invalide!`;
                console.log(`${nom.id} incorrecte`);
                return false;
            } else {
                surligne(nom, false);
                champErreur.innerHTML = "";
                console.log(`${nom.id} correcte`);
                return true;
            }
        }
    }

    function updateDateFinAuto() {
        const duree = parseInt(inputDuree.value);
        const debut = inputDateDebut.value;

        if (!isNaN(duree) && debut) {
            const dateDebut = new Date(debut);
            const dateFinAuto = new Date(dateDebut);
            dateFinAuto.setMonth(dateFinAuto.getMonth() + duree);
            dateFinAuto.setDate(dateFinAuto.getDate() - 1); // ➖ 1 jour

            const dateFinFormat = dateFinAuto.toISOString().split("T")[0];

            inputDateFin.min = debut;
            inputDateFin.value = dateFinFormat;

            spanErreurDateFin.innerHTML = "";
            surligne(inputDateFin, false);
        }
    }

    inputDuree.addEventListener("input", updateDateFinAuto);
    inputDateDebut.addEventListener("blur", updateDateFinAuto);

    inputDateFin.addEventListener("blur", () => {
        verifDatesContrat(inputDateDebut, inputDateFin, "#erreurDateFin");
    });

    function verifDatesContrat(dateDebutEl, dateFinEl, idErreur) {
        const dateDebut = dateDebutEl.value;
        const dateFin = dateFinEl.value;
        const duree = parseInt(inputDuree.value);
        const erreurSpan = document.querySelector(idErreur);

        if (dateDebut && dateFin && !isNaN(duree)) {
            const dDebut = new Date(dateDebut);
            const dFin = new Date(dateFin);
            const dateFinAttend = new Date(dDebut);
            dateFinAttend.setMonth(dateFinAttend.getMonth() + duree);
            dateFinAttend.setDate(dateFinAttend.getDate() - 1); // Soustrait 1 jour

            const diffMs = Math.abs(dFin - dateFinAttend);
            const diffJours = diffMs / (1000 * 60 * 60 * 24);

            if (diffJours > 7) {
                erreurSpan.innerHTML = "L'écart entre la date de fin et la durée indiquée dépasse 1 semaine.";
                surligne(dateFinEl, true);
                return false;
            } else {
                erreurSpan.innerHTML = "";
                surligne(dateFinEl, false);
                return true;
            }
        }
        return false;
    }

    const numbers = document.querySelectorAll('.page-enregistrer input[type="number"]');
    numbers.forEach((number) => {
        number.addEventListener('input', function () {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });

    function validateFields(wrapper) {
        let hasError = false;
        const inputs = wrapper.querySelectorAll('input, select');

        inputs.forEach((el) => {
            const idErreur = `#erreur${capitalize(el.id)}`;
            if (el.id === "nom" || el.id === "prenom") {
                if (!verifNom(el, idErreur)) {
                    hasError = true;
                }
            } else {
                if (!verifChampVide(el, idErreur)) {
                    hasError = true;
                }
            }
        });

        return !hasError;
    }

    btn_action.addEventListener('click', () => {
        formulaireASoumettre = formContrat; // Stocke le formulaire
        boite.style.display = 'block';
        overlay.style.display = 'block';
    });

    btnOui.addEventListener('click', () => {
        boite.style.display = 'none';
        overlay.style.display = 'none';
        document.querySelector("#reconductible").value = "oui";
        if (formulaireASoumettre) {
            formulaireASoumettre.submit();
        }
    });

    btnNon.addEventListener('click', () => {
        boite.style.display = 'none';
        overlay.style.display = 'none';
        document.querySelector("#reconductible").value = "non";
        if (formulaireASoumettre) {
            formulaireASoumettre.submit();
        }
    });

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const stepNumber = btn.id.replace("next", "");
            const wrapper = document.querySelector(`.page-enregistrer form #wrapper${stepNumber}`);
            if (wrapper && validateFields(wrapper)) {
                translate = Math.max(translate - STEP_WIDTH, MAX_TRANSLATE);
                wrapperList.style.transform = `translateX(${translate}px)`;
                formStepsNum++;
                updateProgressbar();
            }
        });
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            translate = Math.min(translate + STEP_WIDTH, 0);
            wrapperList.style.transform = `translateX(${translate}px)`;
            formStepsNum--;
            updateProgressbar();
        });
    });

    function updateProgressbar() {
        progressSteps.forEach((step, index) => {
            step.classList.toggle("progress-step-active", index <= formStepsNum);
        });

        const totalSteps = progressSteps.length - 1;
        progress.style.width = `${(formStepsNum / totalSteps) * 100}%`;
    }

    document.querySelectorAll('.page-enregistrer input').forEach(input => {
        input.addEventListener('blur', () => {
            const idErreur = `#erreur${capitalize(input.id)}`;
            if (input.id === 'nom' || input.id === 'prenom') {
                verifNom(input, idErreur);
            } else {
                verifChampVide(input, idErreur);
            }
        });
    });

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
}
