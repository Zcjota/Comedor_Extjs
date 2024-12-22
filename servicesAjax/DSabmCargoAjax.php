<?php
include("../lib/conex.php");


$descripcion = "'" . strtoupper($_POST["des"]) . "'";
$op = $_REQUEST["opcion"];
$codigo = "'" . $_REQUEST["codigo"] . "'";

if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD(); 


$sql = "";
switch ($op) {
    case "0": // Inserción
        $sql = "INSERT INTO cargo (DESCRIPCION, ACTIVO) VALUES ($descripcion, 1)";
        break;

    case "1": // Actualización
        $sql = "UPDATE cargo SET DESCRIPCION = $descripcion WHERE COD_CARGO = $codigo";
        break;

    default:
        echo '{"success": false, "errors":{"reason": "Operación no válida"}}';
        exit;
}

// Establecer el conjunto de caracteres para la conexión
mysqli_set_charset($conex, "utf8");

// Ejecutar la consulta
if (mysqli_query($conex, $sql)) {
    echo '{"success": true}';
} else {
    echo '{"success": false, "errors":{"reason": "Error al guardar registro: ' . mysqli_error($conex) . '"}}';
}

?>
