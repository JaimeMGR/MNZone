<?php
require_once "../api_crud/funciones.php";
require_once "../api_crud/config.php";
require_once "../../esencial/conexion.php";

$id_producto = intval($_GET['id']);

// Si el ID está presente, realizar la eliminación
if (
    isset($_POST["nombre"])
    && isset($_POST["compania"])
    && isset($_FILES['imagen'])
    && isset($_POST["precio"])
    && isset($_POST["categoria"])
) {


    $nombre_producto = $_POST["nombre"];
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

    var_dump(        
    $precio);

    echo '<br>';

    $resultado = modificarProducto(
        $conn,
        $id_producto,
        $nombre_producto,
        $compania,
        "productos/$nombre_imagen",
        $precio,
        $categoria
    );
    http_response_code($resultado["http"]);
    echo json_encode($resultado["respuesta"]);
    header("Location: ../tienda.php");
    } else {
        echo '<p>Producto no encontrado.</p>';
    }
    ?>


    <a href="index.php" style="color:darkgreen">Volver al listado</a>
</body>

</html>