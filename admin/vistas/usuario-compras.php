<?php
if (!isset($_GET['id'])) {
    $_SESSION['mensajeError'] = "ID de usuario no proporcionado";
    header('Location: index.php?s=usuarios');
    exit;
}

$userId = $_GET['id'];
$db = (new \App\DB\DBConexion())->getDB();

// Get user info
$queryUsuario = "SELECT * FROM usuarios WHERE usuario_id = ?";
$stmtUsuario = $db->prepare($queryUsuario);
$stmtUsuario->execute([$userId]);
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    $_SESSION['mensajeError'] = "Usuario no encontrado";
    header('Location: index.php?s=usuarios');
    exit;
}

// Get purchases for this user grouped by compra_id
$queryCompras = "SELECT c.compra_id, c.fecha_compra, c.total as total_compra,
                        j.nombre as jugador_nombre, j.apellido as jugador_apellido, 
                        dc.cantidad, dc.precio
                 FROM compras c 
                 JOIN detalle_compras dc ON dc.compra_fk = c.compra_id
                 JOIN jugadores j ON dc.jugador_fk = j.jugador_id
                 WHERE c.usuario_fk = ?
                 ORDER BY c.fecha_compra DESC, c.compra_id";
$stmtCompras = $db->prepare($queryCompras);
$stmtCompras->execute([$userId]);
$compras = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);

// Group purchases by compra_id
$comprasAgrupadas = [];
foreach ($compras as $compra) {
    $compraId = $compra['compra_id'];
    if (!isset($comprasAgrupadas[$compraId])) {
        $comprasAgrupadas[$compraId] = [
            'fecha_compra' => $compra['fecha_compra'],
            'total_compra' => $compra['total_compra'],
            'items' => []
        ];
    }
    $comprasAgrupadas[$compraId]['items'][] = $compra;
}
?>

<main class="container">
    <section class="sectionAdmin">
        <h1>Compras realizadas por <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></h1>

        <a href="index.php?s=usuarios" class="botonPrimario volverButton">← Volver a usuarios</a>

        <?php if (empty($compras)): ?>
            <p>No hay compras registradas para este usuario.</p>
        <?php else: ?>
            <div class="comprasContainer">
                <?php foreach ($comprasAgrupadas as $compraId => $compra): ?>
                    <div class="compraGrupo">
                        <h2>Compra #<?= htmlspecialchars($compraId) ?> - <?= htmlspecialchars(date('d/m/Y', strtotime($compra['fecha_compra']))) ?></h2>
                        <div class="tablaAdminContainer comprasUsuarios">
                            <table class="tablaAdmin">
                                <thead>
                                    <tr>
                                        <th>Jugador</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($compra['items'] as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['jugador_nombre'] . ' ' . $item['jugador_apellido']) ?></td>
                                            <td><?= htmlspecialchars($item['cantidad']) ?></td>
                                            <td>$<?= htmlspecialchars($item['precio']) ?></td>
                                            <td>$<?= htmlspecialchars($item['cantidad'] * $item['precio']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="total-row">
                                        <td colspan="3" class="text-right"><strong>Total de la compra:</strong></td>
                                        <td><strong>$<?= htmlspecialchars($compra['total_compra']) ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>