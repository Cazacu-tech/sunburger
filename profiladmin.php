<?php
session_start();
if(!isset($_SESSION["mail"])){
    header("Location: ./connexion.php");
}
if(isset($_SESSION["userrole"]) && ($_SESSION["userrole"] != 'admin')){
    header("Location: ./index.php");
}
?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="shortcut icon" href="./asset/img/logo_sun_burger_beauvais_rue_gambetta_hd.ico">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="./assets/css/styleAdmin.css">
        <title>Profil Administrateur</title>
    </head>
    <body>
        <?php
        include "./include/header.php";
        ?>
        <h1 class="titre-profilAdmin">PROFIL ADMINISTRATEUR</h1>
        <div class="profil">
            <!-- <div class="pgauche">
                <ul>
                    <li><a href="./menuAdmin.php">ajout menus</a></li>
                    <li><a href="./infoAdmin.php">ajout infos</a></li>
                </ul>
            </div> -->
            <div class="pdroite">
                <?php
                    echo "<h2>Bienvenue sur votre profil <br>". $_SESSION["civilite"]." ". $_SESSION["prenom"]." ". $_SESSION["nom"]."</h2>";
                    echo "<h3>Mes infos : </h3>";
                    echo "<p><b>Mail : </b>".$_SESSION["mail"] ."</p>";
                    echo "<p><b>Telephone : </b>0".$_SESSION["telephone"] ."</p>";

                    ?>
            </div>
        </div>
        <script src="./assets/vendor/jquery/jquery-3.5.1.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>