<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <?php include 'menu.php'; ?>
</head>

<body class="bg-light">
    <div class="container-fluid mt-2">
        <div class="row justify-content-center">
            <!-- Ocupa el 80% en pantallas grandes -->
            <div class=" col-lg-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <h4 class="fs-2">Registro de Usuarios</h4>
                    </div>
                    <div class="card-body">
                        <form id="registroForm" action="procesar_registro.php" method="POST">
                            <div class="row">
                                <!-- Columna izquierda -->
                                <div class="col-md-6">
                                    <h5 class="text-primary fs-3 mb-3">Datos de Acceso</h5>
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label fs-5">Usuario</label>
                                        <input type="text" class="form-control form-control-lg" id="usuario" name="usuario">
                                    </div>
                                    <div class="mb-3">
                                        <label for="clave" class="form-label fs-5">Clave</label>
                                        <input type="password" class="form-control form-control-lg" id="clave" name="clave" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="departamento" class="form-label fs-5">Departamento</label>
                                        <select class="form-select form-select-lg" id="departamento" name="departamento" >
                                            <option value="">Seleccione un departamento</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol" class="form-label fs-5">Rol</label>
                                        <select class="form-select form-select-lg" id="rol" name="rol" >
                                            <option value="">Seleccione un rol</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Columna derecha -->
                                <div class="col-md-6">
                                    <h5 class="text-primary fs-3 mb-3">Datos Personales</h5>

                                    <div class="mb-3">
                                        <label for="codumento" class="form-label ">Documento</label>
                                        <input class="form-control form-control-lg" id="documento" name="direccion"></input>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label fs-5">Nombre</label>
                                        <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label fs-5">Apellido</label>
                                        <input type="text" class="form-control form-control-lg" id="apellido" name="apellido" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fs-5">Correo Electrónico</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label fs-5">Teléfono</label>
                                        <input type="text" class="form-control form-control-lg" id="telefono" name="telefono">
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label fs-5">Direccion</label>
                                        <input type="text" class="form-control form-control-lg" id="direccion" name="telefono">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="fecha_nacimiento" class="form-label fs-5">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control form-control-lg" id="fecha_nacimiento" name="fecha_nacimiento">
                                    </div>
                                    <div class="mb-3">
                                        <label for="estado_civil" class="form-label fs-5">Estado Civil</label>
                                        <select class="form-select form-select-lg" id="estado_civil" name="estado_civil">
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="estado" class="form-label fs-5">Estado</label>
                                        <select class="form-select form-select-lg" id="estado" name="estado">
                                            <option value="">Seleccione un estado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-lg" id="btnNuevo">Nuevo</button>
                                <button type="submit" class="btn btn-outline-success btn-lg">Registrar</button>
                                <button type="button" class="btn btn-outline-danger btn-lg" id="btnEliminar">Eliminar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../Controllers/registro.js"></script>

</body>
</html>
