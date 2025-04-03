<?php
require 'db.php'; // Include database connection
global $db; // Make $db available

// Constants for error messages (in Dutch)
const NAME_REQUIRED = 'Vul je naam in'; // "Enter your name"
const MIN_BET_REQUIRED = 'Vul een minimale inzet in'; // "Enter a minimum bet"

$errors = []; // Array to store errors
$inputs = []; // Array to store user inputs

if (isset($_POST['submit'])){ // If form is submitted
    // Sanitize name input (remove special chars)
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($name)){ // Validate name isn't empty
        $errors['name'] = NAME_REQUIRED;
    } else{
        $inputs['name'] = $name; // Store valid input
    }

    // Validate min_bet is an integer
    $minBet = filter_input(INPUT_POST, 'min-bet', FILTER_VALIDATE_INT);

    if (empty($minBet)){ // Validate min_bet isn't empty
        $errors['min-bet'] = MIN_BET_REQUIRED;
    } else{
        $inputs['min-bet'] = $minBet; // Store valid input
    }

    if (count($errors) === 0){ // If no errors
        // Prepare INSERT query
        $query = $db->prepare('INSERT INTO games (name, min_bet) VALUES (:name, :min_bet)');
        // Bind parameters
        $query->bindParam('name', $inputs['name']);
        $query->bindParam('min_bet', $inputs['min-bet']);
        $query->execute(); // Execute query

        header('Location: index.php'); // Redirect to main page
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Same meta tags as index.php -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post"> <!-- Form submits to itself -->
    <label for="name">Naam</label> <!-- Name label -->
    <!-- Name input with value preserved if validation fails -->
    <input type="text" name="name" id="name" value="<?= $inputs['name'] ?? '' ?>">
    <!-- Display name error if exists -->
    <div><?= $errors['name'] ?? '' ?></div>
    
    <label for="min-bet">Minimale inzet</label> <!-- Min bet label -->
    <!-- Min bet input with value preserved -->
    <input type="number" name="min-bet" id="min-bet" value="<?= $inputs['min-bet'] ?? '' ?>">
    <!-- Display min bet error if exists -->
    <div><?= $errors['min-bet'] ?? '' ?></div>
    
    <button name="submit">Verzenden</button> <!-- Submit button ("Verzenden" = "Send") -->
</form>
</body>
</html>
