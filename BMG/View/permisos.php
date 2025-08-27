<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Permisos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container-xxl mt-4">
    <div class="row">
        <div class="col-12">
            <!-- ✅ Pestañas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="crear-tab" data-bs-toggle="tab" href="#crear" role="tab" aria-controls="crear" aria-selected="true">
                        Crear Permiso
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ver-tab" data-bs-toggle="tab" href="#ver" role="tab" aria-controls="ver" aria-selected="false">
                        Listar Permisos
                    </a>
                </li>
            </ul>

            <!-- ✅ Contenido de Tabs -->
            <div class="tab-content" id="myTabContent">
                <!-- Tab CREAR -->
                <div class="tab-pane fade show active" id="crear" role="tabpanel" aria-labelledby="crear-tab">
                    <div class="card mt-3">
                        <div class="card-header ">
                            <h4>Registrar Permiso</h4>
                        </div>
                        <div class="card-body">
                            <form id="crearPermisoForm">
                                <div class="mb-3">
                                    <label for="tituloPermiso" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="tituloPermiso" name="tituloPermiso" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcionPermiso" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcionPermiso" name="descripcionPermiso"></textarea>
                                </div>
                                <button type="submit" class="btn btn-outline-success btn-ms">Crear </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab LISTAR -->
                <div class="tab-pane fade" id="ver" role="tabpanel" aria-labelledby="ver-tab">
                    <div class="card mt-3">
                        <div class="card-header ">
                            <h4>Permisos Registrados</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaPermisos">
                                    <!-- Se llena con jQuery -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Modal Editar -->
<div class="modal fade" id="editarPermisoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Editar Permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idPermiso">
                <div class="mb-3">
                    <label for="nuevoTitulo" class="form-label">Nuevo Título</label>
                    <input type="text" class="form-control" id="nuevoTitulo">
                </div>
                <div class="mb-3">
                    <label for="nuevaDescripcion" class="form-label">Nueva Descripción</label>
                    <textarea class="form-control" id="nuevaDescripcion"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarCambiosPermiso">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../Controllers/Permisos.js"></script>
</body>
</html>
