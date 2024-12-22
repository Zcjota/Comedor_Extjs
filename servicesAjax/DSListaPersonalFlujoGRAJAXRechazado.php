<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
include("../lib/conex.php");

if (!VerificaConBD()) {
    echo json_encode(["success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;
}

$conex = ConectarConBD();
mysqli_set_charset($conex, "utf8");

$codpersonal = isset($_REQUEST['cod']) ? mysqli_real_escape_string($conex, $_REQUEST['cod']) : null;

if (!$codpersonal) {
    echo json_encode(["success" => false, "errors" => ["reason" => "El código del personal no fue proporcionado"]]);
    exit;
}

$sql = 'SELECT p.COD_PERSONAL, p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2, p.NRO_TRABAJADOR, p.CI, p.FECHA_INGRESO, 
               c.DESCRIPCION as cDESCRIPCION, cc.DESCRIPCION as ccDESCRIPCION 
        FROM `personal` p 
        INNER JOIN cargo c ON p.COD_CARGO = c.COD_CARGO 
        INNER JOIN centro_de_costo cc ON p.COD_CENTRO = cc.COD_CENTRO 
        WHERE p.ACTIVO = 1 AND p.COD_PERSONAL = ' . $codpersonal . ' 
        ORDER BY p.AP_PATERNO';

$resultado = mysqli_query($conex, $sql);

if (!$resultado) {
    echo json_encode(["success" => false, "errors" => ["reason" => "Error al ejecutar la consulta"]]);
    exit;
}

$data = [];

while ($row = mysqli_fetch_assoc($resultado)) {
    $nombre_completo = $row['AP_PATERNO'] . ' ' . $row['AP_MATERNO'] . ' ' . $row['NOMBRE'] . ' ' . $row['NOMBRE2'];
    $nombre = $row['NOMBRE'] . ' ' . $row['NOMBRE2'];

    $data[] = [
        "codigo" => $row['COD_PERSONAL'],
        "nombre" => $nombre_completo,
        "nombreP" => $nombre,
        "app" => $row['AP_PATERNO'],
        "apm" => $row['AP_MATERNO'],
        "codtrabajador" => $row['NRO_TRABAJADOR'],
        "cargo" => $row['cDESCRIPCION'],
        "cedula" => $row['CI'],
        "area" => $row['ccDESCRIPCION'],
        "fecha_ingreso" => $row['FECHA_INGRESO']
    ];
}

$o = [
    "total" => count($data),
    "data" => $data
];

echo json_encode($o);

// Cerrar la conexión
mysqli_close($conex);
?>
