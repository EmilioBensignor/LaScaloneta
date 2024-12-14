<main class="main-contacto">
    <h2>Se parte de la familia Scaloneta</h2>
    <form action="index.php?s=gracias" method="post">
        <p>Dejanos tus datos para ser parte del newsletter semanal de La Scaloneta.</p>
        <fieldset>
            <legend>Contacto</legend>
            <section class="sectionContacto">
                <div>
                    <label for="nombre">Nombre</label>
                    <input name="nombre" id="nombre" type="text" required>
                </div>
                <div>
                    <label for="apellido">Apellido</label>
                    <input name="apellido" id="apellido" type="text" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input name="email" id="email" type="email" required>
                </div>
                <div>
                    <label for="futbol">¿Jugas al fútbol?</label>
                    <select name="futbol" id="futbol" required>
                        <option value="">Seleccione</option>
                        <option value="regularmente">Si, regularmente</option>
                        <option value="veces">Si, a veces</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </section>
            <div class="divTextarea">
                <label for="comentarios">Comentarios adicionales</label>
                <textarea name="comentarios" id="comentarios" rows="7"></textarea>
            </div>
            <div class="divButtonForm">
                <button type="submit">Enviar</button>
            </div>
        </fieldset>
    </form>
</main>