<?php
require_once '../conexion/db.php';

// Debug: Verificar si se están recibiendo los datos
error_log("POST data: " . print_r($_POST, true));

$usuario_id = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$materia_id = isset($_POST['materia']) ? $_POST['materia'] : null;
$nota_1 = isset($_POST['nota_1']) ? $_POST['nota_1'] : null;
$nota_2 = isset($_POST['nota_2']) ? $_POST['nota_2'] : null;
$nota_3 = isset($_POST['nota_3']) ? $_POST['nota_3'] : null;

// Debug: Mostrar valores recibidos
error_log("Usuario ID: $usuario_id, Materia ID: $materia_id, N1: $nota_1, N2: $nota_2, N3: $nota_3");

// Validaciones básicas
if (!$usuario_id || !$materia_id || $nota_1 === null || $nota_2 === null || $nota_3 === null) {
    error_log("Error de validación: campos faltantes");
    header("Location: ingresar_notas.php?error=" . urlencode("Todos los campos son obligatorios"));
    exit;
}

// Validar rangos de notas
if ($nota_1 < 0 || $nota_1 > 20 || $nota_2 < 0 || $nota_2 > 20 || $nota_3 < 0 || $nota_3 > 20) {
    error_log("Error de validación: notas fuera de rango");
    header("Location: ingresar_notas.php?error=" . urlencode("Las notas deben estar entre 0 y 20"));
    exit;
}

//insertar datos en la base de datos (incluyendo el promedio calculado)
try {
    error_log("Intentando insertar en base de datos");
    
    // Calcular el promedio
    $promedio = ($nota_1 + $nota_2 + $nota_3) / 3;
    error_log("Promedio calculado: $promedio");
    
	$sql = "INSERT INTO notas (usuario_id, materia_id, n1, n2, n3, promedio) VALUES (:u_id, :m_id, :n1, :n2, :n3, :promedio)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':u_id', $usuario_id, PDO::PARAM_INT);
	$stmt->bindParam(':m_id', $materia_id, PDO::PARAM_INT);
	$stmt->bindParam(':n1', $nota_1, PDO::PARAM_STR);
	$stmt->bindParam(':n2', $nota_2, PDO::PARAM_STR);
	$stmt->bindParam(':n3', $nota_3, PDO::PARAM_STR);
	$stmt->bindParam(':promedio', $promedio, PDO::PARAM_STR);
	$result = $stmt->execute();
	
	error_log("Resultado de inserción: " . ($result ? "exitoso" : "fallido"));
	error_log("Filas afectadas: " . $stmt->rowCount());
	
	// Redirigir con mensaje de éxito
	header("Location: ingresar_notas.php?success=1");
	exit;
} catch (PDOException $e) {
	error_log("Error PDO: " . $e->getMessage());
	// Redirigir con mensaje de error
	header("Location: ingresar_notas.php?error=" . urlencode($e->getMessage()));
	exit;
}

?>