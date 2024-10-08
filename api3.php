<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conectar.php';

function fetch_data($mysqli, $serie) {
    $stmt = $mysqli->prepare("SELECT DATE_FORMAT(fecha, '%Y-%m-%d %H:%i:%s') as Fecha, temperatura as Temperatura FROM datos WHERE serie = ? ORDER BY fecha DESC LIMIT 10");
    $stmt->bind_param("s", $serie); // La serie puede ser 'termocupla' o 'pt100'
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $mysqli->close();
    return $data;
}

$mysqli = new mysqli("localhost", "user", "password", "database");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$serie = isset($_GET['serie']) ? $_GET['serie'] : 'termocupla'; // Valor por defecto 'termocupla'

header('Content-Type: application/json');
echo json_encode(fetch_data($mysqli, $serie));
?>