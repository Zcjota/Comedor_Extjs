<?php
include("../lib/conex.php");

// Verificar conexión a la base de datos
$conex = ConectarConBD();
if (!$conex) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$idm = 0;
$sqlp = 'SELECT IFNULL(MAX(idmarcacionmovil), 0) AS TOTALE FROM marcacion WHERE activo = 1';

// Ejecutar consulta
$resultadoex1 = mysqli_query($conex, $sqlp);

if ($resultadoex1) {
    $tot2 = mysqli_fetch_assoc($resultadoex1);
    $idm = $tot2['TOTALE'];
} else {
    echo '{"success": false, "errors":{"reason": "Error en la consulta a la base de datos"}}';
    exit;
}

// Preparar datos
$data = array(
    array(
        "idultima_marcacion_movil" => $idm
    )
);

$paging = array(
    'success' => true,
    'total' => count($data),
    'data' => $data
);

// Devolver respuesta en formato JSON
echo json_encode($paging);

// Cerrar conexión
mysqli_close($conex);
?>
