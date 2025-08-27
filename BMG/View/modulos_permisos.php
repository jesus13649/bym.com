<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html lang="es" translate="no">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Administración de Roles y Permisos</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      background-color: #fff;
    }
    .nav-tabs .nav-link.active {
      background-color: #1f4e79;
      color: #fff;
      border: none;
      border-radius: 6px 6px 0 0;
    }
    .nav-tabs .nav-link {
      color: #1f4e79;
      font-weight: 500;
    }
    .alert-info {
      background-color: #d1e7ff;
      color: #0c63e4;
      border: none;
    }
    .alert-success {
      background-color: #d8f3dc;
      color: #207227;
      border: none;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
      border: none;
    }
    .card-title h5 {
      font-size: 16px;
      margin-bottom: 0;
    }
    .list-group-item {
      padding: 6px;
      font-size: 14px;
      cursor: pointer;
    }
    .list-group-item-primary {
      background-color: #cfe2ff !important;
      color: #084298 !important;
    }
  </style>
</head>
<body>
  <div class="container-xxl">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">
              Módulo de Permisos
            </button>
          </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabContent">
          <div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card mt-2">
              <div class="card-body p-3">
                <form id="form" class="needs-validation" onsubmit="event.preventDefault();" novalidate>
                  <div class="row">
                    <div class="col-sm-4 mb-3">
                      <div class="card h-100">
                        <div class="card-title p-3">
                          <div class="alert alert-info">
                            <h5><i class="bi bi-people-fill me-2"></i>Roles</h5>
                          </div>
                        </div>
                        <div class="card-body" id="list_roles">
                          <!-- Aquí se cargarán los roles -->
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                      <div class="card h-100">
                        <div class="card-title p-3">
                          <div class="alert alert-success">
                            <h5><i class="bi bi-grid-fill me-2"></i>Módulos</h5>
                          </div>
                        </div>
                        <div class="card-body" id="list_modulos">
                          <!-- Aquí se cargarán los módulos -->
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                      <div class="card h-100">
                        <div class="card-title p-3">
                          <div class="alert alert-danger">
                            <h5><i class="bi bi-shield-lock-fill me-2"></i>Permisos</h5>
                          </div>
                        </div>
                        <div class="card-body" id="list_roles_permisos">
                          <!-- Aquí se cargarán los permisos -->
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="../controllers/modulos_permisos.js "></script>
</body>
</html>
