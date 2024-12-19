<?php
use App\Modelos\Carrito;
use App\Modelos\Jugador;

$carrito = new Carrito();
$jugador = new Jugador();
$items = $carrito->getItems();
?>
<main class="main-carrito">
    <h2>Carrito de Compras</h2>
    <?php if (empty($items)): ?>
        <p>No hay items en el carrito</p>
    <?php else: ?>
        <section class="sectionCarrito">
            <div class="carritoContainer">
                <?php foreach ($items as $jugadorId => $cantidad):
                    $item = $jugador->porId($jugadorId);
                    if (!$item)
                        continue;
                    ?>
                    <article class="itemCarrito">
                        <img src="<?= "images/" . $item->getImagenCamiseta(); ?>" alt="<?= $item->getAltImagenCamiseta(); ?>"
                            class="imgItemCarrito">
                        <div class="itemInfo">
                            <h3><?= $item->getNombre(); ?>         <?= $item->getApellido(); ?></h3>
                            <p>Cantidad: <?= $cantidad; ?></p>
                            <p>Precio unitario: $<?= $item->getPrecio(); ?></p>
                            <p>Subtotal: $<?= $item->getPrecio() * $cantidad; ?></p>
                            <form action="acciones/carrito/quitar.php" method="post" class="formQuitarCarrito">
                                <input type="hidden" name="jugador_id" value="<?= $item->getJugadorId(); ?>">
                                <input type="hidden" name="jugador_nombre"
                                    value="<?= $item->getNombre(); ?> <?= $item->getApellido(); ?>">
                                <button type="submit" class="botonPrimario">Quitar</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="carritoTotal">
                <p>Total: $<?= $carrito->getTotal(); ?></p>
                <div class="botonesCarrito">
                    <form action="acciones/carrito/vaciar.php" method="post" class="formVaciarCarrito">
                        <button type="submit" class="botonPrimario">Vaciar Carrito</button>
                    </form>
                    <a href="index.php?s=compra" class="botonPrimario">Finalizar Compra</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.formQuitarCarrito').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const jugadorNombre = this.querySelector('input[name="jugador_nombre"]').value;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Deseas eliminar la camiseta de ${jugadorNombre} del carrito?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this)
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Eliminado!',
                                    `La camiseta de ${data.jugador} ha sido eliminada del carrito`,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            }
                        });
                }
            });
        });
    });

    // Agregar manejador para el formulario de vaciar carrito
    document.querySelector('.formVaciarCarrito').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas vaciar completamente el carrito?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, vaciar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                '¡Carrito vaciado!',
                                'El carrito ha sido vaciado exitosamente',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        }
                    });
            }
        });
    });
</script>