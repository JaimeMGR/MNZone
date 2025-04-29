<?php
// URL del backend (API) con parámetros de paginación
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 10;
$apiUrl = "http://localhost/MNZone/php/tienda/api_crud/api.php?page=$page&limit=$limit"; // Cambia esta URL al endpoint correcto
// echo $apiUrl;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Asignaturas</title>
    <link rel="stylesheet" href="estilos.css"> <!-- Vinculamos el archivo CSS -->
</head>

<body>
    <h1>Listado de Asignaturas</h1>

    <!-- Enlace para añadir nueva asignatura -->
    <a href="agregar.php" class="add">Añadir Nueva Asignatura</a>

    <?php
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        
        $respuesta = json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        

        if ($httpCode==200) {
            $asignaturasDisponibles=$respuesta["datos"];
            $paginacion=$respuesta["paginacion"];

            $actual = $paginacion['actual'];
            $total = $paginacion['paginas'];
            $limite = $paginacion['limite'];
            
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nombre de Asignatura</th>';
            echo '<th>Créditos</th>';
            echo '<th>Acciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Procesamos y mostramos las asignaturas
            foreach ($asignaturasDisponibles as $asignatura) {
                echo '<tr>';
                echo '<td>' . $asignatura['id_asignatura'] . '</td>';
                echo '<td>' . $asignatura['nombre_asignatura'] . '</td>';
                echo '<td>' . $asignatura['creditos'] . '</td>';
                echo '<td>';
                echo '<a href="editar.php?id=' . $asignatura['id_asignatura'] . '" class="edit">Editar</a> | ';
                echo '<a href="borrar.php?id=' . $asignatura['id_asignatura'] . '" class="delete" onclick="return confirm(\'¿Seguro que quieres borrar esta asignatura?\');">Borrar</a>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
          
            
    
            echo '<div class="pagination">';
    
                // Enlace a la página anterior (si no estamos en la primera)
            if ($actual > 1) {
                echo '<a class="paginacion" href="?page=' . ($actual - 1) . '&limit=' . $limite . '">Anterior</a>';
            }
    
            // Enlaces a las páginas
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $actual) {
                    echo '<span class="current">' . $i . '</span>';
                } else {
                    echo '<a class="paginacion" href="?page=' . $i . '&limit=' . $limite . '">' . $i . '</a>';
                }
            }
    
            // Enlace a la siguiente página (si no estamos en la última)
            if ($actual < $total) {
                echo '<a class="paginacion" href="?page=' . ($actual + 1) . '&limit=' . $limite . '">Siguiente</a>';
            }
    
            echo '</div>';
            
        } else {
            echo "<p>".$respuesta["error"]."</p>";
        }

        // Mostrar los controles de paginación
        
    ?>

</body>

</html>