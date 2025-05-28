<?php
require 'db.php';

$stmt = $db->prepare("INSERT INTO items (name) VALUES (?)");
$stmt->execute(["Hardcoded Item"]);

echo "Item added.";
?>
