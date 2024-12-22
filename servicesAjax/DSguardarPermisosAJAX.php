<?php
/*!
 * DSoft-MHCA ARG
 * Copyright(c) 2010
 */
include("../lib/conex.php");
session_start();

$regMod = $_POST['modulo'];
$regAlta = $_POST['alta'];
$regBaja = $_POST['baja'];
$regModf = $_POST['modificar'];
$codperfil = $_REQUEST["codperfil"];

if (!VerificaConBD()) {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;
}

$conex = ConectarConBD();
mysqli_set_charset($conex, 'utf8');

$recordMod = json_decode(stripslashes($regMod));
$recordAlta = json_decode(stripslashes($regAlta));
$recordBaja = json_decode(stripslashes($regBaja));
$recordModf = json_decode(stripslashes($regModf));

$roles = [];

// Reiniciar registros para el perfil
$sqlReinicia = "UPDATE `detalle_perfil` SET ACTIVO = 0 WHERE COD_TIPOU = ?";
$stmtReinicia = mysqli_prepare($conex, $sqlReinicia);
mysqli_stmt_bind_param($stmtReinicia, 's', $codperfil);

if (mysqli_stmt_execute($stmtReinicia)) {
    foreach ($recordMod as $record1) {
        $cont = 0;
        $cod_sm1 = $record1->codigosub;

        foreach ($recordAlta as $record2) {
            $cod_sm2 = $record2->codigosub;
            if ($cod_sm2 == $cod_sm1) {
                $cont++;
                $roles[$cod_sm1] = '1';
            }
        }

        if ($cont <= 0) {
            $roles[$cod_sm1] = '0';
        } else {
            $cont = 0;
        }

        foreach ($recordBaja as $record3) {
            $cod_sm3 = $record3->codigosub;
            if ($cod_sm3 == $cod_sm1) {
                $cont++;
                $roles[$cod_sm1] .= '1';
            }
        }

        if ($cont <= 0) {
            $roles[$cod_sm1] .= '0';
        } else {
            $cont = 0;
        }

        foreach ($recordModf as $record4) {
            $cod_sm4 = $record4->codigosub;
            if ($cod_sm4 == $cod_sm1) {
                $cont++;
                $roles[$cod_sm1] .= '1';
            }
        }

        if ($cont <= 0) {
            $roles[$cod_sm1] .= '0';
        }

        // Verificar si ya existe el registro
        $sqlCheck = "SELECT * FROM detalle_perfil WHERE COD_TIPOU = ? AND COD_SUB_MENU = ?";
        $stmtCheck = mysqli_prepare($conex, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, 'ss', $codperfil, $cod_sm1);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if ($row = mysqli_fetch_assoc($resultCheck)) {
            if ($row['ACTIVO'] == 0) {
                $sqlUpdate = "UPDATE `detalle_perfil` SET ACTIVO = 1, ROL = ? WHERE COD_SUB_MENU = ? AND COD_TIPOU = ?";
                $stmtUpdate = mysqli_prepare($conex, $sqlUpdate);
                $roleValue = $roles[$cod_sm1] . "00";
                mysqli_stmt_bind_param($stmtUpdate, 'sss', $roleValue, $cod_sm1, $codperfil);
                mysqli_stmt_execute($stmtUpdate);
            }
        } else {
            $sqlInsert = "INSERT INTO `detalle_perfil` (`COD_SUB_MENU`, `COD_TIPOU`, `ROL`, `ACTIVO`) VALUES (?, ?, ?, 1)";
            $stmtInsert = mysqli_prepare($conex, $sqlInsert);
            $roleValue = $roles[$cod_sm1] . "00";
            mysqli_stmt_bind_param($stmtInsert, 'sss', $cod_sm1, $codperfil, $roleValue);
            mysqli_stmt_execute($stmtInsert);
        }
    }
}

mysqli_close($conex);
?>
