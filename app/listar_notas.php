<?php
require_once '../conexion/db.php';

// Consulta con JOIN para obtener nombres de usuarios y materias
$sql = "SELECT n.id, n.n1, n.n2, n3, n.promedio, 
               u.nombre as usuario_nombre, 
               m.nombre as materia_nombre,
               m.nrc as materia_nrc
        FROM notas n
        INNER JOIN usuarios u ON n.usuario_id = u.id
        INNER JOIN materias m ON n.materia_id = m.id
        ORDER BY u.nombre, m.nombre";

$stmt = $conn->prepare($sql);
$stmt->execute();
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Listar Notas</title>
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
      
      .promedio-excelente { 
        color: var(--success-color) !important; 
        font-weight: bold; 
      }
      
      .promedio-malo { 
        color: var(--danger-color) !important; 
        font-weight: bold; 
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
            <i class="bi bi-clipboard-data me-3"></i>Lista de Notas
        </h1>
        
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <span class="badge fs-6">
                Total: <?php echo count($notas); ?> registro<?php echo count($notas) != 1 ? 's' : ''; ?>
            </span>
            <a href="ingresar_notas.php" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Ingresar Nueva Nota
            </a>
        </div>

        <div class="table-responsive">
            <table class="table" id="tabla-notas">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash me-1"></i>ID</th>
                        <th><i class="bi bi-person me-1"></i>Usuario</th>
                        <th><i class="bi bi-book me-1"></i>Materia</th>
                        <th><i class="bi bi-code me-1"></i>NRC</th>
                        <th><i class="bi bi-1-circle me-1"></i>Parcial 1</th>
                        <th><i class="bi bi-2-circle me-1"></i>Parcial 2</th>
                        <th><i class="bi bi-3-circle me-1"></i>Parcial 3</th>
                        <th><i class="bi bi-graph-up me-1"></i>Promedio</th>
                        <th><i class="bi bi-check-circle me-1"></i>Estado</th>
                        <th><i class="bi bi-gear me-1"></i>Acciones</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php if (count($notas) > 0): ?>
                            <?php foreach ($notas as $nota): ?>
                                <?php 
                                    $promedio = floatval($nota['promedio']);
                                    $clase_promedio = '';
                                    $estado = '';
                                    
                                    if ($promedio >= 14) {
                                        $clase_promedio = 'promedio-excelente';
                                        $estado = '<span class="badge bg-success">Aprobado</span>';
                                    } else {
                                        $clase_promedio = 'promedio-malo';
                                        $estado = '<span class="badge bg-danger">Reprobado</span>';
                                    }
                                ?>
                                <tr id="fila-<?php echo htmlspecialchars($nota['id']); ?>">
                                    <td><?php echo htmlspecialchars($nota['id']); ?></td>
                                    <td>
                                        <i class="bi bi-person-fill text-primary me-1"></i>
                                        <?php echo htmlspecialchars($nota['usuario_nombre']); ?>
                                    </td>
                                    <td>
                                        <i class="bi bi-book-fill text-success me-1"></i>
                                        <?php echo htmlspecialchars($nota['materia_nombre']); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($nota['materia_nrc']); ?></span>
                                    </td>
                                    <td><?php echo number_format($nota['n1'], 2); ?></td>
                                    <td><?php echo number_format($nota['n2'], 2); ?></td>
                                    <td><?php echo number_format($nota['n3'], 2); ?></td>
                                    <td class="<?php echo $clase_promedio; ?>">
                                        <?php echo number_format($promedio, 2); ?>
                                    </td>
                                    <td><?php echo $estado; ?></td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm btn-editar-nota me-1"
                                            data-id="<?php echo htmlspecialchars($nota['id']); ?>"
                                            title="Editar nota"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm btn-eliminar-nota"
                                            data-id="<?php echo htmlspecialchars($nota['id']); ?>"
                                            data-usuario="<?php echo htmlspecialchars($nota['usuario_nombre']); ?>"
                                            data-materia="<?php echo htmlspecialchars($nota['materia_nombre']); ?>"
                                            title="Eliminar nota"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="bi bi-clipboard-x display-4 text-muted"></i>
                                    <p class="mt-3 text-muted">No hay notas registradas</p>
                                    <a href="ingresar_notas.php" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Ingresar primera nota
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="../index.html" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar nota -->
<div class="modal fade" id="editarNota" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil"></i> Editar Nota
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="nota_id">
                
                <!-- Selección de Usuario y Materia -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="edit_usuario_id" class="form-label">
                                <i class="bi bi-person me-1"></i>Usuario
                            </label>
                            <select class="form-select" id="edit_usuario_id" required>
                                <option value="">Seleccionar usuario...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="edit_materia_id" class="form-label">
                                <i class="bi bi-book me-1"></i>Materia
                            </label>
                            <select class="form-select" id="edit_materia_id" required>
                                <option value="">Seleccionar materia...</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Separador visual -->
                <hr class="my-4">
                
                <!-- Calificaciones -->
                <h6 class="mb-3">
                    <i class="bi bi-clipboard-data me-1"></i>Calificaciones
                </h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="edit_n1" class="form-label">Parcial 1</label>
                            <input type="number" class="form-control" id="edit_n1" 
                                   step="0.01" min="0" max="20" 
                                   pattern="[0-9]+([.,][0-9]{1,2})?" title="Máximo 2 decimales"
                                   oninput="validarDecimalesModal(this)" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="edit_n2" class="form-label">Parcial 2</label>
                            <input type="number" class="form-control" id="edit_n2" 
                                   step="0.01" min="0" max="20"
                                   pattern="[0-9]+([.,][0-9]{1,2})?" title="Máximo 2 decimales"
                                   oninput="validarDecimalesModal(this)" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="edit_n3" class="form-label">Parcial 3</label>
                            <input type="number" class="form-control" id="edit_n3" 
                                   step="0.01" min="0" max="20"
                                   pattern="[0-9]+([.,][0-9]{1,2})?" title="Máximo 2 decimales"
                                   oninput="validarDecimalesModal(this)" required>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    El promedio se calculará automáticamente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar-nota">
                    <i class="bi bi-save"></i> Actualizar Nota
                </button>
            </div>
        </div>
    </div>
</div>

<script src="../public/lib/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Función para validar decimales en modal
    function validarDecimalesModal(input) {
        let valor = input.value;
        
        // Limitar a máximo 20
        if (parseFloat(valor) > 20) {
            input.value = '20.00';
            Swal.fire('Atención', 'La nota máxima permitida es 20.00', 'warning');
            return;
        }
        
        // Limitar a mínimo 0
        if (parseFloat(valor) < 0) {
            input.value = '0.00';
            Swal.fire('Atención', 'La nota mínima permitida es 0.00', 'warning');
            return;
        }
        
        // Validar máximo 2 decimales
        if (valor.includes('.')) {
            const partes = valor.split('.');
            if (partes[1] && partes[1].length > 2) {
                input.value = parseFloat(valor).toFixed(2);
            }
        }
    }
    
    // Modal para editar
    const modal = new bootstrap.Modal(document.getElementById('editarNota'));
    
    // Cargar usuarios y materias al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        cargarUsuarios();
        cargarMaterias();
    });
    
    // Función para cargar usuarios
    function cargarUsuarios() {
        fetch('obtener_usuarios.php')
        .then(response => response.json())
        .then(usuarios => {
            const select = document.getElementById('edit_usuario_id');
            select.innerHTML = '<option value="">Seleccionar usuario...</option>';
            
            usuarios.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.id;
                option.textContent = usuario.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar usuarios:', error);
            Swal.fire('Error', 'Error al cargar la lista de usuarios', 'error');
        });
    }
    
    // Función para cargar materias
    function cargarMaterias() {
        fetch('obtener_materias.php')
        .then(response => response.json())
        .then(materias => {
            const select = document.getElementById('edit_materia_id');
            select.innerHTML = '<option value="">Seleccionar materia...</option>';
            
            materias.forEach(materia => {
                const option = document.createElement('option');
                option.value = materia.id;
                option.textContent = `${materia.nombre} (NRC: ${materia.nrc})`;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar materias:', error);
            Swal.fire('Error', 'Error al cargar la lista de materias', 'error');
        });
    }
    
    // Event listener para la tabla
    document.getElementById('tabla-notas').addEventListener('click', function(e) {
        
        // Botón editar
        const editBtn = e.target.closest('.btn-editar-nota');
        if (editBtn) {
            const id = editBtn.dataset.id;
            cargarNota(id);
        }
        
        // Botón eliminar
        const deleteBtn = e.target.closest('.btn-eliminar-nota');
        if (deleteBtn) {
            const id = deleteBtn.dataset.id;
            const usuario = deleteBtn.dataset.usuario;
            const materia = deleteBtn.dataset.materia;
            eliminarNota(id, usuario, materia);
        }
    });
    
    // Botón actualizar
    document.getElementById('btn-actualizar-nota').addEventListener('click', function() {
        actualizarNota();
    });
    
    // Formatear a 2 decimales al perder el foco en campos del modal
    ['edit_n1', 'edit_n2', 'edit_n3'].forEach(id => {
        document.getElementById(id).addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    });
    
    // Función para cargar datos de la nota
    function cargarNota(id) {
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo datos de la nota',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('buscarid_nota.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(nota => {
            Swal.close();
            
            document.getElementById('nota_id').value = nota.id;
            document.getElementById('edit_usuario_id').value = nota.usuario_id;
            document.getElementById('edit_materia_id').value = nota.materia_id;
            document.getElementById('edit_n1').value = parseFloat(nota.n1).toFixed(2);
            document.getElementById('edit_n2').value = parseFloat(nota.n2).toFixed(2);
            document.getElementById('edit_n3').value = parseFloat(nota.n3).toFixed(2);
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al cargar los datos de la nota', 'error');
        });
    }
    
    // Función para eliminar nota
    function eliminarNota(id, usuario, materia) {
        Swal.fire({
            title: '¿Eliminar nota?',
            html: `<strong>Usuario:</strong> ${usuario}<br><strong>Materia:</strong> ${materia}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('eliminar_nota.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', data.message, 'success');
                        document.getElementById('fila-' + id).remove();
                    } else {
                        Swal.fire('Error', data.error, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Error al eliminar la nota', 'error');
                });
            }
        });
    }
    
    // Función para actualizar nota
    function actualizarNota() {
        const id = document.getElementById('nota_id').value;
        const usuario_id = document.getElementById('edit_usuario_id').value;
        const materia_id = document.getElementById('edit_materia_id').value;
        const n1 = parseFloat(document.getElementById('edit_n1').value);
        const n2 = parseFloat(document.getElementById('edit_n2').value);
        const n3 = parseFloat(document.getElementById('edit_n3').value);
        
        // Validar que se hayan seleccionado usuario y materia
        if (!usuario_id || !materia_id) {
            Swal.fire('Error', 'Debe seleccionar un usuario y una materia', 'error');
            return;
        }
        
        // Validar que sean números válidos
        if (isNaN(n1) || isNaN(n2) || isNaN(n3)) {
            Swal.fire('Error', 'Todas las notas deben ser números válidos', 'error');
            return;
        }
        
        // Validar rango
        if (n1 > 20 || n2 > 20 || n3 > 20 || n1 < 0 || n2 < 0 || n3 < 0) {
            Swal.fire('Error', 'Las notas deben estar entre 0 y 20', 'error');
            return;
        }
        
        // Validar máximo 2 decimales
        const validarDecimales = (num) => {
            const str = num.toString();
            return !str.includes('.') || str.split('.')[1].length <= 2;
        };
        
        if (!validarDecimales(n1) || !validarDecimales(n2) || !validarDecimales(n3)) {
            Swal.fire('Error', 'Las notas pueden tener máximo 2 decimales', 'error');
            return;
        }
        
        // Mostrar loading
        const btnActualizar = document.getElementById('btn-actualizar-nota');
        const originalText = btnActualizar.innerHTML;
        btnActualizar.innerHTML = '<i class="bi bi-arrow-repeat"></i> Actualizando...';
        btnActualizar.disabled = true;
        
        fetch('actualizar_nota.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, usuario_id, materia_id, n1, n2, n3 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Actualizado', 'Nota actualizada correctamente', 'success');
                modal.hide();
                location.reload();
            } else {
                Swal.fire('Error', data.error, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al actualizar la nota', 'error');
        })
        .finally(() => {
            btnActualizar.innerHTML = originalText;
            btnActualizar.disabled = false;
        });
    }
</script>
</body>
</html>
