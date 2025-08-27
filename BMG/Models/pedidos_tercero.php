<?php
include 'conexion.php';
$conexion = conectar();

header('Content-Type: application/json; charset=utf-8');

$cliente = $_GET['cliente'] ?? '';
if (empty($cliente)) {
    echo json_encode(["success" => false, "message" => "Parámetro 'cliente' requerido."]);
    exit;
}

try {
    $stmt = $conexion->prepare("SELECT * FROM pedidos WHERE cliente LIKE ?");
    $clienteParam = '%' . $cliente . '%';
    $stmt->bind_param("s", $clienteParam);
    $stmt->execute();
    $resultPedidos = $stmt->get_result();

    if ($resultPedidos->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "No se encontraron pedidos para el cliente."]);
        exit;
    }

    $pedido = $resultPedidos->fetch_assoc();
    $pedido_id = $pedido['id'];

    $stmtDetalles = $conexion->prepare("SELECT * FROM pedido_detalle WHERE pedido_id = ?");
    $stmtDetalles->bind_param("i", $pedido_id);
    $stmtDetalles->execute();
    $resultDetalles = $stmtDetalles->get_result();

    $productos = [];
    while ($row = $resultDetalles->fetch_assoc()) {
        $productos[] = [
            "codigo"   => $row['codigo_producto'],
            "nombre"   => $row['descripcion'],
            "precio"   => $row['precio'],
            "cantidad" => $row['cantidad'],
            "total"    => $row['total']
        ];
    }

    $response = [
        "success" => true,
        "factura_id" => $pedido_id,
        "fecha" => $pedido['fecha_pedido'],
        "cliente" => [
            "nombre" => $pedido['cliente'],
            "direccion" => $pedido['direccion'],
            "identificacion" => $pedido['telefono']
        ],
        "productos" => $productos
    ];

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error al procesar: " . $e->getMessage()]);
}
