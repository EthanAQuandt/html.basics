<?php
include 'db.php';

$stmt = $db->query("
    SELECT f.*, ROUND(AVG(b.cijfer),1) AS avg_score, COUNT(b.id) AS review_count
    FROM film f
    LEFT JOIN beoordeling b ON f.id = b.film_id
    GROUP BY f.id
");

$films = $stmt->fetchAll();
$total = count($films);
?>
<!DOCTYPE html>
<html><head><title>Filmclub</title></head><body>
<h1>Filmclub</h1>
<p><strong>Total films:</strong> <?php echo $total; ?></p>
<p><a href="insert.php">Add New Film</a></p>
<table border="1" cellpadding="4">
  <tr><th>Title</th><th>Genre</th><th>Avg Rating</th><th>Reviews</th><th>Actions</th></tr>
  <?php foreach ($films as $f): ?>
    <tr>
      <td><?= htmlspecialchars($f['titel']) ?></td>
      <td><?= htmlspecialchars($f['genre']) ?></td>
      <td><?= $f['review_count'] ? $f['avg_score'] : '–' ?></td>
      <td><?= $f['review_count'] ?></td>
      <td>
        <a href="detail.php?id=<?= $f['id'] ?>">View reviews</a> |
        <a href="update.php?id=<?= $f['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $f['id'] ?>" onclick="return confirm('Delete this film?');">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</body></html>
