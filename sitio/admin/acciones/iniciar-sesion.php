<?php
use App\Autenticacion\Autenticacion;

require_once __DIR__ . '/../../bootstrap/init.php';

$email = $_POST['email'];
$password = $_POST['password'];

$autenticacion = new Autenticacion();

if(!$autenticacion->iniciarSesion($email, $password)) {
    $_SESSION['mensajeError'] = "Las credenciales ingresadas no coinciden con nuestros registros.";
    header('Location: ../index.php?s=iniciar-sesion');
    exit;
}

$_SESSION['mensajeExito'] = "Sesión iniciada con éxito. ¡Te damos la bienvenida <b>" . $autenticacion->getUsuario()->getEmail() . "</b> de nuevo!";
header('Location: ../index.php?s=home');
exit;

?>