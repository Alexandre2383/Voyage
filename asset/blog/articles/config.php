<!--</*?php
function connect()
{
    try {
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'blog_voyage');

        $bdd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    } catch (\Exception $e) {
        exit('<b>Catched exception at line ' . $e->getLine() . ' :</b> ' . $e->getMessage());
        // En cas d'erreur, on affiche un message et on arrête tout
        //die('Erreur : '.$e->getMessage());
    }
    return $bdd;
}
?*/>-->
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'blog_voyage');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
