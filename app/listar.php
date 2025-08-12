<?php
require_once '../conexion/db.php';

$sql = "SELECT * FROM usuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Listar Usuarios</title>
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
      
      .btn-danger {
        background: var(--danger-color);
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
      }
      
      .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px -3px rgba(239, 68, 68, 0.3);
      }
      
      .btn-sm {
        padding: 8px 16px;
        font-size: 0.875rem;
        border-radius: 8px;
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
      
      .badge {
        background: var(--primary-color) !important;
        color: var(--white);
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 500;
      }
      
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
            <i class="bi bi-people me-3"></i>Lista de Usuarios
        </h1>
        
        <div class="mb-4 text-center">
            <span class="badge fs-6">
                Total: <?php echo count($usuarios); ?> usuario<?php echo count($usuarios) != 1 ? 's' : ''; ?>
            </span>
        </div>

        <div class="table-responsive">
            <table class="table" id="tabla-usuarios">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash me-1"></i>ID</th>
                        <th><i class="bi bi-person me-1"></i>Nombre</th>
                        <th><i class="bi bi-envelope me-1"></i>Email</th>
                        <th><i class="bi bi-calendar-date me-1"></i>Edad</th>
                        <th><i class="bi bi-gear me-1"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($usuarios) > 0): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr id="fila-<?php echo htmlspecialchars($usuario['id']); ?>">
                                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td>
                                        <?php 
                                        if (!empty($usuario['fecha_nacimiento'])) {
                                            $fechaNac = new DateTime($usuario['fecha_nacimiento']);
                                            $hoy = new DateTime();
                                            $edad = $hoy->diff($fechaNac)->y;
                                            echo '<span class="badge bg-info bg-opacity-10 text-info">' . $edad . ' años</span>';
                                            echo '<br><small class="text-muted">' . $fechaNac->format('d F Y') . '</small>';
                                        } else {
                                            echo '<span class="badge bg-secondary bg-opacity-10 text-secondary">No especificada</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm btn-editar-usuario me-1"
                                            data-id="<?php echo htmlspecialchars($usuario['id']); ?>"
                                        >
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm btn-eliminar-usuario"
                                            data-id="<?php echo htmlspecialchars($usuario['id']); ?>"
                                            data-nombre="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                                        >
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <p class="mb-3 text-muted">No hay usuarios registrados</p>
                                <a href="crear.php" class="btn btn-primary">
                                    <i class="bi bi-plus me-2"></i>Crear primer usuario
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="../index.html" class="btn btn-secondary me-3">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="crear.php" class="btn btn-primary">
                <i class="bi bi-plus"></i> Nuevo Usuario
            </a>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script src="../public/lib/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Modal para editar
    const modal = new bootstrap.Modal(document.getElementById('editarUsuario'));
    
    // Configuración de SweetAlert2 con tema moderno
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: 'var(--white)',
        color: 'var(--text-dark)',
        iconColor: 'var(--success-color)'
    });
    
    // Event listener para la tabla
    document.getElementById('tabla-usuarios').addEventListener('click', function(e) {
        
        // Botón editar - buscar el botón padre si se hace clic en el icono
        const editBtn = e.target.closest('.btn-editar-usuario');
        if (editBtn) {
            const id = editBtn.dataset.id;
            cargarUsuario(id);
        }
        
        // Botón eliminar - buscar el botón padre si se hace clic en el icono
        const deleteBtn = e.target.closest('.btn-eliminar-usuario');
        if (deleteBtn) {
            const id = deleteBtn.dataset.id;
            const nombre = deleteBtn.dataset.nombre;
            eliminarUsuario(id, nombre);
        }
    });
    
    // Botón actualizar
    document.getElementById('btn-actualizar').addEventListener('click', function() {
        actualizarUsuario();
    });
    
    // Función para cargar datos del usuario
    function cargarUsuario(id) {
        console.log('Cargando usuario con ID:', id);
        
        // Mostrar loading
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo datos del usuario',
            allowOutsideClick: false,
            showConfirmButton: false,
            background: 'var(--white)',
            color: 'var(--text-dark)',
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('buscarid.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(usuario => {
            console.log('Usuario cargado:', usuario);
            Swal.close();
            
            document.getElementById('id').value = usuario.id;
            document.getElementById('nombre').value = usuario.nombre;
            document.getElementById('email').value = usuario.email;
            document.getElementById('fecha_nacimiento').value = usuario.fecha_nacimiento || '';
            
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar usuario:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar los datos del usuario',
                background: 'var(--white)',
                color: 'var(--text-dark)',
                confirmButtonColor: 'var(--danger-color)'
            });
        });
    }
    
    // Función para eliminar usuario
    function eliminarUsuario(id, nombre) {
        Swal.fire({
            title: '¿Eliminar usuario?',
            html: `¿Estás seguro de eliminar a "<strong>${nombre}</strong>"?<br><small class="text-muted">Esta acción no se puede deshacer</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--danger-color)',
            cancelButtonColor: 'var(--secondary-color)',
            confirmButtonText: '<i class="bi bi-trash"></i> Sí, eliminar',
            cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
            background: 'var(--white)',
            color: 'var(--text-dark)'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading durante eliminación
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Procesando solicitud',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: 'var(--white)',
                    color: 'var(--text-dark)',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                fetch('eliminar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: data.message || 'Usuario eliminado correctamente'
                        });
                        // Remover la fila de la tabla
                        const fila = document.getElementById('fila-' + id);
                        if (fila) {
                            fila.remove();
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error || 'Error al eliminar el usuario',
                            background: 'var(--white)',
                            color: 'var(--text-dark)',
                            confirmButtonColor: 'var(--danger-color)'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar usuario:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la solicitud',
                        background: 'var(--white)',
                        color: 'var(--text-dark)',
                        confirmButtonColor: 'var(--danger-color)'
                    });
                });
            }
        });
    }
    
    // Función para actualizar usuario
    function actualizarUsuario() {
        const id = document.getElementById('id').value;
        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        const fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
        
        // Validar campos
        if (!nombre || !email || !fecha_nacimiento) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor completa todos los campos',
                background: 'var(--white)',
                color: 'var(--text-dark)',
                confirmButtonColor: 'var(--primary-color)'
            });
            return;
        }
        
        // Validar que la fecha no sea futura
        const fechaNac = new Date(fecha_nacimiento);
        const hoy = new Date();
        if (fechaNac > hoy) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha inválida',
                text: 'La fecha de nacimiento no puede ser futura',
                background: 'var(--white)',
                color: 'var(--text-dark)',
                confirmButtonColor: 'var(--primary-color)'
            });
            return;
        }
        
        console.log('Actualizando usuario:', { id, nombre, email, fecha_nacimiento });
        
        // Mostrar loading
        const btnActualizar = document.getElementById('btn-actualizar');
        const originalText = btnActualizar.innerHTML;
        btnActualizar.innerHTML = '<i class="bi bi-arrow-repeat"></i> Actualizando...';
        btnActualizar.disabled = true;
        
        fetch('actualizar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, nombre, email, fecha_nacimiento })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
            if (data.success) {
                modal.hide();
                Toast.fire({
                    icon: 'success',
                    title: data.message || 'Usuario actualizado correctamente'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || 'Error al actualizar el usuario',
                    background: 'var(--white)',
                    color: 'var(--text-dark)',
                    confirmButtonColor: 'var(--danger-color)'
                });
            }
        })
        .catch(error => {
            console.error('Error al actualizar usuario:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al procesar la solicitud',
                background: 'var(--white)',
                color: 'var(--text-dark)',
                confirmButtonColor: 'var(--danger-color)'
            });
        })
        .finally(() => {
            btnActualizar.innerHTML = originalText;
            btnActualizar.disabled = false;
        });
    }
</script>
</body>
</html>