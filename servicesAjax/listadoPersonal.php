<?php
include("../lib/conex.php");

$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 50;
$buscar = isset($_POST['buscar']) ? trim($_POST['buscar']) : '';
$activo = isset($_POST['activo']) ? intval($_POST['activo']) : 1;
$inactivo = isset($_POST['inactivo']) ? intval($_POST['inactivo']) : 0;

$sql_filtro = '';
$sql_filtro1 = '';

if ($activo === 1 && $inactivo === 1) {
    $sql_filtro = " AND p.ACTIVO != 2";
    $sql_filtro1 = " WHERE p.ACTIVO != 2";
} elseif ($activo === 1 && $inactivo === 0) {
    $sql_filtro = " AND p.ACTIVO = 1";
    $sql_filtro1 = " WHERE p.ACTIVO = 1";
} elseif ($activo === 0 && $inactivo === 1) {
    $sql_filtro = " AND p.ACTIVO = 0";
    $sql_filtro1 = " WHERE p.ACTIVO = 0";
} elseif ($activo === 0 && $inactivo === 0) {
    $sql_filtro = " AND p.ACTIVO = -777";
    $sql_filtro1 = " WHERE p.ACTIVO = -777";
}

$sql_buscar = $sql_filtro1;
if ($buscar !== '' && $buscar !== '*') {
    $buscar_escapado = str_replace('*', '%', strtoupper($buscar));
    $sql_buscar = " WHERE (p.AP_PATERNO LIKE '%$buscar_escapado%' 
        OR p.AP_MATERNO LIKE '%$buscar_escapado%' 
        OR p.NOMBRE LIKE '%$buscar_escapado%' 
        OR p.NOMBRE2 LIKE '%$buscar_escapado%' 
        OR p.CI LIKE '%$buscar_escapado%' 
        OR cc.DESCRIPCION LIKE '%$buscar_escapado%') $sql_filtro";
}

// Conexión a la base de datos
$conex = ConectarConBD();
if (!$conex) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    exit;
}

// Configuración de UTF-8
mysqli_set_charset($conex, 'utf8');

// Consulta principal
$sql = "SELECT p.COD_PERSONAL, p.NOMBRE, p.NOMBRE2, p.AP_PATERNO, p.AP_MATERNO, p.CI, p.EXTENSION, 
        p.FECHA_NACIMIENTO, p.GENERO, p.DIRECCION, p.TELEFONO1 AS TELEFONO, p.CELULAR1 AS CELULAR, 
        p.FECHA_INGRESO,
        p.COD_CENTRO, 
        p.COD_CARGO,
        cc.DESCRIPCION AS NOMBRE_CENTRO, 
        ca.DESCRIPCION AS NOMBRE_CARGO 
        FROM personal p
        INNER JOIN centro_de_costo cc ON p.COD_CENTRO = cc.COD_CENTRO
        INNER JOIN cargo ca ON p.COD_CARGO = ca.COD_CARGO
        $sql_buscar
        ORDER BY p.AP_PATERNO 
        LIMIT $start, $limit";

$resultado = mysqli_query($conex, $sql);
if (!$resultado) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error en la consulta SQL: ' . mysqli_error($conex)]]);
    mysqli_close($conex);
    exit;
}

// Consulta del total de registros
$stotal_sql = "SELECT COUNT(p.COD_PERSONAL) AS TOTAL 
    FROM personal p
    INNER JOIN centro_de_costo cc ON p.COD_CENTRO = cc.COD_CENTRO
    INNER JOIN cargo ca ON p.COD_CARGO = ca.COD_CARGO
    $sql_buscar";
$stotal = mysqli_query($conex, $stotal_sql);

if (!$stotal) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error en la consulta total: ' . mysqli_error($conex)]]);
    mysqli_close($conex);
    exit;
}

$total = mysqli_fetch_assoc($stotal)['TOTAL'];
$data = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $data[] = [
        "COD_PERSONAL" => $row['COD_PERSONAL'],
        "NOMBRE" => $row['NOMBRE'],
        "NOMBRE2" => $row['NOMBRE2'],
        "AP_PATERNO" => $row['AP_PATERNO'],
        "AP_MATERNO" => $row['AP_MATERNO'],
        "CI" => $row['CI'],
        "EXTENSION" => $row['EXTENSION'],
        "FECHA_NACIMIENTO" => $row['FECHA_NACIMIENTO'],
        "GENERO" => $row['GENERO'],
        "DIRECCION" => $row['DIRECCION'],
        "TELEFONO" => $row['TELEFONO'],
        "CELULAR" => $row['CELULAR'],
        "NOMBRE_CENTRO" => $row['NOMBRE_CENTRO'],
        "NOMBRE_CARGO" => $row['NOMBRE_CARGO'],
        "COD_CENTRO" => $row['COD_CENTRO'], 
        "COD_CARGO" => $row['COD_CARGO'], 
        "FECHA_INGRESO" => $row['FECHA_INGRESO']
    ];
}

echo json_encode([
    'success' => true,
    'total' => $total,
    'data' => $data
]);

// Cerrar la conexión
mysqli_close($conex);
?>
