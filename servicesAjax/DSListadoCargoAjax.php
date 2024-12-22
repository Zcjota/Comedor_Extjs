<?php
include("../lib/conex.php");

$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

if ((strcmp(trim($buscar), '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
    $sql_buscar = '';
} else {
    $sql_buscar = " AND c.DESCRIPCION LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%'";
}

if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD();

// Consulta principal
$sql = '
    SELECT c.*
    FROM cargo c
    WHERE c.ACTIVO = 1' . $sql_buscar . '
    ORDER BY c.DESCRIPCION
    LIMIT ' . $start . ', ' . $limit;

// Consulta para contar el total
$sql_total = '
    SELECT COUNT(c.COD_CARGO) AS TOTAL
    FROM cargo c
    WHERE c.ACTIVO = 1' . $sql_buscar;

// Ejecutar la consulta total
$stotal = mysqli_query($conex, $sql_total);
$total = mysqli_fetch_array($stotal);

// Ejecutar la consulta de datos
$resultado = mysqli_query($conex, $sql);

$data = array();
while ($row = mysqli_fetch_array($resultado)) {
    array_push($data, array(
        "codigo" => $row['COD_CARGO'],
        "descripcion" => $row['DESCRIPCION']
    ));
}

// Formar la respuesta JSON
$paging = array(
    'success' => true,
    'total' => $total['TOTAL'],
    'data' => $data
);

echo json_encode($paging);
?>
