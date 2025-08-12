<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'] ?? '';
        
        // Validación
        if (empty($id)) {
            echo json_encode(['success' => false, 'error' => 'ID de la materia es requerido']);
            exit;
        }
        
        // Verificar si la materia existe
        $stmt = $conn->prepare("SELECT nombre FROM materias WHERE id = ?");
        $stmt->execute([$id]);
        $materia = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$materia) {
            echo json_encode(['success' => false, 'error' => 'Materia no encontrada']);
            exit;
        }
        
        // Verificar si hay notas asociadas a esta materia
        $stmt = $conn->prepare("SELECT COUNT(*) FROM notas WHERE materia_id = ?");
        $stmt->execute([$id]);
        $notasCount = $stmt->fetchColumn();
        
        if ($notasCount > 0) {
            echo json_encode([
                'success' => false, 
                'error' => "No se puede eliminar la materia porque tiene {$notasCount} nota(s) asociada(s). Elimine primero las notas."
            ]);
            exit;
        }
        
        // Eliminar materia
        $stmt = $conn->prepare("DELETE FROM materias WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Materia eliminada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar la materia']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
