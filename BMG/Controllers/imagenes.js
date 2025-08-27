$(document).ready(function () {
    // ✅ Cargar datos al cambiar Año o Mes
    $("#anio, #mes").on("change", function () {
        const anio = $("#anio").val();
        const mes = $("#mes").val();
        if (anio && mes) {
            cargarEquipos(anio, mes);
        }
    });

    // ✅ Función para cargar la tabla desde la BD
    function cargarEquipos(anio, mes) {
        $.ajax({
            url: "../models/imagenes.php", // Archivo PHP vinculado
            type: "GET",
            data: { action: "listar", anio: anio, mes: mes },
            dataType: "json",
            beforeSend: function () {
                $("#tablaEquipos").html('<tr><td colspan="6">Cargando...</td></tr>');
            },
            success: function (data) {
                if (data.length > 0) {
                    let filas = "";
                    data.forEach(function (item) {
                        const img = item.ruta_imagen
                            ? `<img src="/VDS/${item.ruta_imagen}" width="60" height="40" style="object-fit:cover;cursor:pointer;" class="imagen-preview" data-img="/VDS/${item.ruta_imagen}" alt="Imagen">`
                            : "Sin imagen";

                        filas += `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.titulo}</td>
                                <td>${item.fecha || "-"}</td>
                                <td>${item.fecha_subida}</td>
                                <td>${img}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm me-2 editar" data-id="${item.id}">Editar</button>
                                    <button class="btn btn-danger btn-sm eliminar" data-id="${item.id}">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#tablaEquipos").html(filas);
                } else {
                    $("#tablaEquipos").html('<tr><td colspan="6">No hay registros</td></tr>');
                }
            },
            error: function () {
                $("#tablaEquipos").html('<tr><td colspan="6">Error al cargar datos</td></tr>');
            }
        });
    }

    // ✅ Eliminar registro con confirmación
    $(document).on("click", ".eliminar", function () {
        const id = $(this).data("id");

        Swal.fire({
            title: "¿Eliminar registro?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../models/imagenes.php",
                    type: "POST",
                    data: { action: "eliminar", id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire("Eliminado", "El registro ha sido eliminado", "success");
                            const anio = $("#anio").val();
                            const mes = $("#mes").val();
                            if (anio && mes) cargarEquipos(anio, mes);
                        } else {
                            Swal.fire("Error", "No se pudo eliminar el registro", "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Hubo un problema en el servidor", "error");
                    }
                });
            }
        });
    });

    // ✅ Editar (Por ahora solo alerta, luego modal)
    $(document).on("click", ".editar", function () {
        const id = $(this).data("id");
        Swal.fire("Editar registro ID: " + id);
    });

    // ✅ Ver imagen en grande al hacer clic
    $(document).on("click", ".imagen-preview", function () {
        const imgSrc = $(this).data("img");
        Swal.fire({
            imageUrl: imgSrc,
            imageAlt: "Vista previa",
            width: 600,
            showConfirmButton: false,
            showCloseButton: true
        });
    });
});
