<?php
include '../esencial/conexion.php';

if (isset($_SESSION["nombre"]) && $pagina_actual == "modificar_datos_servicio.php" && $_SESSION["tipo"] == "admin") {

$id_servicio = $_GET['id'];

// Verificar que se ha recibido un ID válido
if (empty($id_servicio)) {
    echo "Error: ID de servicio no especificado.";
    exit();
}

// Preparar la consulta para obtener los datos actuales
$query = "SELECT codigo_servicio, descripcion, horario, duracion, imagen FROM servicio WHERE codigo_servicio = ?";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    echo "Error al preparar la consulta: " . $conexion->error;
    exit();
}

// Enlazar el parámetro del ID y ejecutar
$stmt->bind_param("i", $id_servicio);
$stmt->execute();
$stmt->bind_result($codigo_servicio, $descripcion_actual, $horario_actual, $duracion_actual, $imagen_actual);

// Verificar si se encontraron resultados
if (!$stmt->fetch()) {
    echo "Error: Servicio no encontrado.";
    $stmt->close();
    exit();
}
$stmt->close();

// Recibir los datos del formulario
$descripcion = !empty($_POST['descripcion']) ? $_POST['descripcion'] : $descripcion_actual;
$horario = !empty($_POST['horario']) ? $_POST['horario'] : $horario_actual;
$duracion = !empty($_POST['duracion']) ? $_POST['duracion'] : $duracion_actual;

// Procesar y guardar la imagen si se subió una nueva
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $imagen = "imagenes/" . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);
} else {
    $imagen = $imagen_actual; // Mantener la imagen actual si no se subió una nueva
}

// Si ya existe una foto con ese nombre, cambiar el nombre
if (file_exists("../../imagenes/$imagen")) {
    $imagen = time() . "_" . $imagen;
}

// Preparar la consulta de actualización
$query2 = "UPDATE servicio SET descripcion = ?, horario = ?, duracion = ?, imagen = ? WHERE codigo_servicio = ?";
$stmt2 = $conexion->prepare($query2);

if (!$stmt2) {
    echo "Error al preparar la consulta de actualización: " . $conexion->error;
    exit();
}

// Enlazar los parámetros actualizados
$stmt2->bind_param("ssisi", $descripcion, $horario, $duracion, $imagen, $codigo_servicio);

// Ejecutar la consulta e informar del resultado
if ($stmt2->execute()) {
    echo "Servicio actualizado con éxito";
    header("Location: servicios.php");
} else {
    echo "Error al actualizar el servicio: " . $stmt2->error;
}

// Cerrar la declaración y la conexión
$stmt2->close();
$conexion->close();
} else {
    header("Location:servicios.php");
}