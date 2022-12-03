<?php
    include '_db/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php' ?>
    <title>Accueil</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'; ?>
    </header>
    <main>
        <article class="main-index">
            <h1 class="title">Bonjour <?php if(isset($_SESSION['id'])) {echo $_SESSION['login'];} else{ echo "tout le monde";} ?></h1>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php'; ?>
    </footer>
</body>
</html>