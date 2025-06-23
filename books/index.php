<?php
include "db.php";

$temp = $db->query("
SELECT 
    books.id,
    books.titel,
    books.genre,
    books.author,
    ROUND(AVG(ratings.score), 1) AS avg,
    COUNT(ratings.id) AS review_count
FROM 
    books
LEFT JOIN 
    ratings ON books.id = ratings.book_id
GROUP BY 
    books.id, books.titel, books.genre, books.author
");

$arrays = $temp->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Library</title>
</head>
<body>

<h1>Book Library</h1>
<p><a href="insert.php">Add New Book</a></p>

<?php foreach ($arrays as $array): ?>
    <div style="border:1px solid #000;margin-bottom:10px;">
        <strong>Title:</strong> <?= htmlspecialchars($array['titel']) ?><br>
        <strong>Author:</strong> <?= htmlspecialchars($array['author']) ?><br>
        <strong>Genre:</strong> <?= htmlspecialchars($array['genre']) ?><br>
        <strong>Average Rating:</strong> <?= $array['review_count'] ? $array['avg'] : '–' ?><br>
        <strong>Number of Reviews:</strong> <?= $array['review_count'] ?><br><br>

        <a href="detail.php?id=<?= $array['id'] ?>">View Reviews</a> |
        <a href="update.php?id=<?= $array['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $array['id'] ?>" onclick="return confirm('Delete this book?');">Delete</a>
    </div>
<?php endforeach; ?>

</body>
</html>
