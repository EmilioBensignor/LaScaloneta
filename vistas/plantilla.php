<?php
use App\Modelos\Jugador;
$jugador = new Jugador();
$jugadores = $jugador->publicados();
?>

<main class="main-plantilla">
    <div class="explicacion">
        <h2>Jugadores</h2>
        <p>
            Hacé click en el nombre de tu jugador favorito para poder ver más información de él y poder llevarte ¡tu
            camiseta!
        </p>
    </div>
    <section class="sectionJugadores">
        <?php
        foreach ($jugadores as $jugador):
            ?>
            <article class="card">
                <a href="index.php?s=detalle&id=<?= $jugador->getNumeroCamiseta(); ?>">
                    <img src="<?= "images/" . $jugador->getImagenJugador(); ?>"
                        alt="<?= $jugador->getAltImagenJugador(); ?>" />
                    <div class="cardBody">
                        <h3><?= $jugador->getNombre(); ?>     <?= $jugador->getApellido(); ?></h3>
                        <p><?= $jugador->getClub(); ?></p>
                        <p>Precio: $<?= $jugador->getPrecio(); ?></p>
                    </div>
                </a>
                <div class="cardAction">
                    <?php if (isset($_SESSION['usuario_data'])): ?>
                        <form action="acciones/carrito/agregar.php" method="post" class="formAgregarCarrito">
                            <input type="hidden" name="jugador_id" value="<?= $jugador->getNumeroCamiseta(); ?>">
                            <div class="cantidad-container">
                                <button type="button" class="btn-cantidad" data-action="decrease">-</button>
                                <input type="number" name="cantidad" value="1" min="1" class="input-cantidad" readonly>
                                <button type="button" class="btn-cantidad" data-action="increase">+</button>
                            </div>
                            <button type="submit" class="botonPrimario">Agregar al carrito</button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?s=iniciar-sesion" class="botonPrimario">Iniciá sesión para comprar</a>
                    <?php endif; ?>
                </div>
            </article>
            <?php
        endforeach;
        ?>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.formAgregarCarrito').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar el contador del carrito
                        const carritoLink = document.querySelector('nav ul li a[href="index.php?s=carrito"]');
                        if (carritoLink) {
                            carritoLink.textContent = `Carrito (${data.cantidadItems})`;
                        }

                        Swal.fire({
                            title: 'Éxito!',
                            text: `Has agregado ${this.querySelector('.input-cantidad').value} camiseta(s) de ${data.jugador} al carrito`,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
        });
    });

    // Manejo de los botones de cantidad
    document.querySelectorAll('.cantidad-container').forEach(container => {
        const input = container.querySelector('.input-cantidad');
        const decreaseBtn = container.querySelector('[data-action="decrease"]');
        const increaseBtn = container.querySelector('[data-action="increase"]');

        decreaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value);
            input.value = currentValue + 1;
        });
    });
</script>