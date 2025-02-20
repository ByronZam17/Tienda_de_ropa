# Proyecto plataformas.

# Proyecto plataformas.

# diagrama
![alt text](./Tienda/Modelo/Diagrama%20de%20base%20de%20datos.PNG)


# Marcas con al menos 1 prenda vendida 
SELECT * FROM `marcas` WHERE `ventas` > 0;


id_marca	nombre_marca	cantidad_prendas	ventas	
1	Nike	200	50	
3	Puma	100	30	
4	Reebok	120	20	
5	Under Armour	80	15	
6	New Balance	90	10	


# Prendas mas vendidas y su cantidad de stock restante
SELECT p.nombre_producto, SUM(e.cantidad) AS total_vendido, p.stock 
FROM `productos` p
JOIN `encargos` e ON p.id_producto = e.id_producto
GROUP BY p.id_producto;


nombre_producto	total_vendido	stock	
Camiseta Roja Nike	2	50	
Zapatillas Adidas	1	30	
Pantalón Puma	1	40	


# Top 5 marcas mas vendidas
SELECT nombre_marca, ventas 
FROM `marcas` 
ORDER BY ventas DESC 
LIMIT 5;


nombre_marca	ventas   	
Nike	50	
Puma	30	
Reebok	20	
Under Armour	15	
New Balance	10	




