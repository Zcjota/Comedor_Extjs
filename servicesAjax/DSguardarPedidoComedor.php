<?php
/*! * DSoft-MHCA ARG * Copyright(c) 2010 */

include("../lib/conex.php");
session_start();

if (empty($_SESSION['IdUsuario'])) {
    $IdUsuario = 0;
} else {
    $IdUsuario = $_SESSION['IdUsuario'];
}

if (empty($_SESSION['Nombre1'])) {
    $Nombre = 0;
} else {
    $Nombre = strtoupper($_SESSION['Nombre1']) . ' ' . strtoupper($_SESSION['App']);
}

if (empty($_SESSION['tipoUser'])) {
    $tipoUser = 0;
} else {
    $tipoUser = $_SESSION['tipoUser'];
}

function existePersona($conex, $codPersona, $gestion, $mes, $dia)
{
    $sqlex1 = 'SELECT count(tp.COD_PERSONAL) as TOTALE FROM tipo_comida tp WHERE tp.COD_PERSONAL=? AND tp.GESTION=? AND tp.MES=? AND tp.DIA=?';
    $stmt = mysqli_prepare($conex, $sqlex1);
    mysqli_stmt_bind_param($stmt, 'iiii', $codPersona, $gestion, $mes, $dia);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['TOTALE'];
}

function existePersonaActivo($conex, $codPersona, $gestion, $mes, $dia)
{
    $sqlex1 = 'SELECT count(gp.COD_PERSONAL) as TOTALE FROM tipo_comida gp WHERE gp.COD_PERSONAL=? AND gp.GESTION=? AND gp.MES=? AND gp.DIA=? AND gp.ACTIVO=1';
    $stmt = mysqli_prepare($conex, $sqlex1);
    mysqli_stmt_bind_param($stmt, 'iiii', $codPersona, $gestion, $mes, $dia);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['TOTALE'];
}

if ($IdUsuario != 0) {
    $conex = ConectarConBD();
    if (!$conex) {
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;
    }

    mysqli_begin_transaction($conex);

    $reg = $_POST['registros'];
    $fechaDe = substr($_REQUEST["fechaini"], 0, 10);
    $fechaHasta = substr($_REQUEST["fechahasta"], 0, 10);
    $cbtipo = $_REQUEST["cbtipo"];
    date_default_timezone_set('America/La_Paz');
    $fecha = date("Y-m-d H:i:s");
    // $fecha = "2024-09-02 09:37:18";
    // echo "Fecha generada: " . $fecha;

    $records = json_decode(stripslashes($reg));
    $error = 0;

    if ($records != '') {
        foreach ($records as $record) {
            $codigoTrabajador = $record->codigop;

            // Corregir la conversión de fechas
            $fDE = DateTime::createFromFormat('d/m/Y', $fechaDe);
            $fHATA = DateTime::createFromFormat('d/m/Y', $fechaHasta);

            if (!$fDE || !$fHATA) {
                echo json_encode(["Success" => false, "errors" => ["reason" => "Formato de fecha inválido"]]);
                exit;
            }

            while ($fDE <= $fHATA) {
                $gestion1 = $fDE->format('Y');
                $mes1 = $fDE->format('m');
                $dia1 = $fDE->format('d');

                $f = existePersona($conex, $codigoTrabajador, $gestion1, $mes1, $dia1);
                if ($f != 0) {
                    $f1 = existePersonaActivo($conex, $codigoTrabajador, $gestion1, $mes1, $dia1);
                    if ($f1 != 0) {
                        $sql = "UPDATE tipo_comida SET VALIDADOR=?, FECHA=?, COD_USUARIO=?, FECHA_INICIO=?, FECHA_FIN=? WHERE GESTION=? AND MES=? AND DIA=? AND COD_PERSONAL=?";
                        $stmt = mysqli_prepare($conex, $sql);
                        mysqli_stmt_bind_param($stmt, 'sssissiis', $Nombre, $fecha, $IdUsuario, $fechaDe, $fechaHasta, $gestion1, $mes1, $dia1, $codigoTrabajador);
                    } else {
                        $sql = "UPDATE tipo_comida SET ACTIVO=1, VALIDADOR=?, FECHA=?, COD_USUARIO=?, FECHA_INICIO=?, FECHA_FIN=? WHERE GESTION=? AND MES=? AND DIA=? AND COD_PERSONAL=?";
                        $stmt = mysqli_prepare($conex, $sql);
                        mysqli_stmt_bind_param($stmt, 'sssissiis', $Nombre, $fecha, $IdUsuario, $fechaDe, $fechaHasta, $gestion1, $mes1, $dia1, $codigoTrabajador);
                    }
                } else {
                    // $sql = "INSERT INTO tipo_comida (COD_PERSONAL, COD_TIPO, GESTION, MES, DIA, VALIDADOR, FECHA, COD_USUARIO, FECHA_INICIO, FECHA_FIN, ACTIVO) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
                    // $stmt = mysqli_prepare($conex, $sql);
                    // mysqli_stmt_bind_param($stmt, 'iissssisss', $codigoTrabajador, $cbtipo, $gestion1, $mes1, $dia1, $Nombre, $fecha, $IdUsuario, $fechaDe, $fechaHasta);
                    $sql = "INSERT INTO tipo_comida (COD_PERSONAL, COD_TIPO, GESTION, MES, DIA, VALIDADOR, FECHA, COD_USUARIO, FECHA_INICIO, FECHA_FIN, ACTIVO) 
        VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, 1)";
$stmt = mysqli_prepare($conex, $sql);
mysqli_stmt_bind_param($stmt, 'iissssiss', $codigoTrabajador, $cbtipo, $gestion1, $mes1, $dia1, $Nombre, $IdUsuario, $fechaDe, $fechaHasta);

                }

                if (!mysqli_stmt_execute($stmt)) {
                    $error = 1;
                    mysqli_rollback($conex);
                    echo json_encode(["Success" => false, "errors" => ["reason" => "Error al guardar registro"]]);
                    exit;
                }

                $fDE->modify('+1 day');
            }
        }

        if ($error == 0) {
            mysqli_commit($conex);
            echo json_encode(["success" => true, "msg" => ["reason" => "Se registró correctamente."]]);
        }
    }
}

mysqli_close($conex);
?>
