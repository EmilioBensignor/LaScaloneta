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
                            <h3><?= $item->getNombre(); ?> <?= $item->getApellido(); ?></h3>
                            <div class="cantidad-container">
                                <button type="button" class="btn-cantidad" data-action="decrease">-</button>
                                <input type="number" name="cantidad" value="<?= $cantidad; ?>" min="1" class="input-cantidad" readonly
                                    data-jugador-id="<?= $item->getJugadorId(); ?>">
                                <button type="button" class="btn-cantidad" data-action="increase">+</button>
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

    // Manejo de los botones de cantidad
    document.querySelectorAll('.cantidad-container').forEach(container => {
        const input = container.querySelector('.input-cantidad');
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
                    // Actualizar el valor mostrado
                    input.value = newValue;
                    
                    // Recalcular y actualizar el subtotal
                    const precioUnitario = parseFloat(container.closest('.itemInfo').querySelector('p').textContent.replace('Precio unitario: $', ''));
                    const subtotalElement = container.closest('.itemInfo').querySelector('.subtotal');
                    subtotalElement.textContent = `Subtotal: $${(precioUnitario * newValue).toFixed(2)}`;
                    
                    // Actualizar el contador del carrito
                    const carritoLink = document.querySelector('nav ul li a[href="index.php?s=carrito"]');
                    if (carritoLink) {
                        carritoLink.textContent = `Carrito (${data.cantidadItems})`;
                    }
                    
                    // Actualizar el total
                    window.location.reload();
                }
            });
        };

        decreaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                updateQuantity(currentValue - 1);
            }
        });

        increaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value);
            updateQuantity(currentValue + 1);
        });
    });
</script>