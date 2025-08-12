<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT id, nombre, nrc FROM materias ORDER BY nombre";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($materias);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
