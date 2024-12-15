<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión | La Scaloneta</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <section class="iniciar-sesion">
            <h1>Iniciar Sesión</h1>

            <?php
            if(isset($_SESSION['mensajeError'])):
            ?>
                <div class="msg-error"><?= $_SESSION['mensajeError'];?></div>
            <?php
                unset($_SESSION['mensajeError']);
            endif;
            ?>

            <form action="acciones/auth/iniciar-sesion.php" method="post">
                <div class="form-fila">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-fila">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn">Ingresar</button>
            </form>
            
            <div class="registro-link">
                <p>¿No tienes una cuenta? <a href="index.php?s=registro">Regístrate aquí</a></p>
            </div>
        </section>
    </main>
</body>
</html>
