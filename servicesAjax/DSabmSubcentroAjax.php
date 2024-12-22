<?php
include("../lib/conex.php");

$descripcion = strtoupper($_POST["des"]);
$op = $_REQUEST["opcion"];
$codigo = $_REQUEST["codigo"];

if (!VerificaConBD()) {
    echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD();

switch ($op) {
    case "0":
        $sql = 'INSERT INTO `subcentro` (DESCRIPCION, ACTIVO) VALUES (?, 1)';
        break;
    case "1":
        $sql = 'UPDATE `subcentro` SET DESCRIPCION = ? WHERE COD_SUBCENTRO = ?';
        break;
    default:
        echo '{"Success": false, "errors":{"reason": "Operación no válida"}}';
        exit;
}

// Preparar la consulta
$stmt = mysqli_prepare($conex, $sql);

if ($op === "0") {
    mysqli_stmt_bind_param($stmt, "s", $descripcion);
} else if ($op === "1") {
    mysqli_stmt_bind_param($stmt, "si", $descripcion, $codigo);
}

// Ejecutar la consulta
if (mysqli_stmt_execute($stmt)) {
    echo "{success: true}";
} else {
    echo '{"Success": false, "errors":{"reason": "Error al guardar registro: ' . mysqli_error($conex) . '"}}';
}

// Cerrar la consulta y la conexión
mysqli_stmt_close($stmt);
// mysqli_close($conex); // Opcional si se usa conexión persistente
?>
