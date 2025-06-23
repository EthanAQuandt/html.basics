<?php
include 'db.php';
$id = (int)($_GET['id'] ?? 0);
$f = $db->prepare("SELECT * FROM film WHERE id = ?");
$f->execute([$id]);
$film = $f->fetch();
if (!$film) exit('Film not found.');

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titel = trim($_POST['titel'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    if (!$titel || !$genre) {
        $err = 'Both title and genre are required.';
    } else {
        $dup = $db->prepare("SELECT id FROM film WHERE titel = ? AND id <> ?");
        $dup->execute([$titel, $id]);
        if ($dup->fetch()) {
            $err = 'Another film with that title already exists.';
        } else {
            $u = $db->prepare("UPDATE film SET titel = ?, genre = ? WHERE id = ?");
            $u->execute([$titel, $genre, $id]);
            echo "<p>Updated to: <strong>" . htmlspecialchars($titel) . "</strong> (" . htmlspecialchars($genre) . ")</p>";
            echo '<p><a href="index.php">← Back to list</a></p>';
            exit;
        }
    }
}
?>
<!DOCTYPE html><html><head><title>Edit Film</title></head><body>
<h1>Edit Film</h1>
<?php if ($err): ?><p style="color:red;"><?= htmlspecialchars($err) ?></p><?php endif; ?>
<form method="post">
  <label>Title:<br><input type="text" name="titel" value="<?= htmlspecialchars($_POST['titel'] ?? $film['titel']) ?>"></label><br><br>
  <label>Genre:<br><input type="text" name="genre" value="<?= htmlspecialchars($_POST['genre'] ?? $film['genre']) ?>"></label><br><br>
  <button type="submit">Save Changes</button>
</form>
<p><a href="index.php">← Back to list</a></p>
</body></html>
