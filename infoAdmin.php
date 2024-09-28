<?php
session_start();
if(!isset($_SESSION["mail"])){
    header("Location: ./connexion.php");
}
if(isset($_SESSION["userrole"]) && ($_SESSION["userrole"] != 'admin')){
    header("Location: ./index.php");
}
if(!empty($_POST["annuler"])){
    header("Location: ./infoAdmin.php");
}
if(!empty($_POST["envoie"])){
    include_once "./include/fonctions.php";
    $validenom = verifytext($_POST["nom"]);
    if($validenom == 1){
        include_once "./include/config/connexionbdd.php";
        $nom = secu($_POST["nom"]);
        if(isset($_FILES["fichier"])&& ($_FILES["fichier"]['error']== 0)){
            //on va creer un dossier
            $dossier = 'doc/';
            mkdir($dossier); //creation du dossier
            //On recupere le nom temporaire sur le serveur
            $tmp_name = $_FILES['fichier']['tmp_name'];
            //On verifie la taille du fichier
            if($_FILES["fichier"]['size']>10000000){
                die("fichier trop volumineux <br>");
            }
            //On verifie si le fichier est bien uploadé
            if(!is_uploaded_file($tmp_name)){
                die("fichier introuvable<br>");
            }
            //On recupere le chemin du fichier
            $infos_fichier = pathinfo($_FILES['fichier']['name']);
            //ON recupere l'extension du fichier
            $extension_upload = $infos_fichier['extension'];
            $extension_upload = strtolower($extension_upload);
            $extensions_autorisees = ['png', 'jpeg', 'jpg','webp','PNG','JPG'];
            if(!in_array($extension_upload, $extensions_autorisees)){
                die("Le format de fichier n'est pas autorisée <br>");
            }
            $nom_fichier = $_FILES['fichier']['name'];
            $sql1 = "SELECT * FROM infos";
            $requete = $connexion->query($sql1);
            $users = $requete->fetchAll();
            $id = count($users)+1;
            $nom_fichier .= $id;
            // $nom_fichier .= $extension_upload;
            $nom_fichier = $infos_fichier['filename'] .$id."." . $extension_upload;
            if(move_uploaded_file($tmp_name, $dossier.$nom_fichier)){
                echo 'le fichier a été bien téléversé <br>';
            }else{
                echo "le fichier n'a pas été téléversé <br>";
            }
        }
        $sql = "INSERT INTO infos(nom, photo)VALUES(:nom,:photo)";
        $insertion = $connexion->prepare($sql);
        $insertion->bindParam(":nom", $nom, PDO::PARAM_STR);
        $insertion->bindParam(":photo", $nom_fichier, PDO::PARAM_STR);
        $insertion->execute();
        header("Location: ./infoAdmin.php");
        // var_dump($_FILES);
    }
}
if (!empty($_POST["valider"])) {
    include_once "./include/fonctions.php";
    // $validenom = verifytext($_POST["nom"]);
    // $validenomC = verifytext($_POST["nomC"]);
    $valideId = verifyId($_POST["idInfo"]);
    $valideNomC = verifytext($_POST["nomC"]);
    if (($valideId == 1) && ($valideNomC == 1)) {
        include_once "./include/config/connexionbdd.php";
        // $nom = secu($_POST["nom"]);
        // $nomC = secu($_POST["nomC"]);
        $idInfo = secu($_POST["idInfo"]);
        $nomC = secu($_POST["nomC"]);
        $nom_fichier = "";

        if (isset($_FILES["fichier"]) && ($_FILES["fichier"]["error"] == 0)) {
            // Répertoire de destination
            $dossier = 'doc/';

            $tmp_name = $_FILES['fichier']['tmp_name'];

            if ($_FILES["fichier"]['size'] > 10000000) {
                die("Fichier trop volumineux <br>");
            }

            if (!is_uploaded_file($tmp_name)) {
                die("Fichier introuvable<br>");
            }

            $infos_fichier = pathinfo($_FILES['fichier']['name']);
            $extension_upload = $infos_fichier['extension'];
            $extension_upload = strtolower($extension_upload);
            $extensions_autorisees = ['png', 'jpeg', 'jpg', 'webp','PNG','JPG'];

            if (!in_array($extension_upload, $extensions_autorisees)) {
                die("Le format de fichier n'est pas autorisé <br>");
            }

            $nom_fichier = $_FILES['fichier']['name'];

            // Charger la nouvelle photo
            if (move_uploaded_file($tmp_name, $dossier . $nom_fichier)) {
                echo 'Le fichier a été bien téléversé <br>';

                // Supprimer l'ancienne photo s'il existe
                if (!empty($_POST['ancienne_photo'])) {
                    $ancienne_photo = $_POST['ancienne_photo'];
                    unlink($dossier . $ancienne_photo);
                    echo 'L\'ancienne photo a été supprimée <br>';
                }
            } else {
                echo "Le fichier n'a pas été téléversé <br>";
            }
        }

        $sql = "UPDATE infos SET nom = :nomC, photo = :photo WHERE idInfo = :idinfo";
        $insertion = $connexion->prepare($sql);
        // $insertion->bindParam(":nomC", $nomC, PDO::PARAM_STR);
        // $insertion->bindParam(":photo", $nom_fichier, PDO::PARAM_STR);
        // $insertion->bindParam(":nom", $nom, PDO::PARAM_STR);
        $insertion->bindParam(":idinfo", $idInfo, PDO::PARAM_INT);
        $insertion->bindParam(":nomC", $nomC, PDO::PARAM_STR);
        $insertion->bindParam(":photo", $nom_fichier, PDO::PARAM_STR);
        $insertion->execute();

        // Rediriger vers une page différente ou afficher un message de réussite ici
        header("Location: ./infoAdmin.php");
        exit();
    }
}
// if(!empty($_POST["supp"])){
//     include_once "./include/fonctions.php";
//     include_once "./include/config/connexionbdd.php";
//     $nom = secu($_POST["nom"]);
//     $sql = "DELETE FROM infos WHERE nom = :nom";
//     $insertion = $connexion->prepare($sql);
//     $insertion->bindParam(":nom", $nom, PDO::PARAM_STR);
//     $insertion->execute();
//     header("Location: ./infoAdmin.php");
// }
if (!empty ($_POST["supp"])) {
    include_once "./include/config/connexionbdd.php";
    include_once "./include/fonctions.php";
    $idInfo = secu($_POST["idinfo"]);
    $sql = "DELETE FROM infos WHERE idInfo = :idinfo";
    $insertion = $connexion->prepare($sql);
    $insertion->bindParam(":idinfo", $idInfo, PDO::PARAM_INT);
    $insertion->execute();
    header("Location: ./infoAdmin.php");
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Infos admin</title>
    </head>
    <body>
        <?php
            include "./include/header.php";
        ?>
        <main>
            <h1 class="titre-admin">Ajouter vos infos</h1>
            <!-- pour joindre des fichier on met l'attribut enctype="multipart/form-data" -->
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" placeholder="nom de l'infos" name="nom" required><br>
                <?php
                    if(!empty($_POST["envoie"]) && ($validenom != 1) ){
                        echo "<span style= 'color: red'> le nom ne doit contenir que des lettres</span><br>";
                    }
                ?>
                <input type="file" name="fichier" required><br>
                <input type="submit" value="Ajouter" name="envoie" class="btn">
                <input type="submit" value="Annuler" name="annuler">
            </form>
            <h2>Les Infos qui sont affiché sur le site web :</h2>
            <?php
                include_once "./include/config/connexionbdd.php";
                $sql = "SELECT * FROM infos";
                // echo "<div class='contenu'>";
                //         foreach($connexion->query($sql) as $infos) {
                //             foreach($infos as $cle => $valeur) {
                //                 echo "<div>";
                //                     echo '<img class="img-fluid" src="view.php?image=doc/'.$valeur.'&amp;mode=rotate&amp;degrees=180" height="200px" width="250px" alt="">';
                //                     echo "<p>".$cle." : ".$valeur."</p>";
                //                 echo "</div>";
                //             }
                //         }
                // echo "</div>";
                echo "<div class='contenu'>";

                foreach ($connexion->query($sql) as $infos) {
                    echo "<div>";
                    foreach ($infos as $cle => $valeur) {
                        // Vérifier si la clé est 'nom', 'photo' ou 'id' pour les extraire
                        if ($cle === 'nom' || $cle === 'photo' || $cle === 'idinfo') {
                            // echo "<p class='nom-menu'>" . ucfirst($cle) . ": " . $valeur . "</p><br>";
                            // Si la clé est 'photo', afficher l'image (vous devez ajuster cette partie selon votre structure de base de données)
                            if ($cle === 'idinfo'){
                                echo '<p> <b>Numéro</b> : '.$valeur.'</p>';
                            }
                            if ($cle === 'nom'){
                                echo '<p> nom : '.$valeur.'</p>';
                            }
                            if ($cle === 'photo') {
                                echo "<a href='./doc/$valeur' rel='follow' data-fancybox='gallery' data-caption='Menu #1'>";
                                    echo '<img class="img-fluid" src="view.php?image=doc/'.$valeur.'&amp;mode=resize&amp;size=200x250" alt="">';
                                echo '</a>';
                            }
                        }
                    }
                    echo "</div>";
                }
                echo "<br>";
                echo "</div>";
            ?>
            <h2>modifier une de vos infos :</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- <input type="text" placeholder="nom de l'info actuelle" name="nom" required><br>
                <input type="text" placeholder="ajouter le nouveau nom de l'infos " name="nomC" required><br> -->
                <input type="number" placeholder="mettre le numéro de la photo actuel" name="idInfo" required><br>
                <input type="text" placeholder="ajouter un nouveau nom" name="nomC" required > <br>
                <?php
                if (!empty($_POST["valider"]) && ($valideId != 1) && ($valideNomC != 1)) {
                    echo "<span style='color: red'>Le nom n'est pas correct</span><br>";
                }
                ?>
                <input type="file" name="fichier" required><br>
                <input type="submit" value="Valider" name="valider">
                <input type="submit" value="Annuler" name="annuler">
            </form>
            <h2>Supprimer une des infos :</h2>
            <form action="" method="POST">
                Entrez le numéro de l'infos à supprimer<br>
                <!-- <input type="number" name="idphoto" required><br> -->
                <input type="number" placeholder="" name="idinfo" required><br>
                <input type="submit" name='supp' value="Supprimer">
            </form>
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