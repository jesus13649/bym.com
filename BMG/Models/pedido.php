<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

include 'funciones.php';
include 'conexion.php';
$conexion = conectar();

// Validación de parámetro OP
if (!isset($_POST["OP"])) {
    echo json_encode(["status" => "error", "message" => "Parámetro OP no definido."]);
    exit;
}

switch ($_POST["OP"]) {

    // =============================
    // CASE CLIENTE
    // =============================
    case "cliente":
        $term = $_POST['term'] ?? '';

        $sql = "SELECT 
                    usuarios.ID,
                    usuarios.USUARIO,
                    usuarios.CLAVE,
                    usuarios.FECHA_CREACION,
                    usuarios.nombres,
                    usuarios.apellidos,
                    usuarios.email,
                    usuarios.roles_id,
                    usuarios.nit,
                    usuarios.codigoPrestador,
                    usuarios.telefono,
                    usuarios.direccion,
                    usuarios.estado,
                    usuarios.facturas_max_mes,
                    usuarios.archivos_max_mes,
                    usuarios.alerta_pago
                FROM bmg.usuarios";

        if (!empty($term)) {
            $termEscaped = $conexion->real_escape_string($term);
            $sql .= " WHERE usuarios.nombres LIKE '%$termEscaped%' 
                      OR usuarios.apellidos LIKE '%$termEscaped%' 
                      OR usuarios.nit LIKE '%$termEscaped%'";
        }

        $result = $conexion->query($sql);
        if ($result) {
            $clientes = [];
            while ($row = $result->fetch_assoc()) {
                $clientes[] = $row;
            }
            echo json_encode($clientes);
        } else {
            echo json_encode(["status" => "error", "message" => $conexion->error, "sql" => $sql]);
        }
        break;

    // =============================
    // CASE BUSCAR PRODUCTO
    // =============================
case "buscar":
    $buscar = $_POST['buscar'] ?? '';
    $buscarEscaped = $conexion->real_escape_string($buscar);

    $sql = "SELECT 
                ProductoID,
                CodigoProducto,
                NombreProducto,
                Descripcion,
                Precio,
                IVA,
                Descuento,
                Proveedor,
                Lote,
                FechaVencimiento,
                NotaPrecaucion,
                FechaRegistro,
                CantidadStock,
                Categoria,
                Marca,
                Imagenes,
                Origen,
                DatosVentas
            FROM productos 
            WHERE CodigoProducto = '$buscarEscaped' 
               OR NombreProducto LIKE '%$buscarEscaped%' 
            LIMIT 1";

    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // ✅ Ajustar ruta de imagen correctamente
        if (!empty($producto['Imagenes'])) {
            // Si en BD quedó guardado "uploads/archivo.png", quitamos "uploads/"
            $filename = basename($producto['Imagenes']);
            $producto['Imagenes'] = "/BMG/Models/uploads/" . $filename;
        }

        echo json_encode(["status" => "success", "data" => $producto]);
    } else {
        echo json_encode(["status" => "error", "message" => "Producto no encontrado."]);
    }
    break;






    // =============================
    // CASE GUARDAR PEDIDO
    // =============================
    case "guardarPedido":
        try {
            $cliente   = $conexion->real_escape_string($_POST['cliente'] ?? '');
            $direccion = $conexion->real_escape_string($_POST['direccion'] ?? '');
            $correo    = $conexion->real_escape_string($_POST['correo'] ?? '');
            $telefono  = $conexion->real_escape_string($_POST['telefono'] ?? '');
            $notas     = $conexion->real_escape_string($_POST['notas'] ?? '');
            $resumen   = json_decode($_POST['resumen'] ?? '{}', true);
            $productos = json_decode($_POST['productos'] ?? '[]', true);

            if (empty($cliente) || empty($productos)) {
                echo json_encode(["status" => "error", "message" => "Cliente o productos vacíos."]);
                exit;
            }

            // Valores del resumen
            $subtotal   = floatval($resumen['subtotal'] ?? 0);
            $valorIva   = floatval($resumen['valorIva'] ?? 0);
            $valorTotal = floatval($resumen['valorTotal'] ?? 0);

            // Iniciar transacción
            $conexion->begin_transaction();

            // Insertar pedido
            $sqlPedido = "
                INSERT INTO pedidos (cliente, direccion, correo, telefono, notas, subtotal, iva, total)
                VALUES ('$cliente', '$direccion', '$correo', '$telefono', '$notas', $subtotal, $valorIva, $valorTotal)
            ";
            if (!$conexion->query($sqlPedido)) {
                throw new Exception("Error al insertar pedido: " . $conexion->error);
            }

            $pedido_id = $conexion->insert_id;

            // Insertar detalles
            foreach ($productos as $p) {
                $codigo      = $conexion->real_escape_string($p['codigo'] ?? '');
                $descripcion = $conexion->real_escape_string($p['descripcion'] ?? '');
                $precio      = floatval($p['precio'] ?? 0);
                $iva         = floatval($p['iva'] ?? 0);
                $descuento   = floatval($p['descuento'] ?? 0);
                $cantidad    = intval($p['cantidad'] ?? 0);
                $total       = floatval($p['total'] ?? 0);

                $sqlDetalle = "
                    INSERT INTO pedido_detalle (pedido_id, codigo_producto, descripcion, precio, iva, descuento, cantidad, total)
                    VALUES ($pedido_id, '$codigo', '$descripcion', $precio, $iva, $descuento, $cantidad, $total)
                ";
                if (!$conexion->query($sqlDetalle)) {
                    throw new Exception("Error al insertar detalle: " . $conexion->error);
                }
            }

            // Confirmar transacción
            $conexion->commit();
            echo json_encode(["status" => "success", "message" => "Pedido #$pedido_id guardado correctamente."]);

        } catch (Exception $e) {
            $conexion->rollback();
            echo json_encode(["status" => "error", "message" => "Error al guardar el pedido: " . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Operación no válida."]);
        break;
}
