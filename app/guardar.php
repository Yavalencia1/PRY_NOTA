<?php
header('Content-Type: application/json');
require_once '../conexion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        
        // Validaciones
        if (empty($nombre) || empty($email) || empty($fecha_nacimiento)) {
            echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Email no válido']);
            exit;
        }
        
        // Validar fecha de nacimiento
        $hoy = new DateTime();
        $fechaNac = new DateTime($fecha_nacimiento);
        
        if ($fechaNac > $hoy) {
            echo json_encode(['success' => false, 'error' => 'La fecha de nacimiento no puede ser futura']);
            exit;
        }
        
        $edad = $hoy->diff($fechaNac)->y;
        
        if ($edad > 120) {
            echo json_encode(['success' => false, 'error' => 'La edad no puede ser mayor a 120 años']);
            exit;
        }
        
        if ($edad < 1) {
            echo json_encode(['success' => false, 'error' => 'La persona debe tener al menos 1 año']);
            exit;
        }
        
        // Verificar si el email ya existe
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'error' => 'El email ya está registrado']);
            exit;
        }
        
        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, fecha_nacimiento) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $fecha_nacimiento]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Usuario creado exitosamente',
            'edad_calculada' => $edad
        ]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
