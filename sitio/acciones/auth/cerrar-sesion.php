<?php
require_once __DIR__ . '/../../bootstrap/init.php';

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

$mensajeExito = "Sesión cerrada con éxito.";

session_destroy();

session_start();
$_SESSION['mensajeExito'] = $mensajeExito;

header('Location: ../../index.php');
exit;
