<?php
include("../lib/conex.php");

$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

if ((strcmp(trim($buscar), '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
    $sql_buscar = '';
} else {
    $sql_buscar = " AND (s.DESCRIPCION LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%')";
    echo "/*$sql_buscar*/";
}

if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD(); // Conexión a la base de datos

$sql = 'SELECT s.* ' .
    'FROM `subcentro` s ' .
    'WHERE s.ACTIVO = 1 ' . $sql_buscar .
    'ORDER BY s.DESCRIPCION ' .
    'LIMIT ' . $start . ',' . $limit;

echo "/*$sql*/";

// Ejecutar consulta total
$total_sql = "SELECT COUNT(s.COD_SUBCENTRO) AS TOTAL FROM `subcentro` s WHERE s.ACTIVO = 1 " . $sql_buscar;
$stotal = mysqli_query($conex, $total_sql);

if (!$stotal) {
    echo '{"success": false, "errors":{"reason": "Error al obtener el total: ' . mysqli_error($conex) . '"}}';
    exit;
}

$total = mysqli_fetch_assoc($stotal); // Obtener el total

// Ejecutar consulta de datos
$resultado = mysqli_query($conex, $sql);

if (!$resultado) {
    echo '{"success": false, "errors":{"reason": "Error al obtener los datos: ' . mysqli_error($conex) . '"}}';
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $data[] = [
        "codigo" => $row['COD_SUBCENTRO'],
        "descripcion" => $row['DESCRIPCION'],
    ];
}

// Respuesta final
$paging = [
    'success' => true,
    'total' => $total['TOTAL'],
    'data' => $data
];

echo json_encode($paging);

// Cerrar conexión si no se reutiliza
// mysqli_close($conex);
?>
