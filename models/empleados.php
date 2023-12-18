<?php

require_once('conexion.php');

class EmpleadosAPI {

    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listarEmpleados() {
        try {
            $pdo = $this->conexion->getConexion();
            $query = "CALL spu_empleados_listar()";
            $statement = $pdo->query($query);
            $empleados = $statement->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($empleados);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function buscarEmpleado($nroDocumento) {
        try {
            $pdo = $this->conexion->getConexion();
            $query = "CALL spu_empleados_obtener_por_documento(?)";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':nrodocumento', $nroDocumento);
            $statement->execute();

            $empleado = $statement->fetch(PDO::FETCH_ASSOC);

            if ($empleado) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'empleado' => $empleado]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No se encontró ningún empleado']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function search($data = []){
        try {
          //el SPU require el numero de placa
          $consulta = $this->pdo->prepare("CALL 
          spu_empleados_buscar(?)");
          $consulta->execute(
            array($data['nrodocumento'])
          );
    
          //Devolver el registro encontrado
          //fetch()     : retorna la primera coincidencia (1)
          //fetchAll()  : retorna todas las coincidencia (n)
          //FETCH_ASSOC : define el resultado como un objeto
          //FETCH_ARRAY
          //FETCH NUM   : sirve para retornar solo los elementos
          return $consulta->fetch(PDO::FETCH_ASSOC); //fetch assoc , formato en como se recuperan los datos
          
        } 
        catch (Exception $e) {
          die($e->getMessage());
        }
      }
}

// Crear una instancia de la API y llamar al método correspondiente
$empleadosAPI = new EmpleadosAPI();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['nrodocumento'])) {
        $nroDocumento = $_GET['nrodocumento'];
        $empleadosAPI->buscarEmpleadoPorDocumento($nroDocumento);
    } else {
        $empleadosAPI->listarEmpleados();
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Método no permitido']);
}


?>
