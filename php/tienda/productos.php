<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clubdeportivo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT id, nombre, companía, precio, imagen, Categoría FROM productos"; // Ajusta esta consulta según tu base de datos
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    // Almacenar productos en un array
    while($row = $result->fetch_assoc()) {
        $lista[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'companía' => $row['companía'],
            'precio' => $row['precio'],
            'image' => $row['imagen'],
            'categoria' => $row['Categoría']
            
        ];
        var_dump($row['id']);
        ?><br><?php
        var_dump($row['nombre']);
        ?><br><?php
        var_dump($row['companía']);
        ?><br><?php
        var_dump($row['precio']);
        ?><br><?php
        var_dump($row['imagen']);
        ?><br><br><?php
    }
} 
// Cerrar la conexión
$conn->close();

// Devolver los productos en formato JSON
echo json_encode($lista);
?>
