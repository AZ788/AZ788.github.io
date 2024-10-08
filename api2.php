<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conectar.php';

function fetch_data($mysqli) {
    $stmt = $mysqli->prepare("SELECT DATE_FORMAT(fecha, '%Y-%m-%d %H:%i:%s') as Fecha, serie as Serie, temperatura as Temperatura FROM datos WHERE year(fecha) = ? AND month(fecha) = ? AND day(fecha) = ? ORDER BY fecha DESC LIMIT 10");
    $ano = date("Y");
    $mes = 10;
    $dia = 4;
    $stmt->bind_param("iii", $ano, $mes, $dia);
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

header('Content-Type: application/json');
echo json_encode(fetch_data($mysqli));
?>