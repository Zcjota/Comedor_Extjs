<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
    include("../lib/conex.php");
	
	$codigo = $_POST['id'];
	$val = $_POST['val'];

	if (isset($codigo)) {
		// Conexión a la base de datos
		$conex = ConectarConBD();
		if (!$conex) {
			echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
		}

		// Preparar consulta
		// if ($val == 1) {
		// 	$sql = 'UPDATE `usuario` SET FLUJO_VISUALIZADOR = 1 WHERE COD_USUARIO = ?';
		// } else {
		// 	$sql = 'UPDATE `usuario` SET FLUJO_VISUALIZADOR = 0 WHERE COD_USUARIO = ?';
		// }

		// Preparar y ejecutar consulta
		$stmt = mysqli_prepare($conex, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $codigo);

		if (mysqli_stmt_execute($stmt)) {
			echo '{"success": true}';
		} else {
			echo '{"Success": false, "errors":{"reason": "Registro No Desactivado"}}';
		}

		// Cerrar la conexión
		mysqli_stmt_close($stmt);
		mysqli_close($conex);
	} else {
		echo '{"Success": false, "errors":{"reason": "No se ha enviado el parámetro correcto"}}';
	}
?>
