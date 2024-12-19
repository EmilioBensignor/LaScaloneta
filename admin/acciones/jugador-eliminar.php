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
    
    // Verificamos que el jugador existe
    $jugadorExistente = $jugador->porId($id);
    if(!$jugadorExistente) {
        $_SESSION['mensajeError'] = "El jugador que intentas eliminar no existe.";
        header("Location: ../index.php?s=plantilla");
        exit;
    }
    
    // Guardamos el nombre completo antes de eliminar
    $nombreCompleto = $jugadorExistente->getNombre() . ' ' . $jugadorExistente->getApellido();
    
    // Intentamos eliminar
    $jugador->eliminar($id);
    
    $_SESSION['mensajeExito'] = "El jugador " . $nombreCompleto . " se eliminó exitosamente.";
    
} catch(\PDOException $e) {
    error_log("Error de BD al eliminar jugador: " . $e->getMessage());
    $_SESSION['mensajeError'] = "Error de base de datos al eliminar el jugador. Por favor, intenta nuevamente.";
    
} catch(\Exception $e) {
    error_log("Error general al eliminar jugador: " . $e->getMessage());
    $_SESSION['mensajeError'] = "Error al eliminar el jugador: " . $e->getMessage();
}

header("Location: ../index.php?s=plantilla");
exit;
