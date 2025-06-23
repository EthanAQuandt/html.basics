<?php
include "db.php";
$id = (int) $_GET['id'];

$query1 = $db->prepare("SELECT * FROM books WHERE id = ?");
$query1->execute([$id]);
$book = $query1->fetch();

if (!$book) {
    exit('book not found');
}

$query2 = $db->prepare("SELECT * FROM ratings WHERE book_id = ?");
$query2->execute([$id]);
$ratings = $query2->fetchAll();

$query3 = $db->prepare("SELECT ROUND(AVG(score), 1) AS avg FROM ratings WHERE book_id = ?");
$query3->execute([$id]);
$avg = $query3->fetchColumn() ?: 'no score';

$query4 = $db->prepare("
    SELECT books.titel, ROUND(AVG(ratings.score), 1) AS avg
    FROM books
    LEFT JOIN ratings ON books.id = ratings.book_id
    GROUP BY books.id
");
$query4->execute();
$others = $query4->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reviews for <?= htmlspecialchars($book['titel']) ?></title>
</head>
<body>

  <h1>Reviews: <?= htmlspecialchars($book['titel']) ?></h1>

  <?php if ($ratings): ?>
    <?php foreach ($ratings as $rating): ?>
      <div style="border:1px solid #000; margin-bottom:10px;">
        <strong>Score:</strong> <?= htmlspecialchars($rating['score']) ?><br>
        <strong>Comment:</strong> <?= htmlspecialchars($rating['comment']) ?>
      </div>
    <?php endforeach; ?>
    <div style="font-weight:bold; margin-bottom:20px;">
      Average score: <?= htmlspecialchars($avg) ?>
    </div>
  <?php else: ?>
    <p>No reviews</p>
  <?php endif; ?>

  <h2>All books &amp; averages</h2>

  <?php foreach ($others as $other): ?>
    <div style="border:1px solid #000; margin-bottom:10px;">
      <strong>Title:</strong> <?= htmlspecialchars($other['titel']) ?><br>
      <strong>Average Rating:</strong> <?= htmlspecialchars($other['avg']) ?: 'No score' ?>
    </div>
  <?php endforeach; ?>

  <p><a href="index.php">Back to list</a></p>

</body>
</html>
