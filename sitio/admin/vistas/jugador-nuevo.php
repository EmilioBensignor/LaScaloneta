<?php

use App\Modelos\EstadoPublicacion;
use App\Modelos\Posicion;

$errores = [];
$dataForm = $_POST;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['nombre'])) {
        $errores['nombre'] = "El nombre no puede estar vacío.";
    } elseif (strlen($_POST['nombre']) < 2) {
        $errores['nombre'] = "El nombre debe tener al menos 2 caracteres.";
    }

    if (empty($_POST['apellido'])) {
        $errores['apellido'] = "El apellido no puede estar vacío.";
    } elseif (strlen($_POST['apellido']) < 2) {
        $errores['apellido'] = "El apellido debe tener al menos 2 caracteres.";
    }

    if (empty($_POST['numero_camiseta'])) {
        $errores['numero_camiseta'] = "El número de camiseta es obligatorio.";
    } elseif (!filter_var($_POST['numero_camiseta'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 99]])) {
        $errores['numero_camiseta'] = "El número de camiseta debe ser un número entre 1 y 99.";
    }

    if (empty($_POST['club'])) {
        $errores['club'] = "El club no puede estar vacío.";
    } elseif (strlen($_POST['club']) < 2) {
        $errores['club'] = "El club debe tener al menos 2 caracteres.";
    }

    if (empty($_POST['descripcion'])) {
        $errores['descripcion'] = "La descripción no puede estar vacía.";
    } elseif (strlen($_POST['descripcion']) < 10) {
        $errores['descripcion'] = "La descripción debe tener al menos 10 caracteres.";
    }

    if (empty($_FILES['imagen_jugador']['name'])) {
        $errores['imagen_jugador'] = 'Debes ingresar una imagen del jugador.';
    } else {
        $extension = strtolower(pathinfo($_FILES['imagen_jugador']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $errores['imagen_jugador'] = 'Solo se aceptan imágenes en formato JPG o PNG.';
        }
    }

    if (empty($_FILES['imagen_camiseta']['name'])) {
        $errores['imagen_camiseta'] = 'Debes ingresar una imagen de la camiseta.';
    } else {
        $extension = strtolower(pathinfo($_FILES['imagen_camiseta']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $errores['imagen_camiseta'] = 'Solo se aceptan imágenes en formato JPG o PNG.';
        }
    }

    if (empty($_POST['alt_imagen_jugador'])) {
        $errores['alt_imagen_jugador'] = 'El alt de la imagen del jugador no puede estar vacío.';
    }

    if (empty($_POST['alt_imagen_camiseta'])) {
        $errores['alt_imagen_camiseta'] = 'El alt de la imagen de la camiseta no puede estar vacío.';
    }

    if (empty($_POST['precio']) || $_POST['precio'] == '0.00' || $_POST['precio'] == '0') {
        $errores['precio'] = 'El precio no puede ser 0.';
    }

    if (empty($_POST['posiciones'])) {
        $errores['posiciones'] = 'El jugador debe tener al menos una posición.';
    }

    if (empty($errores)) {
        require __DIR__ . '/../acciones/jugadores-publicar.php';
        exit;
    }
}

$estadosPublicacion = (new EstadoPublicacion())->todos();
$posiciones = (new Posicion())->todas();
?>
<main>
    <section class="sectionAdmin">
        <h1>Publicar un nuevo Jugador</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="formContainer">
                <div class="formFila">
                    <label for="nombre">Nombre</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control"
                        value="<?= $dataForm['nombre'] ?? ''; ?>"
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
                        value="<?= $dataForm['apellido'] ?? ''; ?>"
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
                        value="<?= $dataForm['numero_camiseta'] ?? ''; ?>"
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
                        value="<?= $dataForm['club'] ?? ''; ?>"
                        <?= isset($errores['club']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['club'])): ?>
                        <div class="error-message"><?= $errores['club']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="formFila">
                <label for="descripcion">Descripcion</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    <?= isset($errores['descripcion']) ? 'aria-invalid="true"' : ''; ?>
                    aria-describedby="error-descripcion"><?= $dataForm['descripcion'] ?? ''; ?></textarea>
                <?php if (isset($errores['descripcion'])): ?>
                    <div class="error-message" id="error-descripcion"><?= $errores['descripcion']; ?></div>
                <?php endif; ?>
            </div>
            <div class="formContainer">
                <div class="formFila">
                    <label for="imagen_jugador">Imagen del Jugador</label>
                    <input type="file" id="imagen_jugador" name="imagen_jugador" class="form-control" <?= isset($errores['imagen_jugador']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['imagen_jugador'])): ?>
                        <div class="error-message"><?= $errores['imagen_jugador']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="formFila">
                    <label for="alt_imagen_jugador">Alt de la Imagen del Jugador</label>
                    <input
                        type="text"
                        id="alt_imagen_jugador"
                        name="alt_imagen_jugador"
                        class="form-control"
                        value="<?= $dataForm['alt_imagen_jugador'] ?? ''; ?>"
                        <?= isset($errores['alt_imagen_jugador']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['alt_imagen_jugador'])): ?>
                        <div class="error-message"><?= $errores['alt_imagen_jugador']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="formContainer">
                <div class="formFila">
                    <label for="imagen_camiseta">Imagen de la Camiseta</label>
                    <input type="file" id="imagen_camiseta" name="imagen_camiseta" class="form-control" <?= isset($errores['imagen_camiseta']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['imagen_camiseta'])): ?>
                        <div class="error-message"><?= $errores['imagen_camiseta']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="formFila">
                    <label for="alt_imagen_camiseta">Alt de la Imagen de la Camiseta</label>
                    <input
                        type="text"
                        id="alt_imagen_camiseta"
                        name="alt_imagen_camiseta"
                        class="form-control"
                        value="<?= $dataForm['alt_imagen_camiseta'] ?? ''; ?>"
                        <?= isset($errores['alt_imagen_camiseta']) ? 'aria-invalid="true"' : ''; ?>>
                    <?php if (isset($errores['alt_imagen_camiseta'])): ?>
                        <div class="error-message"><?= $errores['alt_imagen_camiseta']; ?></div>
                    <?php endif; ?>
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
                        value="<?= $dataForm['precio'] ?? '0.00'; ?>"
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
                                <?= $estadoPublicacion->getEstadoPublicacionId() == ($dataForm['estado_publicacion_fk'] ?? null) ? 'selected' : ''; ?>>
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
                            <?= (in_array($posicion->getPosicionId(), $dataForm['posiciones'] ?? [])) ? 'checked' : ''; ?>>
                        <?= $posicion->getNombre(); ?>
                    </label>
                <?php
                endforeach;
                ?>
            </div>
            <?php if (isset($errores['posiciones'])): ?>
                <div class="error-message"><?= $errores['posiciones']; ?></div>
            <?php endif; ?>
            <button type="submit" class="botonPrimario">Publicar</button>
        </form>
    </section>
</main>