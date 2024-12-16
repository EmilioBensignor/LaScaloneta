<?php
use App\Modelos\Carrito;
use App\Modelos\Jugador;

$carrito = new Carrito();
$jugador = new Jugador();
$items = $carrito->getItems();
?>
<main class="main-carrito">
    <h2>Carrito de Compras</h2>
    <?php if(empty($items)): ?>
        <p>No hay items en el carrito</p>
    <?php else: ?>
        <section class="items-carrito">
            <?php foreach($items as $jugadorId => $cantidad): 
                $item = $jugador->porId($jugadorId);
                if(!$item) continue;
            ?>
            <article class="item-carrito">
                <img src="<?="images/" . $item->getImagenCamiseta();?>" alt="<?=$item->getAltImagenCamiseta();?>" class="imgItemCarrito">
                <div class="item-info">
                    <h3><?=$item->getNombre();?> <?=$item->getApellido();?></h3>
                    <p>Cantidad: <?=$cantidad;?></p>
                    <p>Precio unitario: $<?=$item->getPrecio();?></p>
                    <p>Subtotal: $<?=$item->getPrecio() * $cantidad;?></p>
                    <form action="acciones/carrito/quitar.php" method="post" class="formQuitarCarrito">
                        <input type="hidden" name="jugador_id" value="<?=$item->getNumeroCamiseta();?>">
                        <input type="hidden" name="jugador_nombre" value="<?=$item->getNombre();?> <?=$item->getApellido();?>">
                        <button type="submit">Quitar</button>
                    </form>
                </div>
            </article>
            <?php endforeach; ?>
            <div class="carrito-total">
                <p>Total: $<?=$carrito->getTotal();?></p>
                <a href="index.php?s=compra" class="btn-finalizar">Finalizar Compra</a>
            </div>
        </section>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.formQuitarCarrito').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const jugadorNombre = this.querySelector('input[name="jugador_nombre"]').value;
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar la camiseta de ${jugadorNombre} del carrito?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire(
                            'Eliminado!',
                            `La camiseta de ${data.jugador} ha sido eliminada del carrito`,
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    });
});
</script>
