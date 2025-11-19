<?php

function load_json($path) {
    if (!file_exists($path)) return [];

    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function save_json($path, $data){
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}

function old_field($name, $source = []){
    return isset($source[$name]) ? $source[$name] : "";
}

function field_error($name, $errors = []) {
    return isset($errors[$name]) ? "<span class='error'>{$errors[$name]}</span>" : "";
}

?>