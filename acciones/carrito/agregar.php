<?php
require_once __DIR__ . '/../../bootstrap/init.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_data'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Usuario no logueado']);
    exit;
}

use App\Modelos\Carrito;
use App\Modelos\Jugador;

$jugadorId = $_POST['jugador_id'] ?? null;

if($jugadorId) {
    $carrito = new Carrito();
    $carrito->agregar((int)$jugadorId);
    
    // Obtener información del jugador para el mensaje
    $jugador = new Jugador();
    $jugadorData = $jugador->porId((int)$jugadorId);
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'jugador' => $jugadorData->getNombre() . ' ' . $jugadorData->getApellido()
    ]);
    exit;
}

header('Content-Type: application/json');
echo json_encode(['success' => false, 'error' => 'ID de jugador no proporcionado']);
exit;
