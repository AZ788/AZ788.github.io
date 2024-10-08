<?php
function conectar() {
    // Parámetros de conexión a la base de datos
    $servidor = "127.0.0.1";  // Cambia si es necesario
    $usuario = "root";        // Tu usuario de MySQL
    $password = "";           // Tu contraseña de MySQL (en blanco si usas la configuración por defecto de XAMPP)
    $base_datos = "temperatura";  // Cambia por el nombre de tu base de datos

    // Crear conexión con MySQL
    $conn = new mysqli($servidor, $usuario, $password, $base_datos);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Retornar la conexión
    return $conn;
}
?>