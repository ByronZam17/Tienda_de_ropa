<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 5 Marcas Más Vendidas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        canvas {
            display: block;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <h2>Top 5 Marcas Más Vendidas</h2>
    
    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Ventas</th>
            </tr>
        </thead>
        <tbody id="tabla-marcas">
            <tr><td colspan="2">Cargando datos...</td></tr>
        </tbody>
    </table>

    <canvas id="graficoMarcas" width="400" height="200"></canvas>

    <script>
        function obtenerMarcasMasVendidas() {
            fetch("http://localhost/Tienda/Consultas/Lo_mas_vendido.php")
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                //Grafico de las marcas
                .then(data => {
                    const tabla = document.getElementById("tabla-marcas");
                    const canvas = document.getElementById("graficoMarcas");
                    const ctx = canvas.getContext("2d");
                    tabla.innerHTML = "";

                    if (data.length === 0) {
                        tabla.innerHTML = "<tr><td colspan='2'>No hay datos disponibles.</td></tr>";
                        return;
                    }

                    let marcas = [];
                    let ventas = [];
                    let colores = [
                        "rgba(255, 99, 132, 0.6)",
                        "rgba(54, 162, 235, 0.6)",
                        "rgba(255, 206, 86, 0.6)",
                        "rgba(75, 192, 192, 0.6)",
                        "rgba(153, 102, 255, 0.6)"
                    ];

                    data.forEach((marca, index) => {
                        let row = `<tr>
                            <td>${marca.nombre_marca}</td>
                            <td>${marca.ventas}</td>
                        </tr>`;
                        tabla.innerHTML += row;

                        marcas.push(marca.nombre_marca);
                        ventas.push(marca.ventas);
                    });

                    new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: marcas,
                            datasets: [{
                                label: "Ventas",
                                data: ventas,
                                backgroundColor: colores,
                                borderColor: colores.map(c => c.replace("0.6", "1")),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error("Error al obtener las marcas:", error);
                    document.getElementById("tabla-marcas").innerHTML = 
                        "<tr><td colspan='2'>Error al cargar los datos.</td></tr>";
                });
        }
        obtenerMarcasMasVendidas();
    </script>
</body>
</html>

