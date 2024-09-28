<?php
$servername = 'localhost';
$username = 'root';
$password = '';
try {
    //On établit la connexion
    $connexion = new PDO("mysql:host=$servername;", $username, $password);
    //Définir les modes d'erreurs et d'exceptions
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //on va affecter notre requete sql à une variable
    $sql = "CREATE DATABASE sunbdd CHARACTER SET utf8 COLLATE utf8_bin";
    //on execute la requete sql
    $connexion->exec($sql);
}
//On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci
catch(PDOException $e) {
    date_default_timezone_set('Europe/Paris');
    setlocale(LC_TIME,"fr_FR");
    $fichier = fopen("error.log","a+");
    fwrite($fichier, date("d/m/Y H:i:s : ").$e->getMessage(). "\n");
    fclose($fichier);
}

//les variables de connexion
$servername = 'localhost';
$dbname = 'sunbdd';
$username = 'root';
$password = '';
try {
    //On établit la connexion
    $connexion = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
    //Définir les modes d'erreurs et d'exceptions
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //on va affecter notre requete sql à une variable
    $sql = "CREATE TABLE users (
        id INT(5) AUTO_INCREMENT PRIMARY KEY,
        civilite VARCHAR(50) NOT NULL,
        prenom	VARCHAR(70) NOT NULL,
        nom	VARCHAR(70) NOT NULL,
        mail VARCHAR(100) NOT NULL,
        mdp	VARCHAR(200) NOT NULL,
        confirmationMdp VARCHAR (200) NOT NULL,
        telephone	INT(10),
        userrole VARCHAR(50),
        dateinscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )CHARACTER SET utf8 COLLATE utf8_bin";
    //on execute la requete sql
    $connexion->exec($sql);
    //creation de la table formation
    $sql1 = "CREATE TABLE menus (
        idmenu INT(5) AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(150) NOT NULL,
        photo VARCHAR(100) NOT NULL
    )CHARACTER SET utf8 COLLATE utf8_bin";
    //on execute la requete sql
    $connexion->exec($sql1);
        //creation de la table note
        $sql2 = "CREATE TABLE infos (
            idinfo INT(5) AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(150) NOT NULL,
            photo	VARCHAR(100)NOT NULL
        )CHARACTER SET utf8 COLLATE utf8_bin";
        //on execute la requete sql
        $connexion->exec($sql2);
}
//On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci
catch(PDOException $e) {
    $fichier = fopen("error.log","a+");
    fwrite($fichier, date("d/m/Y H:i:s : ").$e->getMessage(). "\n");
    fclose($fichier);
}

?>