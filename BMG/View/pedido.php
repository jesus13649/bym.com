  <?php include 'menu.php'; ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
      body { background:#fff0f5; font-family: 'Arial', sans-serif; }

      /* Lista de clientes */
      #listaClientes {
        position: absolute; z-index: 1000; background: #fff; border: 1px solid #ccc;
        border-radius: 6px; width: 100%; max-height: 200px; overflow-y: auto; display: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }
      #listaClientes .cliente-item {
        padding: 8px 12px; cursor: pointer; transition: background 0.2s;
      }
      #listaClientes .cliente-item:hover {
        background: linear-gradient(90deg, #d66d9a, #f7a9c4); color: #fff;
      }

      /* Tarjetas de info */
      .info-card {
        display: flex; align-items: center; gap: 8px; font-size: 0.95rem;
        background: #fff; padding: 10px 12px; border-radius: 10px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      }
      .info-card:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.12); }

      /* Fondo rosado elegante */
      .bg-pink { background: linear-gradient(135deg, #e295a4, #f9c5d1); color: #5a2c3a; }

      /* Tarjetas de productos */
      #productosGrid .card {
        width: 190px; margin:auto; cursor:pointer; border-radius:1rem; background:#fff;
        border:none; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        text-align:center; display:flex; flex-direction:column;
      }
      #productosGrid .card:hover {
        transform: translateY(-6px); box-shadow:0 10px 20px rgba(0,0,0,0.15);
      }
      #productosGrid .card img {
        border-top-left-radius:1rem; border-top-right-radius:1rem; object-fit:contain;
        height:120px; width:100%; background:#fdf0f5; padding:10px; transition: transform 0.4s ease;
      }
      #productosGrid .card img:hover { transform: scale(1.05); }
      #productosGrid .card-body { padding:12px; }
      #productosGrid .card-title { font-size:14px; font-weight:600; color:#5a3d5c; margin-bottom:4px; }
      #productosGrid .card-text { font-size:13px; color:#a0527d; margin-bottom:8px; }
      #productosGrid .btn-pink {
        background: linear-gradient(135deg,#a0527d,#d58ab1); color:white; border:none;
        border-radius:20px; padding:6px 14px; font-size:13px; transition: background 0.3s ease;
      }
      #productosGrid .btn-pink:hover {
        background: linear-gradient(135deg,#8a3f6d,#b86a95);
      }

      /* Contenedor del carrito */
      .carrito-container {
        max-width: 950px; margin:50px auto; background:#fff0f5;
        border-radius:12px; padding:25px; box-shadow:0 8px 25px rgba(0,0,0,0.1);
      }
      .carrito-title { text-align:center; color:#b76e79; margin-bottom:25px; font-size:28px; font-weight:bold; }

      /* Tabla estilizada */
      .carrito-table { background:#fff0f5; border-radius:10px; overflow:hidden; }
      .carrito-table thead { background:#b76e79; color:white; font-weight:bold; }
      .carrito-table tbody tr { transition: background 0.2s, transform 0.2s; }
      .carrito-table tbody tr:hover { background:#ffe6f0; transform: scale(1.01); }
      .carrito-table th, .carrito-table td { vertical-align:middle!important; font-size:14px; padding:12px; }
      .carrito-table input[type="number"] {
        width:60px; padding:5px; border-radius:5px; border:1px solid #ccc; text-align:center;
      }

      /* Botones */
      .btn-guardar, .btn-vaciar {
        padding:12px 25px; border-radius:50px; font-size:16px; font-weight:bold;
        cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s;
      }
      .btn-guardar { background:#b76e79; color:white; border:none; }
      .btn-guardar:hover { background:#9b5670; }
      .btn-vaciar { background:transparent; color:#d9534f; border:2px solid #d9534f; }
      .btn-vaciar:hover { background:#d9534f; color:white; }

      /* Tabs */
      .nav-tabs .nav-link.active { background:#f9c5d1; color:#5a2c3a; font-weight:bold; border:none; border-radius:0.5rem 0.5rem 0 0; }
      .nav-tabs .nav-link { color:#a0527d; border:none; transition: background 0.3s, color 0.3s; }
      .nav-tabs .nav-link:hover { background:#ffe6f0; color:#5a2c3a; }

      /* Modal cliente */
      #modalDatos .modal-header { background:#b76e79; color:white; }
      #modalDatos .info-card { margin-bottom:6px; }

      /* Modal producto */
      #modalProductoInfo .modal-header { background:#d58ab1; color:white; }
      #modalProductoInfo img { transition: transform 0.3s; border-radius:1rem; }
      #modalProductoInfo img:hover { transform:scale(1.05); }

      /* Notas y resumen */
      textarea { border-radius:0.5rem; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
      .card-body table td { font-size:14px; }
    </style>
  </head>
  <body>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <!-- NAV TABS -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Cliente</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Productos</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">Pedido</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pedido-tab" data-bs-toggle="tab" data-bs-target="#pedido" type="button" role="tab">Pedidos Realizados</button>
              </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content pt-2" id="myTabContent">
              <!-- CLIENTE -->
              <div class="tab-pane fade show active" id="home" role="tabpanel">
                <section class="section">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card shadow-sm rounded-4 border-0">
                        <div class="card-body">
                          <div align="center" class="py-2 rounded-3 mb-3" style="background-color: #40E0D0; color:white; font-weight:bold;">Datos Cliente</div>
                          <form>
                            <div class="row mb-3 position-relative">
                              <label class="col-sm-2 col-form-label">Cliente</label>
                              <div class="col-sm-10">
                                <input type="text" id="cliente" class="form-control" placeholder="Buscar cliente..." autocomplete="off" />
                                <div id="listaClientes"></div>
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label">Dirección</label>
                              <div class="col-sm-10">
                                <input type="text" id="direccion" class="form-control" disabled />
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <input type="email" id="correo" class="form-control" disabled />
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label">Teléfono</label>
                              <div class="col-sm-10">
                                <input type="number" id="tel" class="form-control" disabled />
                              </div>
                            </div>
                          </form>
                          <div class="text-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="limpiar()">Nuevo</button>
                            <button type="button" id="btnDatosCliente" class="btn btn-outline-primary rounded-pill px-4">Datos</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>

              <!-- PRODUCTOS -->
              <div class="tab-pane fade" id="profile" role="tabpanel">
                <div class="container LG-12">
                  <h3>Módulo de Pedidos</h3>
                  <div class="input-group mb-3">
                    <input type="text" id="buscarProducto" class="form-control" placeholder="Ingrese código o nombre del producto" />
                    <button class="btn btn-primary" id="btnBuscarProducto"><i class="bi bi-search"></i></button>
                  </div>
                  <div id="productosGrid" class="row g-3">
                    <!-- Tarjetas de productos se cargarán aquí -->
                  </div>
                  <div class="mt-3 text-center py-2 rounded-3" style="background-color: #43ecd0ff;">
                    Total Pedido: <span id="totalGeneral">$0,00</span>
                  </div>
                </div>
              </div>

              <!-- PEDIDO -->
              <div class="tab-pane fade" id="contact" role="tabpanel">
                <div class="container mt-4">

                <!-- Carrito -->
                  <div class="carrito-container">
                    <h2 class="carrito-title">Tu Carrito de Compras</h2>
                    <div class="table-responsive">
                      <table class="table align-middle table-hover text-center shadow-sm carrito-table">
                        <thead>
                          <tr>
                            <th>CÓDIGO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>VALOR</th>
                            <th>IVA</th>
                            <th>DCTO</th>
                            <th>VNETO</th>
                            <th>STOCK</th>
                            <th>CANTIDAD</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody id="tablaPedidos2">
                          <!-- Productos dinámicos -->
                        </tbody>
                      </table>
                    </div>
                  <h3 class="text-center mb-4" style="font-family:'Playfair Display', serif; color:#b76e79;">🛍️ Carrito de Compras</h3>
                  <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Notas del pedido</label>
                    <textarea class="form-control shadow-sm rounded-3" rows="3" placeholder="Agrega algún detalle especial de tu pedido..."></textarea>
                  </div>

                  <!-- Resumen -->
                  <div class="card shadow-sm border-0 rounded-4 mb-4" style="background:#fff7f9;">
                    <div class="card-body">
                      <h5 class="fw-bold mb-3" style="color:#b76e79;">Resumen del pedido</h5>
                      <table class="table table-borderless mb-0">
                        <tbody>
                          <tr><td>Subtotal:</td><td id="subtotal" class="text-end fw-semibold">$0.000</td></tr>
                          <tr><td>Valor IVA:</td><td id="valorIva" class="text-end fw-semibold">$0.000</td></tr>
                          <tr><td>Total:</td><td id="valorTotal" class="text-end fw-bold" style="color:#b76e79;">$0.000</td></tr>
                          <tr><td>Items:</td><td id="items" class="text-end">0</td></tr>
                          <tr><td>Productos:</td><td id="productos" class="text-end">0</td></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  
                    <div class="d-flex justify-content-end gap-2 mt-4">
                  <button class="btn btn-success">💾 Guardar Pedido</button>

                      <button class="btn btn-vaciar" onclick="vaciarCarrito()">🗑️ Vaciar Carrito</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- PEDIDOS REALIZADOS -->
              <div class="tab-pane fade" id="pedido" role="tabpanel">
                <iframe src="../view/pedidos_terceros.php" style="width:100%; height:600px; border:none;"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MODALES (Cliente y Producto) se mantienen exactamente igual que tu HTML original -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../controllers/pedido.js"></script>
  </body>
  </html>
