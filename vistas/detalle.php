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
        <p>¿Querés llevarte la camiseta de <?=$jugador->getNombre();?> <?=$jugador->getApellido();?>? ¡Próximamente en otro parcial podrás comprarla!</p>
        <div>
            <img src="<?="images/" . $jugador->getImagenCamiseta();?>" alt="<?=$jugador->getAltImagenCamiseta();?>">
            <p>Precio: $<?=$jugador->getPrecio();?></p>
            <?php if(isset($_SESSION['usuario_data'])): ?>
                <form action="acciones/carrito/agregar.php" method="post">
                    <input type="hidden" name="jugador_id" value="<?=$jugador->getNumeroCamiseta();?>">
                    <button type="submit">Agregar al Carrito</button>
                </form>
            <?php else: ?>
                <a href="index.php?s=iniciar-sesion" class="botonPrimario">Iniciá sesión para comprar</a>
            <?php endif; ?>
        </div>
    </section>
</main>