// Función para cargar departamentos desde PHP
function cargarDepartamentos() {
    $.ajax({
        url: '../Models/registro.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.departamentos) {
                var departamentoSelect = $('#departamento');
                departamentoSelect.empty();
                departamentoSelect.append('<option value="">Seleccione un departamento</option>');
                $.each(response.departamentos, function(index, departamento) {
                    departamentoSelect.append('<option value="' + departamento.id + '">' + departamento.nombre + '</option>');
                });
            } else {
                console.error('Error al obtener departamentos:', response.departamentos?.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al realizar la solicitud:', error);
        }
    });
}

// Función para cargar roles desde PHP
function cargarRoles() {
    $.ajax({
        url: '../Models/registro.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.roles) {
                var rolSelect = $('#rol');
                rolSelect.empty();
                rolSelect.append('<option value="">Seleccione un rol</option>');
                $.each(response.roles, function(index, rol) {
                    rolSelect.append('<option value="' + rol.id + '">' + rol.nombre + '</option>');
                });
            } else {
                console.error('Error al obtener roles:', response.roles?.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al realizar la solicitud:', error);
        }
    });
}

// Función para cargar estados desde PHP
function cargarEstados() {
    $.ajax({
        url: '../Models/registro.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.estados) {
                let estados = response.estados;
                let estadoSelect = $('#estado');
                estadoSelect.empty();
                estadoSelect.append('<option value="">Seleccione un estado</option>');
                estados.forEach(function(estado) {
                    estadoSelect.append('<option value="' + estado.EstadoID + '">' + estado.NombreEstado + '</option>');
                });
            } else {
                console.error('Error al obtener estados:', response.estados?.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al realizar la solicitud:', error);
        }
    });
}

// Función para registrar un usuario
function registrarUsuario() {
    let datos = {
        usuario: $('#usuario').val(),
        clave: $('#clave').val(),
        departamento: $('#departamento').val(),
        rol: $('#rol').val(),
        nombre: $('#nombre').val(),
        apellido: $('#apellido').val(),
        email: $('#email').val(),
        telefono: $('#telefono').val(),
        direccion: $('#direccion').val(),
        documento: $('#documento').val(), // Documento -> nit
        fecha_nacimiento: $('#fecha_nacimiento').val(),
        estado_civil: $('#estado_civil').val(),
        estado: $('#estado').val()
    };

    $.ajax({
        type: "POST",
        url: "../Models/registro.php",
        data: datos,
        dataType: "json",
        success: function(response) {
            mostrarAlerta(response.success, response.message);
            if (response.success) {
                $("#registroForm")[0].reset();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            mostrarAlerta(false, "Hubo un problema con el servidor.");
            console.error("Error AJAX (Registro):", textStatus, errorThrown);
            console.log("Detalles de la respuesta:", jqXHR.responseText);
        }
    });
}

// Función para mostrar alertas con SweetAlert2
function mostrarAlerta(exito, mensaje) {
    Swal.fire({
        icon: exito ? "success" : "error",
        title: exito ? "Registro Exitoso" : "Error en el Registro",
        text: mensaje,
        timer: exito ? 2000 : null,
        showConfirmButton: !exito
    });
}

// Inicialización
$(function () {
    cargarDepartamentos();
    cargarRoles();
    cargarEstados();

    $("#registroForm").submit(function (event) {
        event.preventDefault();
        registrarUsuario();
    });

    $('#btnNuevo').click(function () {
        $('#registroForm')[0].reset();
    });

    $('#btnEliminar').click(function () {
        Swal.fire({
            title: "¿Seguro que deseas eliminar este usuario?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire("Eliminado", "Función de eliminar aún no programada.", "success");
            }
        });
    });
});
