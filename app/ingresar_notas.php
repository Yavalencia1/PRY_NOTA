<?php

// conexion a base de datos con conexion/db.php
require_once '../conexion/db.php';
// consultar los usuarios de la base de datos
$sql = "SELECT * FROM usuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// retornar los usuarios en formato json

// consultar las materias de la base de datos
$sql_materias = "SELECT * FROM materias";
$stmt_materias = $conn->prepare($sql_materias);
$stmt_materias->execute();
$materias = $stmt_materias->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Notas</title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      
      .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid var(--border-color);
        padding: 14px 16px;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        background: var(--white);
      }
      
      .form-control:focus, .form-select:focus {
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
      }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="main-container p-5">
        <h1 class="title display-5">
            <i class="bi bi-journal-plus me-3"></i>Ingresar Notas
        </h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                ¡Notas guardadas correctamente!
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Error: <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        
        <form action="./guardar_notas.php" method="POST">
            <div class="mb-4">
                <label for="usuario" class="form-label">
                    <i class="bi bi-person"></i>Seleccionar Usuario
                </label>
                <select id="usuario" name="usuario" class="form-select" required>
                    <option value="">-- Elige un usuario --</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo htmlspecialchars($usuario['id']); ?>">
                            <?php echo htmlspecialchars($usuario['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="materia" class="form-label">
                    <i class="bi bi-book"></i>Seleccionar Materia
                </label>
                <select id="materia" name="materia" class="form-select" required>
                    <option value="">-- Elige una materia --</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo htmlspecialchars($materia['id']); ?>">
                            <?php echo htmlspecialchars($materia['nombre']); ?> (NRC: <?php echo htmlspecialchars($materia['nrc']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label mb-3">
                    <i class="bi bi-star"></i>Calificaciones de Parciales
                </label>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <label for="nota1" class="form-label">Parcial 1</label>
                        <input type="number" name="nota_1" id="nota1" class="form-control"
                               step="0.01" min="0" max="20" placeholder="0.00" required>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="nota2" class="form-label">Parcial 2</label>
                        <input type="number" name="nota_2" id="nota2" class="form-control"
                               step="0.01" min="0" max="20" placeholder="0.00" required>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="nota3" class="form-label">Parcial 3</label>
                        <input type="number" name="nota_3" id="nota3" class="form-control"
                               step="0.01" min="0" max="20" placeholder="0.00" required>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary me-3">
                    <i class="bi bi-save"></i>Guardar Notas
                </button>
                <a href="../index.html" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>
<script src="../public/lib/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Configuración de SweetAlert2 con tema moderno
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: 'var(--white)',
        color: 'var(--text-dark)',
        iconColor: 'var(--danger-color)'
    });

    // Función para validar nota máxima
    function validarNotaMaxima(input) {
        const valor = parseFloat(input.value);
        
        if (valor > 20) {
            // Mostrar alerta con SweetAlert2
            Swal.fire({
                icon: 'error',
                title: '¡Nota inválida!',
                text: 'La nota no puede ser mayor a 20.00',
                background: 'var(--white)',
                color: 'var(--text-dark)',
                confirmButtonColor: 'var(--danger-color)',
                confirmButtonText: 'Entendido'
            });
            
            // Resetear el valor a 20
            input.value = '20.00';
            input.focus();
            return false;
        }
        
        if (valor < 0) {
            Swal.fire({
                icon: 'error',
                title: '¡Nota inválida!',
                text: 'La nota no puede ser menor a 0.00',
                background: 'var(--white)',
                color: 'var(--text-dark)',
                confirmButtonColor: 'var(--danger-color)',
                confirmButtonText: 'Entendido'
            });
            
            input.value = '0.00';
            input.focus();
            return false;
        }
        
        return true;
    }
    
    // Función para validar decimales y formato
    function validarFormatoNota(input) {
        let valor = input.value;
        
        // Validar máximo 2 decimales
        if (valor.includes('.')) {
            const partes = valor.split('.');
            if (partes[1] && partes[1].length > 2) {
                input.value = parseFloat(valor).toFixed(2);
            }
        }
    }
    
    // Función para mostrar toast de error
    function mostrarToastError(mensaje) {
        Toast.fire({
            icon: 'error',
            title: mensaje
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const nota1 = document.getElementById('nota1');
        const nota2 = document.getElementById('nota2');
        const nota3 = document.getElementById('nota3');
        const camposNotas = [nota1, nota2, nota3];
        
        // Agregar eventos de validación en tiempo real a cada campo
        camposNotas.forEach((campo, index) => {
            // Validación al escribir (input event)
            campo.addEventListener('input', function() {
                validarFormatoNota(this);
            });
            
            // Validación al perder el foco (blur event)
            campo.addEventListener('blur', function() {
                if (this.value && !isNaN(this.value)) {
                    const valor = parseFloat(this.value);
                    
                    // Validar rango
                    if (!validarNotaMaxima(this)) {
                        return;
                    }
                    
                    // Formatear a 2 decimales
                    this.value = valor.toFixed(2);
                }
            });
            
            // Validación al cambiar valor (change event)
            campo.addEventListener('change', function() {
                if (this.value && !isNaN(this.value)) {
                    validarNotaMaxima(this);
                }
            });
        });
        
        // Validación antes de enviar el formulario
        form.addEventListener('submit', function(e) {
            const notas = [nota1.value, nota2.value, nota3.value];
            let hayError = false;
            let errores = [];
            
            notas.forEach((nota, index) => {
                const valor = parseFloat(nota);
                const parcial = index + 1;
                
                if (isNaN(valor)) {
                    hayError = true;
                    errores.push(`La nota del Parcial ${parcial} debe ser un número válido`);
                } else if (valor > 20) {
                    hayError = true;
                    errores.push(`La nota del Parcial ${parcial} no puede ser mayor a 20.00`);
                } else if (valor < 0) {
                    hayError = true;
                    errores.push(`La nota del Parcial ${parcial} no puede ser menor a 0.00`);
                }
            });
            
            if (hayError) {
                e.preventDefault();
                
                // Mostrar todos los errores en una sola alerta
                Swal.fire({
                    icon: 'error',
                    title: '¡Errores en las notas!',
                    html: '<ul style="text-align: left; margin: 0; padding-left: 20px;">' + 
                          errores.map(error => `<li>${error}</li>`).join('') + 
                          '</ul>',
                    background: 'var(--white)',
                    color: 'var(--text-dark)',
                    confirmButtonColor: 'var(--danger-color)',
                    confirmButtonText: 'Corregir'
                });
            } else {
                // Si no hay errores, mostrar confirmación
                e.preventDefault();
                
                Swal.fire({
                    icon: 'question',
                    title: '¿Confirmar notas?',
                    html: `<strong>Usuario:</strong> ${document.getElementById('usuario').selectedOptions[0].text}<br>
                           <strong>Materia:</strong> ${document.getElementById('materia').selectedOptions[0].text}<br><br>
                           <strong>Parcial 1:</strong> ${nota1.value}<br>
                           <strong>Parcial 2:</strong> ${nota2.value}<br>
                           <strong>Parcial 3:</strong> ${nota3.value}`,
                    showCancelButton: true,
                    confirmButtonColor: 'var(--success-color)',
                    cancelButtonColor: 'var(--secondary-color)',
                    confirmButtonText: '<i class="bi bi-check-circle"></i> Sí, guardar',
                    cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
                    background: 'var(--white)',
                    color: 'var(--text-dark)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar el formulario
                        form.submit();
                    }
                });
            }
        });
        
        // Prevenir entrada de caracteres no numéricos
        camposNotas.forEach(campo => {
            campo.addEventListener('keypress', function(e) {
                // Permitir: números, punto decimal, teclas de control
                if (!/[0-9.]/.test(e.key) && 
                    !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)) {
                    e.preventDefault();
                    mostrarToastError('Solo se permiten números y punto decimal');
                }
                
                // Permitir solo un punto decimal
                if (e.key === '.' && this.value.includes('.')) {
                    e.preventDefault();
                    mostrarToastError('Solo se permite un punto decimal');
                }
            });
        });
    });
</script>
</body>
</html>