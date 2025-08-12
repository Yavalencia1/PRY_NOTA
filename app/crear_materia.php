<?php
require_once '../conexion/db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Crear Materia</title>
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
                <i class="bi bi-plus-circle-fill me-3"></i>Crear Nueva Materia
            </h1>

            <form id="form-materia">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-journal-text"></i>
                            Nombre de la Materia
                        </label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                               placeholder="Ej: Programación Web" maxlength="100">
                    </div>
                    <div class="col-md-6">
                        <label for="nrc" class="form-label">
                            <i class="bi bi-hash"></i>
                            Código NRC
                        </label>
                        <input type="text" class="form-control" id="nrc" name="nrc" required
                               placeholder="Ej: 25190" pattern="[0-9]{5}" maxlength="5">
                        <div class="form-text">El NRC debe tener exactamente 5 dígitos</div>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Crear Materia
                    </button>
                    <a href="listar_materias.php" class="btn btn-secondary">
                        <i class="bi bi-list-ul"></i>
                        Ver Materias
                    </a>
                    <a href="../index.html" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Volver al Menú
                    </a>
                </div>
            </form>
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
            iconColor: 'var(--success-color)'
        });
        
        // Crear materia
        document.getElementById('form-materia').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Mostrar loading
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Creando...';
            submitBtn.disabled = true;
            
            fetch('guardar_materia.php', {
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
                        // Limpiar formulario
                        this.reset();
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
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
        
        // Validar solo números en NRC
        function validarNRC(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            if (input.value.length > 5) {
                input.value = input.value.slice(0, 5);
            }
        }
        
        document.getElementById('nrc').addEventListener('input', function(e) {
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
