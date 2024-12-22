<?php
include("../lib/conex.php");

// Parámetros
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 25;
$buscar = isset($_POST['buscar']) ? trim($_POST['buscar']) : '';

$sql_buscar = '';
if (!empty($buscar) && $buscar !== '*') {
    $buscar = strtoupper($buscar);
    $sql_buscar = " AND c.DESCRIPCION LIKE CONCAT('%', ?, '%')";
}

// Verificar conexión
if (!VerificaConBD()) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    exit;
}

$conex = ConectarConBD();
mysqli_set_charset($conex, "utf8");

// Consulta principal
$sql = 'SELECT c.*, s.DESCRIPCION AS sDESCRIPCION, u.DESCRIPCION AS uDESCRIPCION 
        FROM `centro_de_costo` c 
        INNER JOIN unidad u ON u.COD_UNIDAD = c.COD_UNIDAD 
        INNER JOIN subcentro s ON c.COD_SUBCENTRO = s.COD_SUBCENTRO 
        WHERE c.ACTIVO = 1 ' . $sql_buscar . 
        ' ORDER BY c.DESCRIPCION 
        LIMIT ?, ?';

// Consulta para obtener el total
$sql_total = 'SELECT COUNT(c.COD_CENTRO) AS TOTAL 
              FROM `centro_de_costo` c 
              WHERE c.ACTIVO = 1 ' . $sql_buscar;

// Preparar y ejecutar consultas
$stmt_total = $conex->prepare($sql_total);
$stmt = $conex->prepare($sql);

if ($stmt_total === false || $stmt === false) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al preparar la consulta']]);
    exit;
}

// Parámetros para ambas consultas
if (!empty($sql_buscar)) {
    $stmt_total->bind_param('s', $buscar);
    $stmt->bind_param('sii', $buscar, $start, $limit);
} else {
    $stmt_total->execute();
    $stmt->bind_param('ii', $start, $limit);
}

// Ejecutar consulta para el total
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total = $result_total->fetch_assoc()['TOTAL'];

// Ejecutar consulta principal
$stmt->execute();
$resultado = $stmt->get_result();

$data = [];
while ($row = $resultado->fetch_assoc()) {
    $data[] = [
        "codigo" => $row['COD_CENTRO'],
        "descripcion" => $row['DESCRIPCION'],
        "codunidad" => $row['COD_UNIDAD'],
        "nomunidad" => $row['uDESCRIPCION'],
        "codsubcentro" => $row['COD_SUBCENTRO'],
        "nomsubcentro" => $row['sDESCRIPCION'],
        "codigo_base" => $row['codigo_base'],
    ];
}

// Estructura final
$paging = [
    'success' => true,
    'total' => $total,
    'data' => $data,
];

echo json_encode($paging);

// Cerrar declaraciones y conexión
$stmt_total->close();
$stmt->close();
mysqli_close($conex);
?>
