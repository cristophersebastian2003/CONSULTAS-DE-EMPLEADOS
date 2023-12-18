<?php
require_once('../models/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cuerpo de la solicitud (formato JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar si los datos esperados están presentes
    if (isset($data['nombres'], $data['apellidos'], $data['idsede'], $data['nrodocumento'], $data['fechanac'], $data['telefono'])) {
        try {
            // Crear una instancia de la clase de conexión
            $conexion = new Conexion();
            $pdo = $conexion->getConexion();

            // Iniciar una transacción
            $pdo->beginTransaction();

            // Construir la consulta SQL para registrar empleado sin incluir el ID
            $sql = "INSERT INTO empleados (
                idsede, 
                apellidos, 
                nombres, 
                nrodocumento, 
                fechanac, 
                telefono
            ) VALUES (
                :idsede, 
                :apellidos, 
                :nombres, 
                :nrodocumento, 
                :fechanac, 
                :telefono
            )";
            
            // Preparar la consulta
            $stmt = $pdo->prepare($sql);

            // Vincular los parámetros
            $stmt->bindParam(':nombres', $data['nombres']);
            $stmt->bindParam(':apellidos', $data['apellidos']);
            $stmt->bindParam(':idsede', $data['idsede']);
            $stmt->bindParam(':nrodocumento', $data['nrodocumento']);
            $stmt->bindParam(':fechanac', $data['fechanac']);
            $stmt->bindParam(':telefono', $data['telefono']);

            // Ejecutar la consulta
            $stmt->execute();

            // Confirmar la transacción
            $pdo->commit();

            // Enviar una respuesta JSON de éxito
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $pdo->rollBack();

            // Enviar una respuesta JSON de error con mensaje detallado
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        // Enviar una respuesta JSON de error si los datos esperados no están presentes
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    // Enviar una respuesta JSON de error si la solicitud no es POST
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
