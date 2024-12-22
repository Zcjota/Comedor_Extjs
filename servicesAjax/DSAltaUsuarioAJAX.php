<?php
include('../lib/conex.php');

// Recuperar parámetros
$Nombre = strtoupper($_REQUEST["nombre"]);
$cod_personal = $_REQUEST["cod_personal"];
$ApellidoPaterno = strtoupper($_REQUEST["apellidopaterno"]);
$ApellidoMaterno = strtoupper($_REQUEST["apellidomaterno"]);
$Usuario = $_REQUEST["usuario"];
$Contrasenia = $_REQUEST["contrasenia"];
$Correo = $_REQUEST["correo"];
$tipoUser = $_POST["tusuario"];

// Conexión a la base de datos
$conex = ConectarConBD();
if (!$conex) {
    echo json_encode(["success" => false, "errors" => ["reason" => "No se puede conectar con la base de datos"]]);
    exit;
}

// Configurar UTF-8
mysqli_set_charset($conex, 'utf8');

// Verificar si el COD_PERSONAL ya existe
$sql_check = 'SELECT LOGIN FROM `usuario` WHERE COD_PERSONAL = ?';
$stmt_check = $conex->prepare($sql_check);
if (!$stmt_check) {
    echo json_encode(["success" => false, "errors" => ["reason" => "Error en la preparación de la consulta"]]);
    mysqli_close($conex);
    exit;
}

$stmt_check->bind_param('i', $cod_personal);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usuarioExistente = $row['LOGIN'];
    echo json_encode([
        "success" => false,
        "errors" => [
            "reason" => "Este personal ya tiene un usuario asociado.",
            "usuario" => $usuarioExistente,
        ]
    ]);
    $stmt_check->close();
    mysqli_close($conex);
    exit;
}
$stmt_check->close();

// Insertar datos
$sql = 'INSERT INTO `usuario` (NOMBRE, AP_PATERNO, AP_MATERNO, LOGIN, PASSWORD, CORREO, COD_TIPOU, COD_PERSONAL, ACTIVO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)';
$stmt = $conex->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "errors" => ["reason" => "Error en la preparación de la consulta"]]);
    mysqli_close($conex);
    exit;
}

$stmt->bind_param(
    'ssssssii',
    $Nombre,
    $ApellidoPaterno,
    $ApellidoMaterno,
    $Usuario,
    $Contrasenia,
    $Correo,
    $tipoUser,
    $cod_personal
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "errors" => ["reason" => "Error al guardar!!!"]]);
}

// Cerrar recursos
$stmt->close();
mysqli_close($conex);
?>
