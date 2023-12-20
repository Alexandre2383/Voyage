<?php
session_start();
if (isset($_SESSION['login'])) { //Si le prenom est défini dans la base de donnée
    header("Location: profil.php"); //affiche directement l'index.php
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à la base de données 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog_voyage";

    // Création d'une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupération des valeurs du formulaire pour connexion
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête SQL pour récupérer l'utilisateur en fonction de l'email
    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'"; //Récupére tout dans le tableau utilisateur en fonction de l'email 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupération de l'utilisateur trouvé
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if ($password === $user['password']) { //(password_verify($password, $user['password']))
            // Création de la session pour l'utilisateur connecté
            $_SESSION['login'] = $user['login'];
            $_SESSION['email'] = $user['email'];

            // Redirection vers la page d'accueil après connexion réussie
            header("Location: profil.php");
            exit();
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email";
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
    <title>Connexion</title>
</head>
<header>
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
        <h2 class="lien" id="title">Connexion</h2>
        <form id="loginForm" class="lien" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"><!--Prévention d'injection de code dans le formulaire avec htmlspecialchars-->
            <label for="email">Email</label>
            <input type="text" name="email" id="email" required><br><br><!--required redirege l'utilisateur sur l'input si il clique sur submit sans écrire-->
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit" name="confirm" class="lien" id="confirm">Se connecter</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>