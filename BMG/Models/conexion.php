<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function conectar() {
    $host = "localhost";
    $dbname = "bmg";
    $username = "root";
    $password = "1234";

    // Crear conexión con MySQLi
    $conexion = new mysqli($host, $username, $password, $dbname);

    // Verificar conexión
    if ($conexion->connect_error) {
        http_response_code(500); // Código de error del servidor
        die(json_encode([
            "ok" => false,
            "mensaje" => "Error de conexión a la base de datos: " . $conexion->connect_error
        ]));
    }

    // Establecer el conjunto de caracteres a UTF-8
    if (!$conexion->set_charset("utf8mb4")) {
        http_response_code(500);
        die(json_encode([
            "ok" => false,
            "mensaje" => "Error al establecer el conjunto de caracteres UTF-8: " . $conexion->error
        ]));
    }

    return $conexion;
}
?>
