<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
	include("../lib/conex.php");

	$start = isset($_POST['start']) ? $_POST['start'] : 0;	
	$limit = isset($_POST['limit']) ? $_POST['limit'] : 25;

	session_start();
	$rcargador = $_SESSION['tipoUser'];
	$ridcargador = $_SESSION['IdUsuario'];
	$nombreValidador = $_SESSION['Apellido1'] . " " . $_SESSION['Apellido2'] . " " . $_SESSION['Nombre'];

	// Conexión a la base de datos
	$conex = ConectarConBD();
	if (!$conex) {
		echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
		exit;
	}

	$fechaf = $_REQUEST["fechaf"];
	$fechai = $_REQUEST["fechai"];
	echo "/*fechainicio---->$fechai*/";
	echo "/*fechafin---->$fechaf*/";

	mysqli_set_charset($conex, "utf8");

	$valores = explode("-", $fechai); 
	$gestion = $valores[0];
	$mes = $valores[1];
	$dia = $valores[2];

	$sqlaux = '';
	if ($fechai !== '' && $fechaf !== '') {
		$sqlaux = " AND DATE(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechaf'";
	}

	function horario($conex, $HM) {
		$i = 1;
		$sqlHorario = 'SELECT * FROM horario_comedor WHERE ACTIVO = 1 ORDER BY HORARIO';
		$rHorario = mysqli_query($conex, $sqlHorario);
		while ($row = mysqli_fetch_assoc($rHorario)) {
			$horario_Marcacion = strtotime($HM);
			$horario_inicio = strtotime($row['HORARIO'] . ":00");
			$horario_fin = strtotime($row['HORARIO_SALIDA'] . ":00");
			if ($horario_Marcacion >= $horario_inicio && $horario_Marcacion <= $horario_fin) {
				return $i;
			}
			$i++;
		}
		return 0;
	}

	$sqlm = 'SELECT m.* FROM marcacion_comedor m WHERE m.ACTIVO = 1 ' . $sqlaux . ' ORDER BY m.COD_MARCACION, m.CODIGO, m.GESTION, m.MES, m.DIA ASC';
	$resultadom = mysqli_query($conex, $sqlm);

	$data = array();
	$v1 = $v2 = $v3 = $v4 = $v5 = $v6 = $v7 = $v8 = $v9 = $v10 = $v11 = $v12 = $v13 = $v14 = $v15 = 0;

	while ($row = mysqli_fetch_assoc($resultadom)) {
		$minut = ((int)$row['MINUTO'] < 10) ? "0" . (string)$row['MINUTO'] : (string)$row['MINUTO'];
		$HoraMarcacion = (string)$row['HORA'] . ':' . $minut . ':00';

		$r = horario($conex, $HoraMarcacion);

		switch ($r) {
			case 1: $v1++; break;
			case 2: $v2++; break;
			case 3: $v3++; break;
			case 4: $v4++; break;
			case 5: $v5++; break;
			case 6: $v6++; break;
			case 7: $v7++; break;
			case 8: $v8++; break;
			case 9: $v9++; break;
			case 10: $v10++; break;
			case 11: $v11++; break;
			case 12: $v12++; break;
			case 13: $v13++; break;
			case 14: $v14++; break;
			case 15: $v15++; break;
		}
	}

	array_push($data, array(
		"codigo"    => 1,
		"nombre"    => "TOTAL",
		"c1"        => $v1,
		"c2"        => $v2,
		"c3"        => $v3,
		"c4"        => $v4,
		"c5"        => $v5,
		"c6"        => $v6,
		"c7"        => $v7,
		"c8"        => $v8,
		"c9"        => $v9,
		"c10"       => $v10,
		"c11"       => $v11,
		"c12"       => $v12,
		"c13"       => $v13,
		"c14"       => $v14,
		"c15"       => $v15,
	));

	$o = array(
		"total" => count($data),
		"data"  => $data
	);
	echo json_encode($o);

	// Cerrar conexión
	mysqli_close($conex);
?>
