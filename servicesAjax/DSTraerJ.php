<?php
/*!
 * TPMV
 * Copyright(c) 2012
 */
include("../lib/conex.php");

$codigo = $_REQUEST['codigo'];
$fecha  = $_REQUEST['fecha'];

if (!VerificaConBD()) {    
    echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';            
    exit;    
}

// Convertir la fecha
$valores = explode("-", $fecha); 
$gestion = (int)$valores[0];
$gestion1 = (int)$valores[0];
$mes = (int)$valores[1];
$mes1 = (int)$valores[1];
$dia = (int)$valores[2];
$dia1 = (int)$valores[2];

if ($mes < 10) {
    $mes = "0" . (string)$mes;
}

if ($dia < 10) {
    $dia = "0" . (string)$dia;
}

$fehaM = $gestion . '-' . $mes . '-' . $dia;

// Conexión a la base de datos
$conex = ConectarConBD();

if (!$conex) {
    echo '{"Success": false, "errors":{"reason": "Error al conectar con la base de datos"}}';
    exit;
}

// Consulta principal
$sql = 'SELECT * FROM historico_justificacion WHERE COD_PERSONAL = ? AND FECHA = ?';
$stmt = $conex->prepare($sql);
$stmt->bind_param("ss", $codigo, $fehaM);
$stmt->execute();
$resultado = $stmt->get_result();

$data = array();

while ($row = $resultado->fetch_assoc()) {
    // Subconsulta
    $sq = 'SELECT MIN_JUSTIFICADOS AS min FROM marcacion_valida WHERE COD_PERSONAL = ? AND GESTION = ? AND MES = ? AND DIA = ?';
    $stmtAsig = $conex->prepare($sq);
    $stmtAsig->bind_param("siii", $codigo, $gestion1, $mes1, $dia1);
    $stmtAsig->execute();
    $resultadoAsig = $stmtAsig->get_result();
    $totAsig = $resultadoAsig->fetch_assoc();
    $tAsig = isset($totAsig['min']) ? $totAsig['min'] : 0; // Cambio aquí

    array_push($data, array(
        "codigop"        => $row['COD_PERSONAL'],
        "nombrep"        => $row['MOTIVO'],
        "nombrep1"       => $row['MOTIVO_HE'],
        "nombrep2"       => $row['MOTIVO_APROBADOR'],
        "minutos"        => $tAsig,
        "idjustificacion" => $row['idjustificacion']
    ));
}

// Generar la respuesta
$o = array(
    "total" => count($data),
    "data" => $data
);

echo json_encode($o);

?>
