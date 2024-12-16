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
            <?php if(isset($_SESSION['usuario_data'])): ?>
                <form action="acciones/carrito/agregar.php" method="post" class="formAgregarCarrito">
                    <input type="hidden" name="jugador_id" value="<?=$jugador->getNumeroCamiseta();?>">
                    <button type="submit" class="boton-primario">Agregar al carrito</button>
                </form>
            <?php else: ?>
                <a href="index.php?s=iniciar-sesion" class="btn-login">Iniciá sesión para comprar</a>
            <?php endif; ?>
        </article>
        <?php
            endforeach;
        ?>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.formAgregarCarrito').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
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