<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = trim($_POST['nombre'] ?? '');
        $nrc = trim($_POST['nrc'] ?? '');
        
        // Validaciones
        if (empty($nombre) || empty($nrc)) {
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
        
        // Verificar si ya existe una materia con ese nombre
        $stmt = $conn->prepare("SELECT COUNT(*) FROM materias WHERE nombre = ?");
        $stmt->execute([$nombre]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'error' => 'Ya existe una materia con ese nombre']);
            exit;
        }
        
        // Verificar si ya existe una materia con ese NRC
        $stmt = $conn->prepare("SELECT COUNT(*) FROM materias WHERE nrc = ?");
        $stmt->execute([$nrc]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'error' => 'Ya existe una materia con ese NRC']);
            exit;
        }
        
        // Insertar nueva materia
        $stmt = $conn->prepare("INSERT INTO materias (nombre, nrc) VALUES (?, ?)");
        $result = $stmt->execute([$nombre, $nrc]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Materia creada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo crear la materia']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
