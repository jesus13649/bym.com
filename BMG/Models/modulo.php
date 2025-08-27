<?php
require_once 'conexion.php';
$sql = "SELECT * FROM modulo_menu ORDER BY ModuloID DESC";
$stmt = $conn->query($sql);
$modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($modulos);
?>
