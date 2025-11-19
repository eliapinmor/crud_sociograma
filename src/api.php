<?php
declare(strict_types=1);
/**
 * De momento solo comprobamos que el endpoint responde y que el navegador
 * puede hacer fetch() a este archivo. En la siguiente parte implementamos
 * list | create | delete con persistencia en data.json.
 */
header('Content-Type: application/json; charset=utf-8');
/**
* Envía una respuesta de éxito con envoltura homogénea.
*
* @param mixed $contenidoDatos Datos a devolver (ej: lista de usuarios).

* @param int $codigoHttp Código de estado HTTP (200 por defecto).
*/
function responder_json_exito(mixed $contenidoDatos = [], int $codigoHttp = 200): void
{
    http_response_code($codigoHttp);
    echo json_encode(
        ['ok' => true, 'data' => $contenidoDatos],
        JSON_UNESCAPED_UNICODE
    );
    exit;
}
/**
 * Envía una respuesta de error con envoltura homogénea.
 *
 * @param string $mensajeError Mensaje de error legible para el cliente.
 * @param int $codigoHttp Código de estado HTTP (400 por defecto).
 */
function responder_json_error(string $mensajeError, int $codigoHttp = 400): void
{
    http_response_code($codigoHttp);
    echo json_encode(
        ['ok' => false, 'error' => $mensajeError],
        JSON_UNESCAPED_UNICODE
    );
    exit;
}

// 2) Ruta al archivo de persistencia (carpeta storage)
$rutaArchivoDatosJson = __DIR__ . '/storage/data.json';
// 2.1) Si no existe, lo creamos con un array JSON vacío ([])
if (!file_exists($rutaArchivoDatosJson)) {
    file_put_contents($rutaArchivoDatosJson, json_encode([]) . "\n");
}
// 2.2) Cargar su contenido como array asociativo de PHP
$listaUsuarios = json_decode((string) file_get_contents($rutaArchivoDatosJson), true);
// 2.3) Si por cualquier motivo no es un array, lo normalizamos a []
if (!is_array($listaUsuarios)) {
    $listaUsuarios = [];
}

// 3) Método HTTP y acción (por querystring o formulario)
// - Por simplicidad: list en GET; create y delete por POST.
// - Si no llega 'action', usamos 'list' como valor por defecto.
$metodoHttpRecibido = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$accionSolicitada = $_GET['action'] ?? $_POST['action'] ?? 'list';

// 4) LISTAR usuarios: GET /api.php?action=list
if ($metodoHttpRecibido === 'GET' && $accionSolicitada === 'list') {
    responder_json_exito($listaUsuarios); // 200 OK
}

// 5) CREAR usuario: POST /api.php?action=create
// Body JSON esperado: { "nombre": "...", "email": "..." }
if ($metodoHttpRecibido === 'POST' && $accionSolicitada === 'create') {
    $cuerpoBruto = (string) file_get_contents('php://input');
    $datosDecodificados = $cuerpoBruto !== '' ? (json_decode($cuerpoBruto, true) ?? []) : [];
    // Extraemos datos y normalizamos
    $nombreUsuarioNuevo = trim((string) ($datosDecodificados['nombre'] ?? $_POST['nombre'] ?? ''));
    $correoUsuarioNuevo = trim((string) ($datosDecodificados['email'] ?? $_POST['email'] ?? ''));
    $correoUsuarioNormalizado = mb_strtolower($correoUsuarioNuevo);
    $passwordUsuarioNuevo = trim((string) ($datosDecodificados['password'] ?? $_POST['password'] ?? ''));
    $rolUsuarioNuevo = trim((string) ($datosDecodificados['rol'] ?? $_POST['rol'] ?? ''));

    // Validación mínima en servidor
    if ($nombreUsuarioNuevo === '' || $correoUsuarioNuevo === '') {
        responder_json_error('Los campos "nombre" y "email" son obligatorios.', 422);
    }
    if (!filter_var($correoUsuarioNuevo, FILTER_VALIDATE_EMAIL)) {
        responder_json_error('El campo "email" no tiene un formato válido.', 422);
    }
    // Límites razonables para este ejercicio
    if (mb_strlen($nombreUsuarioNuevo) > 60) {
        responder_json_error('El campo "nombre" excede los 60 caracteres.', 422);
    }
    if (mb_strlen($correoUsuarioNuevo) > 120) {
        responder_json_error('El campo "email" excede los 120 caracteres.', 422);
    }
    // Evitar duplicados por email
    if (existeEmailDuplicado($listaUsuarios, $correoUsuarioNormalizado)) {
        responder_json_error('Ya existe un usuario con ese email.', 409);
    }
    // Agregamos y persistimos (guardamos el email normalizado)
    $listaUsuarios[] = [
        'id' => uniqid(),
        'nombre' => $nombreUsuarioNuevo,
        'email' => $correoUsuarioNormalizado,
        'password' => password_hash($passwordUsuarioNuevo, PASSWORD_DEFAULT),
        'rol' => $rolUsuarioNuevo,
    ];
    file_put_contents(
        $rutaArchivoDatosJson,
        json_encode($listaUsuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n"
    );
    responder_json_exito($listaUsuarios, 201);
}

// 6) ELIMINAR usuario: POST /api.php?action=delete
// Body JSON esperado: { "index": 0 }
// Nota: podríamos usar método DELETE; aquí lo simplificamos a POST.
if (
    ($metodoHttpRecibido === 'POST' || $metodoHttpRecibido === 'DELETE') && $accionSolicitada === 'delete'
) {
    $cuerpoBruto = (string) file_get_contents('php://input');
    $datosDecodificados = $cuerpoBruto !== '' ? json_decode($cuerpoBruto, true) ?? [] : [];
    $idRecibido = $datosDecodificados['id'] ?? null;

    if ($idRecibido === null) {
        responder_json_error('Falta el parámetro "id" para eliminar.', 422);
    }

    // Buscar usuario por id
    $indice = null;
    foreach ($listaUsuarios as $key => $u) {
        if (($u['id'] ?? '') === $idRecibido) {
            $indice = $key;
            break;
        }
    }

    if ($indice === null) {
        responder_json_error('El usuario con ese ID no existe.', 404);
    }

    // Eliminar y reindexar
    unset($listaUsuarios[$indice]);
    $listaUsuarios = array_values($listaUsuarios);

    // Guardar cambios
    file_put_contents(
        $rutaArchivoDatosJson,
        json_encode($listaUsuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n"
    );

    responder_json_exito($listaUsuarios);
}

// 7) Si llegamos aquí, la acción solicitada no está soportada
responder_json_error('Acción no soportada. Use list | create | delete', 400);

/**
 * Comprueba si ya existe un usuario con el email dado (comparación exacta).
 *
 * @param array $usuarios Lista actual en memoria.
 * @param string $emailNormalizado Email normalizado en minúsculas.
 */
function existeEmailDuplicado(array $usuarios, string $emailNormalizado): bool
{
    foreach ($usuarios as $u) {
        if (
            isset($u['email']) && is_string($u['email']) && mb_strtolower($u['email']) ===
            $emailNormalizado
        ) {
            return true;
        }
    }
    return false;
}
?>