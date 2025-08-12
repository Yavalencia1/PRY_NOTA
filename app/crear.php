<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Crear Usuario</title>
    <style>
      :root {
        --primary-color: #2563eb;
        --secondary-color: #64748b;
        --accent-color: #f1f5f9;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --white: #ffffff;
        --border-color: #e2e8f0;
        --shadow-light: rgba(15, 23, 42, 0.08);
        --shadow-medium: rgba(15, 23, 42, 0.12);
        --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }
      
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      
      body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
      }
      
      .main-container {
        background: var(--white);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px var(--shadow-light);
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
      }
      
      .main-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient);
      }
      
      .title {
        color: var(--text-dark);
        font-weight: 800;
        text-align: center;
        margin-bottom: 3rem;
        letter-spacing: -0.02em;
      }
      
      .form-label {
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      
      .form-control {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 14px 16px;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        background: var(--white);
      }
      
      .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
      }
      
      .btn-primary {
        background: var(--primary-color);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      
      .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -3px rgba(37, 99, 235, 0.3);
      }
      
      .btn-primary:disabled {
        opacity: 0.6;
        transform: none;
        cursor: not-allowed;
      }
      
      .btn-secondary {
        background: var(--secondary-color);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        color: var(--white);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      
      .btn-secondary:hover {
        background: #475569;
        transform: translateY(-2px);
        color: var(--white);
        box-shadow: 0 10px 25px -3px rgba(100, 116, 139, 0.3);
      }
      
      .table-container {
        background: var(--white);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px var(--shadow-light);
        border: 1px solid var(--border-color);
        margin-top: 2rem;
      }
      
      .table {
        margin-bottom: 0;
      }
      
      .table th {
        background: var(--accent-color);
        color: var(--text-dark);
        border: none;
        font-weight: 600;
        padding: 1rem 0.75rem;
        font-size: 0.9rem;
      }
      
      .table td {
        padding: 1rem 0.75rem;
        border-color: var(--border-color);
        vertical-align: middle;
      }
      
      .table tbody tr:hover {
        background-color: #f8fafc;
      }
      
      .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
      }
      
      .alert-success {
        background: var(--success-color);
        color: var(--white);
      }
      
      .alert-danger {
        background: var(--danger-color);
        color: var(--white);
      }
      
      .text-primary { color: var(--primary-color) !important; }
      .text-success { color: var(--success-color) !important; }
      .text-info { color: #0ea5e9 !important; }
      
      @media (max-width: 768px) {
        .main-container {
          margin: 1rem;
          padding: 2rem 1.5rem !important;
        }
        
        .title {
          font-size: 2rem !important;
        }
        
        .btn-primary, .btn-secondary {
          width: 100%;
          justify-content: center;
          margin-bottom: 0.5rem;
        }
      }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="main-container p-5">
        <h1 class="title display-5">
            <i class="bi bi-person-add me-3"></i>Crear Usuario
        </h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Error: <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
    
    <form id="userForm">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-person"></i>Nombre completo
                </label>
                <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingresa tu nombre">
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i>Correo electrónico
                </label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="ejemplo@correo.com">
            </div>
        </div>
        <div class="mb-4">
            <label for="fecha_nacimiento" class="form-label">
                <i class="bi bi-calendar-date"></i>Fecha de Nacimiento
            </label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            <div class="form-text">
                <i class="bi bi-info-circle me-1"></i>La edad se calculará automáticamente
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary me-3" id="crearBtn">
                <i class="bi bi-check2"></i>Crear Usuario
            </button>
            <a href="../index.html" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>Volver
            </a>
        </div>
    </form>    <!-- Área para mostrar mensajes -->
    <div id="mensaje" class="mt-4"></div>
    
    <!-- Área para mostrar la tabla de usuarios -->
    <div id="tablaUsuarios" class="table-container" style="display: none;">
        <h4 class="mb-3">
            <i class="bi bi-people me-2"></i>Usuarios Registrados
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash me-1"></i>ID</th>
                        <th><i class="bi bi-person me-1"></i>Nombre</th>
                        <th><i class="bi bi-envelope me-1"></i>Email</th>
                        <th><i class="bi bi-calendar-date me-1"></i>Edad</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuariosBody">
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

<script src="../public/lib/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>
// Función para calcular la edad a partir de la fecha de nacimiento
function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const diferenciaMes = hoy.getMonth() - nacimiento.getMonth();
    
    if (diferenciaMes < 0 || (diferenciaMes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }
    
    return edad;
}

// Función para validar fecha de nacimiento
function validarFechaNacimiento(fecha) {
    const hoy = new Date();
    const fechaNac = new Date(fecha);
    const edad = calcularEdad(fecha);
    
    if (fechaNac > hoy) {
        return { valida: false, mensaje: 'La fecha de nacimiento no puede ser futura' };
    }
    
    if (edad < 0) {
        return { valida: false, mensaje: 'Fecha de nacimiento inválida' };
    }
    
    if (edad > 120) {
        return { valida: false, mensaje: 'La edad no puede ser mayor a 120 años' };
    }
    
    if (edad < 1) {
        return { valida: false, mensaje: 'La persona debe tener al menos 1 año' };
    }
    
    return { valida: true, edad: edad };
}

// Función para cargar y mostrar los usuarios
async function cargarUsuarios() {
    try {
        const response = await fetch('./obtener_usuarios.php');
        if (response.ok) {
            const usuarios = await response.json();
            const tbody = document.getElementById('tablaUsuariosBody');
            const tablaUsuarios = document.getElementById('tablaUsuarios');
            
            if (usuarios.length > 0) {
                tbody.innerHTML = usuarios.map(usuario => `
                    <tr>
                        <td class="fw-bold text-primary">${usuario.id}</td>
                        <td>${usuario.nombre}</td>
                        <td class="text-info">${usuario.email}</td>
                        <td>
                            <span class="badge bg-primary">${calcularEdad(usuario.fecha_nacimiento)} años</span>
                            <div class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>${new Date(usuario.fecha_nacimiento).toLocaleDateString('es-ES', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                })}
                            </div>
                        </td>
                    </tr>
                `).join('');
                tablaUsuarios.style.display = 'block';
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay usuarios registrados</td></tr>';
                tablaUsuarios.style.display = 'block';
            }
        } else {
            console.error('Error al obtener usuarios');
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }
}

// Establecer fecha máxima (hoy) para el campo de fecha
document.addEventListener('DOMContentLoaded', function() {
    const fechaNacimiento = document.getElementById('fecha_nacimiento');
    const hoy = new Date().toISOString().split('T')[0];
    fechaNacimiento.setAttribute('max', hoy);
    
    // Establecer fecha mínima (120 años atrás)
    const fechaMinima = new Date();
    fechaMinima.setFullYear(fechaMinima.getFullYear() - 120);
    fechaNacimiento.setAttribute('min', fechaMinima.toISOString().split('T')[0]);
    
    cargarUsuarios();
});

document.getElementById('userForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const crearBtn = document.getElementById('crearBtn');
    const mensaje = document.getElementById('mensaje');
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    
    // Validar fecha de nacimiento
    const validacion = validarFechaNacimiento(fechaNacimiento);
    if (!validacion.valida) {
        mensaje.innerHTML = `<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Error: ${validacion.mensaje}
        </div>`;
        return;
    }
    
    // Deshabilitar el botón durante el envío
    crearBtn.disabled = true;
    crearBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Creando...';
    
    // Obtener los datos del formulario
    const formData = new FormData();
    formData.append('nombre', document.getElementById('nombre').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('fecha_nacimiento', fechaNacimiento);
    
    try {
        const response = await fetch('./guardar.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            mensaje.innerHTML = `<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                ${result.message}
                <div class="mt-2">
                    <small><i class="bi bi-info-circle me-1"></i>Edad calculada: ${validacion.edad} años</small>
                </div>
            </div>`;
            document.getElementById('userForm').reset();
            // Cargar y mostrar la tabla actualizada de usuarios
            await cargarUsuarios();
        } else {
            mensaje.innerHTML = `<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Error: ${result.error || 'Error desconocido'}
            </div>`;
        }
    } catch (error) {
        mensaje.innerHTML = `<div class="alert alert-danger" role="alert">
            <i class="bi bi-wifi-off me-2"></i>
            Error de conexión: ${error.message}
        </div>`;
    } finally {
        // Rehabilitar el botón
        crearBtn.disabled = false;
        crearBtn.innerHTML = '<i class="bi bi-check2"></i>Crear Usuario';
    }
});
</script>
</body>
</html>