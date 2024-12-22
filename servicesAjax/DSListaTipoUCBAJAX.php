<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
include("../lib/conex.php");

if (!VerificaConBD()) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;
}

$conex = ConectarConBD(); // Obtiene la conexión activa

$sql = 'SELECT COD_TIPOU, NOMB_TIPOU FROM tipo_usuario WHERE ACTIVO = 1';

$resultado = mysqli_query($conex, $sql);
$data = [];

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $data[] = [
            "codtu" => $row['COD_TIPOU'],
            "nombtu" => $row['NOMB_TIPOU']
        ];
    }

    $paging = [
        "success" => true,
        "data" => $data
    ];
    echo json_encode($paging);
} else {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "Error al ejecutar la consulta"]
    ]);
}

// Cerrar la conexión
mysqli_close($conex);
?>
