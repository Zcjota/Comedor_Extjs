<?php
include("../lib/conex.php");

$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

if (trim($buscar) === '' || trim($buscar) === '*') {
    $sql_buscar = '';
} else {
    $sql_buscar = " AND n.CATEGORIA LIKE '%" . mysqli_real_escape_string(ConectarConBD(), strtoupper($buscar)) . "%'";
}

if (!VerificaConBD()) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    exit;
}

$conex = ConectarConBD();
mysqli_set_charset($conex, "utf8");

// Consulta total de registros
$sql_total = "SELECT COUNT(n.COD_NIVEL) AS TOTAL FROM `nivel` n WHERE n.ACTIVO = 1 $sql_buscar";
$result_total = mysqli_query($conex, $sql_total);

if ($result_total) {
    $total = mysqli_fetch_assoc($result_total)['TOTAL'];
} else {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al ejecutar la consulta total']]);
    exit;
}

// Consulta para los datos paginados
$sql = "SELECT n.* 
        FROM `nivel` n 
        WHERE n.ACTIVO = 1 $sql_buscar 
        ORDER BY n.MIDPOINT DESC 
        LIMIT $start, $limit";

$resultado = mysqli_query($conex, $sql);
$data = [];

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $midpoint = $row['MIDPOINT'];
        $ochenta = $midpoint * 80 / 100;
        $noventa = $midpoint * 90 / 100;
        $ciento_diez = $midpoint * 110 / 100;
        $ciento_veinte = $midpoint * 120 / 100;

        $data[] = [
            "COD_NIVEL" => $row['COD_NIVEL'],
            "NOMBRE_NIVEL" => $row['NOMBRE_NIVEL'],
            "CATEGORIA" => $row['CATEGORIA'],
            "ochenta" => round($ochenta),
            "noventa" => round($noventa),
            "midpoint" => round($midpoint),
            "ciento_diez" => round($ciento_diez),
            "ciento_veinte" => round($ciento_veinte)
        ];
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al ejecutar la consulta de datos']]);
    exit;
}

$paging = [
    'success' => true,
    'total' => $total,
    'data' => $data
];

echo json_encode($paging);

// Cerrar la conexión
mysqli_close($conex);
?>
