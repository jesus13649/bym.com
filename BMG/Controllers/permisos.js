// ✅ Renombramos la constante para evitar conflictos con otras variables globales
const PERMISOS_URL = "../Models/permisos.php";

const Permisos = {
    init: function () {
        console.log("✅ Inicializando módulo Permisos...");
        this.crearPermiso();
        this.cargarPermisos();
    },

    crearPermiso: function () {
        $("#crearPermisoForm").submit(function (e) {
            e.preventDefault();
            const titulo = $("#tituloPermiso").val().trim();
            const descripcion = $("#descripcionPermiso").val().trim();

            console.log("📌 Enviando nuevo permiso:", { titulo, descripcion });

            if (titulo === "") {
                Swal.fire("Error", "El título es obligatorio.", "error");
                return;
            }

            $.ajax({
                url: PERMISOS_URL,
                type: "POST",
                data: { titulo, descripcion },
                dataType: "json",
                beforeSend: function () {
                    console.log("⏳ Enviando solicitud para crear permiso...");
                },
                success: function (response) {
                    console.log("✅ Respuesta al crear permiso:", response);
                    if (response.success) {
                        Swal.fire("Éxito", response.message, "success");
                        $("#crearPermisoForm")[0].reset();
                        Permisos.cargarPermisos();
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function (xhr) {
                    console.error("❌ Error en la solicitud:", xhr.responseText);
                    Swal.fire("Error", "No se pudo conectar con el servidor.", "error");
                }
            });
        });
    },

    cargarPermisos: function () {
        console.log("🔄 Cargando permisos...");
        $.ajax({
            url: PERMISOS_URL,
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log("✅ Respuesta al cargar permisos:", data);

                if (!data.success) {
                    console.warn("⚠️ La API devolvió error:", data.message);
                    Swal.fire("Advertencia", data.message || "No se pudieron cargar los permisos.", "warning");
                    $("#tablaPermisos").html('<tr><td colspan="4" class="text-center text-danger">Error al cargar permisos</td></tr>');
                    return;
                }

                if (!data.permisos || data.permisos.length === 0) {
                    console.log("ℹ️ No hay permisos registrados.");
                    $("#tablaPermisos").html('<tr><td colspan="4" class="text-center">No hay permisos registrados</td></tr>');
                    return;
                }

                let html = '';
                data.permisos.forEach(function (permiso) {
                    html += `
                        <tr>
                            <td>${permiso.id}</td>
                            <td>${permiso.titulo}</td>
                            <td>${permiso.descripcion}</td>
                            <td>
                                <button class="btn btn-outline-warning  " onclick="Permisos.abrirModal(${permiso.id}, '${permiso.titulo}', '${permiso.descripcion}')">  <i class="bi bi-pencil"></i>Editar</button>
                                <button class="btn btn-outline-danger" onclick="Permisos.eliminarPermiso(${permiso.id})"><i class="bi bi-trash"></i> Eliminar</button>
                            </td>
                        </tr>
                    `;
                });

                $("#tablaPermisos").html(html);
            },
            error: function (xhr) {
                console.error("❌ Error al cargar permisos:", xhr.responseText);
                Swal.fire("Error", "No se pudo cargar la lista de permisos.", "error");
            }
        });
    },

    abrirModal: function (id, titulo, descripcion) {
        console.log("✏️ Editando permiso:", { id, titulo, descripcion });
        $("#idPermiso").val(id);
        $("#nuevoTitulo").val(titulo);
        $("#nuevaDescripcion").val(descripcion);
        $("#editarPermisoModal").modal("show");

        $("#guardarCambiosPermiso").off("click").on("click", function () {
            Permisos.editarPermiso();
        });
    },

    editarPermiso: function () {
        const id = $("#idPermiso").val();
        const titulo = $("#nuevoTitulo").val().trim();
        const descripcion = $("#nuevaDescripcion").val().trim();

        console.log("📌 Guardando cambios en permiso:", { id, titulo, descripcion });

        if (titulo === "") {
            Swal.fire("Error", "El título es obligatorio.", "error");
            return;
        }

        $.ajax({
            url: PERMISOS_URL,
            type: "POST",
            data: { editarPermiso: id, nuevoTitulo: titulo, nuevaDescripcion: descripcion },
            dataType: "json",
            success: function (response) {
                console.log("✅ Respuesta al editar permiso:", response);
                if (response.success) {
                    Swal.fire("Éxito", response.message, "success");
                    $("#editarPermisoModal").modal("hide");
                    Permisos.cargarPermisos();
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function (xhr) {
                console.error("❌ Error al editar permiso:", xhr.responseText);
            }
        });
    },

    eliminarPermiso: function (id) {
        console.log("⚠️ Intentando eliminar permiso:", id);
        Swal.fire({
            title: "¿Eliminar permiso?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: PERMISOS_URL,
                    type: "POST",
                    data: { eliminarPermiso: id },
                    dataType: "json",
                    success: function (response) {
                        console.log("✅ Respuesta al eliminar permiso:", response);
                        if (response.success) {
                            Swal.fire("Eliminado", response.message, "success");
                            Permisos.cargarPermisos();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        console.error("❌ Error al eliminar permiso:", xhr.responseText);
                    }
                });
            }
        });
    }
};

$(document).ready(function () {
    console.log("🚀 Documento listo. Inicializando...");
    Permisos.init();
});
