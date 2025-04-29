<?php
// Encabezados para permitir CORS
header("Access-Control-Allow-Origin: *"); // Permite todas las solicitudes de origen
// Establecer tipo de contenido en JSON
header("Content-Type: application/json");


// Configuración de la base de datos
require "config.php";
require "funciones.php";

try {
    $conn = conectar($nombre_host, $nombre_usuario, $password_db, $nombre_db);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al conectar con la base de datos"]);
    die();
}

// Determinar el método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == "POST" || $metodo == "PUT") {
    $entrada = json_decode(file_get_contents("php://input"), true);
}

// Parámetros de paginación con valores predeterminados
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 10;

switch ($metodo) {
    case 'GET':

        if (isset($_GET['id'])) {
            // Obtener una producto por ID
            $resultado = obtenerProductoporId($conn, $_GET["id"]);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else if (isset($_GET['categoria'])) {
            if ($_GET['categoria'] == "") {
                $resultado = obtenerproductosPag($conn, $page, $limit);
                http_response_code($resultado["http"]);
                echo json_encode($resultado["respuesta"]);
            } else {
                // Obtener productos por categoría
                $resultado = obtenerProductoporCategoria($conn, $_GET["categoria"], $page, $limit);
                http_response_code($resultado["http"]);
                echo json_encode($resultado["respuesta"]);
            }
        } else if (isset($_GET['nombre_producto'])) {
            // Obtener productos por categoría
            $resultado = obtenerProductoporNombre($conn, $_GET["nombre_producto"], $page, $limit);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else if (isset($_GET['precio'])) {
            // Obtener productos por precio
            $resultado = obtenerProductoporPrecio($conn, $_GET["precio"], $page, $limit);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else {
            if ($page < 1 || $limit < 1) {
                http_response_code(400); // Bad Request
                echo json_encode([
                    "error" => "Parámetros de paginación inválidos"
                ]);
                die();
            }

            $resultado = obtenerproductosPag($conn, $page, $limit);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        }
        break;


    case 'POST':
        if (
            isset($entrada["nombre_producto"]) && isset($entrada["compania"]) && isset($entrada["imagen"]) && isset($entrada["precio"]) && isset($entrada["categoria"])
        ) {
            $resultado = crearProducto(
                $conn,
                $entrada["nombre_producto"],
                $entrada["compania"],
                $entrada["imagen"],
                $entrada["precio"],
                $entrada["categoria"]
            );
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos"]);
        }

        break;

    case 'PUT':
        if (
            isset($entrada["nombre_producto"]) && isset($entrada["compania"]) && isset($entrada["imagen"]) && isset($entrada["precio"]) && isset($entrada["categoria"])
        ) {
            $resultado = modificarProducto(
                $conn,
                $entrada["id_producto"],
                $entrada["nombre_producto"],
                $entrada["compania"],
                $entrada["imagen"],
                $entrada["precio"],
                $entrada["categoria"]
            );
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos"]);
        }
        break;

    case 'DELETE':
        if (isset($_GET["id"])) {
            $resultado = borrarProducto($conn, $_GET["id"]);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no soportado"]);
}

// Cerrar la conexión
$conn->close();
