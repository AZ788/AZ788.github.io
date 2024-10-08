<?php
// Habilitar la visualización de errores para la depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'conectar.php';

// Obtener los datos del formulario
$user = $_POST['user'] ?? null;
$correoElectronico = $_POST['mail'] ?? null;
$password = $_POST['password'] ?? null;
$r_password = $_POST['r_password'] ?? null;
$acuerdo = $_POST['terms'] ?? null;

// Verificar que todos los campos obligatorios no estén vacíos
if (!$user || !$correoElectronico || !$password || !$r_password) {
    die('Error: Todos los campos son obligatorios. Por favor, complete todos los campos.');
}

// Verificar que las contraseñas coincidan
if ($password !== $r_password) {
    die('Error: Las contraseñas no coinciden. Por favor, verifique que las contraseñas sean iguales.');
}

// Verificar que el acuerdo esté marcado
if (!$acuerdo) {
    die('Error: Debe aceptar los términos y condiciones para continuar.');
}

// Encriptar la contraseña
$password_encriptada = password_hash($password, PASSWORD_DEFAULT);

// Conectar a la base de datos
require_once 'conectar.php';
// Preparar la consulta para verificar si el correo ya existe
$stmt = $mysqli->prepare("SELECT mail FROM users WHERE mail = ?");
$stmt->bind_param('s', $correoElectronico);
$stmt->execute();
$stmt->store_result();

// Verificar si el correo ya existe
if ($stmt->num_rows > 0) {
    die('Error: El correo electrónico ya está registrado. Por favor, utilice un correo electrónico diferente.');
} else {
    // Insertar el nuevo usuario en la base de datos
    $stmt = $mysqli->prepare("INSERT INTO users (id, fecha, user, password, mail) VALUES (NULL, ?, ?, ?, ?)");
    $hoy = date("Y-m-d H:i:s");
    $stmt->bind_param('ssss', $hoy, $user, $password_encriptada, $correoElectronico);
    
    if ($stmt->execute()) {
        echo 'Registro exitoso. Su cuenta ha sido creada con éxito.';
        // Forzar la salida del buffer para que se muestre en la pantalla

        header('Location: login.html');
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }
}

// Cerrar la conexión
$stmt->close();
$mysqli->close();
?>