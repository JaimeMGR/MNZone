<?php
include '../esencial/conexion.php';

$id_producto = $_GET['id'];

// Preparar la consulta con una declaración preparada
$query = "SELECT nombre, companía, imagen, precio, Categoría FROM productos WHERE id = $id_producto";
$stmt = $conexion->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Enlazar las variables para recibir los resultados
$stmt->bind_result($nombre_actual, $companía_actual, $imagen_actual, $precio_actual, $Categoría_actual);
$stmt->fetch();
$stmt->close();

// var_dump($nombre_actual, $companía_actual, $imagen_actual, $precio_actual, $Categoría_actual);

// Recibir los datos del formulario
$nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : $nombre_actual;
$companía = !empty($_POST['companía']) ? $_POST['companía'] : $companía_actual;
$imagen = !empty($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : $imagen_actual;
$precio = !empty($_POST['precio']) ? $_POST['precio'] : $precio_actual;
$Categoría = !empty($_POST['categoria']) ? $_POST['categoria'] : $Categoría_actual;

// Procesar y guardar la imagen
if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $imagen =  basename($_FILES['imagen']['name']);
    $rutaimagen = "../../imagenes/" . $imagen;
    move_uploaded_file($_FILES['imagen']['tmp_name'], "../../imagenes/$imagen");
} else {
    $imagen = $imagen_actual; // Usar la imagen actual si no se sube ninguna nueva
}

// Preparar la consulta de inserción con parámetros usando una consulta preparada

$query2 = "UPDATE productos SET nombre = ?, companía = ?, imagen = ?, precio = ?, Categoría = ? WHERE id = $id_producto";
$stmt2 = $conexion->prepare($query2);
// Enlazar los parámetros (s: string, i: integer)
$stmt2->bind_param("sssss",  $nombre, $companía, $imagen, $precio, $Categoría);
var_dump($nombre, $companía, $imagen, $precio, $Categoría, $id_producto);
// Ejecutar la consulta e informar del resultado
if ($stmt2->execute()) {
    echo "Socio modificado con éxito";
    header("Location:tienda.php");
    exit(); // Salir del script para evitar que se siga ejecutando el código después de la actualización
} else {
    echo "Error: " . $stmt2->error;
    header("Location:tienda.php");
}
// Cerrar la declaración y la conexión
$stmt2->close();
