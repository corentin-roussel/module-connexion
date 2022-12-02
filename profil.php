<?php
    include '_db/connect.php';

    $valid = (boolean) TRUE;

    $regex = "^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^";

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['modify'])) {
            $login = htmlspecialchars(trim($login));
            $prenom = htmlspecialchars(trim($prenom));
            $nom = htmlspecialchars(trim($nom));
            $password = htmlspecialchars(trim($password));
            $confpassword = htmlspecialchars(trim($confpassword));
            $oldpassword = htmlspecialchars(trim($oldpassword));
        

            $sessionLogin = $_SESSION['login'];

            if(password_verify($oldpassword, $_SESSION['password'])) {

                if($login != $_SESSION['login']) {
                    $user = ("SELECT login FROM utilisateurs WHERE login = '$sessionLogin'");
                    $verif = mysqli_query($mysqli, $user);
                    
                    if(mysqli_num_rows($verif) > 0) {
                        $valid = FALSE;
                        $err_login = "Ce login est déja pris";
                    }
                    if($valid){ 
                        $req = $mysqli->query("UPDATE utilisateurs SET login = '$login' WHERE login = '$sessionLogin' ");
                    }
                    
                }

                if($prenom != $_SESSION['prenom']) {
                    $req= $mysqli->query("UPDATE utilisateurs SET prenom = '$prenom' WHERE login ='$sessionLogin'");
                    header("Location: deconnexion.php");
                }else {
                    $valid = FALSE;
                    $err_prenom = "Le prenom est identique";
                }

                if($nom != $_SESSION['nom']) {
                    $req= $mysqli->query("UPDATE utilisateurs SET nom = '$nom' WHERE login ='$sessionLogin'");
                }else {
                    $valid = FALSE;
                    $err_nom = "Le nom est identique";
                    header("Location: deconnexion.php");
                }

                if($password === $confpassword) {
                    if(preg_match($regex, $password)) {
                        $crypt_password = password_hash($password, PASSWORD_DEFAULT);
                        $req= $mysqli->query("UPDATE utilisateurs SET password = '$crypt_password' WHERE login ='$sessionLogin'");
                        header("Location: deconnexion.php");
                    }else {
                        $valid = FALSE;
                        $err_password = "Le mot de passe dont contenir au moins 1 majuscules, 1 minuscules 1 chiffres et 1 caractére spéciale";
                    }
                }
            }else {
                $valid = FALSE;
                $err_password = "Le mot de passe de session n'est pas bon";
            }
        }
    }

    if($_SESSION != NULL) { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://kit.fontawesome.com/7e3324cff8.js" crossorigin="anonymous"></script>
    <title>Profil</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="main-index">
            <h1 class="title">Modifier le profil de <?php if($_SESSION) {echo $_SESSION['login'];}  ?></h1>
        </article>
        <article>
        <article class="form-flex">
            <form class="form" action="" method="POST">
                    <?php if(isset($err_login)) {echo '<div>' . "$err_login" . '</div>' ;} ?>
                    <label class="space" for="login">Login</label>
                    <input class="space" type="text" name ="login" value="<?php echo $_SESSION['login']; ?>"  >
                    
                    <?php if(isset($err_prenom)) {echo '<div>' . "$err_prenom" . '</div>' ;} ?>
                    <label class="space" for="prenom">Prenom</label>
                    <input class="space" type="text" name ="prenom"  value="<?php echo $_SESSION['prenom']; ?>" >

                    <?php if(isset($err_nom)) {echo '<div>' . "$err_nom" . '</div>' ;} ?>
                    <label class="space" for="nom">Nom</label>
                    <input class="space" type="text" name ="nom"  value="<?php echo $_SESSION['nom']; ?>" >
                    
                    <?php if(isset($err_password)) {echo '<div>' . "$err_password" . '</div>' ;} ?>
                    <label class="space" for="password">Nouveau mot de passe</label>
                    <input class="space" type="password" name ="password"  value="" placeholder="Entrez votre nouveau mot de passe" >
                    
                    <label class="space" for="password">Confirmation nouveau mot de passe</label>
                    <input class="space" type="password" name ="confpassword"  value="" placeholder="Confirmez votre nouveau mot de passe" >
                    
                    <label class="space" for="password">Ancien mot de passe</label>
                    <input class="space" type="password" name ="oldpassword"  value="" placeholder="Entrez votre ancien mot de passe" >


                    <input class="button" type="submit" name="modify"  value="Modification">
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php'?>
    </footer>
</body>
</html>

<?php }else {
    header("Location: index.php");
} ?>