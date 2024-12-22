<?php
include("../lib/conex.php");

$descripcion = strtoupper($_POST["des"]);
$op = $_REQUEST["opcion"];
$codigo = $_REQUEST["codigo"];

if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD(); // Obtener conexión activa

switch ($op) {
    case "0":
        $sql = "INSERT INTO unidad (DESCRIPCION, ACTIVO) VALUES ('$descripcion', 1)";
        break;
    case "1":
        $sql = "UPDATE unidad SET DESCRIPCION = '$descripcion' WHERE COD_UNIDAD = '$codigo'";
        break;
    default:
        echo '{"success": false, "errors":{"reason": "Operación no válida"}}';
        exit;
}

// Ejecutar la consulta
if (mysqli_query($conex, $sql)) {
    echo '{"success": true}';
} else {
    echo '{"success": false, "errors":{"reason": "Error al guardar registro: ' . mysqli_error($conex) . '"}}';
}

// Cerrar conexión si no se reutiliza
// mysqli_close($conex);
?>
