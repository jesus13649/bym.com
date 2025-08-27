<?php
session_start();
session_unset();  // Limpia variables
session_destroy(); // Elimina la sesión
header("Location: ../View/login.php");
header('Content-Type: application/json');
echo json_encode(["status" => "success", "message" => "Sesión cerrada"]);
