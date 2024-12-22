<?php
include_once('DSEnviarMailNuevo.php');
include("../lib/conex.php");
session_start();

// Verificar sesión del usuario
if (!isset($_SESSION['IdUsuario'])) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Usuario no autenticado']]);
    exit;
}
// $conex = ConectarConBD();
// if (!$conex) {
//     echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
//     exit;
// }

$id = $_SESSION['IdUsuario'];
$login = isset($_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
$contrasena = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

// Conexión a la base de datos
$conex = ConectarConBD();
if (!$conex) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    exit;
}

// Configurar codificación
mysqli_set_charset($conex, "utf8");

// Actualizar login y contraseña
$sql = "UPDATE usuario SET LOGIN = ?, PASSWORD = ?, BANDERA = 1 WHERE COD_USUARIO = ?";
$stmt = mysqli_prepare($conex, $sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error en la consulta SQL: ' . mysqli_error($conex)]]);
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssi', $login, $contrasena, $id);
if (mysqli_stmt_execute($stmt)) {
    // Obtener datos del usuario para el correo
    $sql1 = "SELECT p.NOMBRE, p.AP_PATERNO, u.CORREO, u.LOGIN, u.PASSWORD 
             FROM usuario u 
             INNER JOIN personal p ON u.COD_PERSONAL = p.COD_PERSONAL 
             WHERE u.COD_USUARIO = ?";
    $stmt1 = mysqli_prepare($conex, $sql1);

    if (!$stmt1) {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'Error en la consulta SQL: ' . mysqli_error($conex)]]);
        exit;
    }

    mysqli_stmt_bind_param($stmt1, 'i', $id);
    mysqli_stmt_execute($stmt1);
    $resultado1 = mysqli_stmt_get_result($stmt1);

    if ($row = mysqli_fetch_assoc($resultado1)) {
        $correo = $row['CORREO'];
        $nombre = $row['NOMBRE'] . ' ' . $row['AP_PATERNO'];
        $login = $row['LOGIN'];
        $password = $row['PASSWORD'];

        // Enviar correo
        if (EnvioMailUsuarioConfirmacion($correo, $nombre, $login, $password)) {
            echo json_encode(['success' => true, 'message' => ['reason' => 1]]);
        } else {
            echo json_encode(['success' => true, 'message' => ['reason' => 2]]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'No se encontraron datos del usuario']]);
    }
    mysqli_stmt_close($stmt1);
} else {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al guardar registro']]);
}

// Cerrar conexión
mysqli_stmt_close($stmt);
mysqli_close($conex);
?>
