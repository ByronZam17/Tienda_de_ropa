// Configuración global
const API_BASE = 'http://localhost/tienda_de_ropa/public/index.php?url=';
const TABLAS = {
  clientes: {
    campos: ['nombre', 'correo', 'telefono', 'direccion'],
    id: 'id_cliente'
  },
  productos: {
    campos: ['nombre_producto', 'descripcion', 'precio', 'stock', 'id_marca'],
    id: 'id_producto'
  },
  marcas: {
    campos: ['nombre_marca', 'cantidad_prendas', 'ventas'],
    id: 'id_marca'
  },
  encargos: {
    campos: ['id_cliente', 'id_producto', 'fecha_encargo', 'cantidad'],
    id: 'id_encargo'
  }
};

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
  // Cargar datos para todas las tablas
  Object.keys(TABLAS).forEach(tabla => {
    cargarDatos(tabla);
    
    // Configurar evento submit para cada formulario
    const form = document.getElementById(`form-${tabla}`);
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      guardarDatos(tabla);
    });
  });

  // Configurar eventos de cancelar
  document.querySelectorAll('.cancelar').forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      form.reset();
      form.querySelector('[type="hidden"]').value = '';
    });
  });
});

// Función para cargar datos de una tabla
async function cargarDatos(tabla) {
  try {
    const response = await fetch(`${API_BASE}${tabla}`);
    
    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }
    
    const data = await response.json();
    
    if (!Array.isArray(data)) {
      throw new Error('La respuesta no es un array');
    }
    
    mostrarDatos(tabla, data);
  } catch (error) {
    console.error(`Error al cargar ${tabla}:`, error);
    mostrarError(tabla, error.message);
  }
}

// Función para mostrar datos en la tabla
function mostrarDatos(tabla, datos) {
  const tbody = document.querySelector(`#tabla-${tabla} tbody`);
  tbody.innerHTML = '';

  if (datos.length === 0) {
    tbody.innerHTML = `<tr><td colspan="${TABLAS[tabla].campos.length + 2}">No hay datos disponibles</td></tr>`;
    return;
  }

  datos.forEach(item => {
    const tr = document.createElement('tr');
    
    // Celda ID
    tr.innerHTML = `<td>${item[TABLAS[tabla].id] || ''}</td>`;
    
    // Celdas de campos
    TABLAS[tabla].campos.forEach(campo => {
      tr.innerHTML += `<td>${item[campo] || ''}</td>`;
    });
    
    // Celda de acciones
    tr.innerHTML += `
      <td>
        <button class="editar" data-id="${item[TABLAS[tabla].id]}">Editar</button>
        <button class="eliminar" data-id="${item[TABLAS[tabla].id]}">Eliminar</button>
      </td>
    `;
    
    tbody.appendChild(tr);
  });

  // Configurar eventos de los botones
  tbody.querySelectorAll('.editar').forEach(btn => {
    btn.addEventListener('click', () => editarRegistro(tabla, btn.dataset.id));
  });
  
  tbody.querySelectorAll('.eliminar').forEach(btn => {
    btn.addEventListener('click', () => eliminarRegistro(tabla, btn.dataset.id));
  });
}

// Función para mostrar errores
function mostrarError(tabla, mensaje) {
  const tbody = document.querySelector(`#tabla-${tabla} tbody`);
  tbody.innerHTML = `
    <tr>
      <td colspan="${TABLAS[tabla].campos.length + 2}" class="error-message">
        Error al cargar datos: ${mensaje}
      </td>
    </tr>
  `;
}

// Función para guardar datos (crear o actualizar)
async function guardarDatos(tabla) {
  const form = document.getElementById(`form-${tabla}`);
  const id = form.querySelector('[type="hidden"]').value;
  const datos = {};

  // Validar campos requeridos
  let isValid = true;
  form.querySelectorAll('[required]').forEach(input => {
    if (!input.value.trim()) {
      input.style.borderColor = 'red';
      isValid = false;
    } else {
      input.style.borderColor = '#ddd';
    }
  });

  if (!isValid) {
    alert('Por favor complete todos los campos requeridos');
    return;
  }

  // Recoger datos del formulario
  TABLAS[tabla].campos.forEach(campo => {
    datos[campo] = document.getElementById(`${tabla}-${campo}`).value;
  });

  try {
    const url = id ? `${tabla}/${id}` : tabla;
    const method = id ? 'PUT' : 'POST';
    
    const response = await fetch(`${API_BASE}${url}`, {
      method,
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(datos)
    });

    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }
    
    form.reset();
    await cargarDatos(tabla);
  } catch (error) {
    console.error(`Error al guardar ${tabla}:`, error);
    alert(`Error al guardar: ${error.message}`);
  }
}

// Función para editar un registro
async function editarRegistro(tabla, id) {
  try {
    const response = await fetch(`${API_BASE}${tabla}/${id}`);
    
    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }
    
    const data = await response.json();
    const form = document.getElementById(`form-${tabla}`);
    
    // Establecer ID
    form.querySelector('[type="hidden"]').value = id;
    
    // Llenar campos del formulario
    TABLAS[tabla].campos.forEach(campo => {
      const input = document.getElementById(`${tabla}-${campo}`);
      if (input) input.value = data[campo] || '';
    });
    
    // Desplazarse al formulario
    form.scrollIntoView({ behavior: 'smooth' });
  } catch (error) {
    console.error(`Error al editar ${tabla}:`, error);
    alert(`Error al cargar datos para edición: ${error.message}`);
  }
}


// Función para eliminar un registro
async function eliminarRegistro(tabla, id) {
  if (!confirm(`¿Estás seguro de eliminar este ${tabla}?`)) return;

  try {
    const response = await fetch(`${API_BASE}${tabla}/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    // Verificar si la respuesta es exitosa
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || `Error al eliminar: ${response.status}`);
    }

    // Eliminar la fila visualmente sin recargar toda la tabla
    const fila = document.querySelector(`#tabla-${tabla} button.eliminar[data-id="${id}"]`).closest('tr');
    if (fila) {
      fila.remove();
    }
    
    // Opcional: Mostrar mensaje de éxito
    alert('Registro eliminado correctamente');

  } catch (error) {
    console.error('Error al eliminar:', error);
    alert(`Error: ${error.message}`);
  }
}  



