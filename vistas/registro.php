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
            <h1>Registro de Usuario</h1>

            <?php
            // Agregar manejo de mensajes de error
            if(isset($_SESSION['mensajeError'])):
            ?>
                <div class="msg-error"><?= $_SESSION['mensajeError'];?></div>
            <?php
                unset($_SESSION['mensajeError']);
            endif;
            ?>

            <!-- Cambio en la ruta del action -->
            <form action="acciones/auth/registro.php" method="post">
                <div class="form-fila">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-fila">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                </div>
                <div class="form-fila">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-fila">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn">Registrarse</button>
            </form>
            
            <!-- Nuevo: agregar enlace a inicio de sesión -->
            <div class="login-link">
                <p>¿Ya tienes una cuenta? <a href="index.php?s=iniciar-sesion">Inicia sesión aquí</a></p>
            </div>
        </section>
    </main>
</body>
</html>
