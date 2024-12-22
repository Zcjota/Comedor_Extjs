<?php
include "../lib/conex.php";

$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 100;
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

if ((strcmp($buscar, '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
    $sql_buscar = '';
} else {
    $sql_buscar = " AND u.DESCRIPCION LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%'";
}

if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD();

// Consulta principal
$sql = '
    SELECT u.*
    FROM unidad u
    WHERE u.ACTIVO = 1' . $sql_buscar . '
    ORDER BY u.DESCRIPCION ASC
    LIMIT ' . $start . ', ' . $limit;

// Consulta para contar el total
$sql_total = '
    SELECT COUNT(u.COD_UNIDAD) AS TOTAL
    FROM unidad u
    WHERE u.ACTIVO = 1' . $sql_buscar;

// Ejecutar la consulta total
$stotal = mysqli_query($conex, $sql_total);
$total = mysqli_fetch_array($stotal);

// Ejecutar la consulta de datos
$resultado = mysqli_query($conex, $sql);

$data = array();
while ($row = mysqli_fetch_array($resultado)) {
    array_push($data, array(
        "codigo" => $row['COD_UNIDAD'],
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
