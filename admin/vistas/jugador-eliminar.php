<?php

use App\Modelos\Jugador;

$jugador = (new Jugador())->porId($_GET['id']);
?>
<main>
    <section class="sectionAdmin">
        <h1>Confirmación para Eliminar Jugador</h1>

        <p class="estarPor">Estás por eliminar a <span><?= $jugador->getNombre(); ?> <?= $jugador->getApellido(); ?></span></p>
        <form action="acciones/jugador-eliminar.php?id=<?= $jugador->getJugadorId(); ?>" method="post">
            <button type="submit" class="botonPrimario">Confirmar eliminación</button>
        </form>
    </section>
</main>