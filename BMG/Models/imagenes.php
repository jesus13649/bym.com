<?php
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';
$conexion = conectar();

$action = $_REQUEST['action'] ?? '';

if ($action == "listar") {
    $anio = $_GET['anio'] ?? '';
    $mes = $_GET['mes'] ?? '';

    // Validación
    if (empty($anio) || empty($mes)) {
        echo json_encode(["status" => "error", "message" => "Parámetros inválidos"]);
        exit;
    }

    // Consulta correcta con la estructura de la tabla
    $sql = "SELECT id, titulo, ruta_imagen, fecha_subida 
            FROM imagenes 
            WHERE YEAR(fecha_subida) = ? AND MONTH(fecha_subida) = ? 
            ORDER BY fecha_subida DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $anio, $mes);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Ajustamos ruta para la vista
        $row['imagen_url'] = "../" . $row['ruta_imagen']; 
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

if ($action == "eliminar") {
    $id = $_POST['id'] ?? 0;

    if ($id > 0) {
        // Primero obtenemos la ruta de la imagen para eliminar el archivo
        $sql = "SELECT ruta_imagen FROM imagenes WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $img = $result->fetch_assoc();

        if ($img && file_exists("../" . $img['ruta_imagen'])) {
            unlink("../" . $img['ruta_imagen']); // Borra archivo físico
        }

        // Elimina registro de la BD
        $sql = "DELETE FROM imagenes WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "ID inválido"]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Acción no válida"]);
?>
