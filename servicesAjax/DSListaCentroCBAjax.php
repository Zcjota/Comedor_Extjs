<?php
include("../lib/conex.php");

// Verificar conexión
$conex = ConectarConBD();
if (!$conex) {	
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;	
}

// Configurar UTF-8
mysqli_set_charset($conex, "utf8");

// Obtener parámetros y sanitizarlos
$unidad = "'" . mysqli_real_escape_string($conex, $_REQUEST['cbUnidad']) . "'";
$subcentro = "'" . mysqli_real_escape_string($conex, $_REQUEST['cbSubCentro']) . "'";

// Consulta SQL
$sql = 'SELECT C.COD_CENTRO, C.DESCRIPCION 
        FROM `centro_de_costo` C 
        INNER JOIN unidad U ON C.COD_UNIDAD = U.COD_UNIDAD 
        WHERE C.ACTIVO = 1 AND C.COD_UNIDAD = ' . $unidad . ' AND C.COD_SUBCENTRO = ' . $subcentro . ' 
        ORDER BY C.DESCRIPCION';

// Imprimir la consulta SQL para depuración
// echo "Consulta SQL: " . $sql . "\n";

// Ejecutar la consulta
$resultado = mysqli_query($conex, $sql);

if (!$resultado) {
    echo json_encode(["Success" => false, "errors" => ["reason" => mysqli_error($conex)]]);
    exit;
}

// Procesar resultados
$data = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $data[] = [
        "codigop" => $row['COD_CENTRO'],
        "nombrep" => $row['DESCRIPCION']
    ];
}

// Preparar salida
$o = [
    "total" => count($data),
    "data" => $data
];

// Imprimir resultados en formato JSON
echo json_encode($o);

// Liberar memoria y cerrar conexión
mysqli_free_result($resultado);
mysqli_close($conex);
?>
