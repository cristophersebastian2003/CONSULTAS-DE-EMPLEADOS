<?php
// sedes.php - Devuelve las sedes en formato JSON

require_once('conexion.php');

try {
    $conexion = new Conexion();
    $pdo = $conexion->getConexion();
    
    $query = "SELECT idsede, sede FROM sede";
    $statement = $pdo->query($query);
    $sedes = $statement->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($sedes);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
