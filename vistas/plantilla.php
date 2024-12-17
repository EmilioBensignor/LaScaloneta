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
                            <button type="submit" class="boton-primario">Agregar al carrito</button>
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
                        Swal.fire({
                            title: 'Éxito!',
                            text: `Has agregado la camiseta de ${data.jugador} al carrito`,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
        });
    });
</script>