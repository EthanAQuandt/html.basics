<?php
require 'db.php';
require 'header.php';


$stmt = $db->query("SELECT * FROM items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="mb-4">Welcome to MySite</h1>

<div class="row">
  <?php foreach ($items as $item): ?>
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
          <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
        </div>
        <div class="card-footer text-muted">
          Added on <?= date('F j, Y', strtotime($item['created_at'])) ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php require 'footer.php'; ?>
