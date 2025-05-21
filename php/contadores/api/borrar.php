<?php

require_once "../api_crud/funciones.php";
require_once "../api_crud/config.php";

// Si el ID está presente, realizar la eliminación
if (isset($_GET['id'])) {

    $conn = conectar($nombre_host, $nombre_usuario, $password_db, $nombre_db);
    $resultado = borrarProducto($conn, $_GET["id"]);
    http_response_code($resultado["http"]);
    echo json_encode($resultado["respuesta"]);
    header("Location: ../tienda.php");
} else {
    echo "ID no indicado para eliminar.";
}
