<?php
include '../esencial/conexion.php';

 // Recibir los datos del formulario
 $alumno = $_POST['alumno'];
 $clase = $_POST['clase'];
 $fecha = $_POST['fecha'];
 $hora = $_POST['hora'];
 $estado = 1;

 // Preparar la consulta de inserción con parámetros
 $query = "INSERT INTO cita (codigo_socio, codigo_servicio, fecha, hora, estado) VALUES (?, ?, ?, ?, ?)";
 $stmt = $conexion->prepare($query);

 // Enlazar los parámetros (s: string, i: integer)
 $stmt->bind_param("sisss", $alumno, $clase, $fecha, $hora, $estado);

 // Ejecutar la consulta e informar del resultado
 if ($stmt->execute()) {
 } else {
   echo "Error: " . $stmt->error;
 }

 // Cerrar la declaración y la conexión
 $stmt->close();
 
 echo "Cita creada correctamente";
 header('Refresh: 0.1; url=clases.php');


?>