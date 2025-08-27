<?php include 'menu.php'; ?>

<style>
    .card-header {
        background-color: #f8f9fa; /* Gris claro */
        color: #000; /* Texto negro */
    }
    .nav-tabs .nav-link.active {
        background-color: #ffffff !important;
        border-bottom: 2px solid #0d6efd;
    }
    .nav-tabs .nav-link {
        color: #000 !important;
    }
    .table img {
        width: 60px;
        height: auto;
        border-radius: 5px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                        cargar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">
                        listar
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">

                <!-- TAB 1: Programar Próximo Mantenimiento -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h4 class="mb-3">CARGAR IMAGENES MARCAS</h4>
                    <div class="row mt-4">
                        <!-- Subir imagen al carrusel -->
                        <div class="col-md-4">
                            <div class="card p-3 shadow-sm">
                                <h5>Subir Imagen al Carrusel</h5>
                                <form id="formImagen" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="imageUpload" class="form-label">Selecciona una imagen</label>
                                        <input type="file" class="form-control" id="imageUpload" name="image" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="text" class="form-label">Texto para la imagen</label>
                                        <input type="text" class="form-control" id="text" name="text" >
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Subir Imagen</button>
                                </form>
                            </div>
                        </div>

                        <!-- Carrusel dinámico -->
                        <div class="col-lg-8 col-md-8">
                            <div class="card shadow-sm p-3">
                                <h5 class="mb-3">Vista Previa del Carrusel</h5>
                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators" id="carouselIndicators"></div>
                                    <div class="carousel-inner" id="carouselItems"></div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
    <h4 class="mb-3">LISTAR IMAGENES</h4>

    <!-- Filtros Año y Mes -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="anio" class="form-label">Año</label>
            <select class="form-select" id="anio">
                <option value="" selected disabled>Seleccione un año</option>
                <?php
                for ($i = date("Y"); $i >= 2020; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="mes" class="form-label">Mes</label>
            <select class="form-select" id="mes">
                <option value="" selected disabled>Seleccione un mes</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>TITULO</th>
                    <th>Fecha</th>
                    <th>Fecha de Creación</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody id="tablaEquipos">
                <tr>
                    <td colspan="5">Seleccione Año y Mes para ver registros</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- Librerías -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="../controllers/login.js?<?php echo rand(); ?>"></script>
<script src="../controllers/imagenes.js?<?php echo rand(); ?>"></script>