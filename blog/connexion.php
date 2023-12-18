<?php
session_start();
if(isset($_SESSION['prenom'])) {//Si le prenom est défini dans la base de donnée
    header("Location: profil.php");//affiche directement l'index.php
    exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connexion à la base de données 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jour05utilisateurs"; 

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
    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";//Récupére tout dans le tableau utilisateur en fonction de l'email 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupération de l'utilisateur trouvé
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            // Création de la session pour l'utilisateur connecté
            $_SESSION['prenom'] = $user['prenom'];
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
    <title>Connexion</title>
    <script src="script.js" defer></script>
</head>
<body>
    <h2>Connexion</h2>
    <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"><!--Prévention d'injection de code dans le formulaire avec htmlspecialchars-->
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required><br><br><!--required redirege l'utilisateur sur l'input si il clique sur submit sans écrire-->
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required><br><br>
        <button type="submit" name="login" id="login">Se connecter</button>
    </form>
</body>
</html>