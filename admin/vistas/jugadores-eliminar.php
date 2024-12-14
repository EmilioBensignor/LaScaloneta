<?php
use App\Modelos\Jugador;

$jugador = (new Jugador())->porId($_GET['id']);
?>
<main>
    <section>
        <h1>Confirmación para Eliminar Jugador</h1>

        <p>Estás por eliminar el siguiente jugador, y se necesita una confirmación para hacerlo:</p>
        
        <article>
            <div>
                <h2><?= $jugador->getNombre();?> <?= $jugador->getApellido(); ?></h2>
            </div>
            <picture>
                <source srcset="<?= "imgs/big-" . $jugador->getImagenJugador();?>" media="all and (min-width: 46.875em)">
                <img src="<?= "imgs/" . $jugador->getImagenJugador();?>" alt="<?= $jugador->getAltImagenJugador();?>">
            </picture>

            <div>
                <?= $jugador->getDescripcion();?>
            </div>
        </article>

        <h2>Confirmación</h2>
        <form action="acciones/jugadores-eliminar.php?id=<?= $jugador->getNumeroCamiseta();?>" method="post">
            <button type="submit" class="button">Confirmar eliminación</button>
        </form>
    </section>
</main>
