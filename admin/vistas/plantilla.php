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
                    <th>Numero Camiseta</th>
                    <th>Estado de Publicación</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Club</th>
                    <th>Descripcion</th>
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
                        <td><img src="<?= '../images/' . $jugador->getImagenJugador(); ?>" alt="<?= $jugador->getAltImagenJugador(); ?>" class="imgPlantilla"></td>
                        <td><img src="<?= '../images/' . $jugador->getImagenCamiseta(); ?>" alt="<?= $jugador->getAltImagenCamiseta(); ?>" class="imgPlantilla"></td>
                        <td>
                            <a href="index.php?s=jugador-editar&id=<?= $jugador->getNumeroCamiseta(); ?>">Editar</a>
                            <a href="index.php?s=jugador-eliminar&id=<?= $jugador->getNumeroCamiseta(); ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </section>
</main>