<?php
require_once '../conexion/db.php';

// Obtener todas las materias para mostrar en la tabla
$sql = "SELECT * FROM materias ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Listar Materias</title>
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
      
      .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
      }
      
      .action-buttons .btn {
        padding: 6px 12px;
        font-size: 0.8rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
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
        
        .action-buttons {
          flex-direction: column;
          gap: 4px;
        }
      }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="main-container p-5">
            <h1 class="title display-5">
                <i class="bi bi-list-ul me-3"></i>Lista de Materias
            </h1>

            <div class="d-flex justify-content-center mb-4">
                <a href="crear_materia.php" class="btn btn-primary me-3">
                    <i class="bi bi-plus-circle"></i>
                    Nueva Materia
                </a>
                <a href="../index.html" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Volver al Menú
                </a>
            </div>

            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        Materias Registradas
                    </h4>
                    <span class="badge bg-light text-dark fs-6"><?php echo count($materias); ?> registrada<?php echo count($materias) != 1 ? 's' : ''; ?></span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="tabla-materias">
                        <thead>
                            <tr>
                                <th width="15%">
                                    <i class="bi bi-hash me-2"></i>ID
                                </th>
                                <th width="50%">
                                    <i class="bi bi-journal-text me-2"></i>Nombre de la Materia
                                </th>
                                <th width="20%">
                                    <i class="bi bi-code-square me-2"></i>Código NRC
                                </th>
                                <th width="15%">
                                    <i class="bi bi-gear me-2"></i>Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($materias) > 0): ?>
                                <?php foreach ($materias as $materia): ?>
                                    <tr id="fila-<?php echo $materia['id']; ?>">
                                        <td class="fw-bold text-primary"><?php echo htmlspecialchars($materia['id']); ?></td>
                                        <td class="fw-medium"><?php echo htmlspecialchars($materia['nombre']); ?></td>
                                        <td>
                                            <span class="badge bg-primary fs-6">
                                                <?php echo htmlspecialchars($materia['nrc']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" class="btn btn-primary btn-sm btn-editar"
                                                        data-id="<?php echo $materia['id']; ?>"
                                                        data-nombre="<?php echo htmlspecialchars($materia['nombre']); ?>"
                                                        data-nrc="<?php echo htmlspecialchars($materia['nrc']); ?>"
                                                        title="Editar materia">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="eliminarMateria(<?php echo $materia['id']; ?>, '<?php echo htmlspecialchars($materia['nombre']); ?>')"
                                                        title="Eliminar materia">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                            <h5>No hay materias registradas</h5>
                                            <p class="mb-3">Crea la primera materia para comenzar</p>
                                            <a href="crear_materia.php" class="btn btn-primary">
                                                <i class="bi bi-plus-circle"></i>
                                                Crear Primera Materia
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar materia -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Editar Materia
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-editar">
                        <input type="hidden" id="edit-id">
                        <div class="mb-4">
                            <label for="edit-nombre" class="form-label">
                                <i class="bi bi-journal-text"></i>
                                Nombre de la Materia
                            </label>
                            <input type="text" class="form-control" id="edit-nombre" required maxlength="100">
                        </div>
                        <div class="mb-4">
                            <label for="edit-nrc" class="form-label">
                                <i class="bi bi-hash"></i>
                                Código NRC
                            </label>
                            <input type="text" class="form-control" id="edit-nrc" required 
                                   pattern="[0-9]{5}" maxlength="5">
                            <div class="form-text">El NRC debe tener exactamente 5 dígitos</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-actualizar">
                        <i class="bi bi-check2-circle"></i>
                        Actualizar Materia
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="../public/lib/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
        
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
        
        // Event listeners para la tabla
        document.getElementById('tabla-materias').addEventListener('click', function(e) {
            // Editar materia
            const btnEditar = e.target.closest('.btn-editar');
            if (btnEditar) {
                const id = btnEditar.dataset.id;
                const nombre = btnEditar.dataset.nombre;
                const nrc = btnEditar.dataset.nrc;
                
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nombre').value = nombre;
                document.getElementById('edit-nrc').value = nrc;
                
                modalEditar.show();
            }
        });
        
        // Actualizar materia
        document.getElementById('btn-actualizar').addEventListener('click', function() {
            const id = document.getElementById('edit-id').value;
            const nombre = document.getElementById('edit-nombre').value.trim();
            const nrc = document.getElementById('edit-nrc').value.trim();
            
            if (!nombre || !nrc) {
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
            
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Actualizando...';
            this.disabled = true;
            
            const formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('nrc', nrc);
            
            fetch('actualizar_materia.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalEditar.hide();
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error,
                        background: 'var(--white)',
                        color: 'var(--text-dark)',
                        confirmButtonColor: 'var(--primary-color)'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud',
                    background: 'var(--white)',
                    color: 'var(--text-dark)',
                    confirmButtonColor: 'var(--primary-color)'
                });
            })
            .finally(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
        
        // Función para eliminar materia
        function eliminarMateria(id, nombre) {
            Swal.fire({
                title: '¿Eliminar materia?',
                html: `¿Estás seguro de eliminar "<strong>${nombre}</strong>"?<br><small class="text-muted">Esta acción no se puede deshacer</small>`,
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
                    const formData = new FormData();
                    formData.append('id', id);
                    
                    fetch('eliminar_materia.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error,
                                background: 'var(--white)',
                                color: 'var(--text-dark)',
                                confirmButtonColor: 'var(--primary-color)'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud',
                            background: 'var(--white)',
                            color: 'var(--text-dark)',
                            confirmButtonColor: 'var(--primary-color)'
                        });
                    });
                }
            });
        }
        
        // Validar solo números en NRC
        function validarNRC(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            if (input.value.length > 5) {
                input.value = input.value.slice(0, 5);
            }
        }
        
        document.getElementById('edit-nrc').addEventListener('input', function(e) {
            validarNRC(this);
        });
        
        // Animación de loading para botones
        const style = document.createElement('style');
        style.textContent = `
            .spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
