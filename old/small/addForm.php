<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $stmt = $db->prepare("INSERT INTO items (name) VALUES (?)");
    $stmt->execute([$_POST['name']]);
    echo "Item added.";
}
?>

<form action="addF orm.php" method="POST">
    <input type="text" name="name" placeholder="Item name" required>
    <button type="submit">Add</button>
</form>

<a href="showDel.php">View Data</a>


<?php

for ($i=0; $i < 1; $i++) { 
    
}