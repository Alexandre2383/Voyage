<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <header style="height: 50px;">
        <nav class="nav">
            <div class="nav-mobile">
                <a id="nav-toggle" href="#!"><span></span></a>
            </div>
            <div class="positionnav">
                <a class="listlogo" href="../index.html"><img src="../img/logo.png" class="logo" /></a>
                <ul class="nav-list">
                    <li>
                        <a href="#">Countries</a>
                        <ul class="nav-dropdown">
                            <li>
                                <a href="morocco/morocco.html">Morocco</a>
                            </li>
                            <li>
                                <a href="#" class="navbordure">South Korea</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#!">Guides</a>
                        <ul class="nav-dropdown">
                            <li>
                                <a href="morocco/morocco.html">Sabrine</a>
                            </li>
                            <li>
                                <a href="#" class="navbordure">Océane</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profil.php">Profil</a>
                    </li>
                    <li>
                        <a href="inscription.php">Sign out</a>
                    </li>
                </ul>
            </div>
            <script src="../js/navbar.js"></script>
        </nav>
    </header>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Articles</h2>
                        <a href="articles/creer-article.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Article</a>
                    </div>
                    <?php
                    require_once "articles/config.php";

                    $sql = "SELECT a.id, a.titre, a.article, a.id_utilisateur, a.id_categorie, a.date_time_publication, u.login AS utilisateur, c.nom AS categorie
                            FROM articles AS a
                            JOIN utilisateurs AS u ON a.id_utilisateur = u.id JOIN categories AS c ON a.id_categorie = c.id";

                    $result = mysqli_query($conn, $sql);


                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Titre</th>";
                            echo "<th>Article</th>";
                            echo "<th>Utilisateur</th>";
                            echo "<th>Categorie</th>";
                            echo "<th>Date</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                                echo "<td>" . htmlentities($row['article']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['utilisateur']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categorie']) . "</td>";
                                echo "<td>" . $row['date_time_publication'] . "</td>";
                                echo "<td>";
                                echo '<a href="articles/article.php?id=' . $row['id'] . '" class="mr-3" title="View Article" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a href="articles/modifier.php?id=' . $row['id'] . '" class="mr-3" title="Update Article" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="articles/supprimer.php?id=' . $row['id'] . '" title="Delete Article" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No articles found.</em></div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">Oops! Something went wrong. Please try again later.</div>';
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>