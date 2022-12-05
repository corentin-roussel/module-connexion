<article>
    <nav class="nav"> <!-- bar de navigation a affichage conditionnelle  accueil afficher en permanence-->
                    <a class="link" href="index.php">Accueil</a>
        <?php if(!isset($_SESSION['id'])) {   ?>   <!-- si il n'ya pas d'id de session afficher inscription plus conenxion-->
                    <a class="link" href="inscription.php">Inscription</a>
                    <a class="link" href="connexion.php">Connexion</a>

        <?php }else if($_SESSION['login'] === 'admin') {  ?>    <!-- si le login de la session et égale a admin afficher accueil admin profil et déconnexion-->
                    <a class="link" href="admin.php">Admin</a>
                    <a class="link" href="profil.php">Profil</a>
                    <a class="link" href="deconnexion.php">Se déconnecter</a>
        <?php   }else{?>                                        <!-- sinon afficher accueil profil et deconnexion-->
                    <a class="link" href="profil.php">Profil</a>
                    <a class="link" href="deconnexion.php">Se déconnecter</a>
        <?php } ?>
    </nav>
</article>