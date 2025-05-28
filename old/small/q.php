<?php
// DB connection
$host = 'localhost';
$db   = 'your_database';
$user = 'your_username';
$pass = 'your_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submissions
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['select_salary_above'])) {
        // DQL SELECT
        $salary = $_POST['select_salary_above'];
        $stmt = $pdo->prepare("SELECT name, salary FROM employees WHERE salary > ?");
        $stmt->execute([$salary]);
        $rows = $stmt->fetchAll();
        $result = "<h3>Employees with salary > $salary</h3><ul>";
        foreach ($rows as $row) {
            $result .= "<li>{$row['name']} - {$row['salary']}</li>";
        }
        $result .= "</ul>";
    }

    if (!empty($_POST['insert_name']) && !empty($_POST['insert_position'])) {
        // DML INSERT
        $stmt = $pdo->prepare("INSERT INTO employees (name, position, salary, hire_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['insert_name'],
            $_POST['insert_position'],
            $_POST['insert_salary'],
            $_POST['insert_hire_date']
        ]);
        $result = "Inserted new employee: {$_POST['insert_name']}";
    }

    if (!empty($_POST['update_name']) && !empty($_POST['update_salary'])) {
        // DML UPDATE
        $stmt = $pdo->prepare("UPDATE employees SET salary = ? WHERE name = ?");
        $stmt->execute([$_POST['update_salary'], $_POST['update_name']]);
        $result = "Updated salary for {$_POST['update_name']}";
    }

    if (!empty($_POST['delete_name'])) {
        // DML DELETE
        $stmt = $pdo->prepare("DELETE FROM employees WHERE name = ?");
        $stmt->execute([$_POST['delete_name']]);
        $result = "Deleted employee: {$_POST['delete_name']}";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; }
        fieldset { margin-bottom: 1.5em; padding: 1em; }
        label { display: block; margin-top: 0.5em; }
        input[type="text"], input[type="number"], input[type="date"] { width: 100%; padding: 0.4em; }
        input[type="submit"] { margin-top: 1em; padding: 0.6em 1.2em; }
    </style>
</head>
<body>
    <h1>SQL Query Form</h1>
    <form method="POST">
        <!-- SELECT -->
        <fieldset>
            <legend>SELECT Employees by Salary</legend>
            <label for="select_salary_above">Salary greater than:</label>
            <input type="number" name="select_salary_above" id="select_salary_above">
        </fieldset>

        <!-- INSERT -->
        <fieldset>
            <legend>INSERT New Employee</legend>
            <label for="insert_name">Name:</label>
            <input type="text" name="insert_name" id="insert_name">
            <label for="insert_position">Position:</label>
            <input type="text" name="insert_position" id="insert_position">
            <label for="insert_salary">Salary:</label>
            <input type="number" name="insert_salary" id="insert_salary">
            <label for="insert_hire_date">Hire Date:</label>
            <input type="date" name="insert_hire_date" id="insert_hire_date">
        </fieldset>

        <!-- UPDATE -->
        <fieldset>
            <legend>UPDATE Employee Salary</legend>
            <label for="update_name">Name:</label>
            <input type="text" name="update_name" id="update_name">
            <label for="update_salary">New Salary:</label>
            <input type="number" name="update_salary" id="update_salary">
        </fieldset>

        <!-- DELETE -->
        <fieldset>
            <legend>DELETE Employee</legend>
            <label for="delete_name">Name:</label>
            <input type="text" name="delete_name" id="delete_name">
        </fieldset>

        <input type="submit" value="Execute Queries">
    </form>

    <?php if ($result): ?>
        <div>
            <h2>Result:</h2>
            <div><?= $result ?></div>
        </div>
    <?php endif; ?>
</body>
</html>
