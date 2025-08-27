<?php
session_start();

require_once('../models/bd.php');
require_once('../shared/funciones.php');

$conn = conectar();

if (!isset($_POST['op'])) {
    echo json_encode(['error' => 'Operación no definida']);
    exit;
}

switch ($_POST['op']) {

  case "menu":
    $rol = intval($_SESSION["Ses_roles_id"]);  // cast a entero para seguridad

    // Consulta mejorada: seleccionamos campos que el frontend necesita
    $sql = "
        SELECT
            tm.id_modulo,
            tm.numero AS modulo,
            SUBSTRING(tm.numero, 1, 2) AS id_grupo,
            tm.descripcion AS titulo,
            tm.ruta,
            tm.icono
        FROM t_modulos_permisos mp
        INNER JOIN t_permisos p ON mp.id_permiso = p.id_permiso
        INNER JOIN t_roles_modulos_permisos rp ON rp.id_modulo_permiso = mp.id_modulo_permiso
        INNER JOIN t_modulos tm ON tm.id_modulo = mp.id_modulo
        WHERE
            rp.id_rol = $rol
            AND p.id_permiso = 1
        ORDER BY tm.numero;
    ";

    $query = GenerarArray($sql);
    echo json_encode($query);
    break;


    case "infoUser":
        $id_usuario = $_SESSION["Ses_id"];

        $sql = GenerarArray("
            SELECT
                u.nit,
                u.usuario,
                CONCAT(u.nombres, ' ', u.apellidos) AS nombres,
                r.descripcion AS tipo_usuario,
                u.fecha_creacion,
                u.email,
                u.codigoPrestador
            FROM t_usuarios u
            INNER JOIN t_roles r ON r.id_roles = u.roles_id
            WHERE u.id = $id_usuario
        ");

        echo json_encode($sql);
        break;

    case "alerta_pago":
        try {
            $usuario = $_SESSION["Ses_id"];
            $alerta_pago = GenerarArray("SELECT IFNULL(alerta_pago,0) AS alerta_pago FROM t_usuarios WHERE id=$usuario");

            $ultimo_dia_mes = date('t');
            $dia_actual = date('j');
            $dias_restantes = $ultimo_dia_mes - $dia_actual;
            $dias_alerta = 0;

            if (count($alerta_pago) > 0) {
                $dias_alerta = $alerta_pago[0]["alerta_pago"];
            }

            echo json_encode([
                'restantes' => $dias_restantes,
                'dias_alerta' => $dias_alerta
            ]);
        } catch (Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
        }
        break;

    default:
        echo json_encode(['error' => 'Operación no válida']);
}
