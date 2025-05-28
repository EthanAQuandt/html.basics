<?php
require 'db.php';


if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $db->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
    echo "Item with ID $id deleted.<br><br>";
}


$stmt = $db->query("SELECT * FROM items");
foreach ($stmt as $row) {
    echo htmlspecialchars($row['id']) . ": " . htmlspecialchars($row['name']) . 
        " <a href='?id=" . urlencode($row['id']) . "' onclick='return confirm(\"Delete this item?\");'>Delete</a><br>";
}
?>

<a href="addForm.php">Insert Into Database</a>