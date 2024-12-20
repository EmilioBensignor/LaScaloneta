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
            <form action="acciones/carrito/vaciar.php" method="post" class="formVaciarCarrito">
                <button type="submit" class="botonPrimario botonUnderline">Vaciar Carrito</button>
            </form>
            <div class="carritoContainer">
                <?php foreach ($items as $jugadorId => $cantidad):
                    $item = $jugador->porId($jugadorId);
                    if (!$item)
                        continue;
                ?>
                    <article class="itemCarrito">
                        <img src="<?= "images/" . $item->getImagenCamiseta(); ?>" alt="<?= $item->getAltImagenCamiseta(); ?>">
                        <div class="itemInfo">
                            <h3><?= $item->getNombre(); ?> <?= $item->getApellido(); ?></h3>
                            <div class="cantidadContainer">
                                <button type="button" class="btnCantidad" data-action="decrease">-</button>
                                <span class="cantidadDisplay"><?= $cantidad; ?></span>
                                <input type="hidden" name="cantidad" value="<?= $cantidad; ?>" class="inputCantidad"
                                    data-jugador-id="<?= $item->getJugadorId(); ?>">
                                <button type="button" class="btnCantidad" data-action="increase">+</button>
                            </div>
                            <p>Precio unitario: $<?= $item->getPrecio(); ?></p>
                            <p class="subtotal">Subtotal: $<?= $item->getPrecio() * $cantidad; ?></p>
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
                    <a href="index.php?s=compra" class="botonPrimario">Finalizar Compra</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.formQuitarCarrito').forEach(form => {
        form.addEventListener('submit', function(e) {
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

    document.querySelectorAll('.cantidadContainer').forEach(container => {
        const display = container.querySelector('.cantidadDisplay');
        const input = container.querySelector('.inputCantidad');
        const decreaseBtn = container.querySelector('[data-action="decrease"]');
        const increaseBtn = container.querySelector('[data-action="increase"]');
        const jugadorId = input.dataset.jugadorId;

        const updateQuantity = (newValue) => {
            fetch('acciones/carrito/agregar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `jugador_id=${jugadorId}&cantidad=${newValue}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        display.textContent = newValue;
                        input.value = newValue;

                        const precioUnitario = parseFloat(container.closest('.itemInfo').querySelector('p').textContent.replace('Precio unitario: $', ''));
                        const subtotalElement = container.closest('.itemInfo').querySelector('.subtotal');
                        subtotalElement.textContent = `Subtotal: $${(precioUnitario * newValue).toFixed(2)}`;

                        window.location.reload();
                    }
                });
        };

        decreaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(display.textContent);
            if (currentValue > 1) {
                updateQuantity(currentValue - 1);
            }
        });

        increaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(display.textContent);
            updateQuantity(currentValue + 1);
        });
    });
</script>