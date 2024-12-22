<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2012
 */
include("../lib/conex.php");
session_start();

$id = $_SESSION['IdUsuario'] ;
$codigo = $_POST['codigo'] ;

// if (!VerificaConBD()) {
//     echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
//     exit;
// }

$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$login = '';
$contrasena = '';

// Consulta para obtener datos del usuario actual
$sqluser = "SELECT LOGIN, PASSWORD FROM usuario WHERE ACTIVO = 1 AND COD_USUARIO = ?";
$stmt1 = mysqli_prepare($conex, $sqluser);

if (!$stmt1) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al preparar la consulta: ' . mysqli_error($conex)]]);
    exit;
}

mysqli_stmt_bind_param($stmt1, 'i', $id);
mysqli_stmt_execute($stmt1);
$resultado1 = mysqli_stmt_get_result($stmt1);

if ($row1 = mysqli_fetch_assoc($resultado1)) {
    $login = $row1['LOGIN'];
    $contrasena = $row1['PASSWORD'];
}

mysqli_stmt_close($stmt1);

// Consulta para obtener otros usuarios
$data = [];
$sql = "SELECT COD_USUARIO, LOGIN, PASSWORD FROM usuario WHERE ACTIVO = 1 AND COD_USUARIO <> ?";
$stmt2 = mysqli_prepare($conex, $sql);

if (!$stmt2) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al preparar la consulta: ' . mysqli_error($conex)]]);
    exit;
}

mysqli_stmt_bind_param($stmt2, 'i', $id);
mysqli_stmt_execute($stmt2);
$resultado2 = mysqli_stmt_get_result($stmt2);

while ($row = mysqli_fetch_assoc($resultado2)) {
    $data[] = [
        "codusuario" => $row['COD_USUARIO'],
        "login" => $row['LOGIN'],
        "contrasena" => $row['PASSWORD'],
        "usuario_actual" => $login,
        "passwor_actual" => $contrasena
    ];
}

mysqli_stmt_close($stmt2);

// Respuesta JSON
$paging = [
    'success' => true,
    'data' => $data
];
echo json_encode($paging);
?>
