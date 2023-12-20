<?php
session_start();
if (isset($_SESSION['login'])) { //Si prenom est déjà défini, alors affiche directement l'acceuil
    header("Location: profil.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à votre base de données (remplacez les informations par les vôtres)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Blog_Voyage"; // Votre nom de base de données

    // Création d'une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupération des valeurs du formulaire
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password1'];

    // Hashage du mot de passe pour des raisons de sécurité
    // $hashed_password = $password;// password_hash($password, PASSWORD_DEFAULT) hashage par défault du password

    // Préparation de la requête SQL pour l'insertion des données dans la table 'utilisateurs' -> 'nom', 'prenom', 'email', 'password'
    $sql = "INSERT INTO utilisateurs (login, email, password, id_droits) VALUES ('$login', '$email', '$password', 1)";

    // Exécution de la requête et vérification de son succès
    if ($conn->query($sql) === TRUE) {
        // Redirection vers la page de connexion après inscription réussie
        header("Location: connexion.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar2.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="./css/style-connexion-inscription-profil.css">
    <title>Inscription</title>
</head>
<header>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-mobile">
                <a id="nav-toggle" href="#!"><span></span></a>
            </div>
            <div class="positionnav">
                <a class="listlogo" href="index.html"><img src="../img/logo.png" class="logo" /></a>
                <ul class="nav-list">
                    <li>
                        <a href="#">Countries</a>
                        <ul class="nav-dropdown">
                            <li>
                                <a href="#">Morocco</a>
                            </li>
                            <li>
                                <a href="#">South Korea</a>
                            </li>
                            <li>
                                <a href="../sweden/sweden.html" class="navbordure">Sweden</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#!">Guides</a>
                        <ul class="nav-dropdown">
                            <li>
                                <a href="#">Sabrine</a>
                            </li>
                            <li>
                                <a href="#">Océane</a>
                            </li>
                            <li>
                                <a href="../sweden/sweden.html" class="navbordure">Alexandre</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="connexion.php">Log In</a>
                    </li>
                    <li>
                        <a href="inscription.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </nav>
</header>

<body>
    <main>
        <!--commentaire similaire à connexion-->
        <form id="signupForm" method="post" class="lien" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="formPart">
                <h2 id="title">Inscription</h2>
                <br>
                <label for="login">Login</label><br>
                <input type="text" name="login" id="login" required><br><br>
                <label for="email">Email</label><br>
                <input type="text" name="email" id="email" required><br><br>
                <label for="password1">Password</label><br>
                <input type="password" name="password1" id="password1" required><br><br>
                <label for="confirmation-ps">Confirmation password</label><br>
                <input type="password" name="confirmation-ps" id="confirmation-ps" required><br><br>
            </div>
            <div class="formBtn">
                <button type="submit" name="signup" class="lien" id="signup">S'inscrire</button>
            </div>
        </form>
    </main>
    <footer>
        <div class="placement_icon">
            <img src="../img/icon/gmail.svg" alt="" class="icon" />
            <img src="../img/icon/instagram.svg" alt="" class="icon" />
            <img src="../img/icon/pinterest.svg" alt="" class="icon" />
            <img src="../img/icon/twitter.svg" alt="" class="icon" />
            <img src="../img/icon/youtube.svg" alt="" class="icon" />
        </div>
        <p>©Copyright 2024. Tous droits reservées.</p>
    </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>