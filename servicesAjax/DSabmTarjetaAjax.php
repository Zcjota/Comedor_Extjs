<?php
	include("../lib/conex.php");

	$nombre = strtoupper($_POST["nombre"]);
	$cbcentro = strtoupper($_POST["cbcentro"]);
	$op = $_REQUEST["opcion"];
	$codigo = $_REQUEST["nro"];

	// Conexión a la base de datos
	$conex = ConectarConBD();
	if (!$conex) {
		echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
		exit;
	}
	// echo "Consulta SQL: " . $$op . "\n";

	$sql = '';
	switch ($op) {
		case "0": { // Insertar
			$sql = "INSERT INTO `tarjetas_comedor` (CODIGO, NOMBRE, COD_CENTRO, ACTIVO) VALUES (?, ?, ?, 1)";
			break;
		}
		case "1": { // Actualizar
			$sql = "UPDATE `tarjetas_comedor` SET NOMBRE = ?, COD_CENTRO = ? WHERE CODIGO = ?";
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
		mysqli_stmt_bind_param($stmt, 'ssi', $codigo, $nombre, $cbcentro);
	} elseif ($op == "1") {
		mysqli_stmt_bind_param($stmt, 'ssi', $nombre, $cbcentro, $codigo);
	}

	// Ejecutar consulta
	if (mysqli_stmt_execute($stmt)) {
		echo json_encode(["success" => true]);
	} else {
		echo json_encode(["Success" => false, "errors" => ["reason" => "Error al guardar registro, código ya existente."]]);
	}

	// Cerrar recursos
	mysqli_stmt_close($stmt);
	mysqli_close($conex);
?>
