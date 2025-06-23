<?php
include 'db.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titel = trim($_POST['titel'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    if (!$titel || !$genre) {
        $err = 'Both title and genre are required.';
    } else {
        $dup = $db->prepare("SELECT id FROM film WHERE titel = ?");
        $dup->execute([$titel]);
        if ($dup->fetch()) {
            $err = 'A film with that title already exists.';
        } else {
            $ins = $db->prepare("INSERT INTO film (titel, genre) VALUES (?, ?)");
            $ins->execute([$titel, $genre]);
            echo "<p>Added: <strong>" . htmlspecialchars($titel) . "</strong> (" . htmlspecialchars($genre) . ")</p>";
            echo '<p><a href="index.php">← Back to list</a></p>';
            exit;
        }
    }
}
?>
<!DOCTYPE html><html><head><title>Add Film</title></head><body>
<h1>Add a New Film</h1>
<?php if ($err): ?><p style="color:red;"><?php echo htmlspecialchars($err); ?></p><?php endif; ?>
<form method="post">
  <label>Title:<br><input type="text" name="titel" value="<?= htmlspecialchars($_POST['titel'] ?? '') ?>"></label><br><br>
  <label>Genre:<br><input type="text" name="genre" value="<?= htmlspecialchars($_POST['genre'] ?? '') ?>"></label><br><br>
  <button type="submit">Add Film</button>
</form>
<p><a href="index.php">← Back to list</a></p>
</body></html>
