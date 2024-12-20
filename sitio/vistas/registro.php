<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro | La Scaloneta</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main>
        <section class="registro">
            <h2>Registro de Usuario</h2>

            <?php
            if (isset($_SESSION['mensajeError'])):
                ?>
                <div class="msg-error"><?= $_SESSION['mensajeError']; ?></div>
                <?php
                unset($_SESSION['mensajeError']);
            endif;
            ?>

            <form action="acciones/auth/registro.php" method="post">
                <div class="formContainer">
                    <div class="formFila">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" required>
                    </div>
                    <div class="formFila">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" required>
                    </div>
                </div>
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
                <button type="submit" class="botonPrimario">Registrarse</button>
            </form>

            <div>
                <p>¿Ya tienes una cuenta? <a href="index.php?s=iniciar-sesion" class="registrate">Inicia sesión aquí</a></p>
            </div>
        </section>
    </main>
</body>

</html>