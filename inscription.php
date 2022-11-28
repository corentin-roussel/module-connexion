<?php
    include '_db/connect.php';

    var_dump($_POST);

    $valid = (boolean) TRUE;

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['inscription'])) {
            $login = trim($login);
            $prenom = trim($prenom);
            $nom = trim($nom);
            $password = trim($password);
            $confpassword = trim($confpassword);
        }

        if(empty($login)) {
            $valid = FALSE;
            $err_login = "Ce champ ne peut pas être vide";
        }else {
            $req = $mysqli->prepare("SELECT id FROM utilisateurs WHERE login = ?");
            $req->execute(array($login));
            $req = $req->fetch();

            if(isset($req['id'])) {
                $valid = FALSE;
                $err_login = "Ce login est déja pris";
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
        else {
            $req = $mysqli->prepare("SELECT * FROM utilisateurs where password = ?");
            $req->execute(array($nom));
            $req = $req->fetch();
        }

        
        if($valid) {
            $crypt_password = password_hash($password, PASSWORD_DEFAULT);

            $req = $mysqli->prepare("INSERT INTO `utilisateurs`(`login`, `prenom`, `nom`, `password`) VALUES (?, ?, ?, ?)");
            $req->execute((array($login, $prenom, $nom, $crypt_password)));

            exit;
        }else {
            echo 'nok';
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
                    <input class="space" type="text" name ="login" id="login" value="<?php if(isset($login)) {echo "$login";} ?>" placeholder="Entrez votre login" >
                    
                    <?php if(isset($err_prenom)) {echo '<div>' . "$err_prenom" . '</div>' ;} ?>
                    <label class="space" for="prenom">Prenom</label>
                    <input class="space" type="text" name ="prenom" id="prenom" value="<?php if(isset($prenom)) {echo "$prenom";} ?>" placeholder="Entrez votre prenom" >

                    <?php if(isset($err_nom)) {echo '<div>' . "$err_nom" . '</div>' ;} ?>
                    <label class="space" for="nom">Nom</label>
                    <input class="space" type="text" name ="nom" id="nom" value="<?php if(isset($nom)) {echo "$nom";} ?>" placeholder="Entrez votre nom" >
                    
                    <?php if(isset($err_password)) {echo '<div>' . "$err_password" . '</div>' ;} ?>
                    <label class="space" for="password">Mot de passe</label>
                    <input class="space" type="password" name ="password" id="password" value="" placeholder="Entrez votre mot de passe" >

                    <label class="space" for="confpassword">Confirmation mot de passe</label>
                    <input class="space" type="password" name ="confpassword" id="confpassword" value="" placeholder="Confirmez votre mot de passe" >

                    <input class="button" type="submit" name="inscription" id="inscription" value="Connexion">
            </form>
        </article>
    </main>
    <footer>

    </footer>
</body>
</html>