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

$nombre                 = $_POST['nombre'];
$apellido               = $_POST['apellido'];
$numero_camiseta        = $_POST['numero_camiseta'];  // Changed from jugador_id
$club                   = $_POST['club'];
$descripcion            = $_POST['descripcion'];
$precio                 = $_POST['precio'] ?? 0.00;  // Add precio
$imagen_jugador         = $_FILES['imagen_jugador'];
$alt_imagen_jugador     = $_POST['alt_imagen_jugador'];
$imagen_camiseta        = $_FILES['imagen_camiseta'];
$alt_imagen_camiseta    = $_POST['alt_imagen_camiseta'];
$estado_publicacion_fk  = $_POST['estado_publicacion_fk'];
$posiciones             = $_POST['posiciones'];


$errores = [];

if(empty($nombre)) {
    $errores['nombre'] = "El nombre no debe estar vacío.";
} else if(strlen($nombre) < 3) {
    $errores['nombre'] = "El nombre debe tener al menos 3 caracteres.";
}

if(empty($apellido)) {
    $errores['apellido'] = "El apellido no debe estar vacío.";
} else if(strlen($apellido) < 3) {
    $errores['apellido'] = "El apellido debe tener al menos 3 caracteres.";
}

if(empty($numero_camiseta)) {
    $errores['numero_camiseta'] = "El número de camiseta no debe estar vacío.";
} else if($numero_camiseta < 1 || $numero_camiseta > 99) {
    $errores['numero_camiseta'] = "El número de camiseta debe estar entre 1 y 99.";
}

if(empty($club)) {
    $errores['club'] = "El club no debe estar vacío.";
} else if(strlen($club) < 3) {
    $errores['club'] = "El club debe tener al menos 3 caracteres.";
}

if(empty($descripcion)) {
    $errores['descripcion'] = "La descripcion no debe estar vacía.";
}

// Add precio validation
if(!is_numeric($precio) || $precio < 0) {
    $errores['precio'] = "El precio debe ser un número positivo.";
}

if(count($errores) > 0) {
    $_SESSION['mensajeError'] = "Hay errores en el formulario. Por favor, revisá los campos y probá de nuevo.";
    $_SESSION['errores'] = $errores;
    $_SESSION['dataForm'] = $_POST;
    $_SESSION['dataForm']['posiciones'] = $posiciones;

    header("Location: ../index.php?s=jugador-nuevo");
    exit;
}

if(!empty($imagen_jugador['tmp_name'])) {
    $nombreImagenJugador = date('YmdHis') . "_" . $imagen_jugador['name'];

    move_uploaded_file($imagen_jugador['tmp_name'], IMGS_PATH . '/' . $nombreImagenJugador);

    copy(
        IMGS_PATH . '/' . $nombreImagenJugador,
        IMGS_PATH . '/big-' . $nombreImagenJugador,
    );
}

if(!empty($imagen_camiseta['tmp_name'])) {
    $nombreImagenCamiseta = date('YmdHis') . "_" . $imagen_camiseta['name'];

    move_uploaded_file($imagen_camiseta['tmp_name'], IMGS_PATH . '/' . $nombreImagenCamiseta);

    copy(
        IMGS_PATH . '/' . $nombreImagenCamiseta,
        IMGS_PATH . '/big-' . $nombreImagenCamiseta,
    );
}

try {
    (new Jugador())->crear([
        'usuario_fk'            => $autenticacion->getId(),
        'estado_publicacion_fk' => $estado_publicacion_fk,
        'nombre'                => $nombre,
        'apellido'              => $apellido,
        'numero_camiseta'       => $numero_camiseta,  // Changed from jugador_id
        'club'                  => $club,
        'descripcion'           => $descripcion,
        'imagen_jugador'        => $nombreImagenJugador ?? $jugador->getImagenJugador(),
        'alt_imagen_jugador'    => $alt_imagen_jugador,
        'imagen_camiseta'       => $nombreImagenCamiseta ?? $jugador->getImagenCamiseta(),
        'alt_imagen_camiseta'   => $alt_imagen_camiseta,
        'posiciones'            => $posiciones,
        'precio'                => (float)$precio,  // Add precio to the data array
    ]);

    header("Location: ../index.php?s=plantilla&success=created&nombre=" . urlencode($nombre) . "&apellido=" . urlencode($apellido));
    exit;
} catch(Exception $e) {
    $_SESSION['mensajeError'] = "Ocurrió un error inesperado al tratar de crear el jugador. Por favor, probá de nuevo más tarde.";
    $_SESSION['dataForm'] = $_POST;
    header("Location: ../index.php?s=jugador-nuevo");
    exit;
}