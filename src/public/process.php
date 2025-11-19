<?php

include 'includes/header.php';
include 'includes/functions.php'; 

$input = [
    'nombre' => trim($_POST['nombre'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'edad' => ($_POST['edad'] ?? ''),
    'curso' => trim($_POST['curso'] ?? ''),
    'preferido1' => trim($_POST['preferido1'] ?? ''),
    'preferido2' => trim($_POST['preferido2'] ?? ''),
    'evitar1' => trim($_POST['evitar1'] ?? ''),
    'motivo_preferencia' => trim($_POST['motivo_preferencia'] ?? ''),
    'motivo_evitar' => trim($_POST['motivo_evitar'] ?? ''),
    'rol_habitual' => trim($_POST['rol_habitual'] ?? ''),
    'lenguaje_fuerte' => $_POST['lenguaje_fuerte'] ?? [],
    'experiencia' => trim($_POST['experiencia'] ?? ''),
    'comunicacion' => trim($_POST['comunicacion'] ?? ''),
    'herramientas' => $_POST['herramientas'] ?? [],
    'disponibilidad_horas_inicio' => trim($_POST['disponibilidad_horas_inicio'] ?? ''),
    'disponibilidad_horas_fin' => trim($_POST['disponibilidad_horas_fin'] ?? ''),
    'gestion_tiempo' => trim($_POST['gestion_tiempo'] ?? ''),
    'estres_proyecto' => trim($_POST['estres_proyecto'] ?? ''),
    'preferencia_espacio' => trim($_POST['preferencia_espacio'] ?? ''),
    'sentimiento_grupo' => trim($_POST['sentimiento_grupo'] ?? ''),
    'dispositivo' => trim($_POST['dispositivo'] ?? ''),
    'dispositivo_color' => trim($_POST['dispositivo_color'] ?? ''),
    'so_preferido' => trim($_POST['so_preferido'] ?? ''),
    'comentario' => trim($_POST['comentario'] ?? '')
];


$errors = [];

if (strlen($input['nombre']) < 2) {
    $errors['nombre'] = 'El nombre debe tener al menos 2 carácteres';
}


if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Introduce un email válido';
}

if ($input['edad'] === '') {
    $errors['edad'] = 'Introduce tu edad';
} elseif (!is_numeric($edad) || $edad < 15 || $edad > 100) {
    $errors['edad'] = 'Introduce una edad válida entre 15 y 100 años.';
}

if (!in_array($input['curso'], ['daw', 'dam', 'asix'])) {
    $errors['curso'] = 'Indica en que curso estás';
}


if (($input['preferido1']) === '') {
    $errors['preferido1'] = 'Introduce a la primera persona con la que prefieres trabajar';
}

if (($input['preferido2']) === '') {
    $errors['preferido2'] = 'Introduce a la segunda persona con la que prefieres trabajar';
} elseif (($input['preferido2']) === ($input['preferido1'])){
    $errors['preferido2'] = 'Las personas no pueden ser la misma';
}

if (($input['evitar1']) === '') {
    $errors['evitar1'] = 'Escribe una persona con la que prefieres no trabajar';
} elseif (($input['evitar1']) === $input['nombre']) {
    $errors['evitar1'] = 'No puedes no querer trabajr contigo mismo, escribe un nombre válido';
} elseif (($input['evitar1']) === ($input['preferido1']) ||($input['evitar1']) === ($input['preferido2'])) {
    $errors['evitar1'] = 'El nombre de las personas con las que quieres trabajar no puede ser el mismo que con la que no';
}

if (($input['motivo_preferencia']) === ''){
    $errors['motivo_preferencia'] = 'Escribe el motivo por el que quieres trabajar con estas personas';
} elseif (strlen($input['motivo_preferencia']) > 300) {
    $errors['motivo_preferencia'] = 'El motivo no puede superar los 300 caracteres';
}

if (($input['motivo_evitar']) === ''){
    $errors['motivo_evitar'] = 'Escribe el motivo por el que no quieres trabajar con esta persona';
} elseif (strlen($input['motivo_evitar']) > 300) {
    $errors['motivo_evitar'] = 'El motivo no puede superar los 300 caracteres';
}

if(($input['rol_habitual']) === ''){
    $errors['rol_habitual'] = 'Selecciona un rol';
}

if (!in_array($input['rol_habitual'], ['lider', 'seguidor'])) {
    $errors['rol_habitual'] = 'Indica en que rol te sueles desarollar habitualmente';
}

if (empty($_POST['lenguaje_fuerte'])) {
    $errors['lenguaje_fuerte'] = 'Selecciona al menos un lenguaje de programación';
}

if (!in_array($input['experiencia'], ['1','2','3 - 4','5 - 8','9 o más'])) {
    $errors['experiencia'] = 'Selecciona un valor válido';
}

if (!in_array($input['comunicacion'], ['sincrona', 'asincrona', 'mixta'])) {
    $errors['comunicacion'] = 'Selecciona un tipo de comunicación';
}

if (empty($_POST['herramientas'])) {
    $errors['herramientas'] = 'Selecciona al menos una herramienta';
}

if (empty($input['disponibilidad_horas_inicio']) || empty($input['disponibilidad_horas_fin'])) {
    $errors['disponibilidad_horas'] = 'Debes indicar la hora de inicio y de fin.';
} elseif (strtotime($input['disponibilidad_horas_inicio']) >= strtotime($input['disponibilidad_horas_fin'])) {
    $errors['disponibilidad_horas'] = 'La hora de fin debe ser posterior a la de inicio.';
}


if (!in_array($input['gestion_tiempo'], ['1','2','3','4','5'])) {
    $errors['gestion_tiempo'] = 'Selecciona un valor válido';
}

if (!in_array($input['estres_proyecto'], ['1','2','3','4','5'])) {
    $errors['estres_proyecto'] = 'Selecciona un valor válido';
}

if (!in_array($input['preferencia_espacio'], ['silencio','ruido','ruido_blanco','musica','podcast'])) {
    $errors['preferencia_espacio'] = 'Selecciona una opción válida';
}


if (!in_array($input['sentimiento_grupo'], ['muy_comodo','comodo','neutral','incomodo','muy_incomodo'])) {
    $errors['sentimiento_grupo'] = 'Selecciona cómo te sientes al trabajar en grupo';
}


if (!in_array($input['dispositivo'], ['portatil', 'sobremesa'])) {
    $errors['dispositivo'] = 'Selecciona con que dispositivo sueles trabajar';
}

if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $input['dispositivo_color'])) {
    $errors['dispositivo_color'] = 'Selecciona un color válido';
}

if (!in_array($input['so_preferido'], ['windows', 'linux', 'mac'])) {
    $errors['so_preferido'] = 'Selecciona un sistema operativo';
}


if (strlen($input['comentario']) > 500) {
    $errors['comentario'] = 'Máximo 500 caracteres en observaciones.';
}



if ($errors) {
    $old_field = $input;
    include 'index.php';
    exit;
}

// Si todo va bien → guardar y mostrar confirmación
$input['fecha'] = date('Y-m-d H:i:s');
$data = load_json('data/sociograma.json');
$data[] = $input;
save_json('data/sociograma.json', $data);
?>

<main>
    <h2>Gracias, <?= htmlspecialchars($input['nombre']) ?>. Tus datos se han guardado correctamente.</h2>
   
</main>
<?php
include 'includes/footer.php';