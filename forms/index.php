<?php
require 'db.php'; // Include database connection
global $db; // Make $db variable available in this scope

// Prepare SQL query to select all games
$query = $db->prepare('SELECT * FROM games');
$query->execute(); // Execute the query

// Fetch all results as associative array
$games = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Basic HTML meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title> <!-- Page title -->
</head>
<body>
<!-- Link to add new game -->
<a href="insert.php">Toevoegen</a> <!-- "Toevoegen" means "Add" in Dutch -->

<!-- Games table -->
<table>
    <thead>
    <tr>
        <th scope="col">Naam</th> <!-- "Naam" = "Name" -->
        <th scope="col">Minimale inzet</th> <!-- "Minimale inzet" = "Minimum bet" -->
        <th scope="col">Spelers</th> <!-- "Spelers" = "Players" -->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($games as $game): ?> <!-- Loop through each game -->
    <tr>
        <td><?= $game['name'] ?></td> <!-- Display game name -->
        <td><?= $game['min_bet'] ?></td> <!-- Display minimum bet -->
        <!-- Link to view players for this game -->
        <td><a href="players.php?id=<?= $game['id'] ?>">Spelers</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
