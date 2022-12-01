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
    <title>Admin</title>
</head>
<body>
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <h1><?php if(isset($_POST['login'])) {echo $_POST['login'];} ?></h1>
    </main>
    <footer>
        <?php include '_include/footer.php' ?>
    </footer>
</body>
</html>