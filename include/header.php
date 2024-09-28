<header>
    <?php
        if(!isset($_SESSION["mail"])){
            echo
            "<div>
                <img class='header-img' src='view.php?image=./assets/img/header/logo_sun_burger_beauvais_rue_gambetta_hd.png&amp;mode=resize&amp;size=150x200' alt=''>
                <div class='hamburger navbar-toggler'>
                    <div class='menu-btn' id='main'>
                        <div class='menu-bt-burger'></div>
                    </div>
                </div>
            </div>
            <nav class='liste-co'>
                <ul id='navbarNav'>
                    <li class='lien'><a href='./connexion.php'>connexion</a></i></li>
                    <li><a href='./inscription.php'>Inscription</a></li>
                </ul>
            </nav>
            ";
            }else{
            echo
            "<div>
                <a href='./profiladmin.php'> 
                 <img class='header-img' src='view.php?image=./assets/img/header/logo_sun_burger_beauvais_rue_gambetta_hd.png&amp;mode=resize&amp;size=150x200' alt=''>
                </a>
                <div class='hamburger navbar-toggler'>
                    <div class='menu-btn' id='main'>
                        <div class='menu-bt-burger'></div>
                    </div>
                </div>
            </div>
            <nav class='liste-con'>
                <ul id='navbarNav'>
                    <li><a href='./menuAdmin.php'>ajout menus</a></li>
                    <li><a href='./infoAdmin.php'>ajout infos</a></li>
                    <li class='lien'><a href='./profiladmin.php'>profil</a></i></li>
                    <li><a href='./deconnexion.php'>deconnexion</a></li>
                </ul>    
            </nav>
            ";
        }
    ?>
</header>