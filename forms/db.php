<?php
try {
    // Attempt to create a new PDO connection to MySQL database
    $db = new PDO('mysql:host=localhost;dbname=holland_casino', 'root', '');
    // Parameters: 
    // - mysql:host=localhost (database server)
    // - dbname=holland_casino (database name)
    // - 'root' (username)
    // - '' (empty password)
} catch (PDOException $e) {
    // If connection fails, catch the exception
    die('Error! ' . $e->getMessage());
    // Stop execution and display error message
}
?>
