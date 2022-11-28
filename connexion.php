<?php
    include '_db/connect.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Connexion</title>
</head>
<body>
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="form-flex">
            <form class="form" action="" method="POST">
                <label class="space" for="login">Login</label>
                <input class="space" type="text" name ="login" id="login" placeholder="Entrez votre login" required>

                <label class="space" for="mdp">Mot de passe</label>
                <input class="space" type="password" name ="mdp" id="mdp" placeholder="Entrez votre mot de passe" required>

                <input class="button" type="submit" id="submit" value="Connexion">
            </form>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php'?>
    </footer>
</body>
</html>

