const URL = '../Models/modulos_permisos.php';
// Cargar roles al iniciar
const listarRoles = async () => {
  const data = { op: 'LR' };
  const resp = await enviarPeticion(data);

  if (!Array.isArray(resp)) {
    Swal.fire("Error", "No se pudo cargar los roles.", "error");
    return;
  }

  if (resp.length === 0) {
    $('#list_roles').html('<p class="text-danger">No hay roles disponibles</p>');
    return;
  }

  let html = '<div class="list-group" id="rolesList">';
  resp.forEach(r => {
    html += `
      <button type="button" class="list-group-item list-group-item-action" data-id="${r.id}">
        ${r.id} - ${r.nombre}
      </button>
    `;
  });
  html += '</div>';

  $('#list_roles').html(html);
  $('#list_roles_permisos').html('');
  $('#list_modulos').html('');
};


// Delegar evento click para los roles
$(document).on('click', '#rolesList button', async function () {
  $('#rolesList button').removeClass('active');
  $(this).addClass('active');

  const rolId = $(this).data('id');
  cargarModulos(rolId);
  mostrarModulosVisibles(rolId);
  $('#list_roles_permisos').html('');
});

// Cargar módulos para el rol seleccionado
const cargarModulos = async (rol_id) => {
  const data = { op: 'LM', rol_id };
  const resp = await enviarPeticion(data);
 console.log(resp);
  if (!Array.isArray(resp)) {
    Swal.fire("Error", "No se pudieron cargar los módulos.", "error");
    return;
  }

  let html = '<div class="list-group" id="modulosList">';
  resp.forEach(m => {
    const clase = m.asignados > 0 ? 'active' : '';
    html += `<button type="button" class="list-group-item list-group-item-action ${clase}" data-id="${m.id}">${m.numero} - ${m.modulo}</button>`;
  });
  html += '</div>';

  $('#list_modulos').html(html);
};

// Delegar evento click para módulos
$(document).on('click', '#modulosList button', function () {
  const $this = $(this);
  const wasActive = $this.hasClass('active');
  
  // Quitar todos los activos
  $('#modulosList button').removeClass('active');
  $('#list_roles_permisos').html('');

  if (!wasActive) {
    $this.addClass('active');

    const moduloId = $this.data('id');
    const rol_id = $('#rolesList button.active').data('id');

    if (!rol_id) {
      Swal.fire('Error', 'Seleccione un rol primero.', 'error');
      return;
    }

    cargarPermisos(rol_id, moduloId);
  }
});


// Cargar permisos según rol y módulo
const cargarPermisos = async (rol_id, modulo_id) => {
  const data = { op: 'LP', rol_id, modulo_id };
  const resp = await enviarPeticion(data);

  if (!Array.isArray(resp)) {
    Swal.fire("Error", "No se pudieron cargar los permisos.", "error");
    return;
  }

  let html = '<ul class="list-group">';
  resp.forEach(p => {
    const checked = p.modulo_permiso_id > 0 ? 'checked' : '';
    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
      ${p.permiso}
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" data-permiso="${p.id_permiso}" data-modulo="${modulo_id}" ${checked}>
      </div>
    </li>`;
  });
  html += '</ul>';

  $('#list_roles_permisos').html(html);
};

// Manejar el cambio en los checkbox de permisos
$(document).on('change', 'input[type="checkbox"][data-permiso]', async function () {
  const checked = this.checked;
  const rol_id = $('#rolesList button.active').data('id');
  const permiso_id = $(this).data('permiso');
  const modulo_id = $(this).data('modulo');

  if (!rol_id) {
    Swal.fire("Error", "Seleccione un rol primero.", "error");
    $(this).prop('checked', !checked);
    return;
  }

  const data = {
    op: checked ? 'add_permiso' : 'DEL',
    rol_id,
    modulo_id,
    permiso_id,
    modulo_permiso_id: 0
  };

  if (!checked) {
    const permisos = await enviarPeticion({ op: 'LP', rol_id, modulo_id });
    const permiso = permisos.find(p => p.id_permiso == permiso_id);
    data.modulo_permiso_id = permiso ? permiso.modulo_permiso_id : 0;
  }

  const resp = await enviarPeticion(data);
  if (!resp.ok) {
    Swal.fire("Error", resp.mensaje, "error");
    $(this).prop('checked', !checked);
  } else {
    Swal.fire("Correcto", resp.mensaje, "success");
    cargarModulos(rol_id);
    mostrarModulosVisibles(rol_id); // Refrescar visibilidad del menú
  }
});

// 🔥 Mostrar módulos del menú lateral según el rol
const mostrarModulosVisibles = async (rol_id) => {
  // Ocultar todos los módulos inicialmente
  $('#menuModules li').hide();

  const resp = await enviarPeticion({ op: 'modulos_por_usuario', rol_id });

  if (!Array.isArray(resp)) {
    console.error("No se pudieron cargar los módulos del menú");
    return;
  }

  resp.forEach(mod => {
    $(`#menuModules li#${mod.numero}`).show();
  });

  // Asegurarse que el Inicio siempre esté visible
  $('#menuModules li#0000').show();
};

// Función para enviar peticiones
const enviarPeticion = async (data) => {
  try {
    const form = new FormData();
    for (let key in data) form.append(key, data[key]);

    const response = await fetch(URL, { method: 'POST', body: form });
    const text = await response.text();

    try {
      return JSON.parse(text);
    } catch {
      console.error('❌ Respuesta no es JSON:', text);
      return { ok: false, mensaje: 'Respuesta inválida del servidor' };
    }
  } catch (e) {
    return { ok: false, mensaje: 'Error en la petición AJAX' };
  }
};

// Inicializar
$(function () {
  listarRoles();
  
});
