<?php
include '../esencial/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $contenido = $_POST['contenido'];
    var_dump($contenido);
    $socio = $_POST['socio'];
    var_dump($socio);
    // Crea una variable llamada fecha cuyo valor sea hoy
    $fecha = time();
    // Convierte la fecha y hora de Unix a formato HH:MM:SS
    $fecha = date('Y-m-d', $fecha);

    // Preparar la consulta de inserción con parámetros
    $query = "INSERT INTO testimonio (autor, contenido, fecha) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);

    // Enlazar los parámetros (s: string, i: integer)
    $stmt->bind_param("sss",  $socio,$contenido, $fecha);

    // Ejecutar la consulta e informar del resultado
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
}

header('Location: ../../index.php');

?>