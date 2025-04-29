<?php
include '../esencial/conexion.php';


// Método para eliminar o cancelar citas

  $accion = $_POST['accion'];
  $idCita = (int) $_POST['id_cita'];

  if ($accion === 'cancelar') {
      // Cambiar el estado de la cita a "0" (Cancelada)
      $query = "UPDATE cita SET estado = 0 WHERE id_cita = $idCita";
      if ($conexion->query($query)) {
          echo "Cita cancelada exitosamente.";
      } else {
          echo "Error al cancelar la cita: " . $conexion->error;
      }
  } elseif ($accion === 'eliminar') {
      // Eliminar la cita de la base de datos
      $query = "DELETE FROM cita WHERE id_cita = $idCita";
      if ($conexion->query($query)) {
          echo "Cita eliminada exitosamente.";
      } else {
          echo "Error al eliminar la cita: " . $conexion->error;
      }
  }


// quiero que a los 3 segundos serediriga a otra página

header('Refresh: 0.1; url=clases.php');

$conexion->close();
?>