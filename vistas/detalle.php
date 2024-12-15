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
            <button>Comprar</button>
        </div>
    </section>
</main>