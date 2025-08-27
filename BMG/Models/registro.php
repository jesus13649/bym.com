<?php
include 'conexion.php';

header('Content-Type: application/json');
$conexion = conectar();
if (!$conexion) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos"]);
    exit;
}

// POST: Registrar nuevo usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario   = $conexion->real_escape_string($_POST['usuario'] ?? '');
    $clave     = $_POST['clave'] ?? '';
    $rol_id    = (int) ($_POST['rol'] ?? 0);
    $nombre    = $conexion->real_escape_string($_POST['nombre'] ?? '');
    $apellido  = $conexion->real_escape_string($_POST['apellido'] ?? '');
    $email     = $conexion->real_escape_string($_POST['email'] ?? '');
    $telefono  = $conexion->real_escape_string($_POST['telefono'] ?? '');
    $direccion = $conexion->real_escape_string($_POST['direccion'] ?? '');
    $nit       = $conexion->real_escape_string($_POST['documento'] ?? ''); // Documento se guarda en nit
    
    // Asegurar que estado siempre sea 0 o 1 (numérico)
    $estado    = $_POST['estado'] ?? 0;
    if (!is_numeric($estado)) {
        // Si es texto tipo "Activo" o "Inactivo", conviértelo a 1/0
        $estado = (strtolower($estado) === 'activo') ? 1 : 0;
    }
    $estado = (int) $estado;

    echo json_encode(
        registrarUsuario($conexion, $usuario, $clave, $rol_id, $nombre, $apellido, $email, $direccion, $telefono, $nit, $estado)
    );
    exit;
}

// GET: Cargar listas para selects
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = [];

    $departamentos = $conexion->query("SELECT id, nombre FROM departamentos");
    $roles = $conexion->query("SELECT id, nombre FROM roles");
    $estados = $conexion->query("SELECT EstadoID, NombreEstado FROM Estados");

    if ($departamentos) $response['departamentos'] = $departamentos->fetch_all(MYSQLI_ASSOC);
    if ($roles) $response['roles'] = $roles->fetch_all(MYSQLI_ASSOC);
    if ($estados) $response['estados'] = $estados->fetch_all(MYSQLI_ASSOC);

    echo json_encode($response);
    exit;
}

// Función para registrar usuario
function registrarUsuario($conexion, $usuario, $clave, $rol_id, $nombre, $apellido, $email, $direccion, $telefono, $nit, $estado) {
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (
        USUARIO, CLAVE, FECHA_CREACION, nombres, apellidos, email, roles_id, nit, telefono, direccion, estado, facturas_max_mes, archivos_max_mes, alerta_pago
    ) VALUES (
        '$usuario', 
        '$clave_hash', 
        CURRENT_TIMESTAMP, 
        '$nombre', 
        '$apellido', 
        '$email', 
        '$rol_id', 
        '$nit', 
        '$telefono', 
        '$direccion', 
        '$estado', 
        0, 0, 0
    )";

    if ($conexion->query($sql)) {
        return ["success" => true, "message" => "Usuario registrado correctamente."];
    } else {
        return ["success" => false, "message" => "Error al registrar: " . $conexion->error];
    }
}
?>
