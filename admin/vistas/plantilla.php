<?php
// Obtener el término de búsqueda
$searchTerm = $_GET['search'] ?? '';

$jugadores = (new \App\Modelos\Jugador())->todos();

// Filtrar jugadores si hay término de búsqueda
if (!empty($searchTerm)) {
    $jugadores = array_filter($jugadores, function($jugador) use ($searchTerm) {
        $searchLower = strtolower($searchTerm);
        return str_contains(strtolower($jugador->getNombre()), $searchLower) ||
            str_contains(strtolower($jugador->getApellido()), $searchLower) ||
            str_contains(strtolower($jugador->getNumeroCamiseta()), $searchLower) ||
            str_contains(strtolower($jugador->getClub()), $searchLower);
    });
}
?>

<main>
    <section>
        <div class="headerAdmin">
            <h1>Administración de Jugadores</h1>
            <a href="index.php?s=jugador-nuevo" class="botonPrimario">Publicar un nuevo Jugador</a>
        </div>

        <!-- Agregar formulario de búsqueda -->
        <form class="buscador-form" method="get" action="index.php">
            <input type="hidden" name="s" value="plantilla">
            <div class="buscador-container">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nombre, apellido, número o club..."
                    value="<?= htmlspecialchars($searchTerm) ?>"
                >
                <button type="submit" class="botonPrimario">Buscar</button>
            </div>
        </form>

        <?php if (empty($jugadores)): ?>
            <p class="no-resultados">No se encontraron jugadores que coincidan con tu búsqueda.</p>
        <?php else: ?>
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
        <?php endif; ?>
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