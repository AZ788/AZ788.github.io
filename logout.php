<?php
session_start();
session_destroy();
header('Location: login.html'); // Redirigir al login después de cerrar sesión
exit;
?>