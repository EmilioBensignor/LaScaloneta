<?php

use App\Modelos\EstadoPublicacion;
use App\Modelos\Jugador;
use App\Modelos\Posicion;


$jugador = (new Jugador())->porId($_GET['id']);
$jugador->cargarPosicionesId();

if (isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    unset($_SESSION['errores']);
} else {
    $errores = [];
}
if (isset($_SESSION['dataForm'])) {
    $dataForm = $_SESSION['dataForm'];
    unset($_SESSION['dataForm']);
} else {
    $dataForm = [];
}

$estadosPublicacion = (new EstadoPublicacion())->todos();
$posiciones = (new Posicion())->todas();
?>
<main>
    <section class="sectionAdmin">
        <h1>Editar el Jugador "<b><?= $jugador->getNombre(); ?> <?= $jugador->getApellido(); ?></b>"</h1>

        <form action="acciones/jugador-editar.php?id=<?= $jugador->getJugadorId(); ?>" method="post" enctype="multipart/form-data">
            <div class="formContainer">
                <div class="formFila">
                    <label for="nombre">Nombre</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control"
                        value="<?= $dataForm['nombre'] ?? $jugador->getNombre(); ?>"
                        <?= isset($errores['nombre']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['nombre'])): ?>
                        <div class="error-message"><?= $errores['nombre']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="formFila">
                    <label for="apellido">Apellido</label>
                    <input
                        type="text"
                        id="apellido"
                        name="apellido"
                        class="form-control"
                        value="<?= $dataForm['apellido'] ?? $jugador->getApellido(); ?>"
                        <?= isset($errores['apellido']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['apellido'])): ?>
                        <div class="error-message"><?= $errores['apellido']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="formContainer">
                <div class="formFila">
                    <label for="numero_camiseta">Numero Camiseta</label>
                    <input
                        type="number"
                        id="numero_camiseta"
                        name="numero_camiseta"
                        class="form-control"
                        value="<?= $dataForm['numero_camiseta'] ?? $jugador->getNumeroCamiseta(); ?>"
                        <?= isset($errores['numero_camiseta']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['numero_camiseta'])): ?>
                        <div class="error-message"><?= $errores['numero_camiseta']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="formFila">
                    <label for="club">Club</label>
                    <input
                        type="text"
                        id="club"
                        name="club"
                        class="form-control"
                        value="<?= $dataForm['club'] ?? $jugador->getClub(); ?>"
                        <?= isset($errores['club']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['club'])): ?>
                        <div class="error-message"><?= $errores['club']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="formFila">
                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    <?= isset($errores['descripcion']) ? 'aria-invalid="true"' : ''; ?>><?= $dataForm['descripcion'] ?? $jugador->getDescripcion(); ?></textarea>
                <?php if (isset($errores['descripcion'])): ?>
                    <div class="error-message"><?= $errores['descripcion']; ?></div>
                <?php endif; ?>
            </div>
            <div class="formContainer">
                <div class="formFila">
                    <?php
                    if (!empty($jugador->getImagenJugador())):
                    ?>
                        <img src="<?= '../imgs/' . $jugador->getImagenJugador(); ?>" alt="">
                    <?php
                    else:
                    ?>
                        <p><i>No tiene una imagen.</i></p>
                    <?php
                    endif;
                    ?>
                    <div>
                        <label for="imagen_jugador">Imagen del Jugador (opcional)</label>
                        <input
                            type="file"
                            id="imagen_jugador"
                            name="imagen_jugador"
                            class="form-control">
                        <p class="form-help" id="help-imagen_jugador">Solo elegí una imagen si querés cambiar la actual.</p>
                    </div>
                </div>
                <div class="formFila">
                    <label for="imagen_jugador_alt">Alt de la imagen Jugador (opcional)</label>
                    <input
                        type="text"
                        id="imagen_jugador_alt"
                        name="imagen_jugador_alt"
                        class="form-control"
                        value="<?= $dataForm['imagen_jugador_alt'] ?? $jugador->getAltImagenJugador(); ?>">
                </div>
            </div>
            <div class="formContainer">
                <div class="formFila">
                    <?php
                    if (!empty($jugador->getImagenCamiseta())):
                    ?>
                        <img src="<?= '../imgs/' . $jugador->getImagenCamiseta(); ?>" alt="">
                    <?php
                    else:
                    ?>
                        <p><i>No tiene una imagen.</i></p>
                    <?php
                    endif;
                    ?>
                    <div class="formFila">
                        <label for="imagen_camiseta">Imagen de la camiseta (opcional)</label>
                        <input
                            type="file"
                            id="imagen_camiseta"
                            name="imagen_camiseta"
                            class="form-control">
                        <p class="form-help" id="help-imagen_camiseta">Solo elegí una imagen si querés cambiar la actual.</p>
                    </div>
                </div>
                <div class="formFila">
                    <label for="imagen_camiseta_alt">Alt de la imagen Camiseta (opcional)</label>
                    <input
                        type="text"
                        id="imagen_camiseta_alt"
                        name="imagen_camiseta_alt"
                        class="form-control"
                        value="<?= $dataForm['imagen_camiseta_alt'] ?? $jugador->getAltImagenCamiseta(); ?>">
                </div>
            </div>
            <div class="formContainer">
                <div class="formFila">
                    <label for="precio">Precio</label>
                    <input
                        type="number"
                        step="0.01"
                        id="precio"
                        name="precio"
                        class="form-control"
                        value="<?= $dataForm['precio'] ?? $jugador->getPrecio(); ?>"
                        <?= isset($errores['precio']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['precio'])): ?>
                        <div class="error-message"><?= $errores['precio']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="formFila">
                    <label for="estado_publicacion_fk">Estado de Publicación</label>
                    <select name="estado_publicacion_fk" id="estado_publicacion_fk" class="form-control">
                        <?php
                        foreach ($estadosPublicacion as $estadoPublicacion):
                        ?>
                            <option
                                value="<?= $estadoPublicacion->getEstadoPublicacionId(); ?>"
                                <?= $estadoPublicacion->getEstadoPublicacionId() == ($dataForm['estado_publicacion_fk'] ?? $jugador->getEstadoPublicacionFk()) ? 'selected' : ''; ?>>
                                <?= $estadoPublicacion->getEstado(); ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="formCheck">
                <?php
                foreach ($posiciones as $posicion):
                ?>
                    <label>
                        <input
                            type="checkbox"
                            name="posiciones[]"
                            value="<?= $posicion->getPosicionId(); ?>"
                            <?= (in_array($posicion->getPosicionId(), $dataForm['posiciones'] ?? $jugador->getPosicionId())) ? 'checked' : ''; ?>>
                        <?= $posicion->getNombre(); ?>
                    </label>
                <?php
                endforeach;
                ?>
            </div>
            <button type="submit" class="botonPrimario">Editar</button>
        </form>
    </section>
</main>