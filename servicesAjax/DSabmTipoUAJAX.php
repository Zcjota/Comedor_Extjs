<?php
	include("../lib/conex.php");

	$nombre = strtoupper($_POST["nom"]);
	$op = $_REQUEST["opcion"];
	$codigo = $_REQUEST["codigo"];

	// Conexión a la base de datos
	$conex = ConectarConBD();
	if (!$conex) {
		echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
		exit;
	}

	$sql = '';
	switch ($op) {
		case "0": { // Insertar nuevo registro
			$sql = "INSERT INTO `tipo_usuario` (`NOMB_TIPOU`, `ACTIVO`) VALUES (?, 1)";
			break;
		}
		case "1": { // Actualizar registro existente
			$sql = "UPDATE `tipo_usuario` SET NOMB_TIPOU = ? WHERE COD_TIPOU = ?";
			break;
		}
	}

	// Preparar la consulta
	$stmt = mysqli_prepare($conex, $sql);
	if (!$stmt) {
		echo json_encode(["Success" => false, "errors" => ["reason" => "Error al preparar la consulta"]]);
		exit;
	}

	// Asignar parámetros según la operación
	if ($op == "0") {
		mysqli_stmt_bind_param($stmt, 's', $nombre);
	} elseif ($op == "1") {
		mysqli_stmt_bind_param($stmt, 'si', $nombre, $codigo);
	}

	// Ejecutar consulta
	if (mysqli_stmt_execute($stmt)) {
		echo json_encode(["success" => true]);
	} else {
		echo json_encode(["Success" => false, "errors" => ["reason" => "Error al guardar registro"]]);
	}

	// Cerrar conexión
	mysqli_stmt_close($stmt);
	mysqli_close($conex);
?>
