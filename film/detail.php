<?php
include 'db.php';

// Get the film ID from the URL query string, default to 0 if not set or invalid
$filmId = (int)($_GET['id'] ?? 0);

// Prepare a statement to fetch the film details by its ID
$filmStatement = $db->prepare("SELECT * FROM film WHERE id = ?");
$filmStatement->execute([$filmId]);
$film = $filmStatement->fetch();

// If no film is found, stop execution and display an error message
if (!$film) {
    exit('Film not found.');
}

// Prepare a statement to fetch all reviews related to this film
$reviewStatement = $db->prepare("SELECT * FROM beoordeling WHERE film_id = ?");
$reviewStatement->execute([$filmId]);
$reviews = $reviewStatement->fetchAll();

// Prepare a statement to calculate the average score of the reviews for this film, rounded to 1 decimal place
$averageScoreStatement = $db->prepare("SELECT ROUND(AVG(cijfer), 1) AS avg_score FROM beoordeling WHERE film_id = ?");
$averageScoreStatement->execute([$filmId]);
$averageScore = $averageScoreStatement->fetchColumn() ?: '–';

// Query to get a list of all films with their average scores
$filmsWithAverageScores = $db->query("
    SELECT film.titel, ROUND(AVG(beoordeling.cijfer), 1) AS avg_score
    FROM film
    LEFT JOIN beoordeling ON film.id = beoordeling.film_id
    GROUP BY film.id
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reviews for <?= htmlspecialchars($film['titel']) ?></title>
</head>
<body>

  <h1>Reviews: <?= htmlspecialchars($film['titel']) ?></h1>

  <?php if ($reviews): ?>
    <?php foreach ($reviews as $review): ?>
      <div style="border:1px solid #000; margin-bottom:10px;">
        <strong>Rating:</strong> <?= htmlspecialchars($review['cijfer']) ?><br>
        <strong>Comment:</strong> <?= htmlspecialchars($review['opmerking']) ?>
      </div>
    <?php endforeach; ?>
    <div style="font-weight:bold; margin-bottom:20px;">
      Average rating: <?= $averageScore ?>
    </div>
  <?php else: ?>
    <p>No reviews yet.</p>
  <?php endif; ?>

  <h2>All films &amp; averages</h2>

  <?php foreach ($filmsWithAverageScores as $filmRow): ?>
    <div style="border:1px solid #000; margin-bottom:10px;">
      <strong>Title:</strong> <?= htmlspecialchars($filmRow['titel']) ?><br>
      <strong>Average Rating:</strong> <?= $filmRow['avg_score'] ?: '–' ?>
    </div>
  <?php endforeach; ?>

  <p><a href="index.php">← Back to list</a></p>

</body>
</html>