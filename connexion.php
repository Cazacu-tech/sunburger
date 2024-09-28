<?php
    session_start();
    if (isset($_SESSION["mail"]) ) {
        header("Location: ./profiladmin.php");
    }
    if (!empty($_POST["envoi"])) {
        # code...
        include "./include/fonctions.php";
        $mail = $_POST["mail"];
        $mdp = $_POST["mdp"];
        $validemdp = 1;
        $valideMail = verifymail($mail);
        $existe = rechercheMail($mail);
        if (($existe != 0) && ($valideMail == 1)) {
            # code...
            include_once "./include/config/connexionbdd.php";
            $sql = "SELECT * FROM users WHERE mail = '$mail'";
            $requete = $connexion->query($sql);
            $user = $requete->fetch();
            if (password_verify($mdp, $user["mdp"])) {
                # code...
                $_SESSION["id"] = $user["id"];
                $_SESSION["civilite"] = $user["civilite"];
                $_SESSION["prenom"] = $user["prenom"];
                $_SESSION["nom"] = $user["nom"];
                $_SESSION["mail"] = $user["mail"];
                $_SESSION["telephone"] = $user["telephone"];
                $_SESSION["dateinscription"] = $user["dateinscription"];
                if($user["userrole"]== 'admin') {
                    header("Location: ./profiladmin.php");
                }
            }
            else {
                $e = "<p>identifiant ou mot de passe faux</p>";
                $validemdp = 0;
            }
        }
        else {
            $e = "<p> Votre profil n'existe pas </p>";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <link rel="shortcut icon" href="./assets/img/logo_sun_burger_beauvais_rue_gambetta_hd.ico">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow" />
        <link rel="stylesheet" href="./assets/css/styleAdmin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
            integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
            crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <!-- <link rel="stylesheet" href="./asset/vendor/bootstrap-4.5.2-dist/css/bootstrap.min.css"/> -->
        <title>Connexion</title>
    </head>
    <body>
        <?php
        include "./include/header.php";
        ?>
        <div class="h-500">
            <h1 class="titre-connexion">connexion</h1>
            <form action="" method="POST">
                <input type="email" placeholder="mail" name="mail" required> <br>
                <input type="password" placeholder="************" name="mdp" required> <br>
                <?php
                    if(!empty($_POST["envoi"]) && ($valideMail == false)) {
                        echo $e;
                    }
                    if(!empty($_POST["envoi"]) && ($existe == 0)) {
                        echo $e;
                    }
                    if (!empty($_POST["envoi"]) && ($validemdp == 0)) {
                        echo $e;
                    }
                ?>
                <input type="submit" value="connecter" name="envoi" class="btn-contact">
            </form>
            <p class="text-f">Tes pas encore inscrit, inscrit toi en cliquant<a href="./inscription.php"> Ici</a></p>
        </div>
        <script src="./assets/vendor/jquery/jquery-3.5.1.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>
</html>