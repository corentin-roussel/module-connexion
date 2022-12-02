<?php
    include '_db/connect.php';


    if($_SESSION['login'] === "admin") { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://kit.fontawesome.com/7e3324cff8.js" crossorigin="anonymous"></script>
    <title>Admin</title>
</head>
<body class="bg-img">
    <header>
        <?php include '_include/header.php'?>
    </header>
    <main>
        <article class="main-index">
            <h1>Bonjour <?php echo $_SESSION['login'] ?></h1>
        </article>
        <article class="flex-table">
            <table class="table">
                <thead>
                    <tr>
                        <?php
                            $req =  ("SELECT * FROM utilisateurs");
                            $req_user = mysqli_query($mysqli, $req);
                            $users = mysqli_fetch_array($req_user, MYSQLI_ASSOC);

                            foreach($users as $key => $values) { // Pour chaque variable ligne as $key => $values
                                    echo '<th>' . $key . '</th>'; // echo $key
                            }  

                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($users != NULL) { // pour variable line n'est pas égale a NULL (ne pas réutiliser fetch_array sinon l'index passe a 1)
                            echo "<tr>"; //echo balise <tr>
                            foreach($users as $key => $values) { //pour chaque ligne as clé => values
                                    echo '<td>' . $values . '</td>'; // echo balise html + values
                            }
                        $users = mysqli_fetch_array($req_user, MYSQLI_ASSOC); // redonner la variable line avec fetch array pour continuer d'écrire les lignes
                        echo "</tr>"; //pour revenir a la ligne a chaque nouvelle array
                        }
                    ?>
                </tbody>
            </table>
        </article>
    </main>
    <footer>
        <?php include '_include/footer.php' ?>
    </footer>
</body>
</html>

<?php } else {
    header("Location: index.php");
} 
?>