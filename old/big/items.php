<?php
require 'db.php';
require 'header.php';

$sort = $_GET['sort'] ?? 'title';
$allowed_sorts = ['title', 'created_at'];
if (!in_array($sort, $allowed_sorts)) {
    $sort = 'title';
}

$stmt = $db->query("SELECT title, description FROM items ORDER BY $sort ASC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>All Items</h2>
<div class="mb-3">
    <a href="?sort=title" class="btn btn-secondary me-2">Sort by Title</a>
    <a href="?sort=created_at" class="btn btn-secondary">Sort by Date</a>
</div>

<div class="row">
  <?php foreach ($items as $item): ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
          <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php require 'footer.php'; ?>
