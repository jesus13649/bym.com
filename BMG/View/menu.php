<?php
session_start();

if (empty($_SESSION['usuario']) || empty($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$nombreUsuario = ucfirst(mb_strtolower($_SESSION["Ses_nombres"] ?? $_SESSION["usuario"] ?? ''));
$apellidoUsuario = ucfirst(mb_strtolower($_SESSION["Ses_apellidos"] ?? ''));
$rolUsuario = ucfirst(mb_strtolower($_SESSION["Ses_rol"] ?? 'No definido'));
$nit = $_SESSION["Ses_nit"] ?? 'N/A';
$email = $_SESSION["Ses_email"] ?? 'No disponible';
$telefono = $_SESSION["Ses_telefono"] ?? 'No disponible';
$avatar = "../Assets/img/user.png";
?>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8e1e7 0%, #fff0f5 100%);
      color: #6b4c58;
      padding-top: 60px;
      min-height: 100vh;
    }
    header {
      background: #f4c2c2;
      box-shadow: 0 4px 8px rgba(183, 119, 141, 0.3);
      color: #f4c2c2;
      font-family: 'Playfair Display', serif;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1030;
      padding: 0.7rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header a.brand {
      font-size: 1.7rem;
      font-weight: 700;
      color: #5a3646;
      text-decoration: none;
      letter-spacing: 1.5px;
      text-shadow: 1px 1px 2px #ffc8d5;
      transition: color 0.3s ease;
    }
    header a.brand:hover { color: #8e5572; }
    .btn-menu {
      background: transparent;
      border: none;
      font-size: 1.6rem;
      color: #5a3646;
      cursor: pointer;
    }
    .btn-menu:hover { color: #b96f88; }
    .user-photo {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      border: 2px solid #f4c2c2;
      object-fit: cover;
      cursor: pointer;
      box-shadow: 0 0 8px #f4c2c2;
      transition: transform 0.3s ease;
    }
    .user-photo:hover { transform: scale(1.1); box-shadow: 0 0 12px #e3749b; }
    .user-name {
      margin-left: 10px;
      font-weight: 600;
      color: #5a3646;
      user-select: none;
    }
    .offcanvas {
      width: 280px !important;
      background: #f4c2c2;
      box-shadow: 3px 0 15px rgba(139, 112, 116, 0.4);
      font-family: 'Poppins', sans-serif;
    }
    .offcanvas-header { border-bottom: 1px solid #d9a5b3; padding: 1rem 1.5rem; }
    .offcanvas-title {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 1.5rem;
      color: #8b7074;
    }
    .btn-close {
      filter: invert(45%) sepia(66%) saturate(345%) hue-rotate(305deg) brightness(95%) contrast(90%);
    }
    .btn-close:hover {
      filter: invert(70%) sepia(90%) saturate(600%) hue-rotate(330deg) brightness(105%) contrast(110%);
    }
    .sidebar-img {
      max-height: 180px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 1rem;
      box-shadow: 0 2px 8px rgba(187, 116, 137, 0.3);
      width: 90%;
      margin-left: auto;
      margin-right: auto;
      display: block;
    }
    .list-group-item {
      border: none;
      padding: 0.7rem 1.5rem;
      font-weight: 500;
      color: #6b4c58;
      transition: background-color 0.3s ease, color 0.3s ease;
      cursor: pointer;
      user-select: none;
    }
    .list-group-item a {
      color: inherit;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .list-group-item:hover {
      background: #f7c8d6;
      color: #87475c;
      border-radius: 8px;
    }
    .collapse ul { padding-left: 1.3rem; }
    .collapse ul li a {
      font-weight: 400;
      font-size: 0.95rem;
      color: #7a5361;
    }
    .collapse ul li a:hover { color: #b96f88; text-decoration: underline; }
    .bi { font-size: 1.25rem; color: #a96e7d; transition: color 0.3s ease; }
    .list-group-item:hover .bi { color: #87475c; }
  </style>
</head>
<body>

<header>
  <button class="btn-menu" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-label="Abrir menú">
    <i class="bi bi-list"></i>
  </button>
  <a href="home.php" class=" bi bi-stars brand">Blossie & Mar </a>
  <div class="d-flex align-items-center">
    <img src="<?= htmlspecialchars($avatar) ?>" class="user-photo" data-bs-toggle="modal" data-bs-target="#perfilModal" alt="Foto Usuario" />
    <span class="user-name"><?= htmlspecialchars($nombreUsuario) ?></span>
  </div>
</header>

<!-- Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 id="sidebarLabel" class="offcanvas-title">Menú</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>
  <img src="../Assets/img/menu.jpg" alt="Belleza Glamour" class="sidebar-img" />

  <div class="offcanvas-body p-0">
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <a href="home.php"><i class="bi bi-house-door"></i> Inicio</a>
      </li>

  <!-- PEDIDOS -->
<li class="list-group-item">
  <a class="d-flex justify-content-between align-items-center text-decoration-none collapsed"
     data-bs-toggle="collapse"
     href="#submenuPedidos"
     role="button"
     aria-expanded="false"
     aria-controls="submenuPedidos">
    <span><i class="bi bi-bag-heart"></i> Pedidos</span>
    <i class="bi bi-caret-down ms-2"></i>
  </a>
  <ul class="collapse list-unstyled ps-3 mt-2" id="submenuPedidos">
    <li><a href="pedido.php">🛍️ Tomar Pedido</a></li>
    <li><a href="historial.php">📜 Historial</a></li>
  </ul>
</li>

<!-- PRODUCTOS -->
<li class="list-group-item">
  <a class="d-flex justify-content-between align-items-center text-decoration-none collapsed"
     data-bs-toggle="collapse"
     href="#submenuProductos"
     role="button"
     aria-expanded="false"
     aria-controls="submenuProductos">
    <span><i class="bi bi-brush"></i> Productos</span>
    <i class="bi bi-caret-down ms-2"></i>
  </a>
  <ul class="collapse list-unstyled ps-3 mt-2" id="submenuProductos">
    <li><a href="productos.php">📦 Registro</a></li>
    <li><a href="imagenes.php">🖼️ Imágenes</a></li>
  </ul>
</li>

<!-- SISTEMA -->
<li class="list-group-item">
  <a class="d-flex justify-content-between align-items-center text-decoration-none collapsed"
     data-bs-toggle="collapse"
     href="#submenuSistema"
     role="button"
     aria-expanded="false"
     aria-controls="submenuSistema">
    <span><i class="bi bi-gear"></i> Sistema</span>
    <i class="bi bi-caret-down ms-2"></i>
  </a>
  <ul class="collapse list-unstyled ps-3 mt-2" id="submenuSistema">
    <li><a href="registro.php">👤 Creación usuario</a></li>
    <li><a href="permisos.php">🔑 Permisos</a></li>
    <li><a href="roles.php">🧩 Roles</a></li>
    <li><a href="modulo_permisos.php">🛡️ Módulo permisos</a></li>
    <li><a href="crear _modulo.php">📦 Crear módulo</a></li>
  </ul>
</li>
    </ul>
  </div>
</div>

<!-- Modal Perfil -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="perfilModalLabel"><i class="bi bi-person-circle me-2"></i>Mi Perfil</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
          <div class="col-md-4 text-center">
            <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar Usuario" class="img-fluid rounded-circle shadow mb-3" style="width:130px; height:130px;" />
            <h4><?= htmlspecialchars($nombreUsuario . ' ' . $apellidoUsuario) ?></h4>
            <p class="text-muted"><?= htmlspecialchars($rolUsuario) ?></p>
          </div>
          <div class="col-md-8">
            <table class="table">
              <tbody>
                <tr><th>Nombre completo</th><td><?= htmlspecialchars($nombreUsuario . ' ' . $apellidoUsuario) ?></td></tr>
                <tr><th>Cargo</th><td><?= htmlspecialchars($rolUsuario) ?></td></tr>
                <tr><th>NIT</th><td><?= htmlspecialchars($nit) ?></td></tr>
                <tr><th>Teléfono</th><td><?= htmlspecialchars($telefono) ?></td></tr>
                <tr><th>Email</th><td><?= htmlspecialchars($email) ?></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="../Models/logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
