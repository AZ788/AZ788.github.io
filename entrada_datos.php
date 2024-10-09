<?php
	
require_once 'conectar.php';
$serie = $_POST['serie'];
$temperatura = $_POST['temp'];
$res = $mysqli->query("INSERT INTO `datos` (`ID`, `Fecha`, `Serie`, `Temperatura`) VALUES (NULL, current_timestamp(), '$serie', '$temperatura');");

$mysqli->close();

echo"Datos ingresados corectamente"

?>

