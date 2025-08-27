function limpiar() {
    $('#cliente').val('');
    $('#direccion').val('');
    $('#correo').val('');
    $('#tel').val('');
    $('#listaClientes').hide().empty();
    $('#profile-tab, #contact-tab').addClass('disabled').attr('aria-disabled', 'true');
    $('#direccion, #correo, #tel').prop('disabled', true);
    clienteSeleccionado = {};
    $('#cliente').focus();
}

$(document).ready(function () {
    const URL_CLIENTE = '../models/pedido.php';

    // Ocultar la tabla al inicio
    $("#tablaPedidos").closest("div").hide();
    actualizarResumen(); // Inicializa el resumen

    function calcularPrecioNeto(precio, descuento) {
        return precio - (precio * descuento / 100);
    }

    // ----- Buscar producto al presionar Enter -----
    $("#buscarProducto").on("keypress", function (e) {
        if (e.which === 13) { // Enter
            e.preventDefault();
            const buscar = $(this).val().trim();
            if (buscar === "") {
                Swal.fire('Atención', 'Ingrese un código o nombre de producto', 'warning');
                return;
            }

            $.ajax({
                url: URL_CLIENTE,
                type: "POST",
                data: { OP: "buscar", buscar: buscar },
                dataType: "json",
                success: function (producto) {
                    // 🔹 Limpiar el grid antes de mostrar resultados
                    $("#productosGrid").empty();

                    if (producto.status === "success") {
                        // Si vienen varios productos
                        if (Array.isArray(producto.data)) {
                            producto.data.forEach(p => {
                                mostrarProductoConImagen(p);
                            });
                        } else {
                            // Si viene un solo producto
                            mostrarProductoConImagen(producto.data);
                        }

                        mostrarTabla();
                        actualizarResumen();
                    } else {
                        Swal.fire('Error', producto.message || 'Producto no encontrado', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Error al buscar el producto.', 'error');
                    $("#productosGrid").empty();
                }
            });
        }
    });

    function mostrarProductoConImagen(p) {
        let precio = parseFloat(p.Precio) || 0;
        let descuento = parseFloat(p.Descuento) || 0;
        let precioNeto = calcularPrecioNeto(precio, descuento);
        let precioFormateado = precio.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 });

        const imgSrc = p.Imagenes && p.Imagenes !== "" 
            ? p.Imagenes 
            : 'https://via.placeholder.com/400x400/fff0f5/d87093?text=Sin+Imagen';

        const tarjeta = `
        <style>
            .producto-card .producto-img {
                transition: transform 0.5s ease;
            }
            .producto-card .producto-img:hover {
                transform: scale(1.08);
            }
            .btn-pink {
                background: linear-gradient(45deg, #ff9ac6, #ff5ea6);
                color: white;
                border: none;
                transition: 0.3s;
            }
            .btn-pink:hover {
                background: linear-gradient(45deg, #ff5ea6, #ff9ac6);
                transform: translateY(-2px);
            }
        </style>

        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100 producto-card" 
                 style="background: #fff5f8; cursor: pointer; transition: transform .3s, box-shadow .3s;"
                 data-producto='${JSON.stringify(p)}'>
                
                <!-- Imagen -->
                <div class="position-relative" style="overflow: hidden; height: 260px; background: #fff;">
                    <img src="${imgSrc}" 
                         alt="${p.NombreProducto}" 
                         class="img-fluid w-100 producto-img"
                         style="height: 100%; object-fit: cover; border-bottom: 3px solid #f8f9fa; border-radius: 12px 12px 0 0;">
                    
                    <span class="badge position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm rounded-pill"
                          style="background: linear-gradient(135deg, #ff9ac6, #ff5ea6); font-size: 0.85rem; font-weight: 600;">
                        Stock: ${p.CantidadStock}
                    </span>
                </div>

                <!-- Contenido -->
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-dark">${p.NombreProducto}</h5>
                    <p class="card-text text-muted small mb-1">Precio</p>
                    <p class="fs-4 fw-bold text-danger">$${precioFormateado}</p>

                    <input type="number" 
                           class="form-control text-center cantidad-input shadow-sm rounded-pill my-2" 
                           value="1" min="1" max="${p.CantidadStock}">
                    
                    <button class="btn btn-pink w-100 fw-semibold rounded-pill agregarTabla2">
                        <i class="bi bi-cart-plus"></i> Agregar al Pedido
                    </button>
                </div>
            </div>
        </div>
        `;

        $("#productosGrid").append(tarjeta);
    }

    // 🔹 Evento para botón "Agregar al Pedido"
    $(document).on("click", ".agregarTabla2", function (e) {
        e.preventDefault();
        e.stopPropagation();

        let card = $(this).closest(".producto-card");
        let p = card.data("producto");

        if (!p) {
            Swal.fire("Error", "No se pudo obtener la información del producto.", "error");
            return;
        }

        let cantidad = parseInt(card.find(".cantidad-input").val()) || 1;
        if (cantidad < 0) cantidad = 0;
        if (cantidad > p.CantidadStock) cantidad = p.CantidadStock;

        p.CantidadSeleccionada = cantidad;

        agregarProductoTabla(p);
        $("#tablaPedidos2").closest("div").show();

        Swal.fire("Éxito", "Producto agregado al pedido.", "success");
    });

    // 🔹 Modal: un solo evento global (evita duplicados)
    $(document).on("click", "#productosGrid .producto-card", function (e) {
        if ($(e.target).hasClass("cantidad-input") || $(e.target).hasClass("agregarTabla2")) return;

        let p = $(this).data("producto");
        if (!p) return;

        let precio = parseFloat(p.Precio) || 0;
        let descuento = parseFloat(p.Descuento) || 0;
        let precioNeto = precio - (precio * descuento / 100);

        const imgSrc = p.Imagenes && p.Imagenes !== "" 
            ? p.Imagenes 
            : 'https://via.placeholder.com/200x180?text=Sin+Imagen';

        $('#modalProdImg').attr('src', imgSrc);
        $('#modalProdNombre').text(p.NombreProducto || '---');
        $('#modalProdCodigo').text(p.CodigoProducto || '---');
        $('#modalProdDescripcion').text(p.Descripcion || '---');
        $('#modalProdStock').text(p.CantidadStock || '0');
        $('#modalProdPrecio').text(precio.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        $('#modalProdIVA').text(p.IVA || '0');
        $('#modalProdDescuento').text(descuento);
        $('#modalProdPrecioNeto').text(precioNeto.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));

        let modal = new bootstrap.Modal(document.getElementById('modalProductoInfo'));
        modal.show();
    });

    // ----- Tabla temporal -----
    function agregarFila(p) {
        let precio = parseFloat(p.Precio) || 0;
        let precioFormateado = precio.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 });

        $("#tablaPedidos").html(`
            <tr>
                <td>${p.CodigoProducto}</td>
                <td>${p.NombreProducto}</td>
                <td>$${precioFormateado}</td>
                <td>${p.IVA}</td>
                <td>${p.Descuento}</td>
                <td>$${precioFormateado}</td>
                <td>${p.CantidadStock}</td>
                <td><input type="number" class="form-control form-control-sm cantidad" value="1" min="1" max="${p.CantidadStock}"></td>
                <td class="total">$${precioFormateado}</td>
            </tr>
        `);
        $("#buscarProducto").val("");
        actualizarResumen();
    }

    $("#tablaPedidos").on("input", ".cantidad", function () {
        let fila = $(this).closest("tr");
        let precio = parseFloat(fila.find("td:eq(2)").text().replace(/\$|\./g, "").replace(",", ".")) || 0;
        let cantidad = parseInt($(this).val()) || 1;

        if (cantidad < 1) cantidad = 1;
        if (cantidad > parseInt($(this).attr("max"))) cantidad = parseInt($(this).attr("max"));
        $(this).val(cantidad);

        let total = precio * cantidad;
        fila.find(".total").text("$" + total.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        actualizarResumen();
    });

    // ----- Tabla acumulativa -----
    function agregarProductoTabla(p) {
        let precio = parseFloat(p.Precio) || 0;
        let precioFormateado = precio.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 });
        let cantidadAgregar = parseInt(p.CantidadSeleccionada) || 1;

        let filaExistente = $("#tablaPedidos2 tr").filter(function () {
            return $(this).find("td:eq(0)").text() === p.CodigoProducto;
        });

        if (filaExistente.length > 0) {
            let inputCantidad = filaExistente.find(".cantidad2");
            let cantidad = parseInt(inputCantidad.val()) || 0;
            cantidad += cantidadAgregar;
            if (cantidad > p.CantidadStock) cantidad = p.CantidadStock;
            inputCantidad.val(cantidad).trigger("input");
        } else {
            let fila = `
                <tr>
                    <td>${p.CodigoProducto}</td>
                    <td>${p.NombreProducto}</td>
                    <td>$${precioFormateado}</td>
                    <td>${p.IVA}</td>
                    <td>${p.Descuento}</td>
                    <td>$${precioFormateado}</td>
                    <td>${p.CantidadStock}</td>
                    <td><input type="number" class="form-control form-control-sm cantidad2" value="${cantidadAgregar}" min="1" max="${p.CantidadStock}"></td>
                    <td class="total2">$${(precio * cantidadAgregar).toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 })}</td>
                </tr>`;
            $("#tablaPedidos2").append(fila);
        }
        actualizarResumenTabla2();
    }

    $("#tablaPedidos2").on("input", ".cantidad2", function () {
        let fila = $(this).closest("tr");
        let precio = parseFloat(fila.find("td:eq(2)").text().replace(/\$|\./g, "").replace(",", ".")) || 0;
        let cantidad = parseInt($(this).val()) || 1;

        if (cantidad < 1) cantidad = 1;
        if (cantidad > parseInt($(this).attr("max"))) cantidad = parseInt($(this).attr("max"));
        $(this).val(cantidad);

        let total = precio * cantidad;
        fila.find(".total2").text("$" + total.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        actualizarResumenTabla2();
    });

    // ----- Resumen -----
    function actualizarResumen() {
        let subtotal = 0, iva = 0, items = 0, productos = 0;
        $("#tablaPedidos tr").each(function () {
            let total = parseFloat($(this).find(".total").text().replace(/\$|\./g, "").replace(",", ".")) || 0;
            let ivaProd = parseFloat($(this).find("td:eq(3)").text()) || 0;
            let cantidad = parseInt($(this).find(".cantidad").val()) || 0;

            if (cantidad > 0) {
                subtotal += total;
                iva += (total * ivaProd) / 100;
                items++;
                productos += cantidad;
            }
        });
        let valorTotal = subtotal + iva;
        $("#subtotal").text("$" + subtotal.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        $("#valorIva").text("$" + iva.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        $("#valorTotal").text("$" + valorTotal.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        $("#items").text(items);
        $("#productos").text(productos);
        $("#totalGeneral").text("$" + valorTotal.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
    }

    function mostrarTabla() {
        if ($("#tablaPedidos tr").length > 0) {
            $("#tablaPedidos").closest("div").show();
        }
    }

    function actualizarResumenTabla2() {
        let subtotal = 0, iva = 0, items = 0, productos = 0;
        $("#tablaPedidos2 tr").each(function () {
            let total = parseFloat($(this).find(".total2").text().replace(/\$|\./g, "").replace(",", ".")) || 0;
            let ivaProd = parseFloat($(this).find("td:eq(3)").text()) || 0;
            let cantidad = parseInt($(this).find(".cantidad2").val()) || 0;

            if (cantidad > 0) {
                subtotal += total;
                iva += (total * ivaProd) / 100;
                items++;
                productos += cantidad;
            }
        });
        let valorTotal = subtotal + iva;
        $("#subtotal").text("$" + subtotal.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        $("#valorIva").text("$" + iva.toLocaleString("es-CO", { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $("#valorTotal").text("$" + valorTotal.toLocaleString("es-CO", { minimumFractionDigits: 3, maximumFractionDigits: 3 }));
        $("#items").text(items);
        $("#productos").text(productos);
    }

    // ----- Clientes -----
    let clienteSeleccionado = {};
    $('#direccion, #correo, #tel').prop('disabled', true);
    $('#profile-tab, #contact-tab').addClass('disabled').attr('aria-disabled', 'true');
    $('#listaClientes').hide();

    $('#cliente').on('keyup', function () {
        let cliente = $(this).val().trim();
        if (cliente.length > 0) {
            $.ajax({
                url: URL_CLIENTE,
                type: 'POST',
                dataType: 'json',
                data: { OP: "cliente", term: cliente },
                success: function (data) {
                    if (!Array.isArray(data)) {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.' });
                        return;
                    }
                    if (data.length === 0) {
                        $('#listaClientes').hide().empty();
                        return;
                    }
                    let html = '';
                    data.forEach(function (item) {
                        html += `<div class="cliente-item" style="padding:5px; margin:2px; border:1px solid #ccc; cursor:pointer;"  
                                    data-id="${item.ID}" 
                                    data-nombres="${item.nombres || ''}" 
                                    data-apellidos="${item.apellidos || ''}" 
                                    data-nit="${item.nit || ''}"
                                    data-ciudad="${item.FECHA_CREACION || ''}"
                                    data-direccion="${item.direccion || ''}" 
                                    data-email="${item.email || ''}" 
                                    data-telefono="${item.telefono || ''}"
                                    data-vendedor="${item.roles_id || ''}">
                                    ${item.nombres} ${item.apellidos}
                                </div>`;
                    });
                    $('#listaClientes').html(html).show();
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo buscar el cliente.' });
                }
            });
        } else {
            $('#listaClientes').hide().empty();
            $('#profile-tab, #contact-tab').addClass('disabled').attr('aria-disabled', 'true');
            $('#direccion, #correo, #tel').prop('disabled', true).val('');
            clienteSeleccionado = {};
        }
    });

    $('#listaClientes').on('click', '.cliente-item', function () {
        Swal.fire({ title: 'Cargando datos...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        setTimeout(() => {
            Swal.close();
            clienteSeleccionado = {
                ID: $(this).data('id'),
                nombres: $(this).data('nombres'),
                apellidos: $(this).data('apellidos'),
                nit: $(this).data('nit'),
                ciudad: $(this).data('ciudad'),
                direccion: $(this).data('direccion'),
                email: $(this).data('email'),
                telefono: $(this).data('telefono'),
                roles_id: $(this).data('vendedor'),
            };
                $('#cliente').val((clienteSeleccionado.nombres + ' ' + clienteSeleccionado.apellidos).trim());
                $('#direccion').val(clienteSeleccionado.direccion).prop('disabled', false);
                $('#correo').val(clienteSeleccionado.email).prop('disabled', false);
                $('#tel').val(clienteSeleccionado.telefono).prop('disabled', false);
                $('#profile-tab, #contact-tab').removeClass('disabled').removeAttr('aria-disabled');
                $('#listaClientes').hide().empty();
            }, 500);
        });

        $('#btnDatosCliente').on('click', function () {
            if (!clienteSeleccionado.ID) {
                Swal.fire('Atención', 'Debe seleccionar un cliente antes de ver los datos.', 'warning');
                return;
            }
            $('#modalNombre').text((clienteSeleccionado.nombres + ' ' + clienteSeleccionado.apellidos).trim() || '---');
            $('#modalCodigo').text(clienteSeleccionado.ID || '---');
            $('#modalNit').text(clienteSeleccionado.nit || '---');
            $('#modalCiudad').text(clienteSeleccionado.ciudad || '---');
            $('#modalDireccion').text(clienteSeleccionado.direccion || '---');
            $('#modalVendedor').text(clienteSeleccionado.roles_id || '---');
            $('#modalTelefono').text(clienteSeleccionado.telefono || '---');
            $('#modalDatos').modal('show');
        });

        // ----- Guardar Pedido -----
        $(document).on('click', '.btn-success', function () {
            const cliente = $("#cliente").val().trim();
            const direccion = $("#direccion").val().trim();
            const correo = $("#correo").val().trim();
            const telefono = $("#tel").val().trim();
            const notas = $("textarea").val().trim();

            if (!cliente || $("#tablaPedidos2 tr").length === 0) {
                Swal.fire("Error", "Debe seleccionar un cliente y al menos un producto.", "error");
                return;
            }

            let productos = [];
            $("#tablaPedidos2 tr").each(function () {
                productos.push({
                    codigo: $(this).find("td:eq(0)").text(),
                    descripcion: $(this).find("td:eq(1)").text(),
                    precio: $(this).find("td:eq(2)").text().replace("$", "").replace(/\./g, "").replace(",", ".", "."),
                    iva: $(this).find("td:eq(3)").text(),
                    descuento: $(this).find("td:eq(4)").text(),
                    cantidad: $(this).find(".cantidad2").val(),
                    total: $(this).find(".total2").text().replace("$", "").replace(/\./g, "").replace(",", ".", ".")
                });
            });

            const resumen = {
                subtotal: $("#subtotal").text().replace("$", "").replace(/\./g, "").replace(",", ".",".", "."),
                valorIva: $("#valorIva").text().replace("$", "").replace(/\./g, "").replace(",", "."),
                valorTotal: $("#valorTotal").text().replace("$", "").replace(/\./g, "").replace(",", ".", "."),
                items: $("#items").text(),
                productos: $("#productos").text()
            };

            $.ajax({
                url: URL_CLIENTE,
                type: 'POST',
                data: { OP: "guardarPedido", cliente, direccion, correo, telefono, notas, productos, resumen },
                dataType: 'json',
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire("Éxito", response.message || "Pedido guardado correctamente.", "success");
                        limpiar();
                        $("#tablaPedidos2").empty();
                        actualizarResumenTabla2();
                    } else {
                        Swal.fire("Error", response.message || "Ocurrió un error al guardar.", "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "No se pudo guardar el pedido.", "error");
                }
            });
        });
    });
