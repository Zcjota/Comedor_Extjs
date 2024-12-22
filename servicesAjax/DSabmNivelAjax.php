<?php
	include("../lib/conex.php");
	session_start();
	if (empty($_SESSION['IdUsuario'])) { 
		$IdUsuario = 0; 
	} else {  
		$IdUsuario = $_SESSION['IdUsuario'];
	}

	$txtCategoria = strtoupper($_POST["txtCategoria"]);
	$txtNivel = strtoupper($_POST["txtNivel"]);
	$txtMidpoint = $_POST["txtMidpoint"];

	$op = $_REQUEST["opcion"];
	$codigo = $_REQUEST["codigo"];
	date_default_timezone_set('America/La_Paz');
	$fecha_alta = date("Y-m-d H:i:s");

	// Conexión a la base de datos
	$conex = ConectarConBD();
	if (!$conex) {
		echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
		exit;
	}

	$sql = '';
	switch ($op) {
		case "0": {
			$sql = "INSERT INTO `nivel` (NOMBRE_NIVEL, CATEGORIA, MIDPOINT, ACTIVO, idusuario_alta, fecha_alta) VALUES (?, ?, ?, 1, ?, ?)";
			break;
		}
		case "1": {
			$sql = "UPDATE `nivel` SET 
					NOMBRE_NIVEL = ?, 
					CATEGORIA = ?, 
					MIDPOINT = ?, 
					idusuario_update = ?, 
					fecha_update = ? 
					WHERE COD_NIVEL = ?";
			break;
		}
	}

	// Preparar consulta
	$stmt = mysqli_prepare($conex, $sql);
	if (!$stmt) {
		echo json_encode(["Success" => false, "errors" => ["reason" => "Error al preparar la consulta"]]);
		exit;
	}

	// Asignar parámetros según la operación
	if ($op == "0") {
		mysqli_stmt_bind_param($stmt, 'sssis', $txtNivel, $txtCategoria, $txtMidpoint, $IdUsuario, $fecha_alta);
	} else if ($op == "1") {
		mysqli_stmt_bind_param($stmt, 'sssisi', $txtNivel, $txtCategoria, $txtMidpoint, $IdUsuario, $fecha_alta, $codigo);
	}

	// Ejecutar consulta
	if (mysqli_stmt_execute($stmt)) {
		echo json_encode(["success" => true, "message" => ["reason" => 1]]);
	} else {
		echo json_encode(["Success" => false, "errors" => ["reason" => "Error al guardar registro"]]);
	}

	// Cerrar conexión
	mysqli_stmt_close($stmt);
	mysqli_close($conex);
?>
