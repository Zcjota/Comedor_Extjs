<?php
include("../lib/conex.php");

// Verificar conexión con la base de datos
if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD();

// Validar si se envió el ID del personal
if (!isset($_REQUEST["COD_PERSONAL"])) {
    echo '{"success": false, "errors":{"reason": "No se especificó el ID del personal"}}';
    exit;
}

$cod_personal = intval($_REQUEST["COD_PERSONAL"]); // Asegurarse de que el ID sea un número válido

// Consulta para marcar como inactivo
$sql = "UPDATE personal SET ACTIVO = 0 WHERE COD_PERSONAL = $cod_personal";

// Configurar codificación
mysqli_set_charset($conex, "utf8");

// Ejecutar la consulta
if (mysqli_query($conex, $sql)) {
    echo '{"success": true, "message": "Registro marcado como inactivo correctamente"}';
} else {
    echo '{"success": false, "errors":{"reason": "Error al actualizar registro: ' . mysqli_error($conex) . '"}}';
}
?>
