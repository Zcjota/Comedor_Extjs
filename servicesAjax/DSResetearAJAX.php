<?php
include_once('DSEnviarMailNuevo.php');
include("../lib/conex.php");

$codigo = $_POST['codi'];

if (isset($codigo)) {
    if (!VerificaConBD()) {
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;
    }

    $conex = ConectarConBD(); // Establece conexión activa

    $sql = "UPDATE `usuario` SET BANDERA = 0 WHERE COD_USUARIO = '$codigo'";
    if ($resultado = mysqli_query($conex, $sql)) {
        $sql = "SELECT p.NOMBRE, p.AP_PATERNO, u.CORREO, u.LOGIN, u.PASSWORD 
                FROM usuario u 
                INNER JOIN personal p ON u.COD_PERSONAL = p.COD_PERSONAL 
                WHERE u.COD_USUARIO = $codigo";

        $resultado = mysqli_query($conex, $sql);
        if ($resultado) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $correo = $row['CORREO'];
                $nombre = $row['NOMBRE'] . " " . $row['AP_PATERNO'];
                $login = $row['LOGIN'];
                $password = $row['PASSWORD'];

                if (EnvioMailUsuarioNuevo($correo, $nombre, $login, $password)) {
                    echo json_encode(["success" => true, "message" => ["reason" => 1]]);
                } else {
                    echo json_encode(["success" => true, "message" => ["reason" => 2]]);
                }
            }
        } else {
            echo json_encode(["Success" => false, "errors" => ["reason" => "Error al recuperar datos del usuario"]]);
        }
    } else {
        echo json_encode(["Success" => false, "errors" => ["reason" => "Registro No Modificado"]]);
    }

    // Cerrar conexión
    mysqli_close($conex);
} else {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se ha enviado el parámetro correcto"]]);
}
?>
