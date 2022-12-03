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
                    $user = ("SELECT login FROM utilisateurs WHERE login = '$login'");
                    $verif = mysqli_query($mysqli, $user);

                    if(mysqli_num_rows($verif) > 0) {
                        $valid = FALSE;
                        $err_login = "Ce login est déja pris";
                    }
                
                }else if($login === $_SESSION['login']){
                    $valid = FALSE;
                    $err_login = "Le login  $login  est déja pris.";            
                }else if(grapheme_strlen($login) < 5 || grapheme_strlen($login) > 25) {
                    $valid = FALSE;
                    $err_login = "Le login doit contenir au minimum 5 caractéres et pas plus de 25 caractéres";
                }


                if($prenom === $_SESSION['prenom']) {
                    $valid = FALSE;
                    $err_prenom = "Veuillez choisir un prenom différent de $prenom";
                }

           
                if($nom  === $_SESSION['nom']) {
                    $valid = FALSE;
                    $err_nom = "Veuillez choisir un nom différent de $nom";    //    
                }

                if($password != $confpassword) {
                    $valid = FALSE;
                    $err_password = "La confirmation du mot de passe n'est pas bonne";
                }else if($password === $confpassword) {
                    if(preg_match($regex, $password)) {
                        $crypt_password = password_hash($password, PASSWORD_DEFAULT);
                    }else {
                        $valid = FALSE;
                        $err_password = "Le mot de passe doit contenir au moins une majuscules, une minuscules un chiffres et un caractére spéciale";
                    }
                }

                if($valid) {
                    $user = ("UPDATE utilisateurs SET login = '$login', password = '$crypt_password', nom = '$nom', prenom = '$prenom' WHERE login = '$sessionLogin'");
                    $change = mysqli_query($mysqli, $user);
                    header("Location: deconnexion.php");
                }
            }else {
                $valid = FALSE;
                $err_password = "L'ancien mot de passe n'est pas bon";
            }
        }
    }

    if($_SESSION != NULL) { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php'; ?>
    <title>Profil</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="form-flex">
            <h1 class="title main-index ">Modifier le profil de <?php if($_SESSION) {echo $_SESSION['login'];}  ?></h1>
            <form class="form" action="" method="POST">
                    <?php if(isset($err_login)) {echo '<div>' . "$err_login" . '</div>' ;} ?>
                    <label class="space" for="login">Login</label>
                    <input class="space input" type="text" name ="login" value="<?php echo $_SESSION['login']; ?>"  >
                    
                    <?php if(isset($err_prenom)) {echo '<div>' . "$err_prenom" . '</div>' ;} ?>
                    <label class="space" for="prenom">Prenom</label>
                    <input class="space input" type="text" name ="prenom"  value="<?php echo $_SESSION['prenom']; ?>" >

                    <?php if(isset($err_nom)) {echo '<div>' . "$err_nom" . '</div>' ;} ?>
                    <label class="space" for="nom">Nom</label>
                    <input class="space input" type="text" name ="nom"  value="<?php echo $_SESSION['nom']; ?>" >
                    
                    <?php if(isset($err_password)) {echo '<div>' . "$err_password" . '</div>' ;} ?>
                    <label class="space" for="password">Nouveau mot de passe</label>
                    <input class="space, input" type="password" name ="password"  value="" placeholder="Entrez votre nouveau mot de passe" >
                    
                    <label class="space" for="password">Confirmation nouveau mot de passe</label>
                    <input class="space input" type="password" name ="confpassword"  value="" placeholder="Confirmez votre nouveau mot de passe" >
                    
                    <label class="space" for="password">Ancien mot de passe</label>
                    <input class="space input" type="password" name ="oldpassword"  value="" placeholder="Entrez votre ancien mot de passe" >


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