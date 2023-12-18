<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Empleados por Sede</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #007bff;
        }

        #btnMostrarGrafico {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        #graficoEmpleados {
            display: none;
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

    <h2>Gráfico de Empleados por Sede</h2>

    <button id="btnMostrarGrafico">Mostrar Gráfico</button>

    <canvas id="graficoEmpleados"></canvas>

    <script>
        $(document).ready(function() {
            $("#btnMostrarGrafico").click(function() {
                // Llamada AJAX para obtener datos de empleados por sede
                $.ajax({
                    url: 'obtener_estadistica.php', // Asegúrate de que esta URL sea correcta
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Mostrar el botón y ocultar el gráfico después de cargar la gráfica
                        $("#graficoEmpleados").show();
                        $("#btnMostrarGrafico").hide();

                        // Configurar y dibujar el gráfico de barras con Chart.js
                        var ctx = document.getElementById('graficoEmpleados').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Número de Empleados',
                                    data: data.valores,
                                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>

</body>
</html>
