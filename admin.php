<?php
    include '_db/connect.php';


    if($_SESSION['login'] === "admin") { //si login de session et égale a admin on peut accéder a la page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '_include/head.php' ?>
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
                            // requête pour tout sélectionner dans la table utilisateurs
                            $req =  ("SELECT * FROM utilisateurs");
                            $req_user = mysqli_query($mysqli, $req);
                            // récuperation des valeurs dans un tableau associatif avec les id et nom de colonne en clé et utilisation de assoc pour récuperer uniquement les clés en noms de colonnes
                            $users = mysqli_fetch_array($req_user, MYSQLI_ASSOC);

                            foreach($users as $key => $values) { // Pour chaque utilisateurs  as $key => $values pour parcourir le tabeleau echo les clés
                                    echo '<th>' . $key . '</th>'; // echo $key
                            }  

                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($users != NULL) { // tant que variable users n'est pas égale a NULL (ne pas réutiliser fetch_array sinon l'index passe a 1)
                            echo "<tr>"; //echo balise <tr>
                            foreach($users as $key => $values) { //pour chaque ligne de clé => values
                                    echo '<td>' . $values . '</td>'; // echo balise html + values
                            }
                        $users = mysqli_fetch_array($req_user, MYSQLI_ASSOC); // redéfinir la variable users avec fetch array pour continuer d'écrire les lignes
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
    header("Location: index.php"); //sinon on est redirigés vers la page index
} 
?>