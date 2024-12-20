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

$id = $_GET['id'] ?? null;

if(!$id) {
    $_SESSION['mensajeError'] = "No se especificó qué jugador eliminar.";
    header("Location: ../index.php?s=plantilla");
    exit;
}

try {
    $jugador = new Jugador();
    
    $jugadorExistente = $jugador->porId($id);
    if(!$jugadorExistente) {
        $_SESSION['mensajeError'] = "El jugador que intentas eliminar no existe.";
        header("Location: ../index.php?s=plantilla");
        exit;
    }
    
    $nombre = $jugadorExistente->getNombre();
    $apellido = $jugadorExistente->getApellido();
    
    $jugador->eliminar($id);
    
    header("Location: ../index.php?s=plantilla&success=deleted&nombre=" . urlencode($nombre) . "&apellido=" . urlencode($apellido));
    exit;
    
} catch(\PDOException $e) {
    error_log("Error de BD al eliminar jugador: " . $e->getMessage());
    header("Location: ../index.php?s=plantilla&error=database");
    exit;
    
} catch(\Exception $e) {
    error_log("Error general al eliminar jugador: " . $e->getMessage());
    header("Location: ../index.php?s=plantilla&error=general");
    exit;
}
