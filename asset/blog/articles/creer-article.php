<?php
require_once "config.php";

// Fetch categories from the database
$sql_categories = "SELECT id, nom FROM categories";
$result_categories = $conn->query($sql_categories);

// Initialize variables
$article = $title = $author = $category = "";
$articleErr = $titleErr = $authorErr = $categoryErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    htmlspecialchars($article = isset($_POST['content']) ? $_POST['content'] : '');
    htmlspecialchars($title = isset($_POST['title']) ? $_POST['title'] : '');
    htmlspecialchars($author = isset($_POST['author']) ? $_POST['author'] : '');
    $category = isset($_POST['category']) ? intval($_POST['category']) : 0;

    // Validate inputs
    $isValid = true;

    if (empty($article)) {
        $articleErr = "Content is required";
        $isValid = false;
    }

    if (empty($title)) {
        $titleErr = "Title is required";
        $isValid = false;
    }

    if (empty($author)) {
        $authorErr = "Author is required";
        $isValid = false;
    }

    if ($category <= 0) {
        $categoryErr = "Invalid category selected";
        $isValid = false;
    }

    if ($isValid) {
        // Prepare the SQL statement using prepared statements
        $sql = "INSERT INTO articles (titre, article, id_utilisateur, id_categorie, date_time_publication) VALUES (?, ?, ?, ?, NOW())";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $article, $author, $category);

        // Execute the statement
        if ($stmt->execute()) {
            $last_id = $stmt->insert_id;
            echo "<p>New article created successfully</p>";
            // Redirect to articles.php after successful submission
            header("Refresh: 3; url=../articles.php");
            // header("Refresh: 5; url=page2.php");
            exit(); // Ensure that no more output is sent
        } else {
            echo "<p>Error creating article.</p>";
        }

        // Close the statement
        $stmt->close();
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
                        <label for="title">Title:</label><br>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
                        <span class="text-danger"><?php echo $titleErr; ?></span><br><br>

                        <label for="content">Content:</label><br>
                        <textarea id="content" name="content" rows="5" cols="40"><?php echo htmlspecialchars($article); ?></textarea>
                        <span class="text-danger"><?php echo $articleErr; ?></span><br><br>

                        <label for="author">Author Name:</label><br>
                        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>">
                        <span class="text-danger"><?php echo $authorErr; ?></span><br><br>

                        <label for="category">Category:</label><br>
                        <select id="category" name="category">
                            <option value="">Select a category</option>
                            <?php
                            if ($result_categories && $result_categories->num_rows > 0) {
                                while ($row = $result_categories->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['nom']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo $categoryErr; ?></span><br><br>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="articles.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
