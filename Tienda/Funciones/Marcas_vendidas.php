<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Recientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .marca-item {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .marca-item h3 {
            margin: 0;
            color: #555;
        }
        .marca-item p {
            margin: 5px 0;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Ventas con al menos 1 articulo vendido</h1>
    <br>
    <button onclick="obtenerVentasRecientes()">Mostrar mas recientes</button>
    <br>
    <div id="ventas-container"></div>
    <br>

    <script>
        
        function obtenerVentasRecientes() {
            fetch('http://localhost/Tienda/Consultas/Marcas_vendidas.php') 
                .then(response => response.json()) 
                .then(data => {
                    const contenedor = document.getElementById('ventas-container');
                    contenedor.innerHTML = ''; 

                    if (data.length > 0) {
                        data.forEach(marca => {
                            const marcaDiv = document.createElement('div');
                            marcaDiv.className = 'marca-item';
                            marcaDiv.innerHTML = `
                                <h3>${marca.nombre_marca}</h3>
                                <p>Ventas: ${marca.ventas}</p>
                            `;
                            contenedor.appendChild(marcaDiv);
                        });
                    } else {
                        contenedor.innerHTML = '<p>No hay ventas recientes.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener las ventas recientes:', error);
                });
        }
    </script>
</body>
</html>