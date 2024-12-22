<?php
include("../lib/conex.php");

$txtNombre = strtoupper($_POST["txtNombre"]);
$txtRepresentate = strtoupper($_POST["txtRepresentate"]);
$txtNit = strtoupper($_POST["txtNit"]);
$txtDireccion = strtoupper($_POST["txtDireccion"]);
$op = $_REQUEST["opcion"];
$codigo = $_REQUEST["codigo"];

if (!VerificaConBD()) {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;
}

$conex = ConectarConBD(); // Obtiene la conexión activa
mysqli_set_charset($conex, 'utf8'); // Configura el conjunto de caracteres como UTF-8

switch ($op) {
    case "0":
        $sql = "INSERT INTO `proveedor` (nombre, representa_legal, nit, direccion, activo) 
                VALUES ('$txtNombre', '$txtRepresentate', '$txtNit', '$txtDireccion', 1)";
        break;

    case "1":
        $sql = "UPDATE `proveedor` 
                SET nombre = '$txtNombre', 
                    representa_legal = '$txtRepresentate', 
                    nit = '$txtNit', 
                    direccion = '$txtDireccion' 
                WHERE _id = $codigo";
        break;

    default:
        echo json_encode(["Success" => false, "errors" => ["reason" => "Opción no válida"]]);
        mysqli_close($conex);
        exit;
}

if (mysqli_query($conex, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["Success" => false, "errors" => ["reason" => "Error al guardar registro"]]);
}

mysqli_close($conex);
?>
