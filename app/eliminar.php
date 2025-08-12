<?php
header('Content-Type: application/json');
require_once '../conexion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $id = $input['id'] ?? '';
        
        // Validación
        if (empty($id)) {
            echo json_encode(['success' => false, 'error' => 'ID del usuario es requerido']);
            exit;
        }
        
        // Verificar si el usuario existe
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            exit;
        }
        
        // Eliminar usuario
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el usuario']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
