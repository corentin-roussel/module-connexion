<article>
    <nav class="nav">
                    <a class="link" href="index.php">Accueil</a>
        <?php if(!isset($_SESSION['id'])) {  ?>
                    <a class="link" href="inscription.php">Inscription</a>
                    <a class="link" href="connexion.php">Connexion</a>

        <?php }else if($_SESSION['login'] === 'admin') {  ?>
                    <a class="link" href="admin.php">Admin</a>
                    <a class="link" href="profil.php">Profil</a>
                    <a class="link" href="deconnexion.php">Se déconnecter</a>
        <?php   }else{?>
                    <a class="link" href="profil.php">Profil</a>
                    <a class="link" href="deconnexion.php">Se déconnecter</a>
        <?php } ?>
    </nav>
</article>