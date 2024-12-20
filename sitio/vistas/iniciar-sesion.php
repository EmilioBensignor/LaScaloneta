<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión | La Scaloneta</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main>
        <section class="iniciarSesion">
            <h2>Iniciar Sesión</h2>

            <?php
            if (isset($_SESSION['mensajeError'])):
                ?>
                <div class="msg-error"><?= $_SESSION['mensajeError']; ?></div>
                <?php
                unset($_SESSION['mensajeError']);
            endif;
            ?>

            <form action="acciones/auth/iniciar-sesion.php" method="post">
                <div class="formContainer">
                    <div class="formFila">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="formFila">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                </div>
                <button type="submit" class="botonPrimario">Ingresar</button>
            </form>

            <div>
                <p>¿No tienes una cuenta? <a href="index.php?s=registro" class="registrate">Regístrate aquí</a></p>
            </div>
        </section>
    </main>
</body>

</html>