<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'] ?? '';
        $nombre = trim($_POST['nombre'] ?? '');
        $nrc = trim($_POST['nrc'] ?? '');
        
        // Validaciones
        if (empty($id) || empty($nombre) || empty($nrc)) {
            echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
            exit;
        }
        
        if (!preg_match('/^[0-9]{5}$/', $nrc)) {
            echo json_encode(['success' => false, 'error' => 'El NRC debe tener exactamente 5 dígitos']);
            exit;
        }
        
        if (strlen($nombre) < 3) {
            echo json_encode(['success' => false, 'error' => 'El nombre debe tener al menos 3 caracteres']);
            exit;
        }
        
        if (strlen($nombre) > 100) {
            echo json_encode(['success' => false, 'error' => 'El nombre no puede exceder 100 caracteres']);
            exit;
        }
        
        // Verificar si ya existe otra materia con ese nombre
        $stmt = $conn->prepare("SELECT COUNT(*) FROM materias WHERE nombre = ? AND id != ?");
        $stmt->execute([$nombre, $id]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'error' => 'Ya existe otra materia con ese nombre']);
            exit;
        }
        
        // Verificar si ya existe otra materia con ese NRC
        $stmt = $conn->prepare("SELECT COUNT(*) FROM materias WHERE nrc = ? AND id != ?");
        $stmt->execute([$nrc, $id]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'error' => 'Ya existe otra materia con ese NRC']);
            exit;
        }
        
        // Actualizar materia
        $stmt = $conn->prepare("UPDATE materias SET nombre = ?, nrc = ? WHERE id = ?");
        $result = $stmt->execute([$nombre, $nrc, $id]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Materia actualizada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se encontró la materia o no se realizaron cambios']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
