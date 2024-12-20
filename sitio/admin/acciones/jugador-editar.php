<?php
use App\Autenticacion\Autenticacion;
use App\Modelos\Jugador;

require_once __DIR__ . '/../../bootstrap/init.php';

$autenticacion = new Autenticacion();

if(!$autenticacion->estaAutenticado()) {
    $_SESSION['mensajeError'] = "Realizar esta acción requiere iniciar sesión.";
    header("Location: ../index.php?s=iniciar-sesion");
    exit;
}

$errores = [];

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

if (empty($_POST['precio']) || $_POST['precio'] == '0.00' || $_POST['precio'] == '0') {
    $errores['precio'] = 'El precio no puede ser 0.';
}

if (empty($_POST['posiciones'])) {
    $errores['posiciones'] = 'El jugador debe tener al menos una posición.';
}

if (empty($_POST['numero_camiseta'])) {
    $errores['numero_camiseta'] = "El número de camiseta es obligatorio.";
} elseif (!filter_var($_POST['numero_camiseta'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 99]])) {
    $errores['numero_camiseta'] = "El número de camiseta debe ser un número entre 1 y 99.";
}

if (!empty($_FILES['imagen_jugador']['name'])) {
    $extension = strtolower(pathinfo($_FILES['imagen_jugador']['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
        $errores['imagen_jugador'] = 'Solo se aceptan imágenes en formato JPG o PNG.';
    }
}

if (!empty($_FILES['imagen_camiseta']['name'])) {
    $extension = strtolower(pathinfo($_FILES['imagen_camiseta']['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
        $errores['imagen_camiseta'] = 'Solo se aceptan imágenes en formato JPG o PNG.';
    }
}

if(count($errores) > 0) {
    $_SESSION['errores'] = $errores;
    $_SESSION['dataForm'] = $_POST;
    header("Location: ../index.php?s=jugador-editar&id=" . $_GET['id']);
    exit;
}

try {
    $jugador = (new Jugador())->porId($_GET['id']);

    if(!empty($_FILES['imagen_jugador']['tmp_name'])) {
        $nombreImagenJugador = date('YmdHis') . "_" . $_FILES['imagen_jugador']['name'];
        move_uploaded_file($_FILES['imagen_jugador']['tmp_name'], IMGS_PATH . '/' . $nombreImagenJugador);
        copy(IMGS_PATH . '/' . $nombreImagenJugador, IMGS_PATH . '/big-' . $nombreImagenJugador);
    }

    if(!empty($_FILES['imagen_camiseta']['tmp_name'])) {
        $nombreImagenCamiseta = date('YmdHis') . "_" . $_FILES['imagen_camiseta']['name'];
        move_uploaded_file($_FILES['imagen_camiseta']['tmp_name'], IMGS_PATH . '/' . $nombreImagenCamiseta);
        copy(IMGS_PATH . '/' . $nombreImagenCamiseta, IMGS_PATH . '/big-' . $nombreImagenCamiseta);
    }

    (new Jugador())->editar($_GET['id'], [
        'estado_publicacion_fk' => $_POST['estado_publicacion_fk'],
        'nombre'                => $_POST['nombre'],
        'apellido'              => $_POST['apellido'],
        'numero_camiseta'       => $_POST['numero_camiseta'],
        'club'                  => $_POST['club'],
        'descripcion'           => $_POST['descripcion'],
        'imagen_jugador'        => $nombreImagenJugador ?? $jugador->getImagenJugador(),
        'alt_imagen_jugador'    => $_POST['imagen_jugador_alt'],
        'imagen_camiseta'       => $nombreImagenCamiseta ?? $jugador->getImagenCamiseta(),
        'alt_imagen_camiseta'   => $_POST['imagen_camiseta_alt'],
        'posiciones'            => $_POST['posiciones'],
        'precio'                => (float)$_POST['precio'],
    ]);

    $nombre = urlencode($_POST['nombre']);
    $apellido = urlencode($_POST['apellido']);
    header("Location: ../index.php?s=plantilla&success=edited&nombre={$nombre}&apellido={$apellido}");
    exit;
} catch(Exception $e) {
    $_SESSION['errores'] = ['general' => "Ocurrió un error inesperado al tratar de editar el jugador. Por favor, probá de nuevo más tarde."];
    header("Location: ../index.php?s=jugador-editar&id=" . $_GET['id']);
    exit;
}
