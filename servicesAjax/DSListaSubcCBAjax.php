<?php
include("../lib/conex.php");

if (!VerificaConBD()) {	
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;	
}

$conex = ConectarConBD(); // Conexión activa
mysqli_set_charset($conex, 'utf8'); // Configuración de caracteres UTF-8

$sql = 'SELECT COD_SUBCENTRO, DESCRIPCION FROM `subcentro` WHERE ACTIVO = 1 ORDER BY DESCRIPCION';
$resultado = mysqli_query($conex, $sql);

$data = [];

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $data[] = [
            "codigop" => $row['COD_SUBCENTRO'],
            "nombrep" => $row['DESCRIPCION']
        ];
    }
} else {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "Error al ejecutar la consulta"]
    ]);
    mysqli_close($conex);
    exit;
}

$o = [
    "total" => count($data),
    "data" => $data
];

echo json_encode($o);

// Cerrar la conexión
mysqli_close($conex);
?>
