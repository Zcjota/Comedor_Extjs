<?php
include("../lib/conex.php");

$descripcion = strtoupper($_POST["des"]);
$op = $_REQUEST["opcion"];
$codigo = $_REQUEST["codigo"];
$unidad = $_REQUEST["cbunidad"];
$subcentro = $_REQUEST["cbsubcentro"];
$txtcodigobase = $_REQUEST["txtcodigobase"];

if (!VerificaConBD()) {
    echo json_encode([
        "success" => false,
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;
}

$conex = ConectarConBD(); // Obtiene la conexión activa

switch ($op) {
    case "0":
        $sql = "INSERT INTO centro_de_costo (DESCRIPCION, COD_SUBCENTRO, COD_UNIDAD, codigo_base, ACTIVO) VALUES (?, ?, ?, ?, 1)";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("ssss", $descripcion, $subcentro, $unidad, $txtcodigobase);
        break;
    case "1":
        $sql = "UPDATE centro_de_costo SET DESCRIPCION = ?, COD_SUBCENTRO = ?, COD_UNIDAD = ?, codigo_base = ? WHERE COD_CENTRO = ?";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("sssss", $descripcion, $subcentro, $unidad, $txtcodigobase, $codigo);
        break;
    default:
        echo json_encode([
            "success" => false,
            "errors" => ["reason" => "Operación inválida"]
        ]);
        exit;
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode([
        "success" => false,
        "errors" => ["reason" => "Error al guardar registro"]
    ]);
}

$stmt->close();
$conex->close();
?>
