<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: ./profiladmin.php");
}
if(!empty($_POST["envoie"])){
    include_once "./include/fonctions.php";
    $mail = $_POST["mail"];
    $exist = rechercheMail($mail);
    $valideprenom = verifyname($_POST["prenom"]);
    $validenom = verifyname($_POST["nom"]);
    $validemail = verifymail($_POST["mail"]);
    $validemdp = verifymdp($_POST["mdp1"]);
    $validetel = verifytelephone($_POST["tel"]);
    if(($exist == 0)&& ($_POST["mdp1"]==$_POST["mdp2"])&&($valideprenom == 1)&&($validenom == 1)&&($validemail == 1)&&($validemdp == 1)&&($validetel == 1)){
        include_once "./include/config/connexionbdd.php";
        $prenom = secu($_POST["prenom"]);
        $nom = secu($_POST["nom"]);
        $mdp = password_hash($_POST["mdp1"], PASSWORD_DEFAULT);
        $confirmMdp = password_hash($_POST["mdp2"], PASSWORD_DEFAULT);
        $tel = secu($_POST["tel"]);
        $civilite = secu($_POST["civilite"]);
        $userrole = 'admin';
        $sql ="INSERT INTO users(civilite, prenom, nom, mail, mdp, confirmationMdp, telephone,userrole)
                VALUES (:civilite, :prenom,:nom, :mail, :mdp, :confirmationMdp, :telephone,:userrole)";
        $insertion = $connexion->prepare($sql);
        $insertion->bindParam(":civilite", $civilite, PDO::PARAM_STR);
        $insertion->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $insertion->bindParam(":nom", $nom, PDO::PARAM_STR);
        $insertion->bindParam(":mail", $mail, PDO::PARAM_STR);
        $insertion->bindParam(":mdp", $mdp, PDO::PARAM_STR);
        $insertion->bindParam(":confirmationMdp", $confirmMdp, PDO::PARAM_STR);
        $insertion->bindParam(":telephone", $tel, PDO::PARAM_INT);
        // $insertion->bindParam(":photo", $nom_fichier, PDO::PARAM_STR);
        $insertion->bindParam(":userrole", $userrole, PDO::PARAM_STR);
        $insertion->execute();
        header("Location: ./connexion.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="./assets/img/logo_sun_burger_beauvais_rue_gambetta_hd.ico">
        <meta charset="UTF-8">
        <meta name="robots" content="noindex,nofollow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/styleAdmin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Inscription</title>
    </head>
    <body>
        <?php
            include "./include/header.php";
        ?>
        <main>
            <h1 class="titre-inscription">Inscription</h1>
            <!-- pour joindre des fichier on met l'attribut enctype="multipart/form-data" -->
            <form action="" method="POST" enctype="multipart/form-data">
                <select name="civilite" required>
                    <option></option>
                    <option>Mr</option>
                    <option>Mme</option>
                </select><br>
                <input type="text" placeholder="Jean" name="prenom" required pattern="^[a-zA-Z0-9 -'éàèëï]+$"> <br>
                <?php
                    if(!empty($_POST["envoie"]) && ($valideprenom != 1) ){
                        echo "<span style= 'color: red'> le prénom e doit contenir que des lettres</span><br>";
                    }
                ?>
                <input type="text" placeholder="Dupont" name="nom" required pattern="^[a-zA-Z0-9 -'éàèëï]+$"><br>
                <?php
                    if(!empty($_POST["envoie"]) && ($validenom != 1) ){
                        echo "<span style= 'color: red'> le nom ne doit contenir que des lettres</span><br>";
                    }
                ?>
                <input type="email" placeholder="jean@gmail.com" name="mail" required ><br>
                <?php
                    if(!empty($_POST["envoie"]) && ($validemail != 1) ){
                        echo "<span style= 'color: red'> l'adresse mail saisie est incorrecte.</span><br>";
                    }
                    if(!empty($_POST["envoie"]) && ($exist != 0) ){
                        echo "<span style= 'color: red'> l'adresse mail saisie est déjà utilisée par un autre utilisateur.</span><br>";
                    }
                ?>
                <input type="password" placeholder="************" name="mdp1" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$"><br>
                <input type="password" placeholder="confirmez mot de passe" name="mdp2" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$"><br>
                <?php
                    if(!empty($_POST["envoie"]) && ($validemdp != 1) ){
                        echo "<span style= 'color: red'> le mot de passe doit : <br>
                        - comporter au moins de 12 caractères. <br>
                        - Avoir au moins une lettre majuscule. <br>
                        - Avoir au moins une lettre minuscule. <br>
                        - Avoir au moins un chiffre.<br>
                        - Avoir au moins un caractère spécial.<br></span>";
                    }
                    if(!empty($_POST["envoie"]) && ($_POST["mdp1"] != $_POST["mdp2"]) ){
                        echo "<span style= 'color: red'> les mots de passes saisis sont différents</span> <br>";
                    }
                ?>
                <input type="tel" placeholder="0605010203" name="tel" required><br>
                <?php
                    if(!empty($_POST["envoie"]) && ($validetel != 1) ){
                        echo "<span style= 'color: red'> le telephone doit etre composé de 10 chiffres.</span><br>";
                    }
                    ?>
                <br>
                <input type="submit" value="Je m'inscris" name="envoie" class="btn"><br>

                <p class="text-f">Vous etes déjà inscrit, connectez-vous par <a href="./connexion.php">ici</a> </p>
            </form>
        </main>
        <?php
            // include "./includes/footer2.php";
            // include "./includes/footer.php";
        ?>
    </body>
        <script src="./assets/vendor/jquery/jquery-3.5.1.min.js"></script>
        <script src="./assets/js/script.js"></script>
</html>