$(document).ready(function () {
    // Guardar módulo
    $('#formModulo').submit(function (e) {
      e.preventDefault();
      const datos = $(this).serialize();
      $.post('guardar_modulo.php', datos, function (res) {
        const response = JSON.parse(res);
        if (response.success) {
          alert('Módulo creado correctamente');
          $('#formModulo')[0].reset();
          cargarModulos();
        } else {
          alert('Error al guardar módulo');
        }
      });
    });
  
    // Cargar módulos
    function cargarModulos() {
      $.get('obtener_modulos.php', function (res) {
        const modulos = JSON.parse(res);
        const $menu = $('#menuModulos');
        $menu.empty();
  
        if (modulos.length === 0) {
          $menu.append('<li class="nav-item text-muted px-3">No hay módulos</li>');
          return;
        }
  
        modulos.forEach(mod => {
          $menu.append(`
            <li class="nav-item">
              <a href="${mod.url || '#'}" class="nav-link d-flex align-items-center">
                <i class="${mod.Imagen || 'bi bi-folder'} me-2"></i>
                ${mod.Nombre}
              </a>
            </li>
          `);
        });
      });
    }
  
    // Inicializar
    cargarModulos();
  });
  