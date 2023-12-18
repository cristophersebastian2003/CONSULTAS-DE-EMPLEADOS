<?php
// Obtener estadísticas de empleados por sede
require_once('../models/conexion.php');

try {
    $conexion = new Conexion();
    $pdo = $conexion->getConexion();

    // Verifica la consulta SQL y el nombre de la columna 'sede'
    $query = "SELECT sede, COUNT(*) as total FROM empleados GROUP BY sede";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Preparar datos para el gráfico
    $labels = [];
    $valores = [];

    foreach ($resultados as $row) {
        // Asegúrate de que el nombre de la columna sea correcto
        $labels[] = $row['sede'];
        $valores[] = $row['total'];
    }

    // Enviar una respuesta JSON con las estadísticas
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'labels' => $labels, 'valores' => $valores]);
} catch (Exception $e) {
    // Enviar una respuesta JSON de error si ocurre alguna excepción
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>