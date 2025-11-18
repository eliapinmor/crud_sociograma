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
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mini CRUD (Parte 1)</title>
</head>
<body>
    <h1>Mini CRUD en JSON (sin Base de Datos) — Parte 1</h1>
    <p>Servidor PHP 8.4 funcionando dentro de Docker.</p>
    <p><a href="/public/index_ajax.php">Ir a Parte 2 (AJAX con fetch)</a></p>

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
?>