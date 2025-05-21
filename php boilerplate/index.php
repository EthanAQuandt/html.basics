<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';

    try {
        $stmt = $conn->prepare("INSERT INTO users (name) VALUES (:name)");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $message = "Data inserted successfully.";
    } catch (PDOException $e) {
        $message = "Insert failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Submit Name</title></head>
<body>
    <form method="post">
        <input type="text" name="name" placeholder="Enter name" required>
        <button type="submit">Submit</button>
    </form>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    <p><a href="view.php">View Data</a></p>
</body>
</html>
