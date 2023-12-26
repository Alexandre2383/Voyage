<?php
require_once "config.php";

// Check if article ID is provided in the URL
if (!empty($_GET['id'])) {
    $articleId = $_GET['id'];

    // Retrieve article details from the database based on the provided ID
    $sql = "SELECT a.id, a.titre, a.article, a.id_utilisateur, a.id_categorie, a.date_time_publication, u.login AS utilisateur, c.nom AS categorie
    FROM articles AS a
    JOIN utilisateurs AS u ON a.id_utilisateur = u.id 
    JOIN categories AS c ON a.id_categorie = c.id
    WHERE a.id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Store article details in variables
            $titre = $row['titre'];
            $articleContent = $row['article'];
            $user = $row['utilisateur'];
            $categoryId = $row['id_categorie'];
        } else {
            echo "Article not found.";
            exit();
        }
    } else {
        echo "Prepared statement error: " . $conn->error;
        exit();
    }

    // Retrieve categories from the database
    $categories_query = "SELECT id, nom FROM categories";
    $categories_result = $conn->query($categories_query);
    if ($categories_result->num_rows > 0) {
        $categories = $categories_result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "No categories found.";
        exit();
    }

} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission for article update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedTitle = htmlentities($_POST['title'] ?? '');
    $updatedContent = htmlentities($_POST['content'] ?? '');
    $updatedCategoryId = $_POST['category'] ?? '';

    if (!empty($updatedContent) && !empty($updatedCategoryId)) {
        $sql = "UPDATE articles SET titre = ?, article = ?, id_utilisateur = ?, id_categorie = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssii", $updatedTitle, $updatedContent, $updatedUserId, $updatedCategoryId, $articleId);
            $stmt->execute();
            
            //Redirect to the view article page
            header("Location: ../articles.php");
            exit();
        } else {
            echo "Prepared statement error: " . $conn->error;
            exit();
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Article</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style-connexion-inscription-profil.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/footer.css">
</head>
<body>
<div class="wrapper">
        <header>
            <nav class="nav">
                <div class="nav-mobile">
                    <a id="nav-toggle" href="#!"><span></span></a>
                </div>
                <div class="positionnav">
                    <a class="listlogo" href="../../../index.html"><img src="../../img/logo.png" class="logo" /></a>
                    <ul class="nav-list">
                        <li>
                            <a href="#">Countries</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="../../morocco/morocco.html">Morocco</a>
                                </li>
                                <li>
                                    <a href="#" class="navbordure">South Korea</a>
                                </li> 
                                <li>
                                    <a href="../../sweden.html">Sweden</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#!">Guides</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="../../morocco/morocco.html">Sabrine</a>
                                </li>
                                <li>
                                    <a href="#" class="navbordure">Océane</a>
                                </li>
                                <li>
                                    <a href="../../sweden.html">Alexandre</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="../profil.php">Profil</a>
                        </li>
                        <li>
                            <a href="../articles.php">Article</a>
                        </li>
                    </ul>
                </div>
                <script src="../js/navbar.js"></script>
            </nav>
        </header>
    <div class="wrapper">
        <div class="container-fluid" style="width: 600px;">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Modifier l'article</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$articleId"; ?>" method="post">
                        <div class="form-group">
                            <label>Titre</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $titre; ?>">
                        </div>
                        <div class="form-group">
                            <label>Contenu</label>
                            <textarea name="content" class="form-control" rows="5"><?php echo $articleContent; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Utilisateur</label>
                            <input type="text" name="author" class="form-control" value="<?php echo $user; ?>">
                        </div>
                        <div class="form-group">
                            <label>Categorie</label>
                            <select name="category" class="form-control">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $categoryId) echo "selected"; ?>>
                                        <?php echo $category['nom']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="../articles.php" class="btn btn-secondary ml-2">Back</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <footer>
            <div class="placement_icon">
                <img src="../../img/icon/gmail.svg" alt="" class="icon" />
                <img src="../../img/icon/instagram.svg" alt="" class="icon" />
                <img src="../../img/icon/pinterest.svg" alt="" class="icon" />
                <img src="../../img/icon/twitter.svg" alt="" class="icon" />
                <img src="../../img/icon/youtube.svg" alt="" class="icon" />
            </div>
            <p>©Copyright 2024. Tous droits reservées.</p>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script></div>
</body>
</html>