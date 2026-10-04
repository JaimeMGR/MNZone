<?php

require_once "php/esencial/conexion.php";

$nuevaPassword = "Administrador";

$hash = password_hash(
    $nuevaPassword,
    PASSWORD_DEFAULT
);

$stmt = $conexion->prepare(
    "UPDATE socio
     SET contrasena = ?
     WHERE usuario = 'Admin'
       AND tipo = 'admin'"
);

$stmt->bind_param("s", $hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Contraseña del administrador actualizada correctamente.";
} else {
    echo "No se ha actualizado ninguna cuenta.";
}

$stmt->close();
$conexion->close();