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

// Store only the necessary data as an array in the session
$usuario = $autenticacion->getUsuario();
$_SESSION['usuario_data'] = [
    'usuario_id' => $usuario->getUsuarioId(),
    'rol_fk' => $usuario->getRolFk(),
    'email' => $usuario->getEmail(),
    'nombre' => $usuario->getNombre(),
    'apellido' => $usuario->getApellido(),
];

// Redirigir según el rol
if ($autenticacion->iniciarSesion($email, $password)) {
    if ($_SESSION['usuario_data']['rol_fk'] == 1) {
        // Redirigir al admin directamente a la plantilla
        header('Location: ../../admin/index.php?s=plantilla');
    } else {
        header('Location: ../../index.php');
    }
    exit;
}
exit;
