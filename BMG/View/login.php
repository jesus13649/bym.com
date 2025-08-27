<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .vh-100 {
            height: 100vh;
        }
        .carousel, .carousel-inner, .carousel-item, .carousel-item img {
            height: 100vh;
        }
        .carousel-item img {
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container-fluid vh-100">
    <div class="row h-100 align-items-center">
        
        <!-- Columna de Login -->
        <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">
            <div class="card border rounded shadow-lg p-4 w-100" style="max-width: 500px;">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../Assets/img/LOGO1.png" alt="Login Image" class="img-fluid mb-3" style="max-width: 150px;">
                    </div>
                    
                    
                    <form id="loginForm" class="row g-3 needs-validation" novalidate>
                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Usuario</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="usuario" class="form-control" id="yourUsername" required>
                                <div class="invalid-feedback">Por favor, ingrese su usuario.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Clave</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="clave" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Por favor, ingrese su contraseña.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Recordarme</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0">¿No tienes cuenta? <a href="pages-register.html">Crear una cuenta</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna del Carrusel -->
        <div class="col-lg-6 col-md-4 p-0">
            <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel">
                <div class="carousel-indicators" id="carouselIndicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner h-100" id="carouselItems">
                    <div class="carousel-item active h-100">
                        <img src="../Assets/img/IMG1.jpg" class="d-block w-100" alt="Slide 1">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="../Assets/img/IMG2.jpg" class="d-block w-100" alt="Slide 2">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="../Assets/img/IMG3.jpg" class="d-block w-100" alt="Slide 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

    </div>
    <!-- Footer -->
    <footer class="text-center mt-3">
        <p>&copy; 2025 Tec. Jesús López</p>
    </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../Controllers/login.js"></script>
</body>
</html>
