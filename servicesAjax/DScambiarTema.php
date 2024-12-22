<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
include("../lib/conex.php");

$codigo = $_POST['id'];
$tema = $_REQUEST['cbotema'];

if (isset($codigo)) {
    // if (!VerificaConBD()) {
    //     echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    //     exit;
    // }
    $conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

    // Preparar la consulta para actualizar
    $sql = "UPDATE `usuario` SET TEMA = ? WHERE COD_USUARIO = ?";
    $stmt = mysqli_prepare($conex, $sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al preparar la consulta: ' . mysqli_error($conex)]]);
        exit;
    }

    // Vincular parámetros
    mysqli_stmt_bind_param($stmt, 'ii', $tema, $codigo);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'Registro no desactivado: ' . mysqli_stmt_error($stmt)]]);
    }

    // Cerrar la consulta preparada
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se ha enviado el parámetro correcto']]);
}
?>
