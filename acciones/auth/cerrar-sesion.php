<?php
require_once __DIR__ . '/../../bootstrap/init.php';

// Limpiar todas las variables de sesión
$_SESSION = array();

// Destruir la cookie de sesión si existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Guardar mensaje antes de destruir la sesión
$mensajeExito = "Sesión cerrada con éxito.";

// Destruir la sesión
session_destroy();

// Iniciar nueva sesión para el mensaje
session_start();
$_SESSION['mensajeExito'] = $mensajeExito;

// Redirigir siempre a la home principal
header('Location: ../../index.php');
exit;
