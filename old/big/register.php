<?php
require 'db.php';
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        // Check if username exists
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            echo "<div class='alert alert-danger'>Username already taken.</div>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            echo "<div class='alert alert-success'>Registration successful. <a href='login.php'>Login here</a>.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
    }
}
?>

<h2>Register</h2>
<form method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" id="username" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php require 'footer.php'; ?>
