<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
include("../lib/conex.php");

$codigo = $_POST['id'];

if (isset($codigo)) {
    if (!VerificaConBD()) {
        echo json_encode([
            "Success" => false,
            "errors" => ["reason" => "No se puede conectar con la BD"]
        ]);
        exit;
    }

    $conex = ConectarConBD(); // Obtiene la conexión activa
    $codigo = mysqli_real_escape_string($conex, $codigo); // Escapa el valor del código

    $sql = "UPDATE `horario_comedor` SET ACTIVO = 0 WHERE CODIGO = $codigo";

    if (mysqli_query($conex, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode([
            "Success" => false,
            "errors" => ["reason" => "Registro No Desactivado"]
        ]);
    }

    // Cerrar la conexión
    mysqli_close($conex);
} else {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se ha enviado el parámetro correcto"]
    ]);
}
?>
