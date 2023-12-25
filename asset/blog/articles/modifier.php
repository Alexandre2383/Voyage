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
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
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
</body>
</html>