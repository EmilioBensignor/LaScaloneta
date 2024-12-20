<?php
    use App\Modelos\Jugador;
    $jugador = new Jugador();
    $jugador = $jugador->porId($_GET['id']);
?>
<main class="mainDetalle">
    <h2><?=$jugador->getNombre();?> <?=$jugador->getApellido();?></h2>
    <section class="sectionDescripcion">
        <div>
            <img src="<?="images/" . $jugador->getImagenJugador();?>" alt="<?=$jugador->getAltImagenJugador();?>">
        </div>
        <div>
            <p><?=$jugador->getDescripcion();?></p>
        </div>
    </section>
    <section class="sectionCamiseta">
        <p>¿Querés llevarte la camiseta de <?=$jugador->getNombre();?> <?=$jugador->getApellido();?>?</p>
        <div>
            <img src="<?="images/" . $jugador->getImagenCamiseta();?>" alt="<?=$jugador->getAltImagenCamiseta();?>">
            <p>Precio: $<?=$jugador->getPrecio();?></p>
            <?php if(isset($_SESSION['usuario_data'])): ?>
                <form action="acciones/carrito/agregar.php" method="post" class="formAgregarCarrito">
                    <input type="hidden" name="jugador_id" value="<?=$jugador->getJugadorId();?>">
                    <div class="cantidadContainer">
                        <button type="button" class="btnCantidad" data-action="decrease">-</button>
                        <span class="cantidadDisplay">1</span>
                        <input type="hidden" name="cantidad" value="1" class="inputCantidad">
                        <button type="button" class="btnCantidad" data-action="increase">+</button>
                    </div>
                    <button type="submit" class="botonPrimario">Agregar al Carrito</button>
                </form>
            <?php else: ?>
                <a href="index.php?s=iniciar-sesion" class="botonPrimario">Iniciá sesión para comprar</a>
            <?php endif; ?>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

    // Agregar al carrito con fetch
    document.querySelector('.formAgregarCarrito').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const display = form.querySelector('.cantidadDisplay');
        const input = form.querySelector('.inputCantidad');
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
</script>