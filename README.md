# Proyecto plataformas.

# DBA
![alt text](./Tienda_DE_ROPA/Diagrama%20de%20base%20de%20datos.PNG)


# API Tienda de Ropa - Documentación

## Uso de Endpoints de la API

### Endpoints para Marcas

#### Obtener todas las marcas
**Método:** GET  
**Endpoint:** `http://localhost/Tienda_de_ropa/public/api/marcas`  
**Descripción:** Obtiene todas las marcas registradas en el sistema.

**Ejemplo de respuesta:**
```json
[
  {
    "id_marca": 1,
    "nombre_marca": "Nike",
    "cantidad_prendas": 200,
    "ventas": 50
  },
  {
    "id_marca": 2,
    "nombre_marca": "Adidas",
    "cantidad_prendas": 150,
    "ventas": 0
  }
]

##### obtener una marca por ID 
Método: GET
Endpoint: http://localhost/Tienda_de_ropa/public/api/marcas/{id}
Ejemplo: http://localhost/Tienda_de_ropa/public/api/marcas/1

Ejemplo de respuesta:

{
  "id_marca": 1,
  "nombre_marca": "Nike",
  "cantidad_prendas": 200,
  "ventas": 50
}


Endpoints para Productos
Crear un nuevo producto
Método: POST
Endpoint: http://localhost/Tienda_de_ropa/public/api/productos
Body (JSON):

{
  "nombre_producto": "Camiseta",
  "descripcion": "Algodón 100%",
  "precio": 25.99,
  "stock": 100,
  "id_marca": 1
}
Ejemplo de respuesta:
{
  "mensaje": "Producto creado exitosamente",
  "id_producto": 3
}


Endpoints para Reportes
Obtener prendas vendidas con stock
Método: GET
Endpoint: http://localhost/Tienda_de_ropa/public/api/reportes/prendas-vendidas-stock

Ejemplo de respuesta:

json
[
  {
    "nombre_producto": "Camiseta Roja Nike",
    "total_vendido": 2,
    "stock": 48
  },
  {
    "nombre_producto": "Zapatillas Adidas",
    "total_vendido": 1,
    "stock": 29
  }
]


Estructura de Respuestas Comunes
Éxito (200 OK)
json
{
  "mensaje": "Operación exitosa",
  "datos": {}
}
Error (400 Bad Request)
json
{
  "error": "Descripción del error",
  "detalles": {}
}
No encontrado (404)
json
{
  "error": "Recurso no encontrado"
}
Ejemplo Completo de Flujo
Crear marca:
POST /api/marcas
{
  "nombre_marca": "Puma",
  "cantidad_prendas": 100,
  "ventas": 0
}
Crear producto asociado:
POST /api/productos
{
  "nombre_producto": "Short deportivo",
  "descripcion": "Material transpirable",
  "precio": 35.50,
  "stock": 50,
  "id_marca": 3
}
Consultar reporte:
http
GET /api/reportes/marcas-con-ventas



