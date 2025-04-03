<?php
// Start PHP processing block

require 'db.php'; // Include the database connection file
global $db; // Make the database connection available in this scope

// Get the 'id' parameter from URL query string and validate it as an integer
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Check if a valid ID was provided
if (!empty($id)) {
    // Prepare SQL query to select all players for the specified game ID
    $query = $db->prepare('SELECT * FROM player WHERE game_id = :id');
    
    // Bind the $id variable to the :id parameter in the query (prevents SQL injection)
    $query->bindParam('id', $id);
    
    // Execute the prepared query
    $query->execute();
    
    // Fetch all results as an associative array (column names as keys)
    $players = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no valid ID was provided, terminate with error message
    die('Error 404! Item not found');
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Basic HTML5 meta tags for character encoding and responsive viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title> <!-- Default page title -->
</head>
<body>
    <!-- Players table display -->
    <table>
        <thead>
            <tr>
                <th scope="col">Naam</th> <!-- Column header: "Name" in Dutch -->
                <th scope="col">Leeftijd</th> <!-- Column header: "Age" in Dutch -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($players as $player): ?> <!-- Loop through each player -->
            <tr>
                <td><?= htmlspecialchars($player['name']) ?></td> <!-- Display player name (escaped for HTML) -->
                <td><?= htmlspecialchars($player['age']) ?></td> <!-- Display player age (escaped for HTML) -->
            </tr>
            <?php endforeach; ?> <!-- End of players loop -->
        </tbody>
    </table>
</body>
</html>
