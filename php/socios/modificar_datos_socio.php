<?php
include '../esencial/conexion.php';

$id_socio = $_GET['id'];

// Preparar la consulta con una declaración preparada
$query = "SELECT telefono, nombre, contrasena, usuario, edad, foto FROM socio WHERE id_socio = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_socio);

// Ejecutar la consulta
$stmt->execute();

// Enlazar las variables para recibir los resultados
$stmt->bind_result($telefono_actual, $nombre_actual, $contrasena_actual, $usuario_actual, $edad_actual, $foto_actual);
$stmt->fetch();
$stmt->close();

// Recibir los datos del formulario
$nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : $nombre_actual;
$usuario = !empty($_POST['usuario']) ? $_POST['usuario'] : $usuario_actual;
$edad = !empty($_POST['edad']) ? $_POST['edad'] : $edad_actual;
$telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : $telefono_actual;
$contrasena = !empty($_POST['contraseña']) ? $_POST['contraseña'] : $contrasena_actual;
$imagen = !empty($_POST['imagen']) ? $_POST['imagen'] : $foto_actual;

// Procesar y guardar la imagen
if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $imagen =  basename($_FILES['imagen']['name']);
    $rutaimagen = "../../imagenes/" . $imagen;
    move_uploaded_file($_FILES['imagen']['tmp_name'], "../../imagenes/$imagen");
} else {
    $imagen = $foto_actual; // Usar la imagen actual si no se sube ninguna nueva
}

// Preparar la consulta de inserción con parámetros usando una consulta preparada

$query2 = "UPDATE socio SET nombre = ?, edad = ?, usuario = ?, telefono = ?, contrasena = ?, foto = ? WHERE id_socio = ?";
$stmt2 = $conexion->prepare($query2);
// Enlazar los parámetros (s: string, i: integer)
$stmt2->bind_param("sissssi", $nombre, $edad, $usuario, $telefono, $contrasena, $imagen, $id_socio);
var_dump($nombre, $edad, $usuario, $telefono, $contrasena, $imagen, $id_socio);
// Ejecutar la consulta e informar del resultado
if ($stmt2->execute()) {
    echo "Socio modificado con éxito";
    header("Location:socios.php");
    exit(); // Salir del script para evitar que se siga ejecutando el código después de la actualización
} else {
    echo "Error: " . $stmt2->error;
    header("Location:socios.php");
}
// Cerrar la declaración y la conexión
$stmt2->close();
