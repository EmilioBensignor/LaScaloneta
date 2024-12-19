<?php
$jugadores = (new \App\Modelos\Jugador())->todos();
?>

<main>
    <section>
        <h1>Administración de Jugadores</h1>

        <div>
            <a href="index.php?s=jugador-nuevo">Publicar un nuevo Jugador</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número Camiseta</th>
                    <th>Estado de Publicación</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Club</th>
                    <th>Descripcion</th>
                    <th>Posicion</th>
                    <th>Precio</th>
                    <th>Imagen del Jugador</th>
                    <th>Imagen de la Camiseta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($jugadores as $jugador) :
                ?>
                    <tr>
                        <td><?= $jugador->getJugadorId(); ?></td>
                        <td><?= $jugador->getNumeroCamiseta(); ?></td>
                        <td><?= $jugador->getEstadoPublicacion()->getEstado(); ?></td>
                        <td><?= $jugador->getNombre(); ?></td>
                        <td><?= $jugador->getApellido(); ?></td>
                        <td><?= $jugador->getClub(); ?></td>
                        <td><?= $jugador->getDescripcion(); ?></td>
                        <td>
                            <?php
                            if (count($jugador->getPosiciones()) > 0) :
                            ?>
                                <?php
                                foreach ($jugador->getPosiciones() as $posicion) :
                                ?>
                                    <div class="badge"><?= $posicion->getNombre(); ?></div>
                                <?php
                                endforeach;
                                ?>
                            <?php
                            else:
                            ?>
                                <i>Sin posiciones</i>
                            <?php
                            endif;
                            ?>
                        </td>
                        <td>$<?= $jugador->getPrecio(); ?></td>
                        <td><img src="<?= '../images/' . $jugador->getImagenJugador(); ?>" alt="<?= $jugador->getAltImagenJugador(); ?>" class="imgPlantilla"></td>
                        <td><img src="<?= '../images/' . $jugador->getImagenCamiseta(); ?>" alt="<?= $jugador->getAltImagenCamiseta(); ?>" class="imgPlantilla"></td>
                        <td>
                            <a href="index.php?s=jugador-editar&id=<?= $jugador->getJugadorId(); ?>">Editar</a>
                            <a href="index.php?s=jugador-eliminar&id=<?= $jugador->getJugadorId(); ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </section>
</main>

<!-- Add this in the head section or before closing body -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['success']) && $_GET['success'] === 'created'): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Jugador agregado!',
        text: 'El jugador <?= urldecode($_GET['nombre'] ?? ''); ?> <?= urldecode($_GET['apellido'] ?? ''); ?> se ha creado exitosamente',
        confirmButtonColor: '#28a745'
    });
</script>
<?php endif; ?>

<?php if(isset($_GET['success']) && $_GET['success'] === 'edited'): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Jugador editado!',
        text: 'El jugador <?= urldecode($_GET['nombre'] ?? ''); ?> <?= urldecode($_GET['apellido'] ?? ''); ?> se ha editado exitosamente',
        confirmButtonColor: '#28a745'
    });
</script>
<?php endif; ?>

<?php if(isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Jugador eliminado!',
        text: 'El jugador <?= urldecode($_GET['nombre'] ?? ''); ?> <?= urldecode($_GET['apellido'] ?? ''); ?> se ha eliminado exitosamente',
        confirmButtonColor: '#28a745'
    });
</script>
<?php endif; ?>