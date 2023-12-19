<?php
session_start();
if(isset($_SESSION['login'])) {//Si prenom est déjà défini, alors affiche directement l'acceuil
    header("Location: profil.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
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
    $sql = "INSERT INTO utilisateurs (login, email, password) VALUES ('$login', '$email', '$password')";
    $id_droit = "SELECT utilisateurs.id_droits, droits.name FROM utilisateurs JOIN droits ON utilisateurs.id_droits = droits.id;";
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
    <title>Inscription</title>
    <script src="script.js" defer></script>
</head>
<body>
    <h2>Inscription</h2><!--commentaire similaire à connexion-->
    <form id="signupForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="login">Login</label>
        <input type="text" name="login" id="login" required><br><br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required><br><br>
        <label for="password1">Password</label>
        <input type="password" name="password1" id="password1" required><br><br>
        <label for="confirmation-ps">Confirmation password</label>
        <input type="password" name="confirmation-ps" id="confirmation-ps" required><br><br>
        <button type="submit" name="signup" id="signup">S'inscrire</button>
    </form>
    <script src="script.js"></script>
</body>
</html>