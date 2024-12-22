<?php
include("../lib/conex.php");
session_start();

if (empty($_SESSION['IdUsuario'])) {
    $IdUsuario = 0;
} else {
    $IdUsuario = $_SESSION['IdUsuario'];
}

$Codigo = $_REQUEST["codigo"];
$op = $_REQUEST["opcion"];
$txtnombre = strtoupper($_POST["txtnombre"]);
date_default_timezone_set('America/La_Paz');
$fecha_alta = date("Y-m-d H:i:s");

// Establecer conexión utilizando conex
$conex = ConectarConBD();
if (!$conex) {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la base de datos"]]);
    exit;
}

mysqli_set_charset($conex, "utf8");
$stmt = null; // Inicializar la variable para evitar errores
try {
    // Iniciar transacción
    $conex->begin_transaction();

    if ($op == 0) {
        // Inserción
        $sql = "INSERT INTO tipo_justificacion (`nombre`, `idusuario_alta`, `fecha_alta`, `activo`) VALUES (?, ?, ?, 1)";
        $stmt = $conex->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conex->error);
        }
        $stmt->bind_param("sis", $txtnombre, $IdUsuario, $fecha_alta);
    } else {
        // Actualización
        $sql = "UPDATE tipo_justificacion SET nombre = ?, idusuario_update = ?, fecha_update = ? WHERE id = ?";
        $stmt = $conex->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conex->error);
        }
        $stmt->bind_param("sisi", $txtnombre, $IdUsuario, $fecha_alta, $Codigo);
    }

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    // Confirmar transacción
    $conex->commit();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    // Revertir cambios en caso de error
    $conex->rollback();
    echo json_encode(["Success" => false, "errors" => ["reason" => $e->getMessage()]]);
} finally {
    if ($stmt) {
        $stmt->close(); // Cerrar la declaración si fue creada
    }
    $conex->close(); // Cerrar la conexión
}
?>
