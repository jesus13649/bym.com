<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pedidos de Terceros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .pdf-toolbar {
      background-color: #333;
      color: white;
      padding: 8px 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .pdf-toolbar button {
      background: none;
      border: none;
      color: white;
      margin: 0 4px;
      font-size: 1rem;
    }
    #viewer-container {
      overflow: auto;
      text-align: center;
      background: #333;
      padding: 10px;
    }
    #factura-img {
      transition: transform 0.2s ease;
      max-width: 100%;
      transform-origin: center;
    }
  </style>
</head>
<body class="bg-light p-4">

  <div class="container">
    <h3 class="mb-4">Consultar Pedidos de Terceros</h3>

    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <input type="text" id="cliente" class="form-control" placeholder="Nombre o cédula del cliente">
      </div>
      <div class="col-md-3">
        <input type="date" id="fechaInicio" class="form-control">
      </div>
      <div class="col-md-3">
        <input type="date" id="fechaFin" class="form-control">
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary w-100" id="btnBuscar">Buscar</button>
      </div>
    </div>

    <!-- Contenedor para mensaje vacío -->
    <div id="mensajeVacio" class="alert alert-warning d-none">
      No se encontraron pedidos.
    </div>

    <!-- Tabla de resultados -->
    <table id="tablaPedidos" class="table table-striped d-none">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Cliente</th>
          <th>Cédula</th>
          <th>Valor</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody id="tbodyPedidos">
        <!-- Filas dinámicas -->
      </tbody>
    </table>
  </div>

<!-- Modal Factura con estilo personalizado -->
<div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-4">
      <div class="modal-body">
        <div class="container">

          <!-- Cabecera -->
          <div class="row">
            <div class="col-8">
              <h1 class="fw-bold text-primary">FACTURA</h1>
              <p class="mb-0">Rojo Palo Paella Inc.</p>
              <p class="mb-0">Carretera Muelle 38</p>
              <p class="mb-0">23741 Ávila, Ávila</p>
            </div>
            <div class="col-4 text-end">
              <img src="https://via.placeholder.com/80x80?text=LOGO" alt="LOGO" class="img-fluid rounded-circle">
            </div>
          </div>

          <!-- Info Cliente y Factura -->
          <div class="row mt-4">
            <div class="col-md-4">
              <h6 class="fw-bold">FACTURA A</h6>
              <p id="nombreCliente" class="mb-0"></p>
              <p id="direccionCliente" class="mb-0"></p>
            </div>
            <div class="col-md-4">
              <h6 class="fw-bold">ENVIAR A</h6>
              <p id="nombreCliente" class="mb-0"></p>
              <p id="direccionCliente" class="mb-0"></p>
            </div>
            <div class="col-md-4">
              <h6><strong>N° DE FACTURA:</strong> <span id="facturaID"></span></h6>
              <h6><strong>FECHA:</strong> <span id="fechaFactura"></span></h6>
              <h6><strong>IDENTIFICACIÓN:</strong> <span id="identCliente"></span></h6>
            </div>
          </div>

          <!-- Tabla Productos -->
          <table class="table table-bordered mt-4 text-center">
            <thead class="table-light border-danger border-bottom">
              <tr>
                <th>CANT.</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO UNITARIO</th>
                <th>IMPORTE</th>
              </tr>
            </thead>
            <tbody id="tablaProductosFactura">
              <!-- Datos dinámicos -->
            </tbody>
          </table>

          <!-- Totales -->
          <div class="row justify-content-end">
            <div class="col-md-4">
              <p class="mb-1"><strong>Subtotal:</strong> $<span id="subtotalFactura">0.00</span></p>
              <p class="mb-1"><strong>IVA 21%:</strong> $<span id="ivaFactura">0.00</span></p>
              <p class="mb-1"><strong>TOTAL:</strong> $<span id="totalFactura">0.00</span></p>
            </div>
          </div>

          <!-- Firma -->
          <div class="text-end mt-4">
            <p style="font-family: 'Brush Script MT', cursive; font-size: 32px;">Laura García</p>
          </div>

          <!-- Condiciones de pago -->
          <div class="mt-4">
            <h6 class="text-danger"><strong>CONDICIONES Y FORMA DE PAGO</strong></h6>
            <p>El pago se realizará en un plazo de 15 días</p>
            <p>
              <strong>Banco Santander</strong><br>
              IBAN: ES12 3456 7891<br>
              SWIFT/BIC: ABCDESMMXXX
            </p>
          </div>

          <!-- Gracias -->
          <div class="text-center mt-5">
            <h1 style="font-family: 'Brush Script MT', cursive; color: #2e3192;">Gracias</h1>
          </div>

        </div>
      </div>
      <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>





  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="../controllers/pedidos_terceros.js"></script>
</body>
</html>
