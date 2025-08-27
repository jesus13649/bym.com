<?php require_once 'menu.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
</head>

<body class="bg-light">
<div class="card my-4">
  <div class="card-header">Crear Módulo</div>
  <div class="card-body">
    <form id="formModulo">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Módulo</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="imagen" class="form-label">Imagen (ícono o ruta)</label>
        <input type="text" class="form-control" id="imagen" name="imagen">
      </div>
      <div class="mb-3">
        <label for="url" class="form-label">URL del Módulo</label>
        <input type="text" class="form-control" id="url" name="url">
      </div>
      <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo">
          <option value="padre">Padre</option>
          <option value="hijo">Hijo</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Guardar Módulo</button>
    </form>
  </div>
</div>

</body>
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../Controllers/modulo.js <?php echo  rand();?>"></script>

</body>
</html>



