// Guarda como sidebar.js (misma carpeta que sidebar.php o ajusta la ruta)
$(function() {
  const $sidebar = $('#app-sidebar');
  const $toggle = $('#sidebar-toggle');
  const $overlay = $('#content-overlay');
  const $themeIcon = $('#themeIcon');

  // --- Tema (dark/light) ---
  const savedTheme = localStorage.getItem('vds_theme') || 'dark';
  function applyTheme(theme) {
    if (theme === 'light') {
      $sidebar.css('background', '#fff').css('color','#111');
      $sidebar.find('.menu-item, .menu-label').css('color','#111');
      $themeIcon.removeClass('bi-moon-fill').addClass('bi-sun-fill');
    } else {
      $sidebar.css('background', '').css('color','#fff'); // vuelve al gradient por defecto (CSS)
      $sidebar.find('.menu-item, .menu-label').css('color','#fff');
      $themeIcon.removeClass('bi-sun-fill').addClass('bi-moon-fill');
    }
    localStorage.setItem('vds_theme', theme);
  }
  applyTheme(savedTheme);

  $('#toggleTheme').on('click', function() {
    const next = (localStorage.getItem('vds_theme') === 'light') ? 'dark' : 'light';
    applyTheme(next);
  });

  // --- Colapsar / expandir sidebar ---
  $toggle.on('click', function(e) {
    e.preventDefault();
    $sidebar.toggleClass('collapsed');
    // Cambia icono de chevron
    const $icon = $(this).find('i');
    $icon.toggleClass('bi-chevron-left bi-chevron-right');
  });

  // --- Submenus: usar bootstrap collapse (ya inicializa con data-bs-toggle),
  //      pero agregamos cierre automático de otros submenus si lo deseas ---
  // (Bootstrap maneja la animación; no hace falta JS extra para collapse)

  // --- Mobile: overlay para mostrar/ocultar sidebar (si quieres abrirlo en mobile) ---
  // abrirlo si se le agrega la clase 'open' (por ejemplo desde un botón en la cabecera)
  $(document).on('click', '#openSidebarMobile', function(e) {
    e.preventDefault();
    $sidebar.addClass('open');
    $overlay.show();
  });
  $overlay.on('click', function() {
    $sidebar.removeClass('open');
    $overlay.hide();
  });

  // --- Cargar datos del perfil cuando se abre el modal (llama a tu API de sesión) ---
  $('#perfilModal').on('show.bs.modal', function() {
    $.ajax({
      url: '../Models/api.php?action=session',
      method: 'GET',
      dataType: 'json',
      success: function(res) {
        if (res && res.status === 'success') {
          $('#perfilNombre').text(res.nombres + ' ' + res.apellidos || res.usuario);
          $('#perfilRol').text(res.rol_nombre || res.rol);
          $('#perfilNit').text(res.nit || 'N/A');
          $('#perfilTelefono').text(res.telefono || 'N/A');
          $('#perfilEmail').html(res.email ? `<a href="mailto:${res.email}">${res.email}</a>` : 'No disponible');
          $('#perfilAvatar').attr('src', res.avatar ? res.avatar : '<?= htmlspecialchars($avatar); ?>');
        } else {
          // Si falla, dejamos lo estático (ya viene con PHP) o muestra alerta
          console.warn('No se pudo obtener sesión:', res && res.message);
        }
      },
      error: function() {
        console.error('Error al consultar session API');
      }
    });
  });

  // --- Cerrar offcanvas (si tu layout lo usa) antes de abrir modal (tu código original) ---
  $(document).on('click', '#verPerfilBtn', function() {
    const off = bootstrap.Offcanvas.getInstance(document.getElementById('sidebar'));
    if (off) off.hide();
    // abrir modal lo maneja data-bs-toggle
  });

});
