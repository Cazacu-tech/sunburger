<?php
session_start();
if (!isset ($_SESSION["mail"])) {
    header("Location: ./connexion.php");
     exit(""); // Arrête l'exécution du script après la redirection
}
if (isset($_SESSION["userrole"]) && ($_SESSION["userrole"] != 'admin')) {
    header("Location: ./index.php");
     exit(""); // Arrête l'exécution du script après la redirection
}
if (!empty ($_POST["annuler"])) {
    header("Location: ./menuAdmin.php");
     exit(""); // Arrête l'exécution du script après la redirection
}

if (!empty ($_POST["envoie"])) {
    include_once "./include/fonctions.php";
    $valideNom = verifyname($_POST["nom"]);
    if ($valideNom == 1) {
        include_once "./include/config/connexionbdd.php";
        $nom = secu($_POST["nom"]);
        if (isset ($_FILES["fichier"]) && ($_FILES["fichier"]['error'] == 0)) {
            //on va creer un dossier
            $dossier = 'doc/';
            mkdir($dossier); //creation du dossier
            //On recupere le nom temporaire sur le serveur
            $tmp_name = $_FILES['fichier']['tmp_name'];
            //On verifie la taille du fichier
            if ($_FILES["fichier"]['size'] > 10000000) {
                die ("fichier trop volumineux <br>");
            }
            //On verifie si le fichier est bien uploadé
            if (!is_uploaded_file($tmp_name)) {
                die ("fichier introuvable<br>");
            }
            //On recupere le chemin du fichier
            $infos_fichier = pathinfo($_FILES['fichier']['name']);
            //ON recupere l'extension du fichier
            $extension_upload = $infos_fichier['extension'];
            $extension_upload = strtolower($extension_upload);
            $extensions_autorisees = ['png', 'jpeg', 'jpg', 'WEBP', 'PNG', 'Chrome HTML Document',];
            if (!in_array($extension_upload, $extensions_autorisees)) {
                die ("Le format de fichier n'est pas autorisée <br>");
            }

            $nom_fichier = $_FILES['fichier']['name'];
            $infos_fichier = pathinfo($nom_fichier);
            $extension_upload = $infos_fichier['extension'];
            $extension_upload = strtolower($extension_upload);

            $sql1 = "SELECT photo FROM menus";
            $requete = $connexion->query($sql1);
            $users = $requete->fetchAll();
            $id = count($users) + 1;
            $nom_fichier .= $id;
            $nom_fichier = $infos_fichier['filename'] . $id . "." . $extension_upload;

            if (move_uploaded_file($tmp_name, $dossier . $nom_fichier)) {
                echo 'le fichier a été bien téléversé <br>';
            } else {
                echo "le fichier n'a pas été téléversé <br>";
            }
        }
        $sql = "INSERT INTO menus (nom, photo) VALUES (:nom, :photo)";
        $insertion = $connexion->prepare($sql);
        $insertion->bindParam(":nom", $nom, PDO::PARAM_STR);
        $insertion->bindParam(":photo", $nom_fichier, PDO::PARAM_STR);
        $insertion->execute();
        header("Location: ./menuAdmin.php");
    }
}
if (!empty ($_POST["valider"])) {
    include_once "./include/fonctions.php";

    // Vérification des données du formulaire
    $valideId = verifyId($_POST["idmenu"]);
    $valideNomC = verifyname($_POST["nomC"]);

    if (($valideId == 1) && ($valideNomC == 1)) {
        include_once "./include/config/connexionbdd.php";

        // Récupérer les données du formulaire
        $idmenu = secu($_POST["idmenu"]);
        $nomC = secu($_POST["nomC"]);
        $nom_fichier = "";

        // Vérifier si une nouvelle photo est téléchargée
        if (isset ($_FILES["fichier"]) && ($_FILES["fichier"]["error"] == 0)) {
            // Répertoire de destination pour les photos
            $dossier = 'doc/';

            // Traitement de la nouvelle photo
            $tmp_name = $_FILES['fichier']['tmp_name'];
            // Assurez-vous que la taille de la photo est correcte
            if ($_FILES["fichier"]['size'] > 10000000) {
                die ("Fichier trop volumineux <br>");
            }
            // Assurez-vous que le fichier est correctement téléchargé
            if (!is_uploaded_file($tmp_name)) {
                die ("Fichier introuvable<br>");
            }

            // Obtenez les informations sur le fichier téléchargé
            $infos_fichier = pathinfo($_FILES['fichier']['name']);
            $extension_upload = strtolower($infos_fichier['extension']);
            $extensions_autorisees = ['png', 'jpeg', 'jpg', 'webp', 'PNG'];

            // Vérifiez si l'extension est autorisée
            if (!in_array($extension_upload, $extensions_autorisees)) {
                die ("Le format de fichier n'est pas autorisé <br>");
            }

            // Générez un nom de fichier unique
            $nom_fichier = $infos_fichier['filename'] . uniqid() . "." . $extension_upload;

            // Déplacez la nouvelle photo vers le dossier de destination
            if (move_uploaded_file($tmp_name, $dossier . $nom_fichier)) {
                echo 'Le fichier a été bien téléversé <br>';
            } else {
                echo "Le fichier n'a pas été téléversé <br>";
            }
        }

        // Mettre à jour les informations du menu dans la base de données
        $sql = "UPDATE menus SET nom = :nomC, photo = :photo WHERE idmenu = :idmenu";
        $insertion = $connexion->prepare($sql);
        $insertion->bindParam(":idmenu", $idmenu, PDO::PARAM_INT);
        $insertion->bindParam(":nomC", $nomC, PDO::PARAM_STR);
        $insertion->bindParam(":photo", $nom_fichier, PDO::PARAM_STR);
        $insertion->execute();

        // Redirection vers la page d'administration des menus
        header("Location: ./menuAdmin.php");
    }
}

if (!empty ($_POST["supprim"])) {
    include_once "./include/config/connexionbdd.php";
    include_once "./include/fonctions.php";
    $idmenu = secu($_POST["idmenu"]);
    $sql = "DELETE FROM menus WHERE idmenu = :idmenu";
    $insertion = $connexion->prepare($sql);
    $insertion->bindParam(":idmenu", $idmenu, PDO::PARAM_INT);
    $insertion->execute();
    header("Location: ./menuAdmin.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="./assets/img/logo_sun_burger_beauvais_rue_gambetta_hd.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow" />
    <link rel="stylesheet" href="./assets/css/styleAdmin.css">
    <link rel="stylesheet" href="./assets/js/dist-deux/jquery.fancybox.min.css">
    <link rel="stylesheet" href="./assets/js/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Menu admin</title>
</head>

<body>
    <?php
    include "./include/header.php";
    ?>
    <main>
        <h1 class="titre-admin">Page ajout menu</h1>
        <!-- pour joindre des fichier on met l'attribut enctype="multipart/form-data" -->
        <form action="" method="POST" enctype="multipart/form-data">
            <p>Entrez le nom du menu à ajouter</p> <br>
            <input type="text" placeholder="nom du menu" name="nom" required pattern="^[a-zA-Z0-9 -'éàèëï]+$" maxlength="20"> <br>
            <?php
            if (!empty ($_POST["envoie"]) && ($valideNom != 1)) {
                echo "<span style= 'color: red'> le nom ne doit contenir que des lettres</span><br>";
            }
            ?>
            <input type="file" name="fichier" required> <br>
            <input type="submit" value="Ajouter" name="envoie" class="btn">
            <input type="submit" value="Annuler" name="annuler">
        </form>
        <?php
        // include_once "./include/config/connexionbdd.php";
        // $sql = "SELECT * FROM menus ORDER BY nom";
        // $requete = $connexion->query($sql);
        // // fetch recupére juste la premeiere occurence de la requete
        // // fetchAll recupere toutes les occurences
        // $client = $requete->fetchAll(PDO::FETCH_ASSOC);
        // // print_r($client);
        // echo "<div class='contenu'>";
        // foreach($client as $clien){
        //     echo"<div>";
        //     foreach($clien as $key => $value){
        //         // echo "".$value."<br>";
        //             echo"<p>".$key."</p> ";
        //             echo"<p>".$value."</p> ";
        //             echo '<img class="img-fluid" src="view.php?image=doc/'.$value.'&amp;mode=resize&amp;size=200x250" alt="">';
        //     }
        //     echo"</div>";
        //     // echo "<br>";
        //     // print_r($value);
        // }
        // echo "</div>";
        // foreach($connexion->query($sql) as $infos) {
        //     echo "<p style='text-align:center;'>";
        //         echo $infos['nom'];
        //     echo "</p>";
        //     echo "<div class='contenu'>";
        //         echo '<img class="img-fluid" src="view.php?image=doc/'.$infos['photo'].'&amp;mode=resize&amp;size=200x250" alt="">';
        //     echo "</div>";
        //     }
        ?>
        <?php
        // include_once "./include/config/connexionbdd.php";
        // $sql = "SELECT * FROM menus ORDER BY idmenu";
        // $insertion = $connexion->prepare($sql);
        // // $insertion->bindParam(":idmenu", $idmenu, PDO::PARAM_STR);
        // $insertion->execute();
        // $requete = $connexion->query($sql);
        // // fetchAll récupère toutes les lignes sous forme de tableau associatif
        // // $menus = $insertion->fetchAll();
        // $menus = $requete->fetchAll();
        // echo "<div class='contenu'>";
        //     // Parcours du tableau et affichage des noms et chemins de photo
        //     foreach ($menus as $menu) {
        //         echo "<div>";
        //         echo "<p class='nom-menu'>Numéro : " . $menu['idmenu'] . "</p><br>";
        //         echo "<p class='nom-menu'>Nom : " . $menu['nom'] . "</p><br>";
        //         echo "<a href='./doc/" . $menu['photo'] . " 'rel='follow' data-fancybox='gallery' data-caption='Menu #1'>";
        //         echo '<img width="200px" height="300px" class="img-fluid" src="doc/' . $menu['photo'] . '" alt="">';
        //         echo "</a>";
        //         echo "<br>";
        //         echo "</div>";
        //     }
        // echo "</div>";
        ?>
        <?php
        include_once "./include/config/connexionbdd.php";
        $sql = "SELECT * FROM menus ORDER BY idmenu";
        $insertion = $connexion->prepare($sql);
        // $insertion->bindParam(":idmenu", $idmenu, PDO::PARAM_STR);
        $insertion->execute();
        $requete = $connexion->query($sql);
        // fetchAll récupère toutes les lignes sous forme de tableau associatif
        // $menus = $insertion->fetchAll();
        $affMenus = $requete->fetchAll();
        echo "<ul class='cards'>";
        $cont = 0;
        foreach ($affMenus as $menu) {
            echo " <li>";
                echo "<a href='' class='card'>";
                    echo '<img src="doc/' . $menu['photo'] . '" class="card__image" alt="" />';
                    echo "<div class='card__overlay'>";
                        echo "<div class='card__header'>";
                            echo '<img class="card__thumb" src="doc/' . $menu['photo'] . '" alt="" />';
                            echo " <div class='card__header-text'>";
                                    echo "<p class='nom-menu'>Numéro de la photo : " . $menu['idmenu'] . "</p><br>";
                                    echo "<p class='nom-menu'>Nom : " . $menu['nom'] . "</p><br>";
                            echo " </div>";
                        echo "</div>";
                        echo '<div class="card__description">';
                                echo '<div class="bSuppModiff">';
                                    echo '<button value="Modifier" class="modifier" id="modifier-'.$cont.'" name="" action="affMenu('.$cont.')">malaku</button>';
                                    echo '<button value="Supprimer" class="supprimer" name=""></button>';
                                echo '</div>';
                        echo '</div>';
                    echo "</div>";
                    echo "</a>";
                    echo "</li>";
                    $cont++;
        }
            echo "</ul>";
            echo '<div class="fullscreenmenu" id="fullscreenmenu">';
                // echo "malaku";
                echo '<ul>
                        <li>
                            <a href="#">About</a>
                        </li>

                        <li>
                            <a href="#">Blog</a>
                        </li>

                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>';
            echo "</div>";
        ?>
        <!-- <ul class="cards">
        <li>
            <a href="" class="card">
                <img src="https://i.imgur.com/oYiTqum.jpg" class="card__image" alt="" />
                <div class="card__overlay">
                    <div class="card__header">
                        <svg class="card__arc" xmlns="http://www.w3.org/2000/svg"><path /></svg>                     
                        <img class="card__thumb" src="https://i.imgur.com/7D7I6dI.png" alt="" />
                        <div class="card__header-text">
                            <h3 class="card__title">Jessica Parker</h3>
                        <span class="card__tagline">Lorem ipsum dolor sit amet consectetur</span>            
                        <span class="card__status">1 hour ago</span>
                    </div>
                </div>
                <p class="card__description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, blanditiis?</p>
            </div>
            </a>
        </li>
        <li>
            <a href="" class="card">
                    <img src="https://i.imgur.com/2DhmtJ4.jpg" class="card__image" alt="" />
                    <div class="card__overlay">
                        <div class="card__header">
                            <svg class="card__arc" xmlns="http://www.w3.org/2000/svg"><path /></svg>
                            <img class="card__thumb" src="https://i.imgur.com/sjLMNDM.png" alt="" />
                        <div class="card__header-text">
                            <h3 class="card__title">kim Cattrall</h3>
                            <span class="card__status">3 hours ago</span>
                        </div>
                    </div>
                    <p class="card__description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, blanditiis?</p>
                </div>
            </a>
        </li>
</ul> -->
<h2>modifier un des menus :</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="number" placeholder="mettre le numéro de la photo actuel" name="idmenu" required pattern="^\d{1,2}$"><br>
            <?php
                if (!empty ($_POST["valider"]) && ($valideId != 1) && ($valideNomC != 1)) {
                    echo "<span style='color: red'>L'identifiant n'existe pas</span><br>";
                }
            // var_dump($_SESSION[""]);
            ?>
            <input type="text" placeholder="ajouter un nouveau nom" name="nomC" required pattern="^[a-zA-Z0-9 -'éàèëï]+$" maxlength="20"> <br>
            <?php

            if (!empty ($_POST["valider"]) && ($valideId != 1) && ($valideNomC != 1)) {
                echo "<span style='color: red'>Le nom de la photo à modifier n'est pas correct</span><br>";
            }
            // var_dump($_SESSION[""]);
            ?>
            <input type="file" name="fichier" required><br>
            <?php
            // Afficher le champ pour l'ancienne photo seulement si elle existe
            // if (!empty($_POST['ancienne_photo'])) {
            //     echo '<label>Ancienne photo :</label>';
            //     echo '<img src="doc/' .$_POST['ancienne_photo']. '" alt="Ancienne photo"><br>';
            //     echo '<input type="text" name="ancienne_photo" value="' .$_POST['ancienne_photo']. '" readonly>';
            // }
            // if (isset($_POST['ancienne_photo'])) {
            //     echo '<label>Ancienne photo :</label>';
            //     echo '<img src="doc/' . htmlspecialchars($_POST['ancienne_photo']) . '" alt="Ancienne photo"><br>';
            //     echo '<input type="text" name="ancienne_photo" value="' . htmlspecialchars($_POST['ancienne_photo']) . '" readonly>';
            // }
            // print_r($_POST['ancienne_photo']);
            ?>
            <input type="submit" value="Valider" name="valider">
            <input type="submit" value="Annuler" name="annuler">
        </form>
        <h2>Supprimer un menus :</h2>
        <form id="formSuppression" action="" method="POST">
            <p>Entrez le numéro de la photo du menu à supprimer</p> <br>
            <input type="number" placeholder="mettre le numéro de la photo supprimer" name="idmenu" required pattern=""><br>
            <?php
                if (!empty ($_POST["supprim"]) && ($valideId != 1)) {
                    echo "<span style= 'color: red'> le champs doit contenir que des numéros</span><br>";
                }
            ?>
            <input type="submit" value="Valider" name="supprim">
        </form>
        <!--  -->
    </main>
    <script src="./assets/vendor/jquery/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/dist-deux/jquery.fancybox.min.js"></script>
    <script src="./assets/js/dist/aos.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>