<?php
include '../esencial/conexion.php';

$id_producto = $_GET['id'];

// Eliminar el producto de la base de datos

$query = "DELETE FROM productos WHERE id = $id_producto";

if ($conexion->query($query)) {
    echo "Producto eliminado exitosamente.";
} else {
    echo "Error al eliminar el producto: ". $conexion->error;
}

// Redirigir a la página de la tienda
header('Location: tienda.php');
exit();
