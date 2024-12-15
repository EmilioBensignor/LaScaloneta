<?php
    use App\Modelos\Jugador;
    $jugador = new Jugador();
    $jugadores = $jugador->publicados();
?>

<main class="main-plantilla">
    <h2>Jugadores</h2>
    <section class="sectionExplicación">
        <p>Hacé click en el nombre de tu jugador favorito para poder ver más información de él y poder llevarte ¡tu camiseta!</p>
    </section>
    <section class="sectionJugadores">
        <?php
            foreach($jugadores as $jugador):
        ?>
        <article class="card">
            <div>
                <img src="<?="images/" . $jugador->getImagenJugador();?>" alt="<?=$jugador->getAltImagenJugador();?>">
            </div>
            <a href="index.php?s=detalle&id=<?=$jugador->getNumeroCamiseta();?>"><h3><?=$jugador->getNombre();?></h3> <h3><?=$jugador->getApellido();?></h3></a>
            <p><?= $jugador->getClub();?></p>
            <p>Precio: $<?=$jugador->getPrecio();?></p>
            <button>Comprar</button>
        </article>
        <?php
            endforeach;
        ?>
    </section>
</main>