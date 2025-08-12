<?php
header('Content-Type: application/json');
require_once '../conexion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $id = $input['id'] ?? '';
        $nombre = $input['nombre'] ?? '';
        $email = $input['email'] ?? '';
        $fecha_nacimiento = $input['fecha_nacimiento'] ?? '';
        
        // Validaciones
        if (empty($id) || empty($nombre) || empty($email) || empty($fecha_nacimiento)) {
            echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Email no válido']);
            exit;
        }
        
        // Validar fecha de nacimiento
        $fecha = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        if (!$fecha || $fecha->format('Y-m-d') !== $fecha_nacimiento) {
            echo json_encode(['success' => false, 'error' => 'Fecha de nacimiento no válida']);
            exit;
        }
        
        // Verificar que la fecha no sea futura
        $hoy = new DateTime();
        if ($fecha > $hoy) {
            echo json_encode(['success' => false, 'error' => 'La fecha de nacimiento no puede ser futura']);
            exit;
        }
        
        // Verificar que la persona no sea mayor a 120 años
        $edad = $hoy->diff($fecha)->y;
        if ($edad > 120) {
            echo json_encode(['success' => false, 'error' => 'La edad calculada no puede ser mayor a 120 años']);
            exit;
        }
        
        // Verificar si el email ya existe en otro usuario
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'error' => 'El email ya está registrado por otro usuario']);
            exit;
        }
        
        // Actualizar usuario
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, fecha_nacimiento = ? WHERE id = ?");
        $result = $stmt->execute([$nombre, $email, $fecha_nacimiento, $id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el usuario o no se realizaron cambios']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
