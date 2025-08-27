<?php
include 'conexion.php';
$conexion = conectar();

function handleRequest($conexion) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json; charset=utf-8');

        // Crear permiso
        if (isset($_POST['titulo'])) {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];

            error_log("📌 Creando permiso: $titulo");

            if (!empty($titulo)) {
                $sql = "INSERT INTO permisos (titulo, descripcion) VALUES (?, ?)";
                if ($stmt = $conexion->prepare($sql)) {
                    $stmt->bind_param("ss", $titulo, $descripcion);
                    if ($stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Permiso creado exitosamente.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error al crear el permiso.']);
                    }
                    $stmt->close();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'El título no puede estar vacío.']);
            }
        }

        // Editar permiso
        if (isset($_POST['editarPermiso'])) {
            $id = $_POST['editarPermiso'];
            $titulo = $_POST['nuevoTitulo'];
            $descripcion = $_POST['nuevaDescripcion'];

            error_log("✏️ Editando permiso ID $id: $titulo");

            $sql = "UPDATE permisos SET titulo = ?, descripcion = ? WHERE id = ?";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("ssi", $titulo, $descripcion, $id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Permiso actualizado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el permiso.']);
                }
                $stmt->close();
            }
        }

        // Eliminar permiso
        if (isset($_POST['eliminarPermiso'])) {
            $id = $_POST['eliminarPermiso'];
            error_log("🗑️ Eliminando permiso ID $id");
            $sql = "DELETE FROM permisos WHERE id = ?";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Permiso eliminado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al eliminar el permiso.']);
                }
                $stmt->close();
            }
        }
    }
}

function obtenerPermisos($conexion) {
    $sql = "SELECT id, titulo, descripcion FROM permisos";
    $result = $conexion->query($sql);

    $permisos = [];
    while ($row = $result->fetch_assoc()) {
        $permisos[] = $row;
    }

    return $permisos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleRequest($conexion);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => true, 'permisos' => obtenerPermisos($conexion)]);
}

$conexion->close();
?>
