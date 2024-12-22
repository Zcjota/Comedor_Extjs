<?php
include("../lib/conex.php");

// Validar existencia de parámetros esenciales
if (!isset($_REQUEST["opcion"])) {
    echo '{"success": false, "errors":{"reason": "Falta el parámetro de opción"}}';
    exit;
}

// Verificar conexión con la base de datos
if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD();
$opcion = $_REQUEST["opcion"];

// Capturar datos enviados desde el formulario
$nombre = "'" . mysqli_real_escape_string($conex, strtoupper($_POST["NOMBRE"])) . "'";
$nombre2 = isset($_POST["NOMBRE2"]) ? "'" . mysqli_real_escape_string($conex, strtoupper($_POST["NOMBRE2"])) . "'" : "NULL";
$ap_paterno = "'" . mysqli_real_escape_string($conex, strtoupper($_POST["AP_PATERNO"])) . "'";
$ap_materno = "'" . mysqli_real_escape_string($conex, strtoupper($_POST["AP_MATERNO"])) . "'";
$ci = intval($_POST["CI"]);
$extension = isset($_POST["EXTENSION"]) ? "'" . mysqli_real_escape_string($conex, strtoupper($_POST["EXTENSION"])) . "'" : "NULL";
$fecha_nacimiento = "'" . $_POST["FECHA_NACIMIENTO"] . "'";
$genero = "'" . mysqli_real_escape_string($conex, strtoupper($_POST["GENERO"])) . "'";
$telefono = isset($_POST["TELEFONO"]) ? "'" . mysqli_real_escape_string($conex, $_POST["TELEFONO"]) . "'" : "NULL";
$celular = isset($_POST["CELULAR"]) ? "'" . mysqli_real_escape_string($conex, $_POST["CELULAR"]) . "'" : "NULL";
$direccion = isset($_POST["DIRECCION"]) ? "'" . mysqli_real_escape_string($conex, strtoupper($_POST["DIRECCION"])) . "'" : "NULL";
$cod_centro = intval($_POST["COD_CENTRO"]);
$cod_cargo = intval($_POST["COD_CARGO"]);
$fecha_ingreso = isset($_POST["FECHA_INGRESO"]) ? "'" . $_POST["FECHA_INGRESO"] . "'" : "NULL";

// Construir consulta SQL según la opción
$sql = "";

// if ($opcion === "nuevo") {
//     // Inserción
//     $sql = "INSERT INTO personal (
//         NOMBRE, NOMBRE2, AP_PATERNO, AP_MATERNO, CI, EXTENSION, 
//         FECHA_NACIMIENTO, GENERO, TELEFONO1, CELULAR1, DIRECCION, 
//         COD_CENTRO, COD_CARGO, FECHA_INGRESO, ACTIVO
//     ) VALUES (
//         $nombre, $nombre2, $ap_paterno, $ap_materno, $ci, $extension, 
//         $fecha_nacimiento, $genero, $telefono, $celular, $direccion, 
//         $cod_centro, $cod_cargo, $fecha_ingreso, 1
//     )";
// }
if ($opcion === "nuevo") {
    // Obtener el último NRO_TRABAJADOR
    $queryMax = "SELECT MAX(NRO_TRABAJADOR) AS max_trabajador FROM personal";
    $resultMax = mysqli_query($conex, $queryMax);
    if ($resultMax && $row = mysqli_fetch_assoc($resultMax)) {
        $nro_trabajador = intval($row['max_trabajador']) + 1;
    } else {
        // Si no hay registros, comenzar con 1
        $nro_trabajador = 1;
    }

    // Inserción con NRO_TRABAJADOR
    $sql = "INSERT INTO personal (
        NOMBRE, NOMBRE2, AP_PATERNO, AP_MATERNO, CI, EXTENSION, 
        FECHA_NACIMIENTO, GENERO, TELEFONO1, CELULAR1, DIRECCION, 
        COD_CENTRO, COD_CARGO, FECHA_INGRESO, ACTIVO, NRO_TRABAJADOR
    ) VALUES (
        $nombre, $nombre2, $ap_paterno, $ap_materno, $ci, $extension, 
        $fecha_nacimiento, $genero, $telefono, $celular, $direccion, 
        $cod_centro, $cod_cargo, $fecha_ingreso, 1, $nro_trabajador
    )";
}

elseif ($opcion === "modificar") {
    // Modificación
    $cod_personal = intval($_REQUEST["COD_PERSONAL"]);
    $sql = "UPDATE personal SET 
        NOMBRE = $nombre,
        NOMBRE2 = $nombre2,
        AP_PATERNO = $ap_paterno,
        AP_MATERNO = $ap_materno,
        CI = $ci,
        EXTENSION = $extension,
        FECHA_NACIMIENTO = $fecha_nacimiento,
        GENERO = $genero,
        TELEFONO1 = $telefono,
        CELULAR1 = $celular,
        DIRECCION = $direccion,
        COD_CENTRO = $cod_centro,
        COD_CARGO = $cod_cargo,
        FECHA_INGRESO = $fecha_ingreso
    WHERE COD_PERSONAL = $cod_personal";
} else {
    echo '{"success": false, "errors":{"reason": "Opción no válida"}}';
    exit;
}

// Configurar codificación
mysqli_set_charset($conex, "utf8");

// Ejecutar consulta
if (mysqli_query($conex, $sql)) {
    echo '{"success": true}';
} else {
    echo '{"success": false, "errors":{"reason": "Error al guardar registro: ' . mysqli_error($conex) . '"}}';
}
?>
