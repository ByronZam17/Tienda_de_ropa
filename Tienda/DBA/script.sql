CREATE DATABASE IF NOT EXISTS tienda_ropa;
USE tienda_ropa;


CREATE TABLE clientes_frecuentes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(15),
    direccion VARCHAR(255)
);


CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);


CREATE TABLE encargos (
    id_encargo INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_producto INT,
    fecha_encargo DATE,
    cantidad INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes_frecuentes(id_cliente),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);