<?php
include("../lib/conex.php");

$op = $_REQUEST["opcion"];

// Verificar conexión con la base de datos
if (!VerificaConBD()) {
    echo '{"success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$conex = ConectarConBD();

// Capturar datos enviados desde el formulario
$cod_personal = $_REQUEST["COD_PERSONAL"];
$nombre = "'" . strtoupper($_POST["NOMBRE"]) . "'";
$nombre2 = isset($_POST["NOMBRE2"]) ? "'" . strtoupper($_POST["NOMBRE2"]) . "'" : "NULL";
$ap_paterno = "'" . strtoupper($_POST["AP_PATERNO"]) . "'";
$ap_materno = "'" . strtoupper($_POST["AP_MATERNO"]) . "'";
$ci = $_POST["CI"];
$extension = isset($_POST["EXTENSION"]) ? "'" . strtoupper($_POST["EXTENSION"]) . "'" : "NULL";
$fecha_nacimiento = "'" . $_POST["FECHA_NACIMIENTO"] . "'";
$genero = "'" . strtoupper($_POST["GENERO"]) . "'";
$telefono = isset($_POST["TELEFONO"]) ? "'" . $_POST["TELEFONO"] . "'" : "NULL";
$celular = isset($_POST["CELULAR"]) ? "'" . $_POST["CELULAR"] . "'" : "NULL";
$direccion = isset($_POST["DIRECCION"]) ? "'" . strtoupper($_POST["DIRECCION"]) . "'" : "NULL";
$cod_centro = $_POST["COD_CENTRO"];
$cod_cargo = $_POST["COD_CARGO"];
$fecha_ingreso = isset($_POST["FECHA_INGRESO"]) ? "'" . $_POST["FECHA_INGRESO"] . "'" : "NULL";

// Establecer consulta SQL para modificación
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

// Configurar codificación
mysqli_set_charset($conex, "utf8");

// Ejecutar consulta
if (mysqli_query($conex, $sql)) {
    echo '{"success": true}';
} else {
    echo '{"success": false, "errors":{"reason": "Error al modificar registro: ' . mysqli_error($conex) . '"}}';
}
?>
