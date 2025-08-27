<?php
include 'funciones.php';
include 'conexion.php';
$conexion = conectar();

header('Content-Type: application/json; charset=utf-8');

if (isset($_POST['op'])) {
    $op = $_POST['op'];

    // --- Insertar producto ---
    if ($op === 'insertar') {
        $codigo      = $_POST['codigoProducto']   ?? '';
        $nombre      = $_POST['nombreProducto']   ?? '';
        $descripcion = $_POST['descripcion']      ?? '';
        $precio      = $_POST['precio']           ?? 0;
        $iva         = $_POST['iva']              ?? 0;
        $descuento   = ($_POST['descuento'] !== "" ? $_POST['descuento'] : 0); // corrige vacío a 0
        $unidades    = $_POST['unidades']         ?? 0;
        $fechaVenc   = $_POST['fechaVencimiento'] ?? null;
        $proveedor   = $_POST['proveedor']        ?? '';
        $nota        = $_POST['notaPrecaucion']   ?? '';
        $lote        = $_POST['lote']             ?? '';

        // Manejo de imagen
        $imagen = "";
        if (!empty($_FILES['imagen']['name'])) {
            $carpetaDestino = __DIR__ . "/uploads/";
            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
            $rutaFinal = $carpetaDestino . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal)) {
                // Guardar solo la ruta relativa para usar en la app
                $imagen = "uploads/" . $nombreArchivo;
            } else {
                echo json_encode(["status" => "error", "message" => "Error al subir la imagen."]);
                exit;
            }
        }

        $sql = "INSERT INTO productos 
            (CodigoProducto, NombreProducto, Descripcion, Precio, IVA, Descuento, CantidadStock, FechaVencimiento, Proveedor, NotaPrecaucion, Lote, FechaRegistro, Imagenes)
            VALUES 
            ('$codigo', '$nombre', '$descripcion', '$precio', '$iva', '$descuento', '$unidades', " . 
            ($fechaVenc ? "'$fechaVenc'" : "NULL") . ", '$proveedor', '$nota', '$lote', NOW(), '$imagen')";

        if ($conexion->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Producto registrado correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al guardar el producto: " . $conexion->error]);
        }
        exit;
    }

    // --- Listar proveedores ---
    if ($op === 'listarProveedores') {
        $sql = "SELECT id, razon_social FROM proveedores ORDER BY razon_social ASC";
        $result = $conexion->query($sql);

        $proveedores = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $proveedores[] = $row;
            }
        }

        echo json_encode($proveedores);
        exit;
    }

    // --- Listar IVA ---
    if ($op === 'listarivas') {
        $sql = "SELECT IVAID, Porcentaje FROM ivas ORDER BY Porcentaje ASC";
        $result = $conexion->query($sql);

        $ivas = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Asegurar que sea número
                $row['Porcentaje'] = (float)$row['Porcentaje'];
                $ivas[] = $row;
            }
        }

        echo json_encode($ivas);
        exit;
    }

} else {
    echo json_encode(["status" => "error", "message" => "No se recibió una operación válida."]);
    exit;
}
?>
