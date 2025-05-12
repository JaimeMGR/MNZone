<?php
include '../esencial/conexion.php';



// Incluir Bootstrap
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';

// Función para traducir texto con LibreTranslate
function traducirTexto($texto, $source = 'EN', $target = 'ES')
{
    if (empty($texto)) return '';

    $apiKey = "77de0dee-3aa9-4934-8f1a-5f786fd3ee71:fx"; // Sustituye con tu clave de DeepL
    $url = "https://api-free.deepl.com/v2/translate";

    $data = [
        'text' => $texto,
        'source_lang' => strtoupper($source),
        'target_lang' => strtoupper($target)
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\nAuthorization: DeepL-Auth-Key $apiKey",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        return $texto;
    }

    $result = json_decode($response, true);
    return $result['translations'][0]['text'] ?? $texto;
}
// Haz otra funcion para traducir de español a inglés
function traducirTextoAIngles($texto, $source = 'ES', $target = 'EN')
{
    if (empty($texto)) return '';

    $apiKey = "77de0dee-3aa9-4934-8f1a-5f786fd3ee71:fx"; // Sustituye con tu clave de DeepL
    $url = "https://api-free.deepl.com/v2/translate";

    $data = [
        'text' => $texto,
        'source_lang' => strtoupper($source),
        'target_lang' => strtoupper($target)
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\nAuthorization: DeepL-Auth-Key $apiKey",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        return $texto;
    }

    $result = json_decode($response, true);
    return $result['translations'][0]['text'] ?? $texto;
}


// 📌 TRADUCIR INGREDIENTES
function traducirIngredientes($receta)
{
    for ($i = 1; $i <= 20; $i++) {
        $ingredienteKey = "strIngredient" . $i;
        if (!empty($receta[$ingredienteKey])) {
            $receta[$ingredienteKey] = traducirTexto($receta[$ingredienteKey], 'EN', 'ES');
        }
    }
    return $receta;
}




// Función para buscar recetas y traducirlas
function buscarRecetas($nombreReceta)
{
    $nombreReceta = traducirTextoAIngles($nombreReceta);
    if (empty($nombreReceta)) {
        echo "<div class='alert alert-warning text-center'>Por favor, introduce un nombre de receta.</div>";
        return;
    }

    $url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($nombreReceta);
    // limita los resultados a 10
    $url .= "&limit=10";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (!isset($data['meals'])) {
        echo "<div class='alert alert-danger text-center'>No se encontró ninguna receta con ese nombre.</div>";
        return;
    }

    echo "<div class='container mt-4'>";
    echo "<div class='row'>";

    foreach ($data['meals'] as $receta) {
        // Traducir los textos clave
        $tituloTraducido = traducirTexto($receta['strMeal']);
        $categoriaTraducida = traducirTexto($receta['strCategory']);
        $areaTraducida = traducirTexto($receta['strArea']);
        $instruccionesTraducidas = traducirTexto($receta['strInstructions']);

        echo "<div class='col-md-4 mb-4'>";
        echo "<div class='card h-100 shadow-sm'>";
        echo "<img src='" . $receta['strMealThumb'] . "' class='card-img-top' alt='" . $tituloTraducido . "'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title text-primary'>$tituloTraducido</h5>";
        echo "<p class='badge bg-success'>$categoriaTraducida</p> ";
        echo "<p class='badge bg-warning text-dark'>$areaTraducida</p><br>";
        echo "<button class='btn btn-info mt-2' data-bs-toggle='modal' data-bs-target='#modal" . $receta['idMeal'] . "'>Ver detalles</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        // Modal con detalles de la receta
        echo "<div class='modal fade' id='modal" . $receta['idMeal'] . "' tabindex='-1' aria-hidden='true'>";
        echo "<div class='modal-dialog modal-lg'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title text-primary'>$tituloTraducido</h5>";
        echo "<button type='button' class='btn-close' data-bs-dismiss='modal'></button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        echo "<img src='" . $receta['strMealThumb'] . "' class='img-fluid mb-3' alt='$tituloTraducido'>";
        echo "<h6 class='text-secondary'>Categoría: $categoriaTraducida | Origen: $areaTraducida</h6>";
        echo "<h5 class='mt-3'>🛒 Ingredientes:</h5>";
        echo "<ul class='list-group'>";

        for ($i = 1; $i <= 20; $i++) {
            if (!empty($receta["strIngredient$i"])) {
                // 📌 SI HAY RECETAS, TRADUCIMOS LOS INGREDIENTES

                $ingredientetraducodo = traducirTexto($receta["strIngredient$i"]);
                $cantidadtraducida = traducirTexto($receta["strMeasure$i"]);
                echo "<li class='list-group-item'>✅ " . $ingredientetraducodo . " (" . $cantidadtraducida . ")</li>";
            }
        }


        echo "</ul>";
        echo "<h5 class='mt-3'>📜 Instrucciones:</h5>";
        echo "<p>$instruccionesTraducidas</p>";
        echo "<p><strong>🎥 Tutorial:</strong> <a href='" . $receta['strYoutube'] . "' target='_blank' class='btn btn-danger btn-sm'>Ver en YouTube</a></p>";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
    echo "</div>";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas - Atarfe Fighting</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="js/app.js" defer></script>
    <link rel="icon" type="image/ico" href="../../imagenes/Logo.ico" />
    <script src="../../js/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include '../esencial/header.php' ?>
    <main>


        <h1 style="font-weight: bold; text-align: center">Bienvenido al buscador de recetas</h1>
        <div class="container mt-5">
            <p>Esta sección contiene recetas para que aprendas a comer bien, y también te acompañamos con la traducción de los textos clave para que puedas verlos en tu idioma preferido.</p>
            <!-- Formulario de búsqueda -->
            <?php if (isset($_SESSION["nombre"]) && $pagina_actual == "socios.php" && isset($_SESSION["tipo"]) == "admin" || isset($_SESSION["tipo"]) == "socio") { ?>
                <form method="GET" class="mt-4">
                    <div class="input-group">
                        <input type="text" name="receta" class="form-control" placeholder="Introduce el nombre de la receta o ingrediente que le interese" required>
                        <button type="submit" class="btn btn-warning">Buscar</button>
                    </div>
                </form>

                <?php
                // Si el usuario ha buscado una receta, mostrar la información
                if (isset($_GET['receta'])) {
                    buscarRecetas($_GET['receta']);
                }
                ?>
        </div>
    <?php } else { 
        header ("Location:../../index.php");
     } ?>
    </main>
    <?php include '../esencial/footer.php' ?>

</body>

</html>