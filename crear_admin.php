<?php

require_once "php/esencial/conexion.php";

// =========================
// CONFIGURA SOLO ESTO
// =========================
$usuario = "Admin";
$password = "Admin";
$nombre = "Administrador";
$edad = 22;
$telefono = "";
$foto = "";

// Generar hash bcrypt
$hash = password_hash($password, PASSWORD_DEFAULT);

// Comprobar si ya existe
$check = $conexion->prepare(
    "SELECT id_socio FROM socio WHERE usuario = ?"
);

$check->bind_param("s", $usuario);
$check->execute();

$resultado = $check->get_result();

if ($resultado->num_rows > 0) {
    echo "El usuario ya existe.";
    exit;
}

// Crear administrador
$stmt = $conexion->prepare(
    "INSERT INTO socio
    (nombre, edad, contrasena, usuario, telefono, foto, tipo)
    VALUES (?, ?, ?, ?, ?, ?, 'admin')"
);

$stmt->bind_param(
    "sissss",
    $nombre,
    $edad,
    $hash,
    $usuario,
    $telefono,
    $foto
);

if ($stmt->execute()) {
    echo "Administrador creado correctamente.";
} else {
    echo "Error al crear el administrador: " . $stmt->error;
}

$stmt->close();
$check->close();
$conexion->close();