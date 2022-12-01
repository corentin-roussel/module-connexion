<?php
    include('_db/connect.php');


    if(isset($_SESSION['id'])) {
        header("Location: index.php");
        exit;
    }

    $valid = (boolean) TRUE;

    $regex = "^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^";

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
                $err_login = "Le contient trop de caractéres.";
            }
            
            else {
                $user = ("SELECT login FROM utilisateurs WHERE login = '$login'");
                $verif = mysqli_query($mysqli, $user);

                var_dump($verif);
                
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
                $req = $mysqli->prepare("SELECT * FROM utilisateurs where prenom = ?");
                $req->execute(array($prenom));
                $req = $req->fetch();
            }
    
            if(empty($nom)) { 
                $valid = FALSE;
                $err_nom = "Ce champ ne peut pas être vide";
            }else {
                $req = $mysqli->prepare("SELECT * FROM utilisateurs where nom = ?");
                $req->execute(array($nom));
                $req = $req->fetch();
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
                $req = $mysqli->prepare("SELECT * FROM utilisateurs where password = ?");
                $req->execute(array($password));
                $req = $req->fetch();
            }    
            
            if($valid) {
                $crypt_password = password_hash($password, PASSWORD_DEFAULT);
                
                $req = $mysqli->prepare("INSERT INTO `utilisateurs`(`login`, `prenom`, `nom`, `password`) VALUES (?, ?, ?, ?)");
                $req->execute((array($login, $prenom, $nom, $crypt_password)));

                header("Location: connexion.php");
                
            }else {
                echo 'nok';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://kit.fontawesome.com/7e3324cff8.js" crossorigin="anonymous"></script>
    <title>Inscription</title>
</head>
<body>
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="form-flex">
            <form class="form" action="" method="POST">
                    <?php if(isset($err_login)) {echo '<div>' . "$err_login" . '</div>' ;} ?>
                    <label class="space" for="login">Login</label>
                    <input class="space" type="text" name ="login" value="<?php if(isset($login)) {echo "$login";} ?>" placeholder="Entrez votre login" required>
                    
                    <?php if(isset($err_prenom)) {echo '<div>' . "$err_prenom" . '</div>' ;} ?>
                    <label class="space" for="prenom">Prenom</label>
                    <input class="space" type="text" name ="prenom"  value="<?php if(isset($prenom)) {echo "$prenom";} ?>" placeholder="Entrez votre prenom" required>

                    <?php if(isset($err_nom)) {echo '<div>' . "$err_nom" . '</div>' ;} ?>
                    <label class="space" for="nom">Nom</label>
                    <input class="space" type="text" name ="nom"  value="<?php if(isset($nom)) {echo "$nom";} ?>" placeholder="Entrez votre nom" required>
                    
                    <?php if(isset($err_password)) {echo '<div>' . "$err_password" . '</div>' ;} ?>
                    <label class="space" for="password">Mot de passe</label>
                    <input class="space" type="password" name ="password"  value="" placeholder="Entrez votre mot de passe" required>

                    <label class="space" for="confpassword">Confirmation mot de passe</label>
                    <input class="space" type="password" name ="confpassword"  value="" placeholder="Confirmez votre mot de passe" required>

                    <input class="button" type="submit" name="inscription"  value="Connexion">
            </form>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php' ?>
    </footer>
</body>
</html>