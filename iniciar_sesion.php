<?php

session_start();
require_once "php/esencial/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $origen = $_SERVER['HTTP_REFERER'] ?? 'index.php';

    // Si están vacíos te redirecciona con error.
    if (empty($username) || empty($password)) {
        header("Location: " . $origen . "?error=2");
        exit();
    }

    $stmt = $conexion->prepare(
        "SELECT id_socio, contrasena, tipo FROM socio WHERE usuario = ?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['contrasena'])) {
            $_SESSION['nombre'] = $username;
            $_SESSION['tipo'] = $row['tipo'];

            $stmt->close();
            $conexion->close();

            header("Location: " . $origen);
            exit();
        }
    }

    $stmt->close();
    $conexion->close();

    header("Location: " . $origen . "?error=1");
    exit();
}
