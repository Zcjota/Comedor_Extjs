<?php
/*!
 * Calle
 * Copyright(c) 2020
 */
include("../lib/conex.php");

session_start();
$IdUsuario = empty($_SESSION['IdUsuario']) ? 0 : $_SESSION['IdUsuario'];
$codigo = $_POST['id'];
date_default_timezone_set('America/La_Paz');
$fecha_baja = date("Y-m-d H:i:s");

if (isset($codigo)) {
    // Conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;
    }

    // Consulta preparada para desactivar el registro
    $sql = 'UPDATE `tipo_justificacion` 
            SET activo = 0, idusuario_baja = ?, fecha_baja = ? 
            WHERE id = ?'; // Cambiado _id por id (o el nombre correcto de la columna)
    $stmt = mysqli_prepare($conex, $sql);
    if (!$stmt) {
        echo json_encode(["Success" => false, "errors" => ["reason" => "Error al preparar la consulta"]]);
        exit;
    }

    // Asignar parámetros
    mysqli_stmt_bind_param($stmt, 'isi', $IdUsuario, $fecha_baja, $codigo);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["Success" => false, "errors" => ["reason" => "Registro No Desactivado"]]);
    }

    // Cerrar recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conex);
} else {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se ha enviado el parametro correcto"]]);
}
?>
