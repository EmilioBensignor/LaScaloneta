<main>
    <section class="inicar-sesion">
        <h1>Ingresar al Panel de Administración</h1>

        <form action="acciones/iniciar-sesion.php" method="post">
            <div class="form-fila">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-fila">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        
        <div class="registro-link">
            <p>¿No tienes una cuenta? <a href="index.php?s=registro">Regístrate aquí</a></p>
        </div>
    </section>
</main>
