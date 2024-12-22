<?php
include("../lib/conex.php");

if (!VerificaConBD()) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;
}

$conex = ConectarConBD(); // Obtiene la conexión activa
mysqli_set_charset($conex, "utf8"); // Establece el conjunto de caracteres UTF-8

$sql = 'SELECT COD_UNIDAD, DESCRIPCION FROM `unidad` WHERE ACTIVO = 1 ORDER BY DESCRIPCION';
$resultado = mysqli_query($conex, $sql);
$data = [];

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $data[] = [
            "codigop" => $row['COD_UNIDAD'],
            "nombrep" => $row['DESCRIPCION']
        ];
    }

    $response = [
        "total" => count($data),
        "data" => $data
    ];
    echo json_encode($response);
} else {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "Error al ejecutar la consulta"]
    ]);
}

// Cerrar la conexión
mysqli_close($conex);
?>
