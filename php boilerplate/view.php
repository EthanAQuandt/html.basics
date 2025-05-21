<?php
require 'db.php';

try {
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head><title>View Users</title></head>
<body>
    <h2>Stored Users</h2>
    <?php if ($users): ?>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user['name']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
    <p><a href="index.php">Back to Form</a></p>
</body>
</html>
