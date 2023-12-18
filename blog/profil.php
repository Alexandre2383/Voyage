<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['prenom'])) {//si le prenom après la connexion est défini
            $prenom = $_SESSION['prenom'];
            echo "<p>Bonjour $prenom</p>";//affiche Bonjour $prenom
            echo "<a href='../index.html'>retour à la page principal</a>";
        } else {
            echo '<a href="inscription.php">Inscription</a>';//sinon renvoie sur le lien de l'inscription, ou de connexion
            echo '<a href="connexion.php">Connexion</a>';
        }
    ?>

</body>
</html>