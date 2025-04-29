<?php

require_once "../api_crud/funciones.php";
require_once "../api_crud/config.php";
require_once "../../esencial/conexion.php";

// Si el ID está presente, realizar la eliminación
if (
    isset($_POST["nombre_producto"])
    && isset($_POST["compania"])
    && isset($_FILES["imagen"])
    && isset($_POST["precio"])
    && isset($_POST["categoria"])
) {


    $nombre_producto = $_POST["nombre_producto"];
    $compania = $_POST["compania"];
    $imagen = $_FILES["imagen"];
    $precio = intval($_POST["precio"]);
    $categoria = $_POST["categoria"];

    $nombre_imagen = md5(random_bytes(32)) . '.jpg';

    move_uploaded_file(
        $imagen["tmp_name"],
        '../productos/' . $nombre_imagen,
    );

    $conn = conectar($nombre_host, $nombre_usuario, $password_db, $nombre_db);
    $resultado = crearProducto(
        $conn,
        $nombre_producto,
        $compania,
        $nombre_imagen,
        $precio,
        $categoria
    );
    http_response_code($resultado["http"]);
    echo json_encode($resultado["respuesta"]);
    header("Location: ../tienda.php");
} else {
    echo "ID no indicado para eliminar.";
}
