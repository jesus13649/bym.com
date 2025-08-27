<?php include 'menu.php'; ?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.container-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center; /* Centrar */
    padding: 30px 0;
}

.card-minimal {
    width: 230px;
    height: 150px;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    position: relative;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    font-family: Arial, sans-serif;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-minimal:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.15);
}

.card-minimal h6 {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 8px;
}

.card-minimal .value {
    font-size: 24px;
    font-weight: bold;
    color: #000;
}

.card-minimal a {
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
}

.icon-bg {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 50px;
    opacity: 0.1;
}
    h3.brand {
      font-size: 1.7rem;
      font-weight: 700;
      font-family: 'Playfair Display', serif; 
      color: #5a3646;
      text-decoration: none;
      letter-spacing: 1.5px;
      text-shadow: 1px 1px 2px #ffc8d5;
      transition: color 0.3s ease;
    }
     h3.brand:hover {
      color: #8e5572;
    }

/* Bordes y colores */
.border-blue { border-left: 5px solid #0d6efd; }
.border-green { border-left: 5px solid #198754; }
.border-orange { border-left: 5px solid #fd7e14; }
.border-red { border-left: 5px solid #dc3545; }
.text-blue { color: #0d6efd; }
.text-green { color: #198754; }
.text-orange { color: #fd7e14; }
.text-red { color: #dc3545; }
</style>

<div class="container">
  <br>
    <h3 class="text-center brand">Reportes</h3>
    <div class="container-cards">
        <!-- Card 1 -->
        <div class="card-minimal border-blue">
            <i class="fas fa-dollar-sign icon-bg text-blue"></i>
            <h6 class="text-blue">VENTAS TOTALES</h6>
            <div class="value">$12,500</div>
            <a href="#" class="text-blue" data-bs-toggle="modal" data-bs-target="#modalVentas">
                Más información <i class="fas fa-arrow-up-right-from-square"></i>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="card-minimal border-green">
            <i class="fas fa-shopping-cart icon-bg text-green"></i>
            <h6 class="text-green">PEDIDOS EN CURSO</h6>
            <div class="value">35</div>
            <a href="#" class="text-green" data-bs-toggle="modal" data-bs-target="#modalPedidos">
                Más información <i class="fas fa-arrow-up-right-from-square"></i>
            </a>
        </div>

        <!-- Card 3 -->
        <div class="card-minimal border-orange">
            <i class="fas fa-undo icon-bg text-orange"></i>
            <h6 class="text-orange">DEVOLUCIONES</h6>
            <div class="value">4</div>
            <a href="#" class="text-orange" data-bs-toggle="modal" data-bs-target="#modalDevoluciones">
                Más información <i class="fas fa-arrow-up-right-from-square"></i>
            </a>
        </div>

        <!-- Card 4 -->
        <div class="card-minimal border-red">
            <i class="fas fa-exclamation-triangle icon-bg text-red"></i>
            <h6 class="text-red">PRODUCTOS AGOTADOS</h6>
            <div class="value">8</div>
            <a href="#" class="text-red" data-bs-toggle="modal" data-bs-target="#modalAgotados">
                Más información <i class="fas fa-arrow-up-right-from-square"></i>
            </a>
        </div>
    </div>
</div>

<!-- ✅ MODALES -->
<!-- Modal Ventas -->
<div class="modal fade" id="modalVentas" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Ventas Totales</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Las ventas totales son <strong>$12,500</strong>. Última actualización hoy.
      </div>
    </div>
  </div>
</div>

<!-- Modal Pedidos -->
<div class="modal fade" id="modalPedidos" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Pedidos en Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Actualmente hay <strong>35 pedidos</strong> en proceso.
      </div>
    </div>
  </div>
</div>

<!-- Modal Devoluciones -->
<div class="modal fade" id="modalDevoluciones" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">Devoluciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Hay <strong>4 devoluciones</strong> registradas este mes.
      </div>
    </div>
  </div>
</div>

<!-- Modal Agotados -->
<div class="modal fade" id="modalAgotados" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Productos Agotados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Actualmente <strong>8 productos</strong están agotados.
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>