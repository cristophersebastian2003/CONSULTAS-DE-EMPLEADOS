<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleado</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            width: 50%;
            margin: auto;
        }

        button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mt-4">Registro de Empleado</h2>

    <form id="formularioRegistro">
        <div class="mb-3">
            <label for="nombres" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombres" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <!-- Agregar el menú desplegable para seleccionar la sede -->
        <div class="mb-3">
            <label for="sede" class="form-label">Sede:</label>
            <select class="form-select" id="sede" name="sede" required>
                <!-- Las opciones de sede se cargarán dinámicamente mediante JavaScript -->
            </select>
        </div>
        <div class="mb-3">
            <label for="nrodocumento" class="form-label">Número de Documento:</label>
            <input type="text" class="form-control" id="nrodocumento" name="nrodocumento" required>
        </div>
        <div class="mb-3">
            <label for="fechanac" class="form-label">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="fechanac" name="fechanac" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

    <!-- Botón para regresar a index.php -->
    <a href="index.php" class="btn btn-secondary">Regresar a Index</a>
</div>

<!-- Bootstrap 5 JS y Popper.js (necesarios para los componentes de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Llamada AJAX para obtener las sedes desde el servidor
    fetch('../models/sedes.php')
        .then(response => response.json())
        .then(data => {
            // Llenar el menú desplegable con las sedes obtenidas
            const selectSede = document.getElementById('sede');
            data.forEach(sede => {
                const option = document.createElement('option');
                option.value = sede.idsede; // Ajusta esto según la estructura de tus datos
                option.text = sede.sede; // Ajusta esto según la estructura de tus datos
                selectSede.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));

    // Agregar un evento de escucha para el envío del formulario
    document.getElementById('formularioRegistro').addEventListener('submit', function (event) {
        event.preventDefault();

        // Obtener los valores del formulario
        const nombres = document.getElementById('nombres').value;
        const apellidos = document.getElementById('apellidos').value;
        const sede = document.getElementById('sede').value;
        const nrodocumento = document.getElementById('nrodocumento').value;
        const fechanac = document.getElementById('fechanac').value;
        const telefono = document.getElementById('telefono').value;

        // Crear un objeto con los datos del empleado
        const empleado = {
            nombres,
            apellidos,
            idsede: sede,
            nrodocumento,
            fechanac,
            telefono
        };

        // Mostrar confirmación antes de enviar los datos al servidor
        const confirmacion = window.confirm('¿Deseas registrar este empleado?');

        if (confirmacion) {
            // Llamada AJAX para enviar los datos al servidor
            fetch('registrar_empleado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(empleado),
            })
            .then(response => response.json())
            .then(data => {
                // Puedes agregar lógica adicional aquí, como mostrar un mensaje de éxito o redirigir a otra página
                console.log('Registro exitoso:', data);
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>

</body>
</html>
