<?php

include("../lib/conex.php");
session_start();

if (empty($_SESSION['IdUsuario'])) {
    $IdUsuario = 0;
} else {
    $IdUsuario = $_SESSION['IdUsuario'];
}

$codigo = $_POST['id'];
date_default_timezone_set('America/La_Paz');
$fecha_alta = date("Y-m-d H:i:s");

if (isset($codigo)) {
    // Verificar conexión
    if (!VerificaConBD()) {
        echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
        exit;
    }

    // Establecer conexión
    $conex = ConectarConBD();
    mysqli_set_charset($conex, "utf8");

    $sql = 'UPDATE `nivel` SET ACTIVO = 0, idusuario_baja = ?, fecha_baja = ? WHERE COD_NIVEL = ?';
    $stmt = $conex->prepare($sql);

    if (!$stmt) {
        echo '{"Success": false, "errors":{"reason": "Error en la preparación de la consulta"}}';
        mysqli_close($conex);
        exit;
    }

    $stmt->bind_param('isi', $IdUsuario, $fecha_alta, $codigo);

    if ($stmt->execute()) {
        echo '{"success": true}';
    } else {
        echo '{"Success": false, "errors":{"reason": "Registro No Desactivado"}}';
    }

    $stmt->close();
    mysqli_close($conex);
} else {
    echo '{"Success": false, "errors":{"reason": "No se ha enviado el parámetro correcto"}}';
}
?>
