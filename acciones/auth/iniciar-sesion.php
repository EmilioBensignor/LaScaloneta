<?php
use App\Autenticacion\Autenticacion;

require_once __DIR__ . '/../../bootstrap/init.php';

$email = $_POST['email'];
$password = $_POST['password'];

$autenticacion = new Autenticacion();

if(!$autenticacion->iniciarSesion($email, $password)) {
    $_SESSION['mensajeError'] = "Las credenciales ingresadas no coinciden con nuestros registros.";
    header('Location: ../../index.php?s=iniciar-sesion');
    exit;
}

$_SESSION['mensajeExito'] = "¡Bienvenido/a " . $autenticacion->getUsuario()->getNombre() . "!";

// Redirigir según el rol
if($autenticacion->getUsuario()->getRolFk() == 1) {
    header('Location: ../../admin/index.php?s=home');
} else {
    header('Location: ../../index.php');
}
exit;
