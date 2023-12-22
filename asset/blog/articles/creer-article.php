<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $article = $_POST['content'] ?? '';
    $id_utilisateur = $_POST['author'] ?? '';
    $id_categorie = $_POST['category'] ?? '';

    if (!empty($article) && !empty($id_utilisateur) && !empty($id_categorie)) {
        // Insert the article into the 'articles' table
        $sql = "INSERT INTO articles (article, id_utilisateur, id_categorie, date_time_publication) VALUES ('$article', '$id_utilisateur', '$id_categorie', NOW())";
        
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo "<p>New article created successfully with ID: $last_id</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Article</title>
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
<h2>Create an Article</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="5" cols="40"></textarea><br><br>

    <label for="author">Author ID:</label><br>
    <input type="text" id="author" name="author"><br><br>

    <label for="category">Category ID:</label><br>
    <input type="text" id="category" name="category"><br><br>

    <input type="submit" class="btn btn-primary" value="Submit">
    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
</form>
</div>
            </div>        
        </div>
    </div>
</body>
</html>
