<?php
use App\Modelos\Usuario;

require_once __DIR__ . '/../../bootstrap/init.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$password = $_POST['password'];

$usuario = new Usuario();

if($usuario->emailExiste($email)) {
    $_SESSION['mensajeError'] = "El email ya está registrado. Por favor, utiliza otro email o inicia sesión.";
    header('Location: ../../index.php?s=registro');
    exit;
}

$usuario->setRolFk(2);
$usuario->setNombre($nombre);
$usuario->setApellido($apellido);
$usuario->setEmail($email);
$usuario->setPassword($password);

if($usuario->crear()) {
    $_SESSION['mensajeExito'] = "Usuario registrado exitosamente. Por favor, inicia sesión.";
    header('Location: ../../index.php?s=iniciar-sesion');
} else {
    $_SESSION['mensajeError'] = "Hubo un error al registrar el usuario. Por favor, intenta nuevamente.";
    header('Location: ../../index.php?s=registro');
}
exit;
