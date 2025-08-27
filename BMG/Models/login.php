<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include 'conexion.php'; 
$conexion = conectar();

if (!$conexion) {
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos"]);
    exit;
}

// Forzar UTF-8
mysqli_set_charset($conexion, "utf8");

$method = $_SERVER["REQUEST_METHOD"];
$action = $_GET["action"] ?? "";

/* ============================================================
   ✅ GET: Verificar sesión activa
   ============================================================ */
if ($method === "GET" && $action === "session") {
    if (!empty($_SESSION['usuario']) && !empty($_SESSION['id'])) {
        echo json_encode([
            "status" => "success",
            "usuario" => $_SESSION['usuario'],
            "usuarioID" => $_SESSION['id'],
            "nombres" => $_SESSION['Ses_nombres'] ?? '',
            "apellidos" => $_SESSION['Ses_apellidos'] ?? '',
            "email" => $_SESSION['Ses_email'] ?? '',
            "nit" => $_SESSION['Ses_nit'] ?? '',
            "telefono" => $_SESSION['Ses_telefono'] ?? '',
            "rol_id" => $_SESSION['Ses_roles_id'] ?? '',
            "rol_nombre" => $_SESSION['Ses_rol'] ?? '',
            "codigoPrestador" => $_SESSION['Ses_codigoPrestador'] ?? '',
            "estado" => $_SESSION['Ses_estado'] ?? '',
            "facturas_max_mes" => $_SESSION['Ses_facturas'] ?? 0,
            "archivos_max_mes" => $_SESSION['Ses_archivos'] ?? 0,
            "alerta_pago" => $_SESSION['Ses_alerta'] ?? 0
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    }
    exit;
}

/* ============================================================
   ✅ GET: Cargar imágenes del carrusel
   ============================================================ */
if ($method === "GET" && $action === "cargar_imagenes") {
    $query = "SELECT * FROM imagenes ORDER BY id DESC";
    $result = $conexion->query($query);

    $imagenes = [];
    while ($row = $result->fetch_assoc()) {
        $imagenes[] = $row;
    }

    echo json_encode($imagenes);
    exit;
}

/* ============================================================
   ✅ POST: Login de usuario (sin encriptar contraseña)
   ============================================================ */
if ($method === "POST" && $action === "login") {
    $usuario = trim($_POST["usuario"] ?? "");
    $clave = trim($_POST["clave"] ?? "");

    if ($usuario === "" || $clave === "") {
        echo json_encode(["status" => "error", "message" => "Usuario y clave son requeridos"]);
        exit;
    }

    $sql = "SELECT u.ID, u.USUARIO, u.CLAVE, u.nombres, u.apellidos, u.email, 
                   u.roles_id, r.nombre AS rol_nombre, u.nit, u.codigoPrestador, 
                   u.telefono, u.estado, u.facturas_max_mes, u.archivos_max_mes, 
                   u.alerta_pago
            FROM bmg.usuarios u
            LEFT JOIN roles r ON u.roles_id = r.id
            WHERE u.USUARIO = ?";

    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conexion->error]);
        exit;
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        // Comparación directa sin encriptar
        if ($clave === $user["CLAVE"]) {
            $_SESSION['usuario'] = $user['USUARIO'];
            $_SESSION['id'] = $user['ID'];
            $_SESSION['Ses_nombres'] = $user['nombres'];
            $_SESSION['Ses_apellidos'] = $user['apellidos'];
            $_SESSION['Ses_email'] = $user['email'];
            $_SESSION['Ses_nit'] = $user['nit'];
            $_SESSION['Ses_codigoPrestador'] = $user['codigoPrestador'];
            $_SESSION['Ses_telefono'] = $user['telefono'];
            $_SESSION['Ses_rol'] = $user['rol_nombre'];
            $_SESSION['Ses_roles_id'] = $user['roles_id'];
            $_SESSION['Ses_estado'] = $user['estado'];
            $_SESSION['Ses_facturas'] = $user['facturas_max_mes'];
            $_SESSION['Ses_archivos'] = $user['archivos_max_mes'];
            $_SESSION['Ses_alerta'] = $user['alerta_pago'];

            echo json_encode([
                "status" => "success",
                "message" => "Inicio de sesión exitoso",
                "datos" => [
                    "usuario" => $user['USUARIO'],
                    "nombres" => $user['nombres'],
                    "apellidos" => $user['apellidos'],
                    "email" => $user['email'],
                    "rol" => $user['rol_nombre'],
                    "rol_id" => $user['roles_id']
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
    }

    $conexion->close();
    exit;
}

/* ============================================================
   ✅ POST: Subir imagen al carrusel
   ============================================================ */
if ($method === "POST" && $action === "subir_imagen") {
    $titulo = $_POST['text'] ?? '';

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $rutaImagen = "uploads/" . $fileName;

            $sql = "INSERT INTO imagenes (titulo, ruta_imagen) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ss", $titulo, $rutaImagen);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Imagen subida con éxito"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al guardar en la base de datos"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error al mover la imagen"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No se seleccionó ninguna imagen"]);
    }
    exit;
}

/* ============================================================
   ✅ Si ninguna condición se cumple
   ============================================================ */
echo json_encode(["status" => "error", "message" => "Método o acción no permitida"]);
exit;
?>
