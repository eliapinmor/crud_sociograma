<?php
declare(strict_types=1);
session_start();
if (!isset($_SESSION["usuario"])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION["rol"] !== "admin") {
  header("Location: index.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <title>Mini CRUD AJAX (fetch + JSON)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Hoja de estilos básica -->
  <link rel="stylesheet" href="/public/assets/css/styles.css" />
</head>

<body>
  <!-- Encabezado semántico -->
  <header class="encabezado-aplicacion">
    <h1 class="encabezado-aplicacion__titulo">
      Mini CRUD con fetch() (sin Base de Datos)
    </h1>
    <p class="encabezado-aplicacion__descripcion">
      Esta pantalla usa JavaScript para hablar con la API PHP y actualizar la
      tabla sin recargar la página.
    </p>
    <p><a href="logout.php">Cerrar sesión</a></p>
  </header>
  <main class="zona-principal" id="zona-principal" tabindex="-1">
    <!-- Zona de mensajes (con aria-live para lectores de pantalla) -->
    <div id="msg" class="mensajes-estado" role="status" aria-live="polite" aria-atomic="true"></div>
    <!-- Formulario de alta de usuario con etiquetas asociadas y atributos de ayuda -->
    <section class="bloque-formulario" aria-labelledby="titulo-formulario">
      <h2 id="titulo-formulario">Agregar nuevo usuario</h2>
      <form id="formCreate" class="formulario-alta-usuario" autocomplete="on" novalidate>
        <div class="form-row">
          <label for="campo-nombre" class="form-label">Nombre</label>
          <input id="campo-nombre" name="nombre" class="form-input" type="text" required minlength="2" maxlength="60"
            placeholder="Ej.: Ana Pérez" autocomplete="name" inputmode="text" />
        </div>
        <div class="form-row">
          <label for="campo-email" class="form-label">Email</label>
          <input id="campo-email" name="email" class="form-input" type="email" required maxlength="120"
            placeholder="ejemplo@correo.com" autocomplete="email" inputmode="email" />

        </div>
        <div class="form-row">
          <label for="campo-contraseña" class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-input" id="campo-contraseña"required placeholder="password">
        </div>
        <div class="form-row">
          <label for="campo-rol" class="form-label">Rol</label>
          <input type="text" name="rol" id="campo-rol" class="form-input" required placeholder="admin/user">
        </div>

        <div class="form-actions">
          <button id="boton-agregar-usuario" type="submit" class="boton-primario">
            Agregar usuario
          </button>
          <span id="indicador-cargando" class="indicador-cargando" aria-hidden="true" hidden>
            Cargando...
          </span>
        </div>
      </form>
    </section>
    <!-- Listado de usuarios -->
    <section class="bloque-listado" aria-labelledby="titulo-listado">
      <h2 id="titulo-listado">Listado de usuarios</h2>
      <div class="tabla-contenedor" role="region" aria-labelledby="titulo-listado">
        <table class="tabla-usuarios">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Email</th>
              <th scope="col">Rol</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <!-- Fila de estado vacío (se alterna desde JS) -->
            <tr id="fila-estado-vacio" class="fila-estado-vacio" hidden>
              <td colspan="4">
                <em>No hay usuarios registrados todavía.</em>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <!-- Nuestro JavaScript -->
  <script src="/public/assets/js/main.js" defer></script>
</body>

</html>