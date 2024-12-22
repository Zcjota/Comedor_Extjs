<?php
include("../lib/conex.php");
session_start();

$codigo = $_POST['codigo'];

if (isset($codigo)) {
    if (!VerificaConBD()) {
        echo json_encode([
            "Success" => false,
            "errors" => ["reason" => "No se puede conectar con la BD"]
        ]);
        exit;
    }

    // Conexión a la base de datos
    $conex = ConectarConBD();

    // Consulta SQL
    $sql = 'UPDATE `usuario` SET ACTIVO = 0 WHERE COD_USUARIO = ' . intval($codigo);

    // Ejecutar la consulta
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
