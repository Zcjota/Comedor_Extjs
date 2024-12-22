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

    $conex = ConectarConBD(); // Obtener la conexión a la base de datos
    $codigo = mysqli_real_escape_string($conex, $codigo); // Escapar el valor para evitar inyecciones SQL

    $sql = "UPDATE unidad SET ACTIVO = 0 WHERE COD_UNIDAD = '$codigo'";

    // Ejecutar la consulta
    if (mysqli_query($conex, $sql)) {
        echo '{"success": true}';
    } else {
        echo '{"success": false, "errors":{"reason": "Registro No Desactivado: ' . mysqli_error($conex) . '"}}';
    }

    // Cerrar conexión si no se reutiliza
    // mysqli_close($conex);
} else {
    echo '{"success": false, "errors":{"reason": "No se ha enviado el parámetro correcto"}}';
}
?>
