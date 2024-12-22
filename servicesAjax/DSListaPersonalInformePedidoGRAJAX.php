<?php
/*! 
 * DSoft-TPMV
 * Copyright(c) 2011
 */

include("../lib/conex.php");
session_start();

$rcargador = isset($_SESSION['tipoUser']) ? $_SESSION['tipoUser'] : 0;
$ridcargador = isset($_SESSION['IdUsuario']) ? $_SESSION['IdUsuario'] : 0;

if ($rcargador == 7) {
    $sql_buscar1 = " AND pf.COD_USUARIO = $ridcargador";
} else {
    $sql_buscar1 = "";
}

$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

function asignacionAprobar($cargador, $idusuario, $personalE)
{
    $cant = 0;
    if ($cargador != 2) {
        $sqlAsignacion = "SELECT COUNT(COD_USUARIO) AS TOT FROM flujo_aprobador WHERE COD_USUARIO = $idusuario AND COD_PERSONAL = $personalE AND ACTIVO = 1";
        $resultadoAsig = mysqli_query($conex,$sqlAsignacion);
        $totAsig = mysqli_fetch_array($resultadoAsig);
        $cant = isset($totAsig['TOT']) ? $totAsig['TOT'] : 0;
    }
    return $cant;
}

function asignacion($cargador, $idusuario, $personalE)
{
    $cant = 0;
    if ($cargador != 2) {
        $sqlAsignacion = "SELECT COUNT(COD_USUARIO) AS TOT FROM personal_flujo WHERE COD_USUARIO = $idusuario AND COD_PERSONAL = $personalE AND ACTIVO = 1";
        $resultadoAsig = mysqli_query($conex,$sqlAsignacion);
        $totAsig = mysqli_fetch_array($resultadoAsig);
        $cant = isset($totAsig['TOT']) ? $totAsig['TOT'] : 0;
    }
    return $cant;
}

$sql = "SELECT p.COD_PERSONAL, p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2, p.NRO_TRABAJADOR, p.COD_CARGO, p.COD_CENTRO, 
        u.DESCRIPCION AS uDESCRIPCION, s.DESCRIPCION AS sDESCRIPCION, c.DESCRIPCION AS cDESCRIPCION, cc.DESCRIPCION AS ccDESCRIPCION 
        FROM personal p 
        INNER JOIN cargo c ON p.COD_CARGO = c.COD_CARGO 
        INNER JOIN centro_de_costo cc ON p.COD_CENTRO = cc.COD_CENTRO 
        INNER JOIN subcentro s ON s.COD_SUBCENTRO = cc.COD_SUBCENTRO 
        INNER JOIN unidad u ON u.COD_UNIDAD = cc.COD_UNIDAD 
        WHERE p.ACTIVO = 1 $sql_buscar1 
        ORDER BY p.AP_PATERNO";

$stotal = mysqli_query($conex,"SELECT COUNT(COD_PERSONAL) AS TOTAL FROM personal WHERE ACTIVO = 1");
$total = mysqli_fetch_array($stotal);

// mysqli_query("SET NAMES 'utf8'");
mysqli_set_charset($conex, "utf8");
$resultado = mysqli_query($conex,$sql);

$data = [];
while ($row = mysqli_fetch_array($resultado)) {
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
        "codcargo" => $row['COD_CARGO'],
        "unidad" => $row['uDESCRIPCION'],
        "subcentro" => $row['sDESCRIPCION'],
        "centro" => $row['ccDESCRIPCION'],
        "codcentro" => $row['COD_CENTRO'],
    ];
}

$response = [
    "total" => $total['TOTAL'],
    "data" => $data
];

echo json_encode($response);
?>
