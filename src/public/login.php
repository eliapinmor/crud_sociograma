<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $archivo = "../storage/data.json";

    if (file_exists($archivo)) {
        $usuarios = json_decode(file_get_contents($archivo), true);
        foreach ($usuarios as $usuario) {
            if ($usuario["email"] === $email && password_verify($password, $usuario["password"])) {
                $_SESSION["usuario"] = $email;
                $_SESSION["email"] = $email;
                $_SESSION["rol"] = $usuario["rol"];
                if ($usuario["rol"] === "admin") {
                    header("Location: index_ajax.php");
                } else if ($usuario["rol"] === "user") {
                    header("Location: index.php");
                }
                exit;
            }
        }
    }
    echo "<p>Email o contraseña incorrectos.</p>";

}
include_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <h1>Inicio de sesión</h1>
    <form method="POST" action="login.php">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>