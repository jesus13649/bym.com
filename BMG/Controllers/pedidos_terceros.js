$(document).ready(function () {
  $('#btnBuscar').on('click', function () {
    const cliente = $('#cliente').val().trim();

    if (cliente === '') {
      alert('Ingrese el nombre del cliente');
      return;
    }

    $.ajax({
      url: '../models/pedidos.php',
      type: 'GET',
      data: { cliente: cliente },
      dataType: 'json',
      success: function (response) {
        if (!response.success) {
          alert(response.message || 'Error al obtener los datos');
          return;
        }

        $('#factura').empty();

        const facturaHTML = `
          <div class="container bg-white border rounded shadow p-4 my-4" style="max-width: 900px; font-family: Arial, sans-serif;">
            <div class="row mb-4 border-bottom pb-3">
              <div class="col-md-8">
                <h2 class="fw-bold text-primary">Factura de Pedido</h2>
                <p><strong>Factura No.:</strong> ${response.factura_id}</p>
                <p><strong>Fecha:</strong> ${response.fecha}</p>
              </div>
              <div class="col-md-4 text-end">
                <img src="../assets/logo.png" alt="Logo" style="height: 60px;">
              </div>
            </div>

            <div class="row mb-4">
              <h5 class="text-secondary">Datos del Cliente</h5>
              <div class="col-md-4"><strong>Nombre:</strong><br>${response.cliente.nombre}</div>
              <div class="col-md-4"><strong>Dirección:</strong><br>${response.cliente.direccion}</div>
              <div class="col-md-4"><strong>Identificación / Teléfono:</strong><br>${response.cliente.identificacion}</div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  ${response.productos.map(p => `
                    <tr>
                      <td>${p.codigo}</td>
                      <td>${p.nombre}</td>
                      <td>$${parseFloat(p.precio).toFixed(2)}</td>
                      <td>${p.cantidad}</td>
                      <td>$${parseFloat(p.total).toFixed(2)}</td>
                    </tr>
                  `).join('')}
                </tbody>
              </table>
            </div>

            <div class="row mt-4">
              <div class="col-md-12 text-end">
                <h4 class="fw-bold text-success">Total: $${response.productos.reduce((sum, p) => sum + parseFloat(p.total), 0).toFixed(2)}</h4>
              </div>
            </div>

            <div class="text-center text-muted mt-4 small">
              <p>Gracias por su compra. ¡Esperamos verlo pronto!</p>
            </div>
          </div>
        `;

        $('#factura').html(facturaHTML);
      },
      error: function () {
        alert('Error al conectar con el servidor.');
      }
    });
  });
});
