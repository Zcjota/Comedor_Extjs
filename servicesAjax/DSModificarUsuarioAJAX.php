<?php
    include('../lib/conex.php');	
	
    $Codigo          = $_REQUEST["codigo"];
    $Nombre          = strtoupper($_REQUEST["nombre"]);
    $ApellidoPaterno = strtoupper($_REQUEST["apellidopaterno"]);
    $ApellidoMaterno = strtoupper($_REQUEST["apellidomaterno"]);
    $Correo          = $_REQUEST["correo"];
    $Usuario         = $_REQUEST["usuario"];
    $Contrasenia     = $_REQUEST["contrasenia"];
    $tipoUser        = $_REQUEST["tipo_usuario"];

    // Conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {	
        echo "No se puede conectar con la base de datos";
        exit;
    }	

    // Consulta con parámetros
    $sql = 'UPDATE `usuario` 
            SET NOMBRE = ?, 
                AP_PATERNO = ?, 
                AP_MATERNO = ?, 
                LOGIN = ?, 
                PASSWORD = ?, 
                CORREO = ?, 
                COD_TIPOU = ? 
            WHERE COD_USUARIO = ?';

    // Preparar consulta
    $stmt = mysqli_prepare($conex, $sql);
    if (!$stmt) {
        echo '{"Success": false, "errors":{"reason": "Error al preparar la consulta"}}';
        exit;
    }

    // Asignar parámetros
    mysqli_stmt_bind_param($stmt, 'sssssssi', 
        $Nombre, 
        $ApellidoPaterno, 
        $ApellidoMaterno, 
        $Usuario, 
        $Contrasenia, 
        $Correo, 
        $tipoUser, 
        $Codigo
    );

    // Ejecutar consulta
    if (mysqli_stmt_execute($stmt)) {
        echo '{"success": true}';
    } else {
        echo '{"Success": false, "errors":{"reason": "Error al guardar!!!"}}';
    }

    // Cerrar recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conex);
?>
