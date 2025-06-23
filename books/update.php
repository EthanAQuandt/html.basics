<?php
include "db.php";

$id = (int) ($_GET['id'] ?? 0);
if ($id === 0) {
    exit('Invalid book ID');
}


const TITEL_ERROR = 'Je moet een titel toevoegen';
const AUTHOR_ERROR = 'Je moet een author toevoegen';
const GENRE_ERROR = 'Je moet een genre toevoegen';

if (isset($_POST['submit'])) {
    $errors = [];
    $inputs = [];

    $titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($titel)) {
        $errors['titel'] = TITEL_ERROR;
    } else {
        $inputs['titel'] = $titel;
    }

    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($author)) {
        $errors['author'] = AUTHOR_ERROR;
    } else {
        $inputs['author'] = $author;
    }

    $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($genre)) {
        $errors['genre'] = GENRE_ERROR;
    } else {
        $inputs['genre'] = $genre;
    }

    if (count($errors) === 0) {
        $query = $db->prepare('UPDATE books SET titel = :titel, genre = :genre, author = :author WHERE id = :id');
        $query->bindParam(':titel', $inputs['titel']);
        $query->bindParam(':author', $inputs['author']);
        $query->bindParam(':genre', $inputs['genre']);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        header('Location: index.php');
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        
    <label for="titel">titel:</label>
        <input type="text" name="titel" id="titel" value="<?= $inputs['titel'] ?? '' ?>">
        <div><?= $errors['titel'] ?? '' ?></div>

        <label for="author">author:</label>
        <input type="text" name="author" id="author" value="<?= $inputs['author'] ?? '' ?>">
        <div><?= $errors['author'] ?? '' ?></div>

        
        
        <label for="genre">genre:</label>
        <input type="text" name="genre" id="genre" value="<?= $inputs['genre'] ?? '' ?>">
        <div><?= $errors['genre'] ?? '' ?></div>

        <input type="submit" name="submit" value="Submit">

    </form>

</body>

</html>