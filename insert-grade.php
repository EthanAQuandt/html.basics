<?php

require 'db.php';
global $db;

const SUBJECT_ERROR = 'Je moet een vak toevoegen';
const STUDENT_ERROR = 'Je moet een student toevoegen';
const GRADE_ERROR = 'Je moet een cijfer toevoegen';

if (isset($_POST['submit'])){
    $errors = [];
    $inputs = [];

    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($subject)){
        $errors['subject'] = SUBJECT_ERROR;
    }else{
        $inputs['subject'] = $subject;
    }

    $student = filter_input(INPUT_POST, 'student', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($student)){
        $errors['student'] = STUDENT_ERROR;
    }else{
        $inputs['student'] = $student;
    }

    $grade = filter_input(INPUT_POST, 'grade', FILTER_VALIDATE_FLOAT);

    if (empty($grade)){
        $errors['grade'] = GRADE_ERROR;
    }else{
        $inputs['grade'] = $grade;
    }

    if (count($errors) === 0){
        $query = $db->prepare('INSERT INTO grades (subject, student, grade) VALUES (:subject, :student, :grade)');
        $query->bindParam('subject', $inputs['subject']);
        $query->bindParam('student', $inputs['student']);
        $query->bindParam('grade', $inputs['grade']);
        $query->execute();
        header('Location: index.php');
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post">
    <label for="subject">Vak:</label>
    <input type="text" name="subject" id="subject" value="<?= $inputs['subject'] ?? '' ?>">
    <div><?= $errors['subject'] ?? '' ?></div>
    <label for="student">Student:</label>
    <input type="text" name="student" id="student" value="<?= $inputs['student'] ?? '' ?>">
    <div><?= $errors['student'] ?? '' ?></div>
    <label for="grade">Cijfer:</label>
    <input type="number" step="0.1" name="grade" id="grade" value="<?= $inputs['grade'] ?? '' ?>">
    <div><?= $errors['grade'] ?? '' ?></div>
    <button name="submit">Verzenden</button>
</form>
</body>
</html>
