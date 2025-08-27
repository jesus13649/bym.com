<?php
include 'conexion.php'; // Archivo con la conexión a la BD
$conexion = conectar();
// Función para manejar la creación, edición y eliminación de roles
function handleRequest($conexion) {
    // Comprobar si los datos fueron enviados mediante POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Crear un rol
        if (isset($_POST['nombreRol'])) {
            $nombreRol = $_POST['nombreRol'];

            if (!empty($nombreRol)) {
                $sql = "INSERT INTO roles (nombre) VALUES (?)";
                if ($stmt = $conexion->prepare($sql)) {
                    $stmt->bind_param("s", $nombreRol);

                    if ($stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Rol creado exitosamente.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error al crear el rol: ' . $stmt->error]);
                    }

                    $stmt->close();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'El nombre del rol no puede estar vacío.']);
            }
        }

        // Editar un rol
        if (isset($_POST['editarRol']) && isset($_POST['nuevoNombreRol'])) {
            $idRol = $_POST['editarRol'];
            $nuevoNombreRol = $_POST['nuevoNombreRol'];

            $sql = "UPDATE roles SET nombre = ? WHERE id = ?";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("si", $nuevoNombreRol, $idRol);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Rol actualizado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el rol: ' . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
            }
        }

        // Eliminar un rol
        if (isset($_POST['eliminarRol'])) {
            $idRol = $_POST['eliminarRol'];

            $sql = "DELETE FROM roles WHERE id = ?";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("i", $idRol);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Rol eliminado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al eliminar el rol: ' . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
            }
        }
    }
}

// Función para obtener todos los roles
function obtenerRoles($conexion) {
    $sql = "SELECT id, nombre FROM roles"; 
    $result = $conexion->query($sql);

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }

    return $roles;
}

// Comprobar si se debe manejar la solicitud POST o simplemente obtener los roles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleRequest($conexion); // Maneja la creación, edición o eliminación
} else {
    // Obtener los roles
    $roles = obtenerRoles($conexion);

    // Convertir el resultado en formato JSON
    echo json_encode(['success' => true, 'roles' => $roles]);
}

// Cerrar la conexión
$conexion->close();
?>
