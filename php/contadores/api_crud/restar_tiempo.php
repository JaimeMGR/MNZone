<?php
header("Content-Type: application/json");
require "config.php";
require "funciones.php";

$conn = conectar($nombre_host, $nombre_usuario, $password_db, $nombre_db);
$data = json_decode(file_get_contents("php://input"), true);

$usuario = $data["usuario"] ?? null;
$categoria = $data["categoria"] ?? null;
$tiempo = $data["tiempo_restar"] ?? 0;

if (!$usuario || !$categoria || !$tiempo) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Faltan parámetros"]);
    exit;
}

$stmt = $conn->prepare("UPDATE tiempos_sala SET tiempo_total = GREATEST(tiempo_total - ?, 0) WHERE usuario = ? AND categoria = ?");
$stmt->bind_param("iss", $tiempo, $usuario, $categoria);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "mensaje" => "No se actualizó tiempo"]);
}
