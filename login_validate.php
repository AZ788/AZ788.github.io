¿<?php 
// Iniciar sesión
session_start();

// Conexión a la base de datos
require_once('conectar1.php');
$conn = conectar(); // Asegúrate de que la función "conectar" retorne la conexión mysqli

// Obtener y limpiar los datos ingresados
$user = mysqli_real_escape_string($conn, strip_tags($_POST['user']));
$password = mysqli_real_escape_string($conn, strip_tags($_POST['password']));

// Consulta para verificar el usuario
$query = "SELECT * FROM users WHERE user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si existe el usuario
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();

// Verificar la contraseña encriptada
if (password_verify($password, $row['password'])) {
// Guardar la fecha y hora del último ingreso
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");
$updateQuery = "UPDATE users SET ultimo_ingreso = ? WHERE user = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("ss", $hoy, $user);
$updateStmt->execute();

// Crear sesión de inicio de sesión
$_SESSION['logged'] = 'yes';
$_SESSION['user_id'] = $row['id']; // Asignar el ID del usuario a la sesión

header('Location: front.html');
        exit;
} else {
$_SESSION['logged'] = 'no';
// Mensaje si la contraseña es incorrecta
echo "Contraseña incorrecta";
}
} else {
$_SESSION['logged'] = 'no';
// Mensaje si el usuario no existe
echo "Usuario no existe";
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$conn->close();
?>