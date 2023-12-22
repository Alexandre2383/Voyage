<?php
require_once "config.php";

// Check if article ID is provided in the URL
if (!empty($_GET['id'])) {
    $articleId = $_GET['id'];

    // Retrieve article details from the database based on the provided ID
    $sql = "SELECT * FROM articles WHERE id = $articleId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Store article details in variables
        $articleContent = $row['article'];
        $userId = $row['id_utilisateur'];
        $categoryId = $row['id_categorie'];
    } else {
        echo "Article not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission for article update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedContent = htmlentities($_POST['content'] ?? '');
    $updatedUserId = $_POST['author'] ?? '';
    $updatedCategoryId = $_POST['category'] ?? '';

    if (!empty($updatedContent) && !empty($updatedUserId) && !empty($updatedCategoryId)) {
        $sql = "UPDATE articles SET article = '$updatedContent', id_utilisateur = '$updatedUserId', id_categorie = '$updatedCategoryId' WHERE id = $articleId";
        
        if ($conn->query($sql) === TRUE) {
            //Redirect to the view article page
            header("Location: ../articles.php");
            exit();
        } else {
            echo "Error updating article: " . $conn->error;
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
                    <h2 class="mt-5">Update Article</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$articleId"; ?>" method="post">
                        <div class="form-group">
                            <label>Article Content</label>
                            <textarea name="content" class="form-control" rows="5"><?php echo $articleContent; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Author ID</label>
                            <input type="text" name="author" class="form-control" value="<?php echo $userId; ?>">
                        </div>
                        <div class="form-group">
                            <label>Category ID</label>
                            <input type="text" name="category" class="form-control" value="<?php echo $categoryId; ?>">
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
