<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
include("../lib/conex.php");

$codigo = $_POST['id'];

if (isset($codigo)) {
    if (!VerificaConBD()) {
        echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
        exit;
    }

    $conex = ConectarConBD();
    $sql = 'UPDATE `subcentro` SET ACTIVO = 0 WHERE COD_SUBCENTRO = ?';

    // Preparar la consulta
    $stmt = mysqli_prepare($conex, $sql);
    if ($stmt) {
        // Enlazar parámetros
        mysqli_stmt_bind_param($stmt, "i", $codigo);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "{success: true}";
        } else {
            echo '{"Success": false, "errors":{"reason": "Registro No Desactivado: ' . mysqli_error($conex) . '"}}';
        }

        // Cerrar la consulta
        mysqli_stmt_close($stmt);
    } else {
        echo '{"Success": false, "errors":{"reason": "Error al preparar la consulta: ' . mysqli_error($conex) . '"}}';
    }

    // Opcional: cerrar la conexión si no se reutiliza
    // mysqli_close($conex);
} else {
    echo '{"Success": false, "errors":{"reason": "No se ha enviado el parámetro correcto"}}';
}
?>
