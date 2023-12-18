<?php
// Obtener el número de documento enviado desde el formulario
$nrodocumento = isset($_POST['nrodocumento']) ? $_POST['nrodocumento'] : '';

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SENATI";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Inicializar variables
$resultado = '';
$mensaje_error = '';

// Llamada al procedimiento almacenado directamente
$sql = "SELECT e.nombres, e.apellidos, e.fechanac, e.telefono, s.sede 
        FROM empleados e 
        JOIN sede s ON e.idsede = s.idsede
        WHERE e.nrodocumento = '$nrodocumento'";

$result = $conn->query($sql);

// Mostrar los resultados en un formulario
if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resultado .= "<h2 class='display-6 text-center'>Datos del Empleado</h2>";
        $resultado .= "<form class='container'>";
        $resultado .= "<div class='form-group'>";
        $resultado .= "<label for='nombres' class='fw-bold'>Nombres:</label><input type='text' class='form-control' name='nombres' value='{$row['nombres']}' readonly>";
        $resultado .= "</div>";
        $resultado .= "<div class='form-group'>";
        $resultado .= "<label for='apellidos' class='fw-bold'>Apellidos:</label><input type='text' class='form-control' name='apellidos' value='{$row['apellidos']}' readonly>";
        $resultado .= "</div>";
        $resultado .= "<div class='form-group'>";
        $resultado .= "<label for='fechanac' class='fw-bold'>Fecha de Nacimiento:</label><input type='text' class='form-control' name='fechanac' value='{$row['fechanac']}' readonly>";
        $resultado .= "</div>";
        $resultado .= "<div class='form-group'>";
        $resultado .= "<label for='telefono' class='fw-bold'>Teléfono:</label><input type='text' class='form-control' name='telefono' value='{$row['telefono']}' readonly>";
        $resultado .= "</div>";
        $resultado .= "<div class='form-group'>";
        $resultado .= "<label for='sede' class='fw-bold'>Sede:</label><input type='text' class='form-control' name='sede' value='{$row['sede']}' readonly>";
        $resultado .= "</div>";
        $resultado .= "</form>";
    } else {
        $mensaje_error = "No se encontraron empleados con ese número de documento.";
    }
} else {
    $mensaje_error = "Error en la ejecución de la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Empleado por Número de Documento</title>
    <!-- Enlace a Bootstrap CSS (asegúrate de tener conexión a internet) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Enlace a Google Fonts para la fuente Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }

        h1, h2 {
            color: #007bff;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        #resultado {
            margin-top: 20px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nrodocumento" class="fw-bold">Número de Documento:</label>
                <input type="text" name="nrodocumento" class="form-control" required value="<?php echo $nrodocumento; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        <div id="resultado">
            <?php echo $resultado; ?>
            <div class="error"><?php echo $mensaje_error; ?></div>
        </div>
        <!-- Botones para redirigir -->
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-secondary">Ir a Index</a>
            <a href="estadisticas.php" class="btn btn-secondary">Ir a Estadísticas</a>
        </div>
    </div>

    <!-- Scripts de Bootstrap (asegúrate de tener conexión a internet) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
