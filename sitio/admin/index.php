<?php
use App\Autenticacion\Autenticacion;

require_once __DIR__ . '/../bootstrap/init.php';

if (!isset($_SESSION['usuario_data']) || $_SESSION['usuario_data']['rol_fk'] != 1) {
    $_SESSION['mensajeError'] = "No tienes permiso para acceder al panel de administración.";
    header("Location: ../index.php");
    exit;
}

$ruta = $_GET['s'] ?? 'plantilla';

$arrayRutas = [
    'plantilla' => [
        'titulo' => 'Administración de jugadores',
        'requiereAutenticacion' => true,
    ],
    'jugador-nuevo' => [
        'titulo' => 'Publicar Nuevo Jugador',
        'requiereAutenticacion' => true,
    ],
    'jugador-editar' => [
        'titulo' => 'Editar un Jugador',
        'requiereAutenticacion' => true,
    ],
    'jugador-eliminar' => [
        'titulo' => 'Confirmación para Eliminar un Jugador',
        'requiereAutenticacion' => true,
    ],
    'detalle' => [
        'titulo' => 'Ver Jugador',
        'requiereAutenticacion' => true,
    ],
    'usuarios' => [
        'titulo' => 'Administración de Usuarios',
        'requiereAutenticacion' => true,
    ],
    'usuario-compras' => [
        'titulo' => 'Compras del Usuario',
        'requiereAutenticacion' => true,
    ],
    '404' => [
        'titulo' => 'Página no Encontrada',
        'requiereAutenticacion' => true,
    ],
];

if (!isset($arrayRutas[$ruta])) {
    $ruta = '404';
}

$configurarRuta = $arrayRutas[$ruta];

$autenticacion = new Autenticacion();
$requiereAutenticacion = $configurarRuta['requiereAutenticacion'] ?? false;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../favicon.ico" sizes="any">
    <link rel="icon" href="../favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="../favicon.png">
    <title><?= $configurarRuta['titulo']; ?> | Panel de Administración de La Scaloneta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <div class="headerAdmin">
            <p>Panel de Administración</p>
            <a href="../acciones/auth/cerrar-sesion.php" class="iniciar">
                <?= $_SESSION['usuario_data']['email']; ?> (Cerrar Sesión)
            </a>
        </div>
        <nav>
            <div>
                <?php
                if ($autenticacion->estaAutenticado()):
                    ?>
                    <ul>
                        <li><a href="index.php?s=plantilla">Plantilla</a></li>
                        <li><a href="index.php?s=usuarios">Usuarios</a></li>
                    </ul>
                    <?php
                endif;
                ?>
            </div>
        </nav>
    </header>
    <div>
        <?php
        if (isset($_SESSION['mensajeExito'])):
            ?>
            <div class="msg-success"><?= $_SESSION['mensajeExito']; ?></div>
            <?php
            unset($_SESSION['mensajeExito']);
        endif;
        ?>
        <?php
        if (isset($_SESSION['mensajeError'])):
            ?>
            <div class="msg-error"><?= $_SESSION['mensajeError']; ?></div>
            <?php
            unset($_SESSION['mensajeError']);
        endif;
        ?>
        <?php
        require __DIR__ . '/vistas/' . $ruta . '.php';
        ?>
    </div>
    <footer>
        <p>Lara Crupnicoff - Da Vinci - 2024</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.iniciar').forEach(link => {
            if(link.textContent.includes('Cerrar Sesión')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¿Deseas cerrar la sesión?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4496E0',
                        cancelButtonColor: '#2a6ba0',
                        confirmButtonText: 'Sí, cerrar sesión',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = this.href;
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>