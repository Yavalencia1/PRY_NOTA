<?php
header('Content-Type: application/json');
require_once '../conexion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? '';
        
        if (empty($id)) {
            echo json_encode(['success' => false, 'error' => 'ID requerido']);
            exit;
        }
        
        $stmt = $conn->prepare("SELECT id, nombre, email, fecha_nacimiento FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
