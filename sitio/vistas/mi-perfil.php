<?php
try {
    $usuario = (new App\Modelos\Usuario())->porId($_SESSION['usuario_data']['usuario_id']);
    $compras = $usuario ? $usuario->obtenerCompras() : [];
} catch (Exception $e) {
    $compras = [];
}
?>

<main>
    <h2>Mi Perfil</h2>

    <section class="datosPersonales">
        <h3>Datos Personales</h3>
        <div>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->getNombre()); ?></p>
            <p><strong>Apellido:</strong> <?= htmlspecialchars($usuario->getApellido()); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail()); ?></p>
        </div>
    </section>

    <section class="historialCompras">
        <h3>Historial de Compras</h3>
        <?php if (empty($compras)): ?>
            <p>Aún no has realizado ninguna compra.</p>
        <?php else: ?>
            <div class="listaCompras">
                <?php foreach ($compras as $compra): ?>
                    <div class="compraItem">
                        <p><strong>Fecha:</strong> <?= htmlspecialchars((new DateTime($compra['fecha_compra']))->format('d/m/Y H:i')); ?></p>
                        <p><strong>Total:</strong> $<?= htmlspecialchars(number_format($compra['total'], 2)); ?></p>
                        <p><strong>Items:</strong> <?= htmlspecialchars($compra['items'] ?? 'No hay items'); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>