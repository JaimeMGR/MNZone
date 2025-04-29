<?php
include '../esencial/conexion.php';

// Recibir los datos del formulario
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$imagen = $_POST['imagen'];
$fecha_publicacion = date('Y-m-d');

// Procesar y guardar la imagen
if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $imagen = "imagenes/" . basename($_FILES['imagen']['name']);
    $rutaimagen = basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], "../../$imagen");
} else {
    $imagen = NULL; // Si no se sube imagen, se deja como NULL
}

// Si ya existe una foto con ese nombre, cambiar el nombre
if (file_exists("../../imagenes/$imagen")) {
    $imagen = time() . "_" . $imagen;
}

// Preparar la consulta de inserción con parámetros
$query = "INSERT INTO `noticia`(`titulo`, `contenido`, `imagen`, fecha_publicacion) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($query);

// Enlazar los parámetros (s: string, i: integer)
$stmt->bind_param("ssss", $titulo, $contenido, $rutaimagen, $fecha_publicacion);

// Ejecutar la consulta e informar del resultado
if ($stmt->execute()) {
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();

header('Location:noticias.php');
