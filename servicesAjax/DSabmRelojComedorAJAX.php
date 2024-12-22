<?php
	include("../lib/conex.php");

	// Obtener parámetros
	$descripcion = strtoupper($_POST["des"]);
	$octeto1 = $_POST["O1"];
	$octeto2 = $_POST["O2"];
	$octeto3 = $_POST["O3"];
	$octeto4 = $_POST["O4"];
	$op = $_REQUEST["opcion"];
	$codigo = $_REQUEST["codigo"];
	$ip = $octeto1 . '.' . $octeto2 . '.' . $octeto3 . '.' . $octeto4;

	// Conexión a la base de datos
	$conex = ConectarConBD();
	if (!$conex) {
		echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
		exit;
	}

	$sql = '';
	switch ($op) {
		case "0": {
			$sql = "INSERT INTO `reloj_comedor` (NOMBRE, IP, OC1, OC2, OC3, OC4, ACTIVO) VALUES (?, ?, ?, ?, ?, ?, 1)";
			break;
		}
		case "1": {
			$sql = "UPDATE `reloj_comedor` SET 
					NOMBRE = ?, 
					OC1 = ?, 
					OC2 = ?, 
					OC3 = ?, 
					OC4 = ?, 
					IP = ? 
					WHERE COD_RELOJ = ?";
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
		mysqli_stmt_bind_param($stmt, 'ssssss', $descripcion, $ip, $octeto1, $octeto2, $octeto3, $octeto4);
	} else if ($op == "1") {
		mysqli_stmt_bind_param($stmt, 'ssssssi', $descripcion, $octeto1, $octeto2, $octeto3, $octeto4, $ip, $codigo);
	}

	// Ejecutar la consulta
	if (mysqli_stmt_execute($stmt)) {
		echo json_encode(["success" => true]);
	} else {
		echo json_encode(["Success" => false, "errors" => ["reason" => "Error al guardar registro"]]);
	}

	// Cerrar conexión
	mysqli_stmt_close($stmt);
	mysqli_close($conex);
?>
