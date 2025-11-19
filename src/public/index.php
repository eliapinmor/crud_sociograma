<?php
declare(strict_types=1);
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
/**
 * Esta página solo verifica que el servidor PHP 8.4 funciona.
 * Más adelante, la Parte 1 mostrará el CRUD clásico (sin AJAX).
 */
include_once 'includes/header.php';
include_once 'includes/functions.php';

$old_field = isset($old_field) ? $old_field : [];
$errors = isset($errors) ? $errors : [];
?>
<header>
    <h1>Formulario de Registro</h1>
    <p><a href="logout.php">Cerrar sesión</a></p>
</header>
<section>
    <form method="post" action="process.php" id="formulario" novalidate>
        <section>
            <h2>Identificación</h2>
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" type="text" required minlength="3"
                value="<?= old_field('nombre', $old_field) ?>">
            <?= field_error('nombre', $errors) ?>   

            <label for="email">Email</label>
            <input id="email" name="email" type="email" required value="<?= old_field('email', $old_field) ?>">
            <?= field_error('email', $errors) ?>

            <label for="edad">Edad</label>
            <input id="edad" name="edad" type="number" min="15" max="100" required>

            <label for="curso">¿En qué curso estás?</label><br>
            <input id="daw" name="curso" type="radio" value="daw" <?= old_field('curso', $old_field) === 'daw' ? 'checked' : '' ?>>
            <label for="daw">DAW</label><br>

            <input id="dam" name="curso" type="radio" value="dam" <?= old_field('curso', $old_field) === 'dam' ? 'checked' : '' ?>>
            <label for="dam">DAM</label><br>

            <input id="asix" name="curso" type="radio" value="asix" <?= old_field('curso', $old_field) === 'asix' ? 'checked' : '' ?>>
            <label for="asix">ASIX</label><br>
            <?= field_error('curso', $errors) ?>

        </section>
        <section>
            <h2>Preferencias de colaboración</h2>
            <label for="preferido1">Persona 1 con la que prefieres trabajar</label>
            <input id="preferido1" name="preferido1" type="text" required
                value="<?= old_field('preferido1', $old_field) ?>">
            <?= field_error('preferido1', $errors) ?>

            <label for="preferido2">Persona 2 con la que prefieres trabajar</label>
            <input id="preferido2" name="preferido2" type="text" required
                value="<?= old_field('preferido2', $old_field) ?>">
            <?= field_error('preferido2', $errors) ?>

            <label for="evitar1">Persona con la que prefieres no trabajar</label>
            <input id="evitar1" name="evitar1" type="text" required value="<?= old_field('evitar1', $old_field) ?>">
            <?= field_error('evitar1', $errors) ?>

            <label for="motivo_preferencia">¿Por qué prefieres trabajar con estas personas?</label>
            <textarea id="motivo_preferencia" name="motivo_preferencia" required
                maxlength="300"><?= old_field('motivo_preferencia', $old_field) ?></textarea>
            <?= field_error('motivo_preferencia', $errors) ?>

            <label for="motivo_evitar">¿Por qué prefieres no trabajar con estas personas?</label>
            <textarea id="motivo_evitar" name="motivo_evitar" required
                maxlength="300"><?= old_field('motivo_evitar', $old_field) ?></textarea>
            <?= field_error('motivo_evitar', $errors) ?>


        </section>
        <section>
            <h2>Rol y habilidades</h2>
            <label for="rol_habitual">¿En qué rol te sueles desenvolver habitualmente?</label><br>
            <input id="lider" name="rol_habitual" type="radio" value="lider" required <?= old_field('rol_habitual', $old_field) === 'lider' ? 'checked' : '' ?>">
            <label for="lider">Líder</label>
            <input id="seguidor" name="rol_habitual" type="radio" value="seguidor" required <?= old_field('rol_habitual', $old_field) === 'seguidor' ? 'checked' : '' ?>">
            <label for="seguidor">Seguidor</label><br>

            <?= field_error('rol_habitual', $errors) ?>

            <label for="lenguaje_fuerte[]">¿Cuáles son tus lenguajes de programación más fuertes?</label>
            <input type="checkbox" id="php" name="lenguaje_fuerte[]" value="php" <?= in_array('php', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="php">PHP</label><br>

            <input type="checkbox" id="javascript" name="lenguaje_fuerte[]" value="javascript" <?= in_array('javascript', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="javascript">JavaScript</label><br>

            <input type="checkbox" id="python" name="lenguaje_fuerte[]" value="python" <?= in_array('python', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="python">Python</label><br>

            <input type="checkbox" id="java" name="lenguaje_fuerte[]" value="java" <?= in_array('java', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="java">Java</label><br>

            <input type="checkbox" id="csharp" name="lenguaje_fuerte[]" value="csharp" <?= in_array('csharp', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="csharp">C#</label><br>

            <input type="checkbox" id="cplus" name="lenguaje_fuerte[]" value="cplus" <?= in_array('cplus', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="cplus">C++</label><br>

            <input type="checkbox" id="sql" name="lenguaje_fuerte[]" value="sql" <?= in_array('sql', isset($old_field['lenguaje_fuerte']) ? $old_field['lenguaje_fuerte'] : []) ? 'checked' : '' ?>>
            <label for="sql">SQL</label><br><br>
            </select>
            <?= field_error('lenguaje_fuerte', $errors) ?>

            <label for="experiencia">¿Cuánta experiencia tienes trabajando en proyectos? (en años)</label>

            <select id="experiencia" name="experiencia" required>
                <option value="1" <?= old_field('experiencia', $old_field) === '1' ? 'selected' : '' ?>>1</option>
                <option value="2" <?= old_field('experiencia', $old_field) === '2' ? 'selected' : '' ?>>2</option>
                <option value="3 - 4" <?= old_field('experiencia', $old_field) === '3 - 4' ? 'selected' : '' ?>>3 - 4
                </option>
                <option value="5 - 8" <?= old_field('experiencia', $old_field) === '5 - 8' ? 'selected' : '' ?>>5 - 8
                </option>
                <option value="9 o más" <?= old_field('experiencia', $old_field) === '9 o más' ? 'selected' : '' ?>>9 o más
                </option>
            </select>
            <?= field_error('experiencia', $errors) ?>
        </section>
        <section>
            <h2>Dinámica y comunicación</h2>
            <label>¿Qué comunicación sueles usar?</label><br>
            <input type="radio" id="sincrona" name="comunicacion" value="sincrona" required <?= old_field('comunicacion', $old_field) === 'sincrona' ? 'checked' : '' ?>>
            <label for="sincrona">Síncrona</label><br>

            <input type="radio" id="asincrona" name="comunicacion" value="asincrona" <?= old_field('comunicacion', $old_field) === 'asincrona' ? 'checked' : '' ?>>
            <label for="asincrona">Asíncrona</label><br>

            <input type="radio" id="mixta" name="comunicacion" value="mixta" <?= old_field('comunicacion', $old_field) === 'mixta' ? 'checked' : '' ?>>
            <label for="mixta">Mixta</label><br>



            <?= field_error('comunicacion', $errors) ?>

            <label for="herramientas[]">¿Con qué herramientas has trabajado?</label><br>
            <input type="checkbox" id="git" name="herramientas[]" value="Git" <?= in_array('Git', isset($old_field['herramientas']) ? $old_field['herramientas'] : []) ? 'checked' : '' ?>>
            <label for="git">Git</label><br>
            <input type="checkbox" id="docker" name="herramientas[]" value="Docker" <?= in_array('Docker', isset($old_field['herramientas']) ? $old_field['herramientas'] : []) ? 'checked' : '' ?>>
            <label for="docker">Docker</label><br>
            <input type="checkbox" id="jira" name="herramientas[]" value="Jira" <?= in_array('Jira', isset($old_field['herramientas']) ? $old_field['herramientas'] : []) ? 'checked' : '' ?>>
            <label for="jira">Jira</label><br>
            <input type="checkbox" id="trello" name="herramientas[]" value="Trello" <?= in_array('Trello', isset($old_field['herramientas']) ? $old_field['herramientas'] : []) ? 'checked' : '' ?>>
            <label for="trello">Trello</label><br>
            <input type="checkbox" id="slack" name="herramientas[]" value="Slack" <?= in_array('Slack', isset($old_field['herramientas']) ? $old_field['herramientas'] : []) ? 'checked' : '' ?>>
            <label for="slack">Slack</label><br>
            <input type="checkbox" id="notion" name="herramientas[]" value="Notion" <?= in_array('Notion', isset($old_field['herramientas']) ? $old_field['herramientas'] : []) ? 'checked' : '' ?>>
            <label for="notion">Notion</label><br><br>
            <?= field_error('herramientas', $errors) ?>


            <label for="disponibilidad_horas">¿Qué disponibilidad de horas tienes?</label>
            <div class="disponibilidad-container">
                <input id="disponibilidad_horas_inicio" name="disponibilidad_horas_inicio" type="time" required
                    value="<?= old_field('disponibilidad_horas_inicio', $old_field) ?>">
                <p>-</p>
                <input id="disponibilidad_horas_fin" name="disponibilidad_horas_fin" type="time" required
                    value="<?= old_field('disponibilidad_horas_fin', $old_field) ?>">
            </div>
            <?= field_error('disponibilidad_horas', $errors) ?>
        </section>
        <section>
            <h2>Organización y bienestar</h2>
            <label for="gestion_tiempo">¿Cómo gestionas el tiempo?</label>
            <select id="gestion_tiempo" name="gestion_tiempo" required>
                <option value="1" <?= old_field('gestion_tiempo', $old_field) === '1' ? 'checked' : '' ?>>1</option>
                <option value="2" <?= old_field('gestion_tiempo', $old_field) === '2' ? 'checked' : '' ?>>2</option>
                <option value="3" <?= old_field('gestion_tiempo', $old_field) === '3' ? 'checked' : '' ?>>3</option>
                <option value="4" <?= old_field('gestion_tiempo', $old_field) === '4' ? 'checked' : '' ?>>4</option>
                <option value="5" <?= old_field('gestion_tiempo', $old_field) === '5' ? 'checked' : '' ?>>5</option>
            </select>
            <?= field_error('gestion_tiempo', $errors) ?>
            <label for="estres_proyecto">¿Cómo gestionas el estrés en un proyecto?</label>
            <select id="estres_proyecto" name="estres_proyecto" required>
                <option value="1" <?= old_field('estres_proyecto', $old_field) === '1' ? 'checked' : '' ?>>1</option>
                <option value="2" <?= old_field('estres_proyecto', $old_field) === '2' ? 'checked' : '' ?>>2</option>
                <option value="3" <?= old_field('estres_proyecto', $old_field) === '3' ? 'checked' : '' ?>>3</option>
                <option value="4" <?= old_field('estres_proyecto', $old_field) === '4' ? 'checked' : '' ?>>4</option>
                <option value="5" <?= old_field('estres_proyecto', $old_field) === '5' ? 'checked' : '' ?>>5</option>
            </select>

            <label for="preferencia_espacio">¿Cómo te gusta que sea tu espacio al trabajar?</label>
            <select id="preferencia_espacio" name="preferencia_espacio" required>
                <option value="silencio" <?= old_field('preferencia_espacio', $old_field) === 'silencio' ? 'checked' : '' ?>>Silencio</option>
                <option value="ruido" <?= old_field('preferencia_espacio', $old_field) === 'ruido' ? 'checked' : '' ?>>
                    Ruido</option>
                <option value="ruido_blanco" <?= old_field('preferencia_espacio', $old_field) === 'ruido_blanco' ? 'checked' : '' ?>>Ruido blanco</option>
                <option value="musica" <?= old_field('preferencia_espacio', $old_field) === 'musica' ? 'checked' : '' ?>>
                    Música</option>
                <option value="podcast" <?= old_field('preferencia_espacio', $old_field) === 'podcast' ? 'checked' : '' ?>>
                    Podcast/Audiolibro</option>
            </select>
            <?= field_error('preferencia_espacio', $errors) ?>

            <label for="sentimiento_grupo">¿Como te sientes al trabajar en grupo?</label>
            <select id="sentimiento_grupo" name="sentimiento_grupo" type="select" required>
                <option value="muy_comodo" <?= old_field('sentimiento_grupo', $old_field) === 'muy_comodo' ? 'checked' : '' ?>>Muy cómodo</option>
                <option value="comodo" <?= old_field('sentimiento_grupo', $old_field) === 'comodo' ? 'checked' : '' ?>>
                    Cómodo</option>
                <option value="neutral" <?= old_field('sentimiento_grupo', $old_field) === 'neutral' ? 'checked' : '' ?>>
                    Neutral</option>
                <option value="incómodo" <?= old_field('sentimiento_grupo', $old_field) === 'incomodo' ? 'checked' : '' ?>>
                    Incómodo</option>
                <option value="muy_incómodo" <?= old_field('sentimiento_grupo', $old_field) === 'muy_incomodo' ? 'checked' : '' ?>>Muy incómodo</option>
            </select>
            <?= field_error('sentimiento_grupo', $errors) ?>
        </section>
        <section>
            <h2>Logística</h2>
            <label for="dispositivo">¿Con que dispositvo sueles trabajar?</label>
            <select id="dispositivo" name="dispositivo" type="select" required>
                <option value="portatil" <?= old_field('dispositivo', $old_field) === 'portatil' ? 'checked' : '' ?>>
                    Portátil</option>
                <option value="sobremesa" <?= old_field('dispositivo', $old_field) === 'sobremesa' ? 'checked' : '' ?>>
                    Sobremesa</option>
            </select>
            <?= field_error('dispositivo', $errors) ?>

            <label for="dispositivo_color">¿De qué color es tu dispositivo?</label>
            <input type="color" id="dispositivo_color" name="dispositivo_color"
                value="<?= old_field('dispositivo_color', $old_field) ? old_field('dispositivo_color', $old_field) : '#000000' ?>">

            <label for="so_preferido">¿Con que sistema operativo sueles trabajar?</label><br>
            <input id="windows" name="so_preferido" type="radio" value="windows" <?= old_field('so_preferido', $old_field) === 'windows' ? 'checked' : '' ?>>
            <label for="windows">Windows</label><br>
            <input id="linux" name="so_preferido" type="radio" value="linux" <?= old_field('so_preferido', $old_field) === 'linux' ? 'checked' : '' ?>>
            <label for="linux">Linux</label><br>
            <input id="mac" name="so_preferido" type="radio" value="mac" <?= old_field('so_preferido', $old_field) === 'mac' ? 'checked' : '' ?>>
            <label for="mac">Mac</label><br>
            </select>
            <?= field_error('so_preferido', $errors) ?>

        </section>
        <section>
            <h2>Observaciones</h2>
            <label for="comentario">Escribe una observación</label>
            <textarea id="comentario" name="comentario" type="textarea"
                maxlength="500"><?= old_field('comentario', $old_field) ?></textarea>
        </section>

        <button type="submit" id="button-enviar" disabled>Enviar</button>
    </form>
    <?php include 'includes/footer.php'; ?>