<?php
require_once "config.php";

function conectar($host, $usuario, $password, $base_datos)
{
	$conexion = new mysqli($host, $usuario, $password, $base_datos);
	$conexion->set_charset('utf8');
	return $conexion;
}


function obtenerProductoporId($conexion, $id_producto)
{
	global $tabla_productos;

	$consulta = "SELECT * FROM $tabla_productos WHERE id_producto=?";
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bind_param("i", $id_producto);
	$sentencia->execute();
	$resultado = $sentencia->get_result();
	if ($resultado->num_rows == 1) {
		$producto = $resultado->fetch_assoc();
		$salida["http"] = 200;
		$salida["respuesta"] = ["datos" => $producto];
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No se encuentra el producto"];
	}

	$sentencia->close();

	return $salida;
}

function obtenerProductos($conexion)
{
	global $tabla_productos;

	$consulta = "SELECT * FROM $tabla_productos";
	$sentencia = $conexion->prepare($consulta);
	$sentencia->execute();
	$resultado = $sentencia->get_result();
	if ($resultado->num_rows == 1) {
		$producto = $resultado->fetch_assoc();
		$salida["http"] = 200;
		$salida["respuesta"] = ["datos" => $producto];
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No se encuentra el producto"];
	}

	$sentencia->close();

	return $salida;
}

function obtenerProductoporCategoria($conexion, $categoria, $pagina, $limite)
{
	global $tabla_productos;

	$offset = ($pagina - 1) * $limite;
	$consulta = "SELECT * FROM $tabla_productos WHERE categoria=? LIMIT ? OFFSET ?;";
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bind_param("sii", $categoria, $limite, $offset);
	$sentencia->execute();
	$resultado = $sentencia->get_result();

	if ($resultado->num_rows > 0) {
		$datos = [];
		while ($fila = $resultado->fetch_assoc()) {
			$datos[] = [
				"id_producto" => $fila["id_producto"],
				"nombre_producto" => $fila["nombre_producto"],
				"compania" => $fila["compania"],
				"imagen" => $fila["imagen"],
				"precio" => $fila["precio"],
				"categoria" => $fila["categoria"]
			];
		}

		$consulta = "SELECT count(*) FROM $tabla_productos WHERE categoria=?";
		$sentencia = $conexion->prepare($consulta);
		$sentencia->bind_param("s", $categoria);
		$sentencia->execute();
		$resultado = $sentencia->get_result();
		$fila = $resultado->fetch_row();
		$total = $fila[0];

		$salida["http"] = 200;
		$salida["respuesta"] = [
			"datos" => $datos,
			"paginacion" => [
				"actual" => $pagina,
				"limite" => $limite,
				"total" => $total,
				"paginas" => ceil($total / $limite)
				// "anterior"=>null
				// "siguiente"=>"http://...api.php?page=3&limit=$limit"

			]
		];
		$sentencia->close();
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No hay resultados"];
	}

	return $salida;
}

function obtenerProductoporNombre($conexion, $nombre_producto, $pagina, $limite)
{
	global $tabla_productos;
	$offset = ($pagina - 1) * $limite;
	$nombre_producto = "%$nombre_producto%";
	$consulta = "SELECT * FROM $tabla_productos 
				WHERE nombre_producto LIKE ?
				 LIMIT ? OFFSET ?;";
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bind_param("sii", $nombre_producto, $limite, $offset);
	$sentencia->execute();
	$resultado = $sentencia->get_result();

	if ($resultado->num_rows > 0) {
		$datos = [];
		while ($fila = $resultado->fetch_assoc()) {
			$datos[] = [
				"id_producto" => $fila["id_producto"],
				"nombre_producto" => $fila["nombre_producto"],
				"compania" => $fila["compania"],
				"imagen" => $fila["imagen"],
				"precio" => $fila["precio"],
				"categoria" => $fila["categoria"]
			];
		}

		$consulta = "SELECT count(*) FROM $tabla_productos WHERE nombre_producto=?";
		$sentencia = $conexion->prepare($consulta);
		$sentencia->bind_param("s", $nombre_producto);
		$sentencia->execute();
		$resultado = $sentencia->get_result();
		$fila = $resultado->fetch_row();
		$total = $fila[0];

		$salida["http"] = 200;
		$salida["respuesta"] = [
			"datos" => $datos,
			"paginacion" => [
				"actual" => $pagina,
				"limite" => $limite,
				"total" => $total,
				"paginas" => ceil($total / $limite)
				// "anterior"=>null
				// "siguiente"=>"http://...api.php?page=3&limit=$limit"

			]
		];
		$sentencia->close();
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No hay resultados"];
	}

	return $salida;
}

function obtenerProductoporPrecio($conexion, $precio, $pagina, $limite)
{
	global $tabla_productos;

	$offset = ($pagina - 1) * $limite;
	$consulta = "SELECT * FROM $tabla_productos WHERE precio>=? LIMIT ? OFFSET ?;";
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bind_param("iii", $precio, $limite, $offset);
	$sentencia->execute();
	$resultado = $sentencia->get_result();

	if ($resultado->num_rows > 0) {
		$datos = [];
		while ($fila = $resultado->fetch_assoc()) {
			$datos[] = [
				"id_producto" => $fila["id_producto"],
				"nombre_producto" => $fila["nombre_producto"],
				"compania" => $fila["compania"],
				"imagen" => $fila["imagen"],
				"precio" => $fila["precio"],
				"categoria" => $fila["categoria"]
			];
		}

		$consulta = "SELECT count(*) FROM $tabla_productos";
		$resultado = $conexion->query($consulta);
		$fila = $resultado->fetch_row();
		$total = $fila[0];

		$salida["http"] = 200;
		$salida["respuesta"] = [
			"datos" => $datos,
			"paginacion" => [
				"actual" => $pagina,
				"limite" => $limite,
				"total" => $total,
				"paginas" => ceil($total / $limite)
				// "anterior"=>null
				// "siguiente"=>"http://...api.php?page=3&limit=$limit"

			]
		];
		$sentencia->close();
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No hay resultados"];
	}

	return $salida;
}

function obtenerproductosPag($conexion, $pagina, $limite)
{
	global $tabla_productos;

	$offset = ($pagina - 1) * $limite;
	$consulta = "SELECT * FROM $tabla_productos 
		           LIMIT ? OFFSET ?";

	$sentencia = $conexion->prepare($consulta);
	$sentencia->bind_param("ii", $limite, $offset);
	$sentencia->execute();
	$resultado = $sentencia->get_result();

	if ($resultado->num_rows > 0) {
		$datos = [];
		while ($fila = $resultado->fetch_assoc()) {
			$datos[] = [
				"id_producto" => $fila["id_producto"],
				"nombre_producto" => $fila["nombre_producto"],
				"compania" => $fila["compania"],
				"imagen" => $fila["imagen"],
				"precio" => $fila["precio"],
				"categoria" => $fila["categoria"]
			];
		}

		$consulta = "SELECT count(*) FROM $tabla_productos";
		$resultado = $conexion->query($consulta);
		$fila = $resultado->fetch_row();
		$total = $fila[0];

		$salida["http"] = 200;
		$salida["respuesta"] = [
			"datos" => $datos,
			"paginacion" => [
				"actual" => $pagina,
				"limite" => $limite,
				"total" => $total,
				"paginas" => ceil($total / $limite)
				// "anterior"=>null
				// "siguiente"=>"http://...api.php?page=3&limit=$limit"

			]
		];
		$sentencia->close();
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No hay resultados"];
	}

	return $salida;
}

function crearProducto($conexion, $nombre_producto, $compania, $imagen, $precio, $categoria)
{

	if (trim($nombre_producto) != "" && is_integer($precio)) {
		$consulta = "INSERT INTO productos (nombre_producto,compania,imagen,precio,categoria) 
			           VALUES (?,?,?,?,?)";
		$sentencia = $conexion->prepare($consulta);
		$imagen = "productos/$imagen";
		$sentencia->bind_param("sssis", $nombre_producto, $compania, $imagen, $precio, $categoria);
		$sentencia->execute();
		$salida["http"] = 200;
		$salida["respuesta"] = ["id_insertado" => $sentencia->insert_id];
		// Ruta del archivo lista_productos.js
		$archivo_js = "../lista_productos.js";

		// Verificar si el archivo existe, si no, crearlo con una lista vacía
		if (!file_exists($archivo_js)) {
			file_put_contents($archivo_js, "let lista = {};");
		}

		// Leer el contenido actual del archivo
		$contenido_js = file_get_contents($archivo_js);

		// Extraer la parte JSON del archivo
		preg_match('/lista\s*=\s*({.*})/s', $contenido_js, $matches);

		if (isset($matches[1])) {
			$json_actual = json_decode($matches[1], true);
		} else {
			$json_actual = [];
		}

		// Agregar el nuevo producto con su ID como clave
		$json_actual[$sentencia->insert_id] = [
			"id_producto" => $sentencia->insert_id,
			"nombre_producto" => $nombre_producto,
			"compania" => $compania,
			"imagen" => "$imagen",
			"precio" => floatval($precio),
			"categoria" => $categoria
		];

		// Convertir de nuevo a JSON
		$nuevo_json = json_encode($json_actual, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

		// Reemplazar la parte de la lista en el archivo JS
		$contenido_js = "let lista = " . $nuevo_json . ";";

		// Guardar el archivo actualizado
		file_put_contents($archivo_js, $contenido_js);

		$sentencia->close();
	} else {
		$salida["http"] = 400;
		$salida["respuesta"] = ["error" => "Error en los datos"];
	}

	return $salida;
}

function modificarProducto($conexion, $id_producto, $nombre_producto, $compania, $imagen, $precio, $categoria)
{

	if (
		is_integer($id_producto) &&
		trim($nombre_producto) != "" &&
		trim($compania) != "" &&
		trim($imagen) != "" &&
		is_integer($precio) &&
		trim($categoria) != ""
	) {

		$consulta = "UPDATE productos 
			           SET nombre_producto=?, compania=?, imagen=?, precio=?, categoria=? 
		               WHERE id_producto=?";
		$sentencia = $conexion->prepare($consulta);
		$sentencia->bind_param("sssisi", $nombre_producto, $compania, $imagen, $precio, $categoria, $id_producto);
		$sentencia->execute();
		$salida["http"] = 200;
		$salida["respuesta"] = ["mensaje" => "Modificacion realizada"];
		// Ruta del archivo lista_productos.js
		$archivo_js = "../lista_productos.js";

		// Verificar si el archivo existe, si no, crearlo con una lista vacía
		if (!file_exists($archivo_js)) {
			file_put_contents($archivo_js, "let lista = {};");
		}

		// Leer el contenido actual del archivo
		$contenido_js = file_get_contents($archivo_js);

		// Extraer la parte JSON del archivo
		preg_match('/lista\s*=\s*({.*})/s', $contenido_js, $matches);

		if (isset($matches[1])) {
			$json_actual = json_decode($matches[1], true);
		} else {
			$json_actual = [];
		}

		// Modificar el producto con su ID como clave
		$json_actual[$id_producto] = [
			"id_producto" => $id_producto,
			"nombre_producto" => $nombre_producto,
			"compania" => $compania,
			"imagen" => "$imagen",
			"precio" => floatval($precio),
			"categoria" => $categoria
		];

		// Convertir de nuevo a JSON
		$nuevo_json = json_encode($json_actual, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

		// Reemplazar la parte de la lista en el archivo JS
		$contenido_js = "let lista = " . $nuevo_json . ";";

		// Guardar el archivo actualizado
		file_put_contents($archivo_js, $contenido_js);


		$sentencia->close();
	} else {
		$salida["http"] = 400;
		$salida["respuesta"] = ["error" => "Error en los datos"];

		var_dump($id_producto, $nombre_producto, $compania, $imagen, $precio, $categoria);
	}

	return $salida;
}

function borrarProducto($conexion, $id_producto)
{

	if (is_numeric($id_producto)) {
		$consulta = "DELETE FROM productos WHERE id_producto=?";
		$sentencia = $conexion->prepare($consulta);
		$sentencia->bind_param("i", $id_producto);
		$sentencia->execute();
		if ($conexion->affected_rows == 1) {
			$salida["http"] = 200;
			$salida["respuesta"] = ["mensaje" => "Borrado realizado"];
		} else {
			$salida["http"] = 404;
			$salida["respuesta"] = ["error" => "No existe el  id"];
		}
		$sentencia->close();
	} else {
		$salida["http"] = 400;
		$salida["respuesta"] = ["error" => "Error en los datos"];
	}

	return $salida;
}
