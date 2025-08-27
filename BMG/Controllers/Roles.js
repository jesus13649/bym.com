const Roles = {
    init: function () {
        this.crearRol();
        this.cargarRoles();
    },

    crearRol: function () {
        $("#crearRolForm").submit(function (e) {
            e.preventDefault(); // Evitar recarga de la página

            const nombreRol = $("#nombreRol").val().trim();

            if (nombreRol === "") {
                Swal.fire("Error", "El nombre del rol no puede estar vacío.", "error");
                return;
            }

            $.ajax({
                url: "../Models/Roles.php",
                type: "POST",
                data: { nombreRol: nombreRol },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire("Éxito", response.message, "success");
                        $("#nombreRol").val('');
                        Roles.cargarRoles();
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Hubo un problema al crear el rol.", "error");
                }
            });
        });
    },

    cargarRoles: function () {
        $.ajax({
            url: "../Models/Roles.php",
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.success && Array.isArray(data.roles)) {
                    let html = '';
                    data.roles.forEach(function (rol) {
                        html += `
                            <tr>
                                <td>${rol.nombre}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-info"
                                        onclick="Roles.abrirModal(${rol.id}, '${rol.nombre}')">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-outline-danger"
                                        onclick="Roles.eliminarRol(${rol.id}, '${rol.nombre}')">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#tablaRoles").html(html);
                } else {
                    $("#tablaRoles").html('<tr><td colspan="2" class="text-center text-danger">No se encontraron roles.</td></tr>');
                }
            },
            error: function () {
                Swal.fire("Error", "Hubo un error al cargar los roles.", "error");
            }
        });
    },

    abrirModal: function (id, nombre) {
        console.log("✏️ Editando rol:", { id, nombre });
        $("#idRol").val(id);
        $("#nuevoNombreRol").val(nombre);
        $("#editarRolModal").modal("show");

        $("#guardarCambiosRol").off("click").on("click", function () {
            Roles.guardarRol();
        });
    },

    guardarRol: function () {
        const idRol = $("#idRol").val();
        const nuevoNombreRol = $("#nuevoNombreRol").val().trim();

        if (!idRol || nuevoNombreRol === "") {
            Swal.fire("Error", "El nombre del rol no puede estar vacío.", "error");
            return;
        }

        $.ajax({
            url: "../Models/Roles.php",
            type: "POST",
            data: { editarRol: idRol, nuevoNombreRol: nuevoNombreRol },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Éxito",
                        text: response.message,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        $("#editarRolModal").modal("hide");
                        Roles.cargarRoles();
                    }, 1500);
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Hubo un problema al actualizar el rol.", "error");
            }
        });
    },

    eliminarRol: function (idRol, nombre) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: `¿Deseas eliminar el rol "${nombre}"?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../Models/Roles.php",
                    type: "POST",
                    data: { eliminarRol: idRol },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Eliminado", response.message, "success");
                            Roles.cargarRoles();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Hubo un problema al eliminar el rol.", "error");
                    }
                });
            }
        });
    }
};

$(document).ready(function () {
    Roles.init();
});
