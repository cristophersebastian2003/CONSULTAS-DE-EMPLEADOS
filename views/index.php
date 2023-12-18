<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Empleados</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        button {
            margin-bottom: 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mt-4">Interfaz Empleados</h2>

    <div class="mb-3">
        <button class="btn btn-primary" onclick="listarEmpleados()">Listar Empleados</button>
        <button class="btn btn-success" onclick="irAInterfazRegistro()">Registrar Empleado</button>
        <button class="btn btn-info" onclick="irAInterfazBuscar()">Buscar Empleado</button>
    </div>

    <table class="table table-bordered" id="tablaEmpleados">
        <thead class="table-dark">
            <tr>
                <th>ID Empleado</th>
                <th>ID Sede</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Nro Documento</th>
                <th>Fecha Nacimiento</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody id="tbodyEmpleados">
            <!-- Aquí se mostrarán los datos de los empleados -->
        </tbody>
    </table>
</div>

<!-- Bootstrap 5 JS y Popper.js (necesarios para los componentes de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function listarEmpleados() {
        // Llamada AJAX para obtener datos de empleados desde el servidor
        fetch('../models/empleados.php')
            .then(response => response.json())
            .then(data => {
                mostrarEmpleados(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function mostrarEmpleados(empleados) {
        // Limpiar la tabla antes de mostrar nuevos datos
        document.getElementById('tbodyEmpleados').innerHTML = '';

        // Iterar sobre la lista de empleados y agregar filas a la tabla
        empleados.forEach(empleado => {
            let row = document.getElementById('tablaEmpleados').insertRow();
            row.insertCell(0).textContent = empleado.idempleado;
            row.insertCell(1).textContent = empleado.idsede;
            row.insertCell(2).textContent = empleado.apellidos;
            row.insertCell(3).textContent = empleado.nombres;
            row.insertCell(4).textContent = empleado.nrodocumento;
            row.insertCell(5).textContent = empleado.fechanac;
            row.insertCell(6).textContent = empleado.telefono;
        });
    }

    function irAInterfazRegistro() {
        // Redirigir a la página de registro de empleado
        window.location.href = 'registro_empleado.php'; // Cambia esto con la ruta correcta de tu interfaz de registro
    }

    function irAInterfazBuscar() {
        // Redirigir a la página de búsqueda de empleado
        window.location.href = 'buscar_empleado.php'; // Cambia esto con la ruta correcta de tu interfaz de búsqueda
    }
</script>

</body>
</html>
