<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="css/style-connexion-inscription-profil.css">

    <title>Profil</title>
</head>

<body>
    <div class="wrapper">
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
                                    <a href="../morocco/morocco.html">Morocco</a>
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
                                    <a href="../morocco/morocco.html">Sabrine</a>
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
                            <a href="articles.php">Article</a>
                        </li>
                        <li>
                            <a href="inscription.php">Sign out</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <main>
            <div class="container">
                <?php
                session_start();
                if (isset($_SESSION['login'])) { //si le prenom après la connexion est défini
                    $prenom = $_SESSION['login'];
                    echo "<p class='lien' id='hello'>Bonjour $prenom</p>"; //affiche Bonjour $prenom
                    echo "<a href='../index.html' class='lien'>retour à la page principal</a>";
                } else {
                    echo '<a id="redirect" href="inscription.php" class="lien">Inscription</a>'; //sinon renvoie sur le lien de l'inscription, ou de connexion
                    echo '<a id="redirect" href="connexion.php" class="lien">Connexion</a>';
                }
                ?></div>
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
    <script src="../js/navbar.js"></script>
</body>

</html>