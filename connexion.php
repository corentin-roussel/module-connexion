<?php
    require_once('_db/connect.php');
    
    if(isset($_SESSION['id'])) {
        header("Location: index.php");
        exit;
    }

    

    if(!empty($_POST)) {
        extract($_POST);

        $valid = (boolean) TRUE;

        if(isset($_POST['connexion'])) {
            $login = htmlspecialchars(trim($login));
            $password = htmlspecialchars(trim($password));

            if(empty($login)) {
                $valid = FALSE;
                $err_login = "Ce champ ne peut pas être vide";
            }

            if(empty($password)) {
                $valid = FALSE;
                $err_password = "Ce champ ne peut pas être vide";
            }

            if($valid) {
                $user = ("SELECT password FROM utilisateurs WHERE login = '$login'");
                $req_user = mysqli_query($mysqli, $user);
                $users = mysqli_fetch_array($req_user, MYSQLI_ASSOC);
                

                if(isset($users['password'])) {
                    if(!password_verify($password, $users['password'])) {
                        $valid = FALSE;
                        $err_login = "La combinaison du mot de passe et du login est incorrecte";
                    }
                }
                else {
                    $valid = FALSE;
                    $err_login = "La combinaison du mot de passe et du login est incorrecte";
                }
            }

            if($valid) {
                $user = ("SELECT * FROM utilisateurs WHERE login = '$login'");
                $users = mysqli_query($mysqli, $user);
                $session_users = mysqli_fetch_array($users, MYSQLI_ASSOC);


                if(isset($session_users['id'])) {
                    $_SESSION['id'] = $session_users['id'];
                    $_SESSION['login'] = $session_users['login'];
                    $_SESSION['prenom'] = $session_users['prenom'];
                    $_SESSION['nom'] = $session_users['nom'];
                    $_SESSION['password'] = $session_users['password'];

                    header("Location: index.php");
                }
                else{
                    $valid = FALSE;
                    echo "La combinaison du mot de passe et du login est incorrecte";
                }
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
    <title>Connexion</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="main-index">
            <h1 class="title">Connectez vous</h1>
        </article>
        <article class="form-flex">
            <form class="form" action="" method="POST">
                <?php if(isset($err_login)) {echo $err_login;} ?>
                <label class="space" for="login">Login</label>
                <input class="space" type="text" name ="login"  value="<?php if(isset($login)) {echo $login;} ?>" placeholder="Entrez votre login" required>

                <?php if(isset($err_password)) {echo $err_password;} ?>
                <label class="space" for="password">Mot de passe</label>
                <input class="space" type="password" name ="password"  placeholder="Entrez votre mot de passe" required>

                <p>Password admin = Admin.123</p>

                <input class="button" type="submit"  name="connexion" value="Connexion">
            </form>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php'?>
    </footer>
</body>
</html>

