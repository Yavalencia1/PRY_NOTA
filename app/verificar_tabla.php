<?php
require_once '../conexion/db.php';

try {
    // Verificar estructura de la tabla usuarios
    $stmt = $conn->prepare("DESCRIBE usuarios");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Estructura actual de la tabla usuarios:\n";
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}\n";
    }
    
    // Verificar si existe la columna fecha_nacimiento
    $hasDateColumn = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'fecha_nacimiento') {
            $hasDateColumn = true;
            break;
        }
    }
    
    if (!$hasDateColumn) {
        echo "\nLa columna fecha_nacimiento no existe. Necesita ser agregada.\n";
        
        // Agregar la columna fecha_nacimiento
        $alterQuery = "ALTER TABLE usuarios ADD COLUMN fecha_nacimiento DATE AFTER email";
        $conn->exec($alterQuery);
        echo "Columna fecha_nacimiento agregada exitosamente.\n";
        
        // Si hay datos existentes con edad, podemos migrar aproximadamente
        $stmt = $conn->prepare("SELECT id, edad FROM usuarios WHERE edad IS NOT NULL");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($usuarios) > 0) {
            echo "\nMigrando datos existentes...\n";
            foreach ($usuarios as $usuario) {
                $fechaAproximada = date('Y-m-d', strtotime("-{$usuario['edad']} years"));
                $updateStmt = $conn->prepare("UPDATE usuarios SET fecha_nacimiento = ? WHERE id = ?");
                $updateStmt->execute([$fechaAproximada, $usuario['id']]);
                echo "Usuario ID {$usuario['id']}: edad {$usuario['edad']} -> fecha aproximada {$fechaAproximada}\n";
            }
        }
    } else {
        echo "\nLa columna fecha_nacimiento ya existe.\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
