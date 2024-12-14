<?php
use App\Modelos\EstadoPublicacion;
use App\Modelos\Posicion;

if(isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    unset($_SESSION['errores']);
} else {
    $errores = [];
}
if(isset($_SESSION['dataForm'])) {
    $dataForm = $_SESSION['dataForm'];
    unset($_SESSION['dataForm']);
}

$estadosPublicacion = (new EstadoPublicacion())->todos();
$posiciones = (new Posicion())->todas();
?>
<main>
    <section>
        <h1>Publicar un nuevo Jugador</h1>
        <form action="acciones/jugadores-publicar.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control"
                    value="<?= $dataForm['nombre'] ?? '';?>"
                    aria-describedby="help-nombre <?= isset($errores['nombre']) ? 'error-nombre' : '';?>"
                    <?php
                    if(isset($errores['nombre'])):
                    ?>
                    aria-invalid="true"
                    <?php
                    endif;
                    ?>
                >
                <div class="form-help" id="help-nombre">Debe tener al menos 3 caracteres.</div>
                <?php
                if(isset($errores['nombre'])):
                ?>
                    <div class="msg-error" id="error-nombre"><?= $errores['nombre'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="apellido">Apellido</label>
                <input
                    type="text"
                    id="apellido"
                    name="apellido"
                    class="form-control"
                    value="<?= $dataForm['apellido'] ?? '';?>"
                    aria-describedby="help-apellido <?= isset($errores['apellido']) ? 'error-apellido' : '';?>"
                    <?php
                    if(isset($errores['apellido'])):
                    ?>
                    aria-invalid="true"
                    <?php
                    endif;
                    ?>
                >
                <div class="form-help" id="help-apellido">Debe tener al menos 3 caracteres.</div>
                <?php
                if(isset($errores['apellido'])):
                ?>
                    <div class="msg-error" id="error-apellido"><?= $errores['apellido'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="camiseta">Numero Camiseta</label>
                <input
                    type="number"
                    id="camiseta"
                    name="camiseta"
                    class="form-control"
                    value="<?= $dataForm['camiseta'] ?? '';?>"
                    aria-describedby="help-camiseta <?= isset($errores['camiseta']) ? 'error-camiseta' : '';?>"
                    <?php
                    if(isset($errores['camiseta'])):
                    ?>
                    aria-invalid="true"
                    <?php
                    endif;
                    ?>
                >
                <div class="form-help" id="help-camiseta">Debe ser un numero de camiseta no existente.</div>
                <?php
                if(isset($errores['camiseta'])):
                ?>
                    <div class="msg-error" id="error-camiseta"><?= $errores['camiseta'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="club">Club</label>
                <input
                    type="text"
                    id="club"
                    name="club"
                    class="form-control"
                    value="<?= $dataForm['club'] ?? '';?>"
                    aria-describedby="help-club <?= isset($errores['club']) ? 'error-club' : '';?>"
                    <?php
                    if(isset($errores['club'])):
                    ?>
                    aria-invalid="true"
                    <?php
                    endif;
                    ?>
                >
                <div class="form-help" id="help-club">Debe tener al menos 3 caracteres.</div>
                <?php
                if(isset($errores['club'])):
                ?>
                    <div class="msg-error" id="error-club"><?= $errores['club'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="descripcion">Descripcion</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    <?php
                    if(isset($errores['descripcion'])):
                    ?>
                    aria-invalid="true"
                    aria-describedby="error-descripcion"
                    <?php
                    endif;
                    ?>
                ><?= $dataForm['descripcion'] ?? '';?></textarea>
                <?php
                if(isset($errores['descripcion'])):
                ?>
                    <div class="msg-error" id="error-descripcion"><?= $errores['descripcion'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="imagen_jugador">Imagen del Jugador</label>
                <input type="file" id="imagen_jugador" name="imagen_jugador" class="form-control">
            </div>
            <div class="form-fila">
                <label for="alt_imagen_jugador">Alt de la Imagen del Jugador</label>
                <input
                    type="text"
                    id="alt_imagen_jugador"
                    name="alt_imagen_jugador"
                    class="form-control"
                    value="<?= $dataForm['alt_imagen_jugador'] ?? '';?>"
                >
            </div>
            <div class="form-fila">
                <label for="imagen_camiseta">Imagen de la Camiseta</label>
                <input type="file" id="imagen_camiseta" name="imagen_camiseta" class="form-control">
            </div>
            <div class="form-fila">
                <label for="alt_imagen_camiseta">Alt de la Imagen de la Camiseta</label>
                <input
                    type="text"
                    id="alt_imagen_camiseta"
                    name="alt_imagen_camiseta"
                    class="form-control"
                    value="<?= $dataForm['alt_imagen_camiseta'] ?? '';?>"
                >
            </div>
            <div class="form-fila">
                <label for="estado_publicacion_fk">Estado de Publicación</label>
                <select name="estado_publicacion_fk" id="estado_publicacion_fk" class="form-control">
                <?php
                foreach($estadosPublicacion as $estadoPublicacion):
                ?>
                    <option
                        value="<?= $estadoPublicacion->getEstadoPublicacionId();?>"
                        <?= $estadoPublicacion->getEstadoPublicacionId() == ($dataForm['estado_publicacion_fk'] ?? null) ? 'selected' : '';?>
                    >
                        <?= $estadoPublicacion->getEstado();?>
                    </option>
                <?php
                endforeach;
                ?>
                </select>
            </div>
            <div class="form-fila">
                <?php
                foreach($posiciones as $posicion):
                ?>
                <label>
                    <input 
                        type="checkbox"
                        name="posiciones[]"
                        value="<?= $posicion->getPosicionId();?>"
                        <?=(in_array($posicion->getPosicionId(),$dataForm['posiciones'] ?? [])) ? 'checked' : '';?>
                    >
                    <?= $posicion->getNombre(); ?>
                </label>
                <?php
                    endforeach;
                ?>
            </div>
            <button type="submit" class="button">Publicar</button>
        </form>
    </section>
</main>
