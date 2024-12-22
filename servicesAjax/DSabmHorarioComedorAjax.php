<?php
include("../lib/conex.php");

$descripcion    = strtoupper($_POST["des"]);
$txtHorario     = strtoupper($_POST["txtHorario"]);
$txtHorarioFin  = strtoupper($_POST["txtHorarioFin"]);
$op             = $_REQUEST["opcion"];
$codigo         = $_REQUEST["codigo"];

if (!VerificaConBD()) {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;
}

$conex = ConectarConBD(); // Obtiene la conexión activa
mysqli_set_charset($conex, 'utf8'); // Configura el conjunto de caracteres

switch ($op) {
    case "0":
        $sql = "INSERT INTO `horario_comedor` (DESCRIPCION, HORARIO, HORARIO_SALIDA, ACTIVO) 
                VALUES ('$descripcion', '$txtHorario', '$txtHorarioFin', 1)";
        break;

    case "1":
        $sql = "UPDATE `horario_comedor` 
                SET DESCRIPCION = '$descripcion', 
                    HORARIO = '$txtHorario', 
                    HORARIO_SALIDA = '$txtHorarioFin'
                WHERE CODIGO = '$codigo'";
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
