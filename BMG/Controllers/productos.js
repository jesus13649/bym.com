function cargarProveedores() {
    $.ajax({
        url: "../models/productos.php",
        type: "POST",
        data: { op: "listarProveedores" }, // Se envía la operación
        dataType: "json",
        success: function (data) {
            let $select = $("#proveedor");
            $select.empty(); // Limpiar el select
            $select.append('<option value="">Seleccione un proveedor</option>');

            if (data.length > 0) {
                data.forEach(function (proveedor) {
                    $select.append(
                        `<option value="${proveedor.id}">${proveedor.razon_social}</option>`
                    );
                });
            } else {
                $select.append('<option value="">No hay proveedores</option>');
            }
        },
        error: function () {
            alert("Error al cargar los proveedores");
        }
    });
}
function cargarivas() {
    $.ajax({
        url: "../models/productos.php",
        type: "POST",
        data: { op: "listarivas" }, // Se envía la operación
        dataType: "json",
        success: function (data) {
            console.log("Datos recibidos:", data);
            let $select = $("#iva");
            $select.empty(); // Limpiar el select
            $select.append('<option value="">  IVA 0%</option>');

            if (data.length > 0) {
                data.forEach(function (iva) {
                    $select.append(
                        `<option value="${iva.IVAID}">${iva.Porcentaje}</option>`
                    );
                });
            } else {
                $select.append('<option value="">No hay iva</option>');
            }
        },
        error: function () {
            alert("Error al cargar los ivas");
        }
    });
}



$(function () {

    cargarProveedores();
cargarivas();
    $("#productoForm").submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append("op", "insertar");

        // Mostrar todo el contenido del formulario antes de enviarlo
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        $.ajax({
            url: "../models/productos.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: 'Guardando...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                console.log("Respuesta del servidor:", response);
                Swal.close();
                if (response.status === "success") {
                    Swal.fire("Éxito", response.message, "success");
                    $("#productoForm")[0].reset();
                    $("#previewImg").hide();
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                console.error("Error AJAX:", status, error);
                console.log("Respuesta completa:", xhr.responseText);
                Swal.fire("Error", "No se pudo guardar el producto.", "error");
            }
        });
    });
});
