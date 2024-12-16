<?php
use App\Modelos\Carrito;

$carrito = new Carrito();
$items = $carrito->getItems();

if(empty($items)) {
    header('Location: index.php?s=carrito');
    exit;
}
?>
<main class="main-compra">
    <h2>Finalizar Compra</h2>
    <section class="resumen-compra">
        <h3>Resumen de la compra</h3>
        <p>Total a pagar: $<?=$carrito->getTotal();?></p>
        <p>Cantidad de items: <?=$carrito->getCantidadItems();?></p>
    </section>

    <section class="form-compra">
        <form action="acciones/compra/procesar.php" method="post" class="form">
            <div class="form-group">
                <label for="nombre">Nombre en la tarjeta</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="numero">Número de tarjeta</label>
                <input type="text" id="numero" name="numero" required pattern="[0-9]{16}" title="Ingrese los 16 dígitos de la tarjeta">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="vencimiento">Vencimiento (MM/YY)</label>
                    <input type="text" id="vencimiento" name="vencimiento" required pattern="(0[1-9]|1[0-2])\/([0-9]{2})" title="Formato MM/YY">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" required pattern="[0-9]{3,4}" title="3 o 4 dígitos">
                </div>
            </div>
            <button type="submit" class="btn-comprar">Confirmar Compra</button>
        </form>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelector('.form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: '¿Confirmar compra?',
        text: "Se procesará el pago por $<?=$carrito->getTotal();?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, comprar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
