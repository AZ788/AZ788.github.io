<?php
// conectar.php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'temperatura');

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");
?>
