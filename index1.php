<?php
require 'db.php';
global $db;

$fieldConfigs = [
    'text_input'       => 'Vul tekst in',
    'password_input'   => 'Vul wachtwoord in',
    'email_input'      => 'Vul e-mail in',
    'number_input'     => 'Vul nummer in',
    'tel_input'        => 'Vul telefoonnummer in',
    'search_input'     => 'Vul zoekopdracht in',
    'date_input'       => 'Vul datum in',
    'time_input'       => 'Vul tijd in',
    'datetime_input'   => 'Vul datum + tijd in',
    'month_input'      => 'Vul maand in',
    'week_input'       => 'Vul week in',
    'color_input'      => 'Vul kleur in',
    'radio_input'      => 'Kies een optie',
    'dropdown_input'   => 'Kies iets in dropdown',
];

$inputs = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($fieldConfigs as $field => $errorMsg) { 
        if ($field === 'email_input') {
            $rawValue = filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);
            $value = ($rawValue === '0') ? '0' : trim($rawValue);

            // Validate email
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = $errorMsg;
            }
        } else {
            $rawValue = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);
            $value = ($rawValue === '0') ? '0' : trim($rawValue);

            // Validate required non-empty value
            if ($value === '' || $value === null) {
                $errors[$field] = $errorMsg;
            }
        }

        $inputs[$field] = $value; // Always store for field repopulation in case of validation error
    }

    // Checkbox validation
    $inputs['checkbox_input'] = isset($_POST['checkbox_input']);
    if (!$inputs['checkbox_input']) {
        $errors['checkbox_input'] = 'Je moet akkoord gaan';
    }

    // password hashing
    if (!empty($inputs['password_input'])) {
        $inputs['password_input'] = password_hash($inputs['password_input'], PASSWORD_DEFAULT);
    }

    if (empty($errors)) {
        $keys = array_keys($inputs);
        $query = $db->prepare("INSERT INTO form_data (`" . implode('`,`', $keys) . "`) VALUES (:" . implode(',:', $keys) . ")");
        foreach ($inputs as $k => $v) $query->bindValue(":$k", $v);
        $query->execute();
        header('Location: index1.php');
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

        <!-- Text -->
        <label for="text_input">Text:</label>
        <input type="text" name="text_input" id="text_input" value="<?= $inputs['text_input'] ?? '' ?>">
        <div><?= $errors['text_input'] ?? '' ?></div>

        <!-- Password -->
        <label for="password_input">Password:</label>
        <input type="password" name="password_input" id="password_input">
        <div><?= $errors['password_input'] ?? '' ?></div>

        <!-- Email -->
        <label for="email_input">Email:</label>
        <input type="email" name="email_input" id="email_input" value="<?= $inputs['email_input'] ?? '' ?>">
        <div><?= $errors['email_input'] ?? '' ?></div>

        <!-- Number -->
        <label for="number_input">Number:</label>
        <input type="number" name="number_input" id="number_input" value="<?= $inputs['number_input'] ?? '' ?>">
        <div><?= $errors['number_input'] ?? '' ?></div>

        <!-- Tel -->
        <label for="tel_input">Phone:</label>
        <input type="tel" name="tel_input" id="tel_input" value="<?= $inputs['tel_input'] ?? '' ?>">
        <div><?= $errors['tel_input'] ?? '' ?></div>

        <!-- Search -->
        <label for="search_input">Search:</label>
        <input type="search" name="search_input" id="search_input" value="<?= $inputs['search_input'] ?? '' ?>">
        <div><?= $errors['search_input'] ?? '' ?></div>

        <!-- Date -->
        <label for="date_input">Date:</label>
        <input type="date" name="date_input" id="date_input" value="<?= $inputs['date_input'] ?? '' ?>">
        <div><?= $errors['date_input'] ?? '' ?></div>

        <!-- Time -->
        <label for="time_input">Time:</label>
        <input type="time" name="time_input" id="time_input" value="<?= $inputs['time_input'] ?? '' ?>">
        <div><?= $errors['time_input'] ?? '' ?></div>

        <!-- Datetime-Local -->
        <label for="datetime_input">Date & Time:</label>
        <input type="datetime-local" name="datetime_input" id="datetime_input" value="<?= $inputs['datetime_input'] ?? '' ?>">
        <div><?= $errors['datetime_input'] ?? '' ?></div>

        <!-- Month -->
        <label for="month_input">Month:</label>
        <input type="month" name="month_input" id="month_input" value="<?= $inputs['month_input'] ?? '' ?>">
        <div><?= $errors['month_input'] ?? '' ?></div>

        <!-- Week -->
        <label for="week_input">Week:</label>
        <input type="week" name="week_input" id="week_input" value="<?= $inputs['week_input'] ?? '' ?>">
        <div><?= $errors['week_input'] ?? '' ?></div>

        <!-- Color -->
        <label for="color_input">Color:</label>
        <input type="color" name="color_input" id="color_input" value="<?= $inputs['color_input'] ?? '#000000' ?>">
        <div><?= $errors['color_input'] ?? '' ?></div>

        <!-- Checkbox -->
        <label for="checkbox_input">Accept Terms:</label>
        <input type="checkbox" name="checkbox_input" id="checkbox_input" value="1" <?= ($inputs['checkbox_input'] ?? false) ? 'checked' : '' ?>>
        <div><?= $errors['checkbox_input'] ?? '' ?></div>

        <!-- Radio -->
        <p>Choose an option:</p>
        <input type="radio" name="radio_input" id="radio1" value="option1" <?= ($inputs['radio_input'] ?? '') === 'option1' ? 'checked' : '' ?>>
        <label for="radio1">Option 1</label>
        <input type="radio" name="radio_input" id="radio2" value="option2" <?= ($inputs['radio_input'] ?? '') === 'option2' ? 'checked' : '' ?>>
        <label for="radio2">Option 2</label>
        <div><?= $errors['radio_input'] ?? '' ?></div>

        <!-- Dropdown (Select) -->
        <label for="dropdown_input">Choose an option:</label>
        <select name="dropdown_input" id="dropdown_input">
            <option value="">Please select</option>
            <option value="alpha" <?= ($inputs['dropdown_input'] ?? '') === 'alpha' ? 'selected' : '' ?>>Alpha</option>
            <option value="beta" <?= ($inputs['dropdown_input'] ?? '') === 'beta' ? 'selected' : '' ?>>Beta</option>
            <option value="gamma" <?= ($inputs['dropdown_input'] ?? '') === 'gamma' ? 'selected' : '' ?>>Gamma</option>
        </select>
        <div><?= $errors['dropdown_input'] ?? '' ?></div>

        <!-- Submit -->
        <input type="submit" name="submit" value="Submit">

    </form>

</body>

</html>