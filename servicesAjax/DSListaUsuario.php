<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2012
 */
include("../lib/conex.php");
session_start();

$id = $_SESSION['IdUsuario'];

// if (!VerificaConBD()) {
//     echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
//     exit;
// }
$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$data = [];

// Consulta para obtener los datos del usuario activo
$sql = "SELECT * FROM usuario WHERE ACTIVO = 1 AND COD_USUARIO = ?";
$stmt = mysqli_prepare($conex, $sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al preparar la consulta: ' . mysqli_error($conex)]]);
    exit;
}

// Vincular parámetros y ejecutar la consulta
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($resultado)) {
    $data[] = [
        "codigo" => $row['COD_USUARIO'],
        "nombre" => $row['NOMBRE'] . " " . $row['AP_PATERNO'] . " " . $row['AP_MATERNO'],
        "login" => $row['LOGIN'],
        "contrasena" => $row['PASSWORD'],
        "correo" => $row['CORREO'],
        "tema" => $row['TEMA']
    ];
}

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);

// Construir la respuesta en JSON
$paging = [
    'success' => true,
    'data' => $data
];

echo json_encode($paging);
?>
