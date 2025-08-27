<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

include 'funciones.php';
include 'conexion.php';
$conexion = conectar();

// Validar método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'mensaje' => 'Método no permitido']);
    exit;
}

// Validar parámetro de operación
if (!isset($_POST["op"])) {
    echo json_encode(['ok' => false, 'mensaje' => 'Falta el parámetro "op"']);
    exit;
}

ob_clean(); // Limpia cualquier salida previa

try {
    switch ($_POST["op"]) {

        // Listar Roles
        case "LR":
            $sql = "SELECT id, nombre FROM roles;";
            $query = GenerarArray($sql);
            echo json_encode($query);
            break;

        // Listar Módulos por Rol
        case "LM":
            $rol = intval($_POST["rol_id"]);

            $sql = "SELECT 
                        m.id AS id,
                        m.numero,
                        m.descripcion AS modulo,
                        (
                            SELECT COUNT(*)
                            FROM roles_modulos_permisos p 
                            INNER JOIN modulos_permisos mp ON mp.id = p.id_modulo_permiso
                            WHERE p.id_rol = $rol AND mp.id_modulo = m.id
                        ) AS asignados
                    FROM modulos m
                    LEFT JOIN modulos_permisos x ON x.id_modulo = m.id
                    ORDER BY m.numero ASC;";
            $query = GenerarArray($sql);
            echo json_encode($query);
            break;

        // Listar Permisos por Módulo y Rol
        case "LP":
            $modulo_id = intval($_POST["modulo_id"]);
            $rol_id = intval($_POST["rol_id"]);

            $sql = "SELECT 
                        p.id AS id_permiso,
                        p.titulo AS permiso,
                        
                        COALESCE(rp.id_modulo_permiso, 0) AS modulo_permiso_id
                    FROM permisos p
                    INNER JOIN modulos_permisos mp ON mp.id_permiso = p.id 
                    LEFT JOIN roles_modulos_permisos rp 
                        ON rp.id_modulo_permiso = mp.id AND rp.id_rol = $rol_id
                    WHERE mp.id_modulo = $modulo_id
                    ORDER BY p.descripcion;";
            $query = GenerarArray($sql);
            echo json_encode($query);
            break;

        // Agregar Permiso a Rol
        case "add_permiso":
            $modulo_id = intval($_POST["modulo_id"]);
            $rol_id = intval($_POST["rol_id"]);
            $permiso_id = intval($_POST["permiso_id"]);

            // Obtener el ID de la relación módulo-permiso
            $result = GenerarArray("SELECT id FROM modulos_permisos WHERE id_modulo = $modulo_id AND id_permiso = $permiso_id LIMIT 1;");

            if (count($result) === 0) {
                echo json_encode(['ok' => false, 'mensaje' => 'No se encontró el identificador del módulo-permiso']);
                break;
            }

            $modulo_permiso_id = $result[0]["id"];

            // Insertar en la tabla de asignación
            $insert = $conexion->query("INSERT INTO roles_modulos_permisos (id_modulo_permiso, id_rol) VALUES ($modulo_permiso_id, $rol_id);");

            echo json_encode($insert
                ? ['ok' => true, 'mensaje' => 'Permiso asignado correctamente']
                : ['ok' => false, 'mensaje' => 'Error al asignar el permiso']);
            break;

        // Eliminar Permiso de Rol
        case "DEL":
            $modulo_permiso_id = intval($_POST["modulo_permiso_id"]);
            $rol_id = intval($_POST["rol_id"]);

            $query = $conexion->query("DELETE FROM roles_modulos_permisos WHERE id_modulo_permiso = $modulo_permiso_id AND id_rol = $rol_id");

            echo json_encode($query
                ? ['ok' => true, 'mensaje' => 'Permiso eliminado correctamente']
                : ['ok' => false, 'mensaje' => 'Error al eliminar el permiso']);
            break;

        // Obtener módulos visibles según el rol
        case "modulos_por_usuario":
            $rol_id = intval($_POST["rol_id"]);

            $sql = "SELECT DISTINCT m.numero, m.descripcion, m.id
                    FROM modulos m
                    INNER JOIN modulos_permisos mp ON mp.id_modulo = m.id
                    INNER JOIN roles_modulos_permisos rmp ON rmp.id_modulo_permiso = mp.id
                    WHERE rmp.id_rol = $rol_id
                    ORDER BY m.numero ASC;";
            $modulos = GenerarArray($sql);
            echo json_encode($modulos);
            break;

        // Operación no válida
        default:
            echo json_encode(['ok' => false, 'mensaje' => 'Operación no válida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'mensaje' => 'Excepción: ' . $e->getMessage()]);
}
