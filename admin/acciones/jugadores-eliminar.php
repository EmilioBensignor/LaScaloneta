<?php

use App\Autenticacion\Autenticacion;
use App\Modelos\Jugador;

require_once __DIR__ . '/../../bootstrap/init.php';

$autenticacion = new Autenticacion();


if(!$autenticacion->estaAutenticado()) {
    $_SESSION['mensajeError'] = "Realizar esta acción requiere iniciar sesión.";
    header("Location: ../index.php?s=iniciar-sesion");
    exit;
}

$id = $_GET['id'];

try {
    (new Jugador())->eliminar($id);

    $_SESSION['mensajeExito'] = "El jugador se eliminó exitosamente.";
    header("Location: ../index.php?s=plantilla");
    exit;
} catch(\Exception $e) {
    $_SESSION['mensajeError'] = "Ocurrió un error inesperado al tratar de eliminar el jugador.";
    header("Location: ../index.php?s=plantilla");
    exit;
}
