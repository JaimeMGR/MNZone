<?php
require_once "config.php";

function conectar($host, $usuario, $password, $base_datos)
{
	$conexion = new mysqli($host, $usuario, $password, $base_datos);
	$conexion->set_charset('utf8');
	return $conexion;
}


function obtenerTiempoPorUsuario($conexion, $usuario)
{

	$consulta = "SELECT categoria, tiempo_total FROM tiempos_sala WHERE usuario=?";
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bind_param("s", $usuario);
	$sentencia->execute();
	$resultado = $sentencia->get_result();

	if ($resultado->num_rows > 0) {
		$tiempos = [];
		while ($fila = $resultado->fetch_assoc()) {
			$tiempos[$fila["categoria"]] = $fila["tiempo_total"];
		}
		$salida["http"] = 200;
		$salida["respuesta"] = ["tiempos" => $tiempos];
	} else {
		$salida["http"] = 404;
		$salida["respuesta"] = ["error" => "No se encontraron tiempos para el usuario"];
	}

	$sentencia->close();
	return $salida;
}

function obtenerTiempoPorCategoria($conexion, $usuario, $categoria)
{
    $consulta = "SELECT usuario, categoria, tiempo_total FROM tiempos_sala WHERE usuario = ? AND categoria = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bind_param("ss", $usuario, $categoria);
    $sentencia->execute();
    $resultado = $sentencia->get_result();

    if ($resultado->num_rows > 0) {
        $tiempos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tiempos[$fila["categoria"]] = $fila["tiempo_total"];
        }
        $salida["http"] = 200;
        $salida["respuesta"] = ["tiempos" => $tiempos];
    } else {
        $salida["http"] = 404;
        $salida["respuesta"] = ["error" => "No se encontraron tiempos para el usuario en esa categoría"];
    }

    $sentencia->close();
    return $salida;
}



function sumarTiempo($conexion, $id_socio, $usuario, $id_producto)
{
    // Obtener la categoría y duración del producto
    $consulta_producto = "SELECT categoria, duracion FROM productos WHERE id_producto=?";
    $sentencia_producto = $conexion->prepare($consulta_producto);
    $sentencia_producto->bind_param("i", $id_producto);
    $sentencia_producto->execute();
    $resultado_producto = $sentencia_producto->get_result();

    if ($resultado_producto->num_rows == 1) {
        $producto = $resultado_producto->fetch_assoc();
        $categoria = $producto["categoria"];
        $duracion = $producto["duracion"];

        // Verificar si ya existe un registro para el socio y la categoría
        // CORRECCIÓN: Cambiar 'usuario' por 'id_socio' en la comparación
        $consulta_tiempo = "SELECT tiempo_total FROM tiempos_sala WHERE id_socio=? AND categoria=?";
        $sentencia_tiempo = $conexion->prepare($consulta_tiempo);
        $sentencia_tiempo->bind_param("is", $id_socio, $categoria);
        $sentencia_tiempo->execute();
        $resultado_tiempo = $sentencia_tiempo->get_result();

        if ($resultado_tiempo->num_rows == 1) {
            // Actualizar el tiempo existente
            $fila_tiempo = $resultado_tiempo->fetch_assoc();
            $nuevo_tiempo = $fila_tiempo["tiempo_total"] + $duracion;

            $consulta_actualizar = "UPDATE tiempos_sala SET tiempo_total=? WHERE id_socio=? AND categoria=?";
            $sentencia_actualizar = $conexion->prepare($consulta_actualizar);
            $sentencia_actualizar->bind_param("iis", $nuevo_tiempo, $id_socio, $categoria);
            $sentencia_actualizar->execute();
        } else {
            // Insertar un nuevo registro
            $consulta_insertar = "INSERT INTO tiempos_sala (id_socio, usuario, categoria, tiempo_total) VALUES (?, ?, ?, ?)";
            $sentencia_insertar = $conexion->prepare($consulta_insertar);
            $sentencia_insertar->bind_param("issi", $id_socio, $usuario, $categoria, $duracion);
            $sentencia_insertar->execute();
        }

        $salida["http"] = 200;
        $salida["respuesta"] = ["mensaje" => "Tiempo actualizado correctamente"];
    } else {
        $salida["http"] = 404;
        $salida["respuesta"] = ["error" => "Producto no encontrado"];
    }

    $sentencia_producto->close();
    return $salida;
}
