<?php
    include('_db/connect.php');


    if(isset($_SESSION['id'])) { //si on a quelquechose dans $_SESSION['id']
        header("Location: index.php");// redirige vers index.php
        exit;
    }

    $valid = (boolean) TRUE; //initialisation d'un booleen

    $regex = "^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^"; //intialisation de la regex

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['inscription'])) {
            $login = htmlspecialchars(trim($login));
            $prenom = htmlspecialchars(trim($prenom));
            $nom = htmlspecialchars(trim($nom));
            $password = htmlspecialchars(trim($password));
            $confpassword = htmlspecialchars(trim($confpassword));

            if(empty($login)) {
                $valid = FALSE;
                $err_login = "Ce champ ne peut pas être vide";
            }
            
            else if(grapheme_strlen($login) < 5) {
                $valid = FALSE;
                $err_login = "Le login ne contient pas assez de caractéres.";
            }
            
            else if(grapheme_strlen($login) > 25) {
                $valid = FALSE;
                $err_login = "Le login contient trop de caractéres.";
            }
            
            else {
                $user = ("SELECT login FROM utilisateurs WHERE login = '$login'");
                $verif = mysqli_query($mysqli, $user);

                
                if(mysqli_num_rows($verif) > 0) {
                    $valid = FALSE;
                    $err_login = "Ce login est déja pris";
                }
                else {

                }
            }

            if(empty($prenom)) {
                $valid = FALSE;
                $err_prenom = "Ce champ ne peut pas être vide";
            }else {
                $user = ("SELECT * FROM utilisateurs WHERE prenom = '$prenom'");
                $verif = mysqli_query($mysqli, $user);
            }
    
            if(empty($nom)) { 
                $valid = FALSE;
                $err_nom = "Ce champ ne peut pas être vide";
            }else {
                $user = ("SELECT * FROM utilisateurs WHERE nom = '$nom'");
                $verif = mysqli_query($mysqli, $user);
            }
    
            if(empty($password)) {
                $valid = FALSE;
                $err_password = "Ce champ ne peut pas être vide";
            }
            else if($password != $confpassword) {
                $valid = FALSE;
                $err_password = "Le mot de passe est différent de la confirmation";
            }
            else if($password === $confpassword) {
                if(preg_match($regex, $password)) {
                    
                }else {
                    $valid = FALSE;
                    $err_password = "Le mot de passe dont contenir au moins 1 majuscules, 1 minuscules 1 chiffres et 1 caractére spéciale";
                }

            }
            else {
                $user = ("SELECT * FROM utilisateurs WHERE prenom = '$prenom'");
                $verif = mysqli_query($mysqli, $user);
            }    
            
            if($valid) {
                $crypt_password = password_hash($password, PASSWORD_DEFAULT);
                
                $req = $mysqli->prepare("INSERT INTO `utilisateurs`(`login`, `prenom`, `nom`, `password`) VALUES (?, ?, ?, ?)");
                $req->execute((array($login, $prenom, $nom, $crypt_password)));

                header("Location: connexion.php");
                
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php' ?>
    <title>Inscription</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="form-flex">
            <h1 class="title main-index">Inscrivez-vous</h1>
            <form class="form" action="" method="POST">
                    <?php if(isset($err_login)) {echo '<div>' . "$err_login" . '</div>' ;} ?>
                    <label class="space" for="login">Login</label>
                    <input class="space input" type="text" name ="login" value="<?php if(isset($login)) {echo "$login";} ?>" placeholder="Entrez votre login" required>
                    
                    <?php if(isset($err_prenom)) {echo '<div>' . "$err_prenom" . '</div>' ;} ?>
                    <label class="space" for="prenom">Prenom</label>
                    <input class="space input" type="text" name ="prenom"  value="<?php if(isset($prenom)) {echo "$prenom";} ?>" placeholder="Entrez votre prenom" required>

                    <?php if(isset($err_nom)) {echo '<div>' . "$err_nom" . '</div>' ;} ?>
                    <label class="space" for="nom">Nom</label>
                    <input class="space input" type="text" name ="nom"  value="<?php if(isset($nom)) {echo "$nom";} ?>" placeholder="Entrez votre nom" required>
                    
                    <?php if(isset($err_password)) {echo '<div>' . "$err_password" . '</div>' ;} ?>
                    <label class="space" for="password">Mot de passe</label>
                    <input class="space input" type="password" name ="password"  value="" placeholder="Entrez votre mot de passe" required>

                    <label class="space" for="confpassword">Confirmation mot de passe</label>
                    <input class="space input" type="password" name ="confpassword"  value="" placeholder="Confirmez votre mot de passe" required>

                    <input class="button" type="submit" name="inscription"  value="Connexion">
            </form>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php' ?>
    </footer>
</body>
</html>