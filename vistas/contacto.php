<?php
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación del nombre
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (strlen($_POST['nombre']) < 2) {
        $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
    } elseif (strlen($_POST['nombre']) > 50) {
        $errores['nombre'] = 'El nombre no debe superar los 50 caracteres.';
    }

    // Validación del apellido
    if (empty($_POST['apellido'])) {
        $errores['apellido'] = 'El apellido es obligatorio.';
    } elseif (strlen($_POST['apellido']) < 2) {
        $errores['apellido'] = 'El apellido debe tener al menos 2 caracteres.';
    } elseif (strlen($_POST['apellido']) > 50) {
        $errores['apellido'] = 'El apellido no debe superar los 50 caracteres.';
    }

    // Validación del email
    if (empty($_POST['email'])) {
        $errores['email'] = 'El email es obligatorio.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'El formato del email no es válido.';
    }

    // Validación del campo futbol
    if (empty($_POST['futbol'])) {
        $errores['futbol'] = 'Por favor seleccione una opción.';
    }

    if (empty($errores)) {
        // Redirigir si no hay errores
        header('Location: index.php?s=gracias');
        exit;
    }
}
?>
<main class="main-contacto">
    <h2>Se parte de la familia Scaloneta</h2>
    <form action="index.php?s=contacto" method="post">
        <p>Dejanos tus datos para ser parte del newsletter semanal de La Scaloneta.</p>
        <fieldset>
            <legend>Contacto</legend>
            <section class="sectionContacto">
                <div>
                    <label for="nombre">Nombre</label>
                    <input 
                        name="nombre" 
                        id="nombre" 
                        type="text"
                        value="<?= $_POST['nombre'] ?? '';?>"
                        class="<?= isset($errores['nombre']) ? 'input-error' : '';?>"
                    >
                    <?php if (isset($errores['nombre'])): ?>
                        <p class="error-message"><?= $errores['nombre'];?></p>
                    <?php endif;?>
                </div>
                <div>
                    <label for="apellido">Apellido</label>
                    <input 
                        name="apellido" 
                        id="apellido" 
                        type="text"
                        value="<?= $_POST['apellido'] ?? '';?>"
                        class="<?= isset($errores['apellido']) ? 'input-error' : '';?>"
                    >
                    <?php if (isset($errores['apellido'])): ?>
                        <p class="error-message"><?= $errores['apellido'];?></p>
                    <?php endif;?>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input 
                        name="email" 
                        id="email" 
                        type="email"
                        value="<?= $_POST['email'] ?? '';?>"
                        class="<?= isset($errores['email']) ? 'input-error' : '';?>"
                    >
                    <?php if (isset($errores['email'])): ?>
                        <p class="error-message"><?= $errores['email'];?></p>
                    <?php endif;?>
                </div>
                <div>
                    <label for="futbol">¿Jugas al fútbol?</label>
                    <select 
                        name="futbol" 
                        id="futbol"
                        class="<?= isset($errores['futbol']) ? 'input-error' : '';?>"
                    >
                        <option value="">Seleccione</option>
                        <option value="regularmente" <?= isset($_POST['futbol']) && $_POST['futbol'] === 'regularmente' ? 'selected' : '';?>>Si, regularmente</option>
                        <option value="veces" <?= isset($_POST['futbol']) && $_POST['futbol'] === 'veces' ? 'selected' : '';?>>Si, a veces</option>
                        <option value="no" <?= isset($_POST['futbol']) && $_POST['futbol'] === 'no' ? 'selected' : '';?>>No</option>
                    </select>
                    <?php if (isset($errores['futbol'])): ?>
                        <p class="error-message"><?= $errores['futbol'];?></p>
                    <?php endif;?>
                </div>
            </section>
            <div class="divTextarea">
                <label for="comentarios">Comentarios adicionales</label>
                <textarea name="comentarios" id="comentarios" rows="7"><?= $_POST['comentarios'] ?? '';?></textarea>
            </div>
            <div class="divButtonForm">
                <button type="submit" class="botonPrimario">Enviar</button>
            </div>
        </fieldset>
    </form>
</main>