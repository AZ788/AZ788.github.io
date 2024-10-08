<?php
// Connect to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "temperatura";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT Serie, Temperatura, Fecha FROM datos";
$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()) {
    $data[] = array(
        'Serie' => $row['Serie'],
        'Temperatura' => $row['Temperatura'],
        'Fecha' => $row['Fecha']
    );
}

// Close the database connection
$conn->close();

// Output the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>