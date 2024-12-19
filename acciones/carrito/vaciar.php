<?php
require_once __DIR__ . '/../../bootstrap/init.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_data'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Usuario no logueado']);
    exit;
}

use App\Modelos\Carrito;

$carrito = new Carrito();
$carrito->vaciar();

header('Content-Type: application/json');
echo json_encode(['success' => true]);
exit;
