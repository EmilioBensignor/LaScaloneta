<?php
require_once __DIR__ . '/../../bootstrap/init.php';

use App\Modelos\Carrito;
use App\DB\DBConexion;

if(!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php?s=login');
    exit;
}

$carrito = new Carrito();
$items = $carrito->getItems();

if(empty($items)) {
    header('Location: ../../index.php?s=carrito');
    exit;
}

try {
    $dbConexion = new DBConexion();
    $db = $dbConexion->getDB();
    $db->beginTransaction();

    $query = "INSERT INTO compras (usuario_fk, total) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$_SESSION['usuario_id'], $carrito->getTotal()]);
    $compraId = $db->lastInsertId();

    $query = "INSERT INTO detalle_compras (compra_fk, jugador_fk, cantidad, precio) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    foreach($items as $jugadorId => $cantidad) {
        $jugador = new App\Modelos\Jugador();
        $item = $jugador->porId($jugadorId);
        if($item) {
            $stmt->execute([
                $compraId,
                $jugadorId,
                $cantidad,
                $item->getPrecio()
            ]);
        }
    }

    $db->commit();

    $carrito->vaciar();
    
    $_SESSION['mensaje_exitoso'] = "¡Compra realizada con éxito!";
    header('Location: ../../index.php?s=compra-exitosa');
    exit;
} catch (\Exception $e) {
    if(isset($db)) {
        $db->rollBack();
    }
    $_SESSION['mensaje_error'] = "Ocurrió un error al procesar la compra. Por favor intente nuevamente.";
    header('Location: ../../index.php?s=carrito');
    exit;
}
