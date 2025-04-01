<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "testdb";

$data = '';
$sql = '';
$result;
//  INSERT INTO testdb1 (name, email) VALUES ('data', 'data')
// SELECT * FROM testdb1        ////WHERE name = 'data'




try{
    $conn = new mysqli($servername, $username, $password, $database);
    echo "<script>console.log('Database connection successful');</script>";
} catch (mysqli_sql_exception) {
    echo "<script>console.log('Database connection failed');</script>";
}




/*
try{
    mysqli_query($conn, $sql);
    echo "<script>console.log('query successful');</script>";
    //$result = $conn->query($sql);
} catch (mysqli_sql_exception) {
    echo "<script>console.log('query failed');</script>";
}
*/



/*
if(mysqli_num_rows($result) > 0){
$rows = mysqli_fetch_assoc($result);
echo "<script>console.log('Data Dump: " . json_encode($rows) . "');</script>";
echo "<script>console.log('Data Dump: " . json_encode($rows["id"]) . "');</script>";
*/



/*while ($row = mysqli_fetch_assoc($result)) {
    echo "<script>console.log('Data Dump: " . json_encode($rows["id"]) . "');</script>";
}*/

/*echo "<h2>Bestaande aanbod</h2>";
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Huistype</th>
                    <th>Adres</th>
                    <th>Huisnummer</th>
                    <th>Prijs (€)</th>
                </tr>";

        foreach ($result as $row) {
            // Format price with thousand separators
            $formattedPrice = number_format($row["prijs"], 0, ',', '.');

            // Display address with optional addition
            $adres = htmlspecialchars($row["straatnaam"]);
            $huisnummer = htmlspecialchars($row["huisnr"]);

            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["huistype"]) . "</td>
                    <td>" . $adres . "</td>
                    <td>" . $huisnummer . "</td>
                    <td>€ " . $formattedPrice . "</td>
                  </tr>";
        }
        echo "</table>";

*/

//////}
        
/*else{
    echo "<script>console.log('No results found');</script>";
}
*/


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['show_db'])) {
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);
    
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
    echo "<script>console.log('Connected Database Tables: " . json_encode($tables) . "');</script>";
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['show_db'])) {
        echo "<script>console.log('Show Database button pressed');</script>";

    }
    // Text Inputs
    $text = $_POST['text'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $number = $_POST['number'] ?? '';
    $tel = $_POST['tel'] ?? '';
    $url = $_POST['url'] ?? '';
    $search = $_POST['search'] ?? '';
    
    // Date and Time Inputs
    $date = $_POST['date'] ?? '';
    $datetime = $_POST['datetime'] ?? '';
    $month = $_POST['month'] ?? '';
    $week = $_POST['week'] ?? '';
    $time = $_POST['time'] ?? '';
    
    // Misc Inputs
    $color = $_POST['color'] ?? '';
    $range = $_POST['range'] ?? '';
    $checkbox = isset($_POST['checkbox']) ? 'Checked' : 'Not Checked';
    $radio = $_POST['radio'] ?? '';
    $file = $_FILES['file']['name'] ?? '';
    
    // Select & Textarea
    $select = $_POST['select'] ?? '';
    $textarea = $_POST['textarea'] ?? '';
    
    // Logging each variable separately
    echo "<script>console.log('Text: " . json_encode($text) . "');</script>";
    echo "<script>console.log('Password: " . json_encode($password) . "');</script>";
    echo "<script>console.log('Email: " . json_encode($email) . "');</script>";
    echo "<script>console.log('Number: " . json_encode($number) . "');</script>";
    echo "<script>console.log('Telephone: " . json_encode($tel) . "');</script>";
    echo "<script>console.log('URL: " . json_encode($url) . "');</script>";
    echo "<script>console.log('Search: " . json_encode($search) . "');</script>";
    echo "<script>console.log('Date: " . json_encode($date) . "');</script>";
    echo "<script>console.log('Datetime: " . json_encode($datetime) . "');</script>";
    echo "<script>console.log('Month: " . json_encode($month) . "');</script>";
    echo "<script>console.log('Week: " . json_encode($week) . "');</script>";
    echo "<script>console.log('Time: " . json_encode($time) . "');</script>";
    echo "<script>console.log('Color: " . json_encode($color) . "');</script>";
    echo "<script>console.log('Range: " . json_encode($range) . "');</script>";
    echo "<script>console.log('Checkbox: " . json_encode($checkbox) . "');</script>";
    echo "<script>console.log('Radio: " . json_encode($radio) . "');</script>";
    echo "<script>console.log('File: " . json_encode($file) . "');</script>";
    echo "<script>console.log('Select: " . json_encode($select) . "');</script>";
    echo "<script>console.log('Textarea: " . json_encode($textarea) . "');</script>";
}

$bgColor = $_POST['color'] ?? '#ffffff'; // Default color
$textSize = $_POST['range'] ?? '16'; // Default size
$headerText = 'this is a header';
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Elements</title>
    <h1 id="myHeader"><?= htmlspecialchars($headerText) ?></h1>

    <style>
        /*
        body {
            background-color: <?= htmlspecialchars($bgColor) ?>;
        }
        p {
            font-size: <?= htmlspecialchars($textSize) ?>px;
        }
            */
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label>Text: <input type="text" name="text"></label><br>
        <label>Password: <input type="password" name="password"></label><br>
        <label>Email: <input type="email" name="email"></label><br>
        <label>Number: <input type="number" name="number"></label><br>
        <label>Telephone: <input type="tel" name="tel"></label><br>
        <label>URL: <input type="url" name="url"></label><br>
        <label>Search: <input type="search" name="search"></label><br>
        <label>Date: <input type="date" name="date"></label><br>
        <label>Datetime: <input type="datetime-local" name="datetime"></label><br>
        <label>Month: <input type="month" name="month"></label><br>
        <label>Week: <input type="week" name="week"></label><br>
        <label>Time: <input type="time" name="time"></label><br>
        <label>Color: <input type="color" name="color"></label><br>
        <label>Range: <input type="range" name="range" min="0" max="100"></label><br>
        <label>Checkbox: <input type="checkbox" name="checkbox" value="checked"></label><br>
        <label>Radio:
            <input type="radio" name="radio" value="Option 1"> Option 1
            <input type="radio" name="radio" value="Option 2"> Option 2
        </label><br>
        <label>File: <input type="file" name="file"></label><br>
        <label>Select:
            <select name="select">
                <option value="Option 1">Option 1</option>
                <option value="Option 2">Option 2</option>
            </select>
        </label><br>
        <label>Textarea: <textarea name="textarea"></textarea></label><br>
        <input type="submit" value="Submit">

        <form method="post">
            <input type="submit" name="show_db" value="Show Database">
        </form>
    </form>

</body>
</html>




