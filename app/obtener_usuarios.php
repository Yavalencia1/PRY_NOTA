<?php
header('Content-Type: application/json');
require_once '../conexion/db.php';

try {
    $stmt = $conn->prepare("SELECT id, nombre, email, fecha_nacimiento FROM usuarios ORDER BY id DESC");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($usuarios);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>
