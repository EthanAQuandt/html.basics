<?php
require 'db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if ($current_password && $new_password) {
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($current_password, $user['password'])) {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->execute([$hashedPassword, $_SESSION['user_id']]);
            echo "<div class='alert alert-success'>Password updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Incorrect current password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
    }
}
?>

<h2>Change Password</h2>
<form method="post">
  <div class="mb-3">
    <label for="current_password" class="form-label">Current Password</label>
    <input type="password" class="form-control" name="current_password" required>
  </div>
  <div class="mb-3">
    <label for="new_password" class="form-label">New Password</label>
    <input type="password" class="form-control" name="new_password" required>
  </div>
  <button type="submit" class="btn btn-primary">Update Password</button>
</form>

<?php require 'footer.php'; ?>
