<?php
    if(!isset($_POST['submit'])){
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RHContrat</title>
    <link rel="shortcut icon" href="img/logo_sci_sotradic.png" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <div id = "container">
        <form action = "index.php" method = "post">
            <div class = "entete">
                <h4>Welcome to</h4>
                <h1>RHContrApp</h1>
            </div>
            <div class = "form">
                <span class="mdi-light--account"></span>
                <input type = "text" name = "login" placeholder = "Login" required>
                <span id ="error_login" class ="msg_error"></span>
                <span class="formkit--password"></span>
                <input type = "password" name = "password" placeholder = "Password" required>
                <span id ="error_password" class ="msg_error"></span>
                <button type = "submit" value="submit" name="submit">Sing In</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    }else{
        require_once('include/login.php');

        $login = strip_tags(htmlspecialchars($_POST['login']));
        $password = strip_tags(htmlspecialchars($_POST['password']));

        if (!preg_match('#^[a-zA-Z_]{6,25}$#', $login)) {
            header('Location: index.php?err=login wrong!');
        }
        if (!preg_match('#^[a-zA-Z0-9.-_*@&$]{9}$#', $password)) {
            header('Location: index.php?err=password wrong!');
        }

        try {
            $bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $passwordadmin);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // $password = hash('sha256', $password);
            // $password = substr($password, 0, 9);
            // echo $password;
            // exit;

            $requete = $bdd->prepare('SELECT * FROM users WHERE login=? AND password=?');
            $requete->execute(array($login, $password));
            $userexist = $requete->rowCount();

            if ($userexist == 1)        #s'il existe, on ouvre sa session
            {
                $userinfo = $requete->fetch();

                session_start();

                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['nom'] = $userinfo['name'];
                $_SESSION['login'] = $userinfo['login'];
                $_SESSION['password'] = $userinfo['password'];
                $_SESSION['type'] = $userinfo['type'];

                $requete->closeCursor();

                //setlog($_SESSION['id'], 1, "Connexion sur la plateforme!");
                header('location: dashboard/index.php?onglet=enregistrer');
                exit;
            } else {
                $requete->closeCursor();
                header('Location: index.php?err=identifiants inexitants!');
                exit;
            }
        } catch (PDOException $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
?>