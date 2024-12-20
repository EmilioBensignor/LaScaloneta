<?php
use App\Autenticacion\Autenticacion;
use App\Modelos\Jugador;

require_once __DIR__ . '/../../bootstrap/init.php';

$autenticacion = new Autenticacion();

if (!$autenticacion->estaAutenticado()) {
    $_SESSION['mensajeError'] = "Realizar esta acción requiere iniciar sesión.";
    header("Location: ../index.php?s=iniciar-sesion");
    exit;
}

if (!empty($_FILES['imagen_jugador']['tmp_name'])) {
    $nombreImagenJugador = date('YmdHis') . "_" . $_FILES['imagen_jugador']['name'];
    move_uploaded_file($_FILES['imagen_jugador']['tmp_name'], IMGS_PATH . '/' . $nombreImagenJugador);
    copy(IMGS_PATH . '/' . $nombreImagenJugador, IMGS_PATH . '/big-' . $nombreImagenJugador);
}

if (!empty($_FILES['imagen_camiseta']['tmp_name'])) {
    $nombreImagenCamiseta = date('YmdHis') . "_" . $_FILES['imagen_camiseta']['name'];
    move_uploaded_file($_FILES['imagen_camiseta']['tmp_name'], IMGS_PATH . '/' . $nombreImagenCamiseta);
    copy(IMGS_PATH . '/' . $nombreImagenCamiseta, IMGS_PATH . '/big-' . $nombreImagenCamiseta);
}

try {
    (new Jugador())->crear([
        'usuario_fk'            => $autenticacion->getId(),
        'estado_publicacion_fk' => $_POST['estado_publicacion_fk'],
        'nombre'                => $_POST['nombre'],
        'apellido'              => $_POST['apellido'],
        'numero_camiseta'       => $_POST['numero_camiseta'],
        'club'                  => $_POST['club'],
        'descripcion'           => $_POST['descripcion'],
        'imagen_jugador'        => $nombreImagenJugador,
        'alt_imagen_jugador'    => $_POST['alt_imagen_jugador'],
        'imagen_camiseta'       => $nombreImagenCamiseta,
        'alt_imagen_camiseta'   => $_POST['alt_imagen_camiseta'],
        'posiciones'            => $_POST['posiciones'],
        'precio'                => (float)$_POST['precio'],
    ]);

    $nombre = urlencode($_POST['nombre']);
    $apellido = urlencode($_POST['apellido']);
    header("Location: ../admin/index.php?s=plantilla&success=created&nombre={$nombre}&apellido={$apellido}");
    exit;
} catch (Exception $e) {
    $_SESSION['errores'] = ['general' => "Ocurrió un error inesperado al tratar de crear el jugador. Por favor, probá de nuevo más tarde."];
    header("Location: ../index.php?s=jugador-nuevo");
    exit;
}