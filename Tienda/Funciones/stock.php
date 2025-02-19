<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Vendidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .producto-item {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .producto-item h3 {
            margin: 0;
            color: #555;
        }
        .producto-item p {
            margin: 5px 0;
            color: #777;
        }
        .boton-redireccion {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .boton-redireccion:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Productos Vendidos y Stock Restante</h1>
    <button class="boton-redireccion" onclick="obtenerProductosVendidos()">
        Cargar Productos Vendidos
    </button>
    <div id="productos-container"></div>

    <script>
        
        function obtenerProductosVendidos() {
            fetch('http://localhost/Tienda/Consultas/stock.php') 
                .then(response => response.json()) 
                .then(data => {
                    const contenedor = document.getElementById('productos-container');
                    contenedor.innerHTML = ''; 

                    if (data.length > 0) {
                        data.forEach(producto => {
                            const productoDiv = document.createElement('div');
                            productoDiv.className = 'producto-item';
                            productoDiv.innerHTML = `
                                <h3>${producto.nombre_producto}</h3>
                                <p>Stock restante: ${producto.stock}</p>
                            `;
                            contenedor.appendChild(productoDiv);
                        });
                    } else {
                        contenedor.innerHTML = '<p>No hay productos vendidos.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los productos vendidos:', error);
                });
        }
    </script>
</body>
</html>