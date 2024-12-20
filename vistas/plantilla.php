<?php
use App\Modelos\Jugador;
$jugador = new Jugador();

// Obtener el término de búsqueda
$searchTerm = $_GET['search'] ?? '';

// Obtener jugadores filtrados
$jugadores = $jugador->publicados();

if (!empty($searchTerm)) {
    $jugadores = array_filter($jugadores, function($jugador) use ($searchTerm) {
        $searchLower = strtolower($searchTerm);
        $nombreCompleto = strtolower($jugador->getNombre() . ' ' . $jugador->getApellido());
        
        return str_contains($nombreCompleto, $searchLower) ||
            str_contains(strtolower($jugador->getNombre()), $searchLower) ||
            str_contains(strtolower($jugador->getApellido()), $searchLower) ||
            str_contains(strtolower($jugador->getNumeroCamiseta()), $searchLower);
    });
}
?>

<main class="main-plantilla">
    <div class="explicacion">
        <h2>Jugadores</h2>
        <p>
            Hacé click en el nombre de tu jugador favorito para poder ver más información de él y poder llevarte ¡tu
            camiseta!
        </p>
        <!-- Agregar formulario de búsqueda -->
        <form class="buscadorForm" method="get" action="index.php">
            <input type="hidden" name="s" value="plantilla">
            <div class="buscadorContainer">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nombre, apellido o número..."
                    value="<?= htmlspecialchars($searchTerm) ?>"
                >
                <button type="submit" class="botonPrimario">Buscar</button>
            </div>
        </form>
    </div>
    
    <section class="sectionJugadores">
        <?php if (empty($jugadores)): ?>
            <p class="no-resultados">No se encontraron jugadores que coincidan con tu búsqueda.</p>
        <?php else: ?>
            <?php foreach ($jugadores as $jugador): ?>
            <article class="card">
                <a href="index.php?s=detalle&id=<?= $jugador->getJugadorId(); ?>">
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
                            <input type="hidden" name="jugador_id" value="<?= $jugador->getJugadorId(); ?>">
                            <div class="cantidadContainer">
                                <button type="button" class="btnCantidad" data-action="decrease">-</button>
                                <span class="cantidadDisplay">1</span>
                                <input type="hidden" name="cantidad" value="1" class="inputCantidad">
                                <button type="button" class="btnCantidad" data-action="increase">+</button>
                            </div>
                            <button type="submit" class="botonPrimario">Agregar al carrito</button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?s=iniciar-sesion" class="botonPrimario">Iniciá sesión para comprar</a>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.formAgregarCarrito').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const display = this.querySelector('.cantidadDisplay');
            const input = this.querySelector('.inputCantidad');
            const cantidadAgregada = input.value; // Guardar la cantidad antes de resetear

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

                        // Resetear la cantidad a 1
                        display.textContent = '1';
                        input.value = '1';

                        Swal.fire({
                            title: 'Éxito!',
                            text: `Has agregado ${cantidadAgregada} camiseta(s) de ${data.jugador} al carrito`,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
        });
    });

    // Manejo de los botones de cantidad
    document.querySelectorAll('.cantidadContainer').forEach(container => {
        const display = container.querySelector('.cantidadDisplay');
        const input = container.querySelector('.inputCantidad');
        const decreaseBtn = container.querySelector('[data-action="decrease"]');
        const increaseBtn = container.querySelector('[data-action="increase"]');

        decreaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(display.textContent);
            if (currentValue > 1) {
                display.textContent = currentValue - 1;
                input.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(display.textContent);
            display.textContent = currentValue + 1;
            input.value = currentValue + 1;
        });
    });
</script>