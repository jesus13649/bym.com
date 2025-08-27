<?php include 'menu.php'; ?>
<body>
<div class="container-xxl ">
    <div class="row">
        <div class="col-12">
            <!-- Pestañas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="crear-tab" data-bs-toggle="tab" href="#crear" role="tab" aria-controls="crear" aria-selected="true">Crear Rol</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ver-tab" data-bs-toggle="tab" href="#ver" role="tab" aria-controls="ver" aria-selected="false">Ver Roles</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Pestaña Crear Rol -->
                <div class="tab-pane fade show active" id="crear" role="tabpanel" aria-labelledby="crear-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Registrar Nuevo Rol</h4>
                        </div>
                        <div class="card-body">
                            <form id="crearRolForm">
                                <div class="mb-3">
                                    <label for="nombreRol" class="form-label">Nombre del Rol</label>
                                    <input type="text" class="form-control" id="nombreRol" name="nombreRol" required>
                                </div>
                                <button type="submit" class="btn btn-outline-success btn-ms">Crear </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Ver Roles -->
                <div class="tab-pane fade" id="ver" role="tabpanel" aria-labelledby="ver-tab">
                    <div class="card mt-3">
                        <div class="card-header">   
                            <h4>Roles Registrados</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaRoles">
                                    <!-- Aquí se llenarán los roles con JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal para editar rol -->
<div class="modal fade" id="editarRolModal" tabindex="-1" aria-labelledby="editarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header bg-info">
                <h5 class="modal-title" id="editarRolModalLabel">Editar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idRol">
                <div class="form-group">
                    <label for="nuevoNombreRol">Nuevo Nombre del Rol</label>
                    <input type="text" class="form-control" id="nuevoNombreRol" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarCambiosRol">Guardar Cambios</button>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../Controllers/Roles.js "></script>

</body>
</html>
