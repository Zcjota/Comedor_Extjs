<?php
include("../lib/conex.php");

// Parámetros de entrada
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 25;
$buscar = isset($_POST['buscar']) ? trim($_POST['buscar']) : '';

$sql_buscar = '';
if (!empty($buscar) && $buscar !== '*') {
    $buscar = strtoupper($buscar);
    $buscar = $conex->real_escape_string($buscar); // Escapar caracteres para evitar inyección SQL
    $sql_buscar = " AND c.DESCRIPCION LIKE '%$buscar%'";
}

// Verificar conexión con la base de datos
$conex = ConectarConBD();
if (!$conex) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    exit;
}

// Establecer UTF-8
$conex->set_charset('utf8');

// Consulta principal
$sql = "SELECT c.* 
        FROM `horario_comedor` c 
        WHERE c.ACTIVO = 1 $sql_buscar 
        ORDER BY c.HORARIO 
        LIMIT $start, $limit";

// Consulta para obtener el total
$sql_total = "SELECT COUNT(c.CODIGO) AS TOTAL 
              FROM `horario_comedor` c 
              WHERE c.ACTIVO = 1 $sql_buscar";

// Ejecutar las consultas
$result_total = $conex->query($sql_total);
if (!$result_total) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al ejecutar la consulta de total']]);
    exit;
}

$total = $result_total->fetch_assoc()['TOTAL'];

$resultado = $conex->query($sql);
if (!$resultado) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al ejecutar la consulta principal']]);
    exit;
}

$data = [];
while ($row = $resultado->fetch_assoc()) {
    $data[] = [
        "codigo" => $row['CODIGO'],
        "descripcion" => $row['DESCRIPCION'],
        "horario" => $row['HORARIO'],
        "horario_fin" => $row['HORARIO_SALIDA'],
    ];
}

// Estructura final del JSON
$paging = [
    'success' => true,
    'total' => $total,
    'data' => $data,
];

// Enviar respuesta como JSON
echo json_encode($paging);
?>
