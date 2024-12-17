<?php
if(!isset($_SESSION['mensaje_exitoso'])) {
    header('Location: index.php?s=home');
    exit;
}

$mensaje = $_SESSION['mensaje_exitoso'];
unset($_SESSION['mensaje_exitoso']);
?>
<main>
    <section class="mensajeExito">
        <h2>¡Gracias por tu compra!</h2>
        <p><?=$mensaje;?></p>
        <div class="acciones">
            <a href="index.php?s=plantilla" class="botonPrimario">Seguir comprando</a>
            <a href="index.php?s=home" class="botonPrimario swal2-cancel">Volver al inicio</a>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: '¡Compra exitosa!',
    text: '<?=$mensaje;?>',
    icon: 'success',
    confirmButtonText: 'Ok'
});
</script>
