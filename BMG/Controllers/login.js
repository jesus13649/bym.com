$(document).ready(function () {

    // ✅ Subir imagen y texto al carrusel
    $("#formImagen").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "../Models/login.php?action=subir_imagen", // ✅ Agregamos action
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Subiendo imagen...",
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();
                if (response.status === "success") {
                    Swal.fire("Éxito", response.message, "success");
                    $("#formImagen")[0].reset();
                    cargarCarrusel();
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Error en la comunicación con el servidor", "error");
            }
        });
    });

    // ✅ Cargar imágenes al iniciar
    cargarCarrusel();

    // ✅ Login con AJAX
    $("#loginForm").submit(function (e) {
        e.preventDefault();
        handleLogin();
    });
});

// ✅ Función para cargar carrusel
function cargarCarrusel() {
    $.ajax({
        url: "../Models/login.php?action=cargar_imagenes", // ✅ Agregamos action
        type: "GET",
        dataType: "json",
        success: function (data) {
            let indicadores = "";
            let items = "";

            data.forEach((img, index) => {
                indicadores += `
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="${index}" 
                        ${index === 0 ? 'class="active" aria-current="true"' : ""} 
                        aria-label="Slide ${index + 1}"></button>
                `;

                items += `
                    <div class="carousel-item ${index === 0 ? 'active' : ''} h-100">
                        <img src="../${img.ruta_imagen}" class="d-block w-100" alt="${img.titulo}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>${img.titulo}</h5>
                        </div>
                    </div>
                `;
            });

            $("#carouselIndicators").html(indicadores);
            $("#carouselItems").html(items);
        },
        error: function () {
            console.error("Error al cargar imágenes");
        }
    });
}

// ✅ Login con AJAX
function handleLogin() {
    let usuario = $("#yourUsername").val().trim();
    let clave = $("#yourPassword").val().trim();

    if (usuario === "" || clave === "") {
        Swal.fire("Error", "Todos los campos son obligatorios", "error");
        return;
    }

    $.ajax({
        url: "../Models/login.php?action=login", // llamamos la action
        type: "POST",
        dataType: "json",
        data: { usuario: usuario, clave: clave },
        beforeSend: function () {
            $("#loginButton").prop("disabled", true).text("Validando...");
        },
        success: function (response) {
            if (response.status === "success") {
                Swal.fire("Éxito", response.message, "success").then(() => {
                    window.location.href = "home.php";
                });
            } else {
                Swal.fire("Error", response.message, "error");
            }
        },
        error: function (xhr) {
            console.error("Error AJAX:", xhr.responseText);
            Swal.fire("Error", "Error en la comunicación con el servidor", "error");
        },
        complete: function () {
            $("#loginButton").prop("disabled", false).text("Iniciar sesión");
        }
    });
}
