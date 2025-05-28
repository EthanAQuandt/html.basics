<?php
require 'db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title && $description) {
        $stmt = $db->prepare("INSERT INTO items (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        echo "<div class='alert alert-success'>Item added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
    }
}
?>

<h2>Add New Item</h2>
<form method="post">
  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" name="title" id="title" required>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Add Item</button>
</form>

<?php require 'footer.php'; ?>
