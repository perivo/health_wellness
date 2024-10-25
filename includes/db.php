 
<?php
// db.php
define('DB_HOST', 'localhost:3305');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'health_wellness');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
