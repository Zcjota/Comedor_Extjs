<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */ 
include("../lib/conex.php");

$codigo = $_POST['id'];

if (isset($codigo)) {
    if (!VerificaConBD()) {
        echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
        exit;
    }

    $conex = ConectarConBD(); // Obtener la conexión activa

    // Construir la consulta
    $sql = "UPDATE cargo SET ACTIVO = 0 WHERE COD_CARGO = $codigo";

    // Ejecutar la consulta
    if (mysqli_query($conex, $sql)) {
        echo '{"success": true}';
    } else {
        echo '{"success": false, "errors":{"reason": "Registro No Desactivado: ' . mysqli_error($conex) . '"}}';
    }

    // Cerrar conexión (opcional si no se reutiliza en el flujo)
    // mysqli_close($conex);
} else {
    echo '{"success": false, "errors":{"reason": "No se ha enviado el parámetro correcto"}}';
}
?>
