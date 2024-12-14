<?php

use App\Modelos\EstadoPublicacion;
use App\Modelos\Jugador;
use App\Modelos\Posicion;


$jugador = (new Jugador())->porId($_GET['id']);
$jugador->cargarPosicionesId();

if(isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    unset($_SESSION['errores']);
} else {
    $errores = [];
}
if(isset($_SESSION['dataForm'])) {
    $dataForm = $_SESSION['dataForm'];
    unset($_SESSION['dataForm']);
} else {
    $dataForm = [];
}

$estadosPublicacion = (new EstadoPublicacion())->todos();
$posiciones = (new Posicion())->todas();
?>
<main>
    <section>
        <h1>Editar el Jugador "<b><?=$jugador->getNombre(); ?><?=$jugador->getApellido();?></b>"</h1>

        <form action="acciones/jugadores-editar.php?id=<?= $jugador->getNumeroCamiseta();?>" method="post" enctype="multipart/form-data">
            <div class="form-fila">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="form-control"
                    value="<?= $dataForm['nombre'] ?? $jugador->getNombre();?>"
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
            <div class="form-fila">
                <label for="apellido">Apellido</label>
                <input
                    type="text"
                    id="apellido"
                    name="apellido"
                    class="form-control"
                    <?php
                    if(isset($errores['apellido'])):
                    ?>
                    aria-invalid="true"
                    aria-describedby="error-apellido"
                    <?php
                    endif;
                    ?>
                ><?= $dataForm['apellido'] ?? $jugador->getApellido();?></input>
                <?php
                if(isset($errores['apellido'])):
                ?>
                    <div class="msg-error" id="error-apellido"><?= $errores['apellido'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="club">Club</label>
                <input
                    type="text"
                    id="club"
                    name="club"
                    class="form-control"
                    <?php
                    if(isset($errores['club'])):
                    ?>
                    aria-invalid="true"
                    aria-describedby="error-club"
                    <?php
                    endif;
                    ?>
                ><?= $dataForm['club'] ?? $jugador->getClub();?></input>
                <?php
                if(isset($errores['club'])):
                ?>
                    <div class="msg-error" id="error-club"><?= $errores['club'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="descripcion">Descripción</label>
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
                ><?= $dataForm['descripcion'] ?? $jugador->getDescripcion();?></textarea>
                <?php
                if(isset($errores['descripcion'])):
                ?>
                    <div class="msg-error" id="error-descripcion"><?= $errores['descripcion'];?></div>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <p>Imagen jugador</p>
                <?php
                if(!empty($jugador->getImagenJugador())):
                ?>
                <img src="<?= '../imgs/' . $jugador->getImagenJugador();?>" alt="">
                <?php
                else:
                ?>
                <p><i>No tiene una imagen.</i></p>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="imagen_jugador">Imagen del Jugador (opcional)</label>
                <input
                    type="file"
                    id="imagen_jugador"
                    name="imagen_jugador"
                    class="form-control"
                    aria-describedby="help-imagen_jugador"
                >
                <p class="form-help" id="help-imagen_jugador">Solo elegí una imagen si querés cambiar la actual.</p>
            </div>
            <div class="form-fila">
                <label for="imagen_jugador_alt">Alt de la imagen Jugador (opcional)</label>
                <input
                    type="text"
                    id="imagen_jugador_alt"
                    name="imagen_jugador_alt"
                    class="form-control"
                    value="<?= $dataForm['imagen_jugador_alt'] ?? $jugador->getAltImagenJugador();?>"
                >
            </div>
            <div class="form-fila">
                <p>Imagen camiseta</p>
                <?php
                if(!empty($jugador->getImagenCamiseta())):
                ?>
                <img src="<?= '../imgs/' . $jugador->getImagenCamiseta();?>" alt="">
                <?php
                else:
                ?>
                <p><i>No tiene una imagen.</i></p>
                <?php
                endif;
                ?>
            </div>
            <div class="form-fila">
                <label for="imagen_camiseta">Imagen de la camiseta (opcional)</label>
                <input
                    type="file"
                    id="imagen_camiseta"
                    name="imagen_camiseta"
                    class="form-control"
                    aria-describedby="help-imagen_camiseta"
                >
                <p class="form-help" id="help-imagen_camiseta">Solo elegí una imagen si querés cambiar la actual.</p>
            </div>
            <div class="form-fila">
                <label for="imagen_camiseta_alt">Alt de la imagen Camiseta (opcional)</label>
                <input
                    type="text"
                    id="imagen_camiseta_alt"
                    name="imagen_camiseta_alt"
                    class="form-control"
                    value="<?= $dataForm['imagen_camiseta_alt'] ?? $jugador->getAltImagenCamiseta();?>"
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
                        <?= $estadoPublicacion->getEstadoPublicacionId() == ($dataForm['estado_publicacion_fk'] ?? $jugador->getEstadoPublicacionFk()) ? 'selected' : '';?>
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
                        <?=(in_array($posicion->getPosicionId(),$dataForm['posiciones'] ?? $jugador->getPosicionId())) ? 'checked' : '';?>
                    >
                    <?= $posicion->getNombre(); ?>
                </label>
                <?php
                    endforeach;
                ?>
            </div>
            <button type="submit" class="button">Editar</button>
        </form>
    </section>
</main>
