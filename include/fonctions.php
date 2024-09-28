<?php
    function rechercheMail($mail) {
        $servername = 'localhost';
        $dbname = 'sunbdd';
        $username = 'root';
        $password = '';
        $compteur = 0;
        try {
            //On établit la connexion
            $connexion = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            //Définir les modes d'erreurs et d'exceptions
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //on va affecter notre requete sql à une variable
        }
        //On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci
        catch(PDOException $e) {
            echo "". $e->getMessage();
        }
        $sql = "SELECT mail FROM users";
        $requete = $connexion->query($sql);
        $user = $requete->fetchAll();
        for( $i = 0; $i < count($user); $i++ ) {
            foreach($user[$i] as $key => $value) {
                if($value == $mail) {
                    $compteur++;
                }
            }
        }
        return $compteur;
    }
    function secuSql($mot){
        $regex1 = "select";
        $regex2 = "from";
        $regex3 = "delete";
        $regex4 = "insert";
        $regex5 = "update";
        if(preg_match("/$regex1|$regex2|$regex3|$regex4|$regex5/i", $mot)){
            $mot = str_ireplace("$regex1","s-e-l-e-c-t", $mot);
            $mot = str_ireplace("$regex2","f-r-o-m", $mot);
            $mot = str_ireplace("$regex3","d-e-l-e-t-e", $mot);
            $mot = str_ireplace("$regex4","i-n-s-e-r-t", $mot);
            $mot = str_ireplace("$regex5","u-p-d-a-t-e", $mot);
        }
        return $mot;
    }
    function secuHtml($mot){
        $mot = htmlspecialchars($mot);
        $mot = trim($mot);
        $mot = stripslashes($mot);
        $mot = htmlentities($mot);
        return $mot;
    }
    function secuHtmlJs($mot) {
        $regex1 = "<";
        $regex2 = ">";
        $regex3 = "&lt;";
        $regex4 = "&gt;";
        $regex5 = "script";
        if(preg_match("/$regex1|$regex2|$regex3|$regex4|$regex5/i", $mot)) {
            $mot = str_ireplace("$regex1","", $mot);
            $mot = str_ireplace("$regex2","", $mot);
            $mot = str_ireplace("$regex3","", $mot);
            $mot = str_ireplace("$regex4","", $mot);
            $mot = str_ireplace("$regex5","", $mot);
        }
        return $mot;
    }
    function secu($mot){
        $mot = secuHtml($mot);
        $mot = secuHtmlJs($mot);
        $mot = secuSql($mot);
        return $mot;
    }
    // function verifymail($mail){
    //     if(filter_var($mail, FILTER_VALIDATE_EMAIL)&& preg_match()) {
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }
    function verifymail($mail){
        if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return 1;
        }else{
            return 0;
        }
    }
    function verifymdp($mdp){
        if (preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/", $mdp)){
            return 1;
        }else{
            return 0;
        }
    }
    function verifytext($adress){
        if(preg_match("/^[a-zA-Z0-9 -'éàèëï]+$/", $adress)){
            return 1;
        }else{
            return 0;
        }
    }
    function verifyname($name){
        if(preg_match("/^[a-zA-Z0-9 -'éàèëï]+$/", $name)){
            return 1;
        }else{
            return 0;
        }
    }

    function verifycp($cp){
        if(preg_match("/^[\d]{5}+$/", $cp)){
            return 1;
        }else{
            return 0;
        }
    }
    function verifytelephone($tel){
        if(preg_match("/^[\d]{10}+$/", $tel)){
            return 1;
        }else{
            return 0;
        }
    }
    function verifyId($id) {
        if (preg_match("/^\d{1,2}$/", $id)) {
            return 1;
        } else {
            return 0;
        }
    }

?>