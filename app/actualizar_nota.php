<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

try {
    // Recibir datos JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    $id = $input['id'] ?? '';
    $usuario_id = $input['usuario_id'] ?? '';
    $materia_id = $input['materia_id'] ?? '';
    $n1 = isset($input['n1']) ? floatval($input['n1']) : null;
    $n2 = isset($input['n2']) ? floatval($input['n2']) : null;
    $n3 = isset($input['n3']) ? floatval($input['n3']) : null;
    
    if (empty($id) || empty($usuario_id) || empty($materia_id) || $n1 === null || $n2 === null || $n3 === null) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son requeridos']);
        exit;
    }
    
    // Validar que el usuario existe
    $stmt_usuario = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmt_usuario->execute([$usuario_id]);
    if (!$stmt_usuario->fetch()) {
        echo json_encode(['success' => false, 'error' => 'El usuario seleccionado no existe']);
        exit;
    }
    
    // Validar que la materia existe
    $stmt_materia = $conn->prepare("SELECT id FROM materias WHERE id = ?");
    $stmt_materia->execute([$materia_id]);
    if (!$stmt_materia->fetch()) {
        echo json_encode(['success' => false, 'error' => 'La materia seleccionada no existe']);
        exit;
    }
    
    // Verificar si ya existe una nota para este usuario y materia (excluyendo la actual)
    $stmt_duplicado = $conn->prepare("SELECT id FROM notas WHERE usuario_id = ? AND materia_id = ? AND id != ?");
    $stmt_duplicado->execute([$usuario_id, $materia_id, $id]);
    if ($stmt_duplicado->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Ya existe una nota para este usuario y materia']);
        exit;
    }
    
    // Validar rango de notas
    if ($n1 < 0 || $n1 > 20 || $n2 < 0 || $n2 > 20 || $n3 < 0 || $n3 > 20) {
        echo json_encode(['success' => false, 'error' => 'Las notas deben estar entre 0 y 20']);
        exit;
    }
    
    // Calcular promedio
    $promedio = ($n1 + $n2 + $n3) / 3;
    
    $sql = "UPDATE notas SET usuario_id = ?, materia_id = ?, n1 = ?, n2 = ?, n3 = ?, promedio = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario_id, $materia_id, $n1, $n2, $n3, $promedio, $id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Nota actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontró la nota o no se realizaron cambios']);
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
