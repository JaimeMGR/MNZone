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

        if (isset($_GET['nombre'])) {
            // Obtener una producto por ID
            $resultado = obtenerTiempoPorUsuario($conn, $_GET["nombre"]);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else if (isset($_GET['usuario']) && isset($_GET['categoria'])) {
            $resultado = obtenerTiempoPorCategoria($conn, $_GET['usuario'], $_GET['categoria']);
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
            break;
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos"]);
        }
        break;


    case 'POST':
        if (
            isset($_GET["id_socio"]) && isset($_GET["nombre"]) && $_GET["id_producto"]
        ) {
            $resultado = sumarTiempo(
                $conn,
                $_GET["id_socio"],
                $_GET["nombre"],
                $_GET["id_producto"]
            );
            http_response_code($resultado["http"]);
            echo json_encode($resultado["respuesta"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos"]);
        }

        break;

    case 'PUT':
        ;

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
