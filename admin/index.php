<?php
use App\Autenticacion\Autenticacion;

require_once __DIR__ . '/../bootstrap/init.php';

$ruta = $_GET['s'] ?? 'home';

$arrayRutas = [
    'home' => [
        'titulo' => 'Tablero Principal',
        'requiereAutenticacion' => true,
    ],
    'plantilla' => [
        'titulo' => 'Administración de jugadores',
        'requiereAutenticacion' => true,
    ],
    'jugador-nuevo' => [
        'titulo' => 'Publicar Nuevo Jugador',
        'requiereAutenticacion' => true,
    ],
    'jugadores-editar' => [
        'titulo' => 'Editar un Jugador',
        'requiereAutenticacion' => true,
    ],
    'jugadores-eliminar' => [
        'titulo' => 'Confirmación para Eliminar un Jugador',
        'requiereAutenticacion' => true,
    ],
    'detalle' => [
        'titulo' => 'Ver Jugador',
        'requiereAutenticacion' => true,
    ],
    'iniciar-sesion' => [
        'titulo' => 'Ingresar al Panel de Administración',
    ],
    '404' => [
        'titulo' => 'Página no Encontrada',
        'requiereAutenticacion' => true,
    ],
];

if(!isset($arrayRutas[$ruta])) {
    $ruta = '404';
}

$configurarRuta = $arrayRutas[$ruta];

$autenticacion = new Autenticacion();
$requiereAutenticacion = $configurarRuta['requiereAutenticacion'] ?? false;

if($requiereAutenticacion && !$autenticacion->estaAutenticado()) {
    $_SESSION['mensajeError'] = "Para acceder a esta sección se requiere iniciar sesión.";
    header("Location: index.php?s=iniciar-sesion");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../favicon.ico" sizes="any">
    <link rel="icon" href="../favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="../favicon.png">
    <title><?= $configurarRuta['titulo'];?> | Panel de Administración de La Scaloneta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <p>Panel de Administración</p>
    </header>
    <nav>
        <div>
            <?php
            if($autenticacion->estaAutenticado()):
            ?>
            <ul>
                <li><a href="index.php?s=home">Tablero</a></li>
                <li><a href="index.php?s=plantilla">Plantilla</a></li>
                <li>
                    <form action="acciones/cerrar-sesion.php" method="post">
                        <button type="submit" class="button"><?= $autenticacion->getUsuario()->getEmail();?> (Cerrar Sesión)</button>
                    </form>
                </li>
            </ul>
            <?php
            endif;
            ?>
        </div>
    </nav>
    <div>
    <?php
    if(isset($_SESSION['mensajeExito'])):
    ?>
        <div class="msg-success"><?= $_SESSION['mensajeExito'];?></div>
    <?php
        unset($_SESSION['mensajeExito']);
    endif;
    ?>
    <?php
    if(isset($_SESSION['mensajeError'])):
    ?>
        <div class="msg-error"><?= $_SESSION['mensajeError'];?></div>
    <?php
        unset($_SESSION['mensajeError']);
    endif;
    ?>
        <?php
        require __DIR__ . '/vistas/' . $ruta . '.php';
        ?>
    </div>
    <footer>
        <p>Lara Crupnicoff - Da Vinci - 2023</p>
    </footer>
</body>
</html>
