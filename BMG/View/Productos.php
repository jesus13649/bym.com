<?php include 'menu.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Productos</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body >

    <div class="container ">
        <div class="row justify-content-center mt-5 ">
            <div class="col-lg-12 ">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-center bg-gradient bg-secondary text-dark rounded-top">
                        <h3 class="mb-0"><i class="fas fa-boxes me-2"></i>Registro de Productos</h3>
                        <small class="text-dark-50">Complete todos los campos requeridos</small>
                    </div>
                    <div class="card-body p-4">
                        <form id="productoForm" enctype="multipart/form-data">

                            <!-- Grupo 1: Código y Nombre -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="codigoProducto" class="form-label fw-bold">
                                        <i class="fas fa-barcode me-1"></i> Código de Producto
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="codigoProducto" name="codigoProducto" placeholder="Ej: P-1001" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="nombreProducto" class="form-label fw-bold">
                                        <i class="fas fa-tag me-1"></i> Nombre del Producto
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="nombreProducto" name="nombreProducto" placeholder="Nombre del producto" required>
                                </div>
                            </div>

                            <!-- Grupo 2: Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-1"></i> Descripción
                                </label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Describe el producto y sus características"></textarea>
                            </div>

                            <!-- Grupo 3: Precio / IVA / Descuento / Stock -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <label for="precio" class="form-label fw-bold">
                                        <i class="fas fa-dollar-sign me-1"></i> Precio
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="precio" name="precio" step="0.01" placeholder="0.00" required>
                                </div>
                                    <div class="col-md-2"> 
    <label for="iva" class="form-label fw-bold">
        <i class="fas fa-percent me-1"></i> IVA (%)
    </label>
    <select class="form-select form-select-lg" id="iva" name="iva" required>
        <option value="">Seleccione un IVA</option>
        <!-- Opciones dinámicas con jQuery -->
    </select>
</div>

                                <div class="col-md-3">
                                    <label for="descuento" class="form-label fw-bold">
                                        <i class="fas fa-tags me-1"></i> Descuento (%)
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="descuento" name="descuento" step="0.01" placeholder="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="unidades" class="form-label fw-bold">
                                        <i class="fas fa-cubes me-1"></i> Unidades
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="unidades" name="unidades" placeholder="Ej: 100" required>
                                </div>
                            </div>

                            <!-- Grupo 4: Fecha Vencimiento / Proveedor -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="fechaVencimiento" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-1"></i> Fecha de Vencimiento
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="fechaVencimiento" name="fechaVencimiento">
                                </div>
                                <div class="col-md-6">
                                    <label for="proveedor" class="form-label fw-bold">
                                        <i class="fas fa-truck me-1"></i> Proveedor
                                    </label>
                                    <select class="form-select form-select-lg" id="proveedor" name="proveedor">
                                        <option value="">Seleccione un proveedor</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>

                            <!-- Grupo 5: Nota y Lote -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="notaPrecaucion" class="form-label fw-bold">
                                        <i class="fas fa-exclamation-circle me-1"></i> Nota de Precaución
                                    </label>
                                    <textarea class="form-control" id="notaPrecaucion" name="notaPrecaucion" rows="2" placeholder="Precauciones del producto"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="lote" class="form-label fw-bold">
                                        <i class="fas fa-layer-group me-1"></i> Lote
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="lote" name="lote" placeholder="Ej: L-2023">
                                </div>
                            </div>

                            <!-- Grupo 6: Imagen -->
                            <div class="mb-4">
                                <label for="imagen" class="form-label fw-bold">
                                    <i class="fas fa-image me-1"></i> Imagen del Producto
                                </label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                                <div class="mt-3 text-center">
                                    <img id="previewImg" src="#" alt="Vista previa" class="img-thumbnail" style="display:none; max-width:150px;">
                                </div>
                            </div>

                            <!-- Botón de Guardar -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-save me-2"></i> Registrar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted">
                        <small>© 2025 Gestión de Productos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- jQuery debe ir primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('imagen').addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                document.getElementById('previewImg').style.display = 'block';
                document.getElementById('previewImg').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<script src="../controllers/productos.js?<?php echo rand(); ?>"></script>
</body>
</html>
