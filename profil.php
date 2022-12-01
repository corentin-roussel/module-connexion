<?php
    include '_db/connect.php';


    $req = ("SELECT login, prenom, nom, password FROM utilisateurs");
    $req_user = mysqli_query($mysqli, $req);
    $users = mysqli_fetch_array($users, MYSQLI_ASSOC);

    var_dump($users);
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
<body>
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="main-index">
            <h1 class="title">Bonjour <?php if(isset($_SESSION['login'])) {echo $_POST['login'];} ?></h1>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php'?>
    </footer>
</body>
</html>

