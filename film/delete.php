<?php
include 'db.php';
$id = (int)($_GET['id'] ?? 0);
$d = $db->prepare("DELETE FROM film WHERE id = ?");
$d->execute([$id]);
header('Location: index.php');
exit;
