<?php
include '../esencial/conexion.php';


// Método para eliminar o cancelar reservas

  $accion = $_POST['accion'];
  $idReserva = (int) $_POST['id_reserva'];

  if ($accion === 'cancelar') {
      // Cambiar el estado de la reserva a "0" (Cancelada)
      $query = "UPDATE reservas SET estado = 0 WHERE id_reserva = $idReserva";
      if ($conexion->query($query)) {
          echo "Reserva cancelada exitosamente.";
      } else {
          echo "Error al cancelar la reserva: " . $conexion->error;
      }
  } elseif ($accion === 'eliminar') {
      // Eliminar la reserva de la base de datos
      $query = "DELETE FROM reservas WHERE id_reserva = $idReserva";
      if ($conexion->query($query)) {
          echo "Reserva eliminada exitosamente.";
      } else {
          echo "Error al eliminar la reserva: " . $conexion->error;
      }
  }


// quiero que a los 3 segundos serediriga a otra página

$conexion->close();
header('Refresh: 0.1; url=reservas.php');
?>