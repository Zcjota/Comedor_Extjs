<?php
include("../lib/conex.php");
session_start();

$rcargador = $_SESSION['tipoUser'];
$ridcargador = $_SESSION['IdUsuario'];

if (!VerificaConBD()) {
    echo json_encode(["success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;
}

$conex = ConectarConBD(); // Conectar con la base de datos
mysqli_set_charset($conex, "utf8");

// Condicional para filtrar según el usuario
$sql_buscar1 = ($rcargador == 7) ? " AND pf.COD_USUARIO = $ridcargador" : "";

// Función para verificar asignación de aprobación
function asignacionAprobar($conex, $cargador, $idusuario, $personalE)
{
    if ($cargador != 2) {
        $sqlAsignacion = "SELECT COUNT(COD_USUARIO) AS TOT FROM flujo_aprobador WHERE COD_USUARIO = $idusuario AND COD_PERSONAL = $personalE AND ACTIVO = 1";
        $resultadoAsig = mysqli_query($conex, $sqlAsignacion);
        $totAsig = mysqli_fetch_assoc($resultadoAsig);
        return ($totAsig['TOT'] > 0) ? 1 : 0;
    }
    return 0;
}

// Función para verificar asignación de personal
function asignacion($conex, $cargador, $idusuario, $personalE)
{
    if ($cargador != 2) {
        $sqlAsignacion = "SELECT COUNT(COD_USUARIO) AS TOT FROM personal_flujo WHERE COD_USUARIO = $idusuario AND COD_PERSONAL = $personalE AND ACTIVO = 1";
        $resultadoAsig = mysqli_query($conex, $sqlAsignacion);
        $totAsig = mysqli_fetch_assoc($resultadoAsig);
        return ($totAsig['TOT'] > 0) ? 1 : 0;
    }
    return 0;
}

// Query principal
$sql = 'SELECT p.COD_PERSONAL, p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2, p.NRO_TRABAJADOR,
               p.COD_CARGO, p.COD_CENTRO, u.DESCRIPCION as uDESCRIPCION, s.DESCRIPCION as sDESCRIPCION,
               c.DESCRIPCION as cDESCRIPCION, cc.DESCRIPCION as ccDESCRIPCION, p.SALDO_VACACIONES,
               p.FECHA_INGRESO, p.ACTIVO
        FROM personal p
        INNER JOIN cargo c ON p.COD_CARGO = c.COD_CARGO
        INNER JOIN centro_de_costo cc ON p.COD_CENTRO = cc.COD_CENTRO
        INNER JOIN subcentro s ON s.COD_SUBCENTRO = cc.COD_SUBCENTRO
        INNER JOIN unidad u ON u.COD_UNIDAD = cc.COD_UNIDAD
        ORDER BY p.AP_PATERNO ASC, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2, p.COD_PERSONAL ASC';

$stotal = mysqli_query($conex, "SELECT COUNT(COD_PERSONAL) AS TOTAL FROM personal WHERE ACTIVO = 1");
$total = mysqli_fetch_assoc($stotal)['TOTAL'];

$resultado = mysqli_query($conex, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $tipoAsignacion = asignacion($conex, $rcargador, $ridcargador, $row['COD_PERSONAL']);
    $tipoAsignacion1 = asignacionAprobar($conex, $rcargador, $ridcargador, $row['COD_PERSONAL']);

    if ($tipoAsignacion1 == 1 || $tipoAsignacion == 1 || $rcargador == 2) {
        $nombre_completo = $row['AP_PATERNO'] . ' ' . $row['AP_MATERNO'] . ' ' . $row['NOMBRE'] . ' ' . $row['NOMBRE2'];
        $nombre = $row['NOMBRE'] . ' ' . $row['NOMBRE2'];

        $data[] = [
            "codigo" => $row['COD_PERSONAL'],
            "nombre" => $nombre_completo . ' (' . $row['NRO_TRABAJADOR'] . ')',
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
            "saldo" => $row['SALDO_VACACIONES'],
            "fecha_ing" => $row['FECHA_INGRESO']
        ];
    }
}

// Construir y enviar respuesta JSON
$paging = [
    "total" => $total,
    "data" => $data,
    "success" => true
];

echo json_encode($paging);

// Cerrar conexión
mysqli_close($conex);
?>
