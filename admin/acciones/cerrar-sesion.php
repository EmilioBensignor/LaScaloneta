<?php
use App\Autenticacion\Autenticacion;

require_once __DIR__ . '/../../bootstrap/init.php';

(new Autenticacion())->cerrarSesion();

$_SESSION['mensajeExito'] = "Sesión cerrada con éxito. ¡Te esperamos de nuevo pronto!";
header('Location: ../index.php?s=iniciar-sesion');
exit;
