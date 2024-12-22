<?php     
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */

include("../lib/conex.php");

session_start();
$codpersona = $_SESSION['cod_personal'];

if (!VerificaConBD()) {
    echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
    exit;
}

$conex = ConectarConBD(); // Conexión activa con la BD

// Función para verificar asignaciones de aprobación
function asignacionAprobar($conex, $cargador, $idusuario, $personalE) {
    if ($cargador != 2) {
        $sqlAsignacion = "SELECT COUNT(COD_USUARIO) AS TOT FROM flujo_aprobador WHERE COD_USUARIO = $idusuario AND COD_PERSONAL = $personalE AND ACTIVO = 1";
        $resultadoAsig = mysqli_query($conex, $sqlAsignacion);
        $totAsig = mysqli_fetch_assoc($resultadoAsig);
        return $totAsig['TOT'] > 0 ? 1 : 0;
    }
    return 0;
}

// Consultas específicas
$sql1 = "SELECT COUNT(COD_FORMULARIO) AS total FROM formulario f WHERE f.ESTADO = 2 AND f.ACTIVO = 1";
$resultform = mysqli_query($conex, $sql1);
$totrform = mysqli_fetch_assoc($resultform);
$bandejarevisor = $totrform['total'];

$sqla = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f INNER JOIN asignar_flujo a ON f.COD_FORMULARIO = a.COD_FORMULARIO 
         INNER JOIN detalle_flujo df ON a.COD_ASIGNAR = df.COD_FLUJO 
         WHERE df.ESTADO = 1 AND f.ACTIVO = 1 AND df.COD_USUARIO = " . $_SESSION['IdUsuario'];
$resulaprob = mysqli_query($conex, $sqla);
$totalSA = mysqli_fetch_assoc($resulaprob);
$pendiente = $totalSA['TOTAL'];

$sqlb = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f INNER JOIN personal p ON p.COD_PERSONAL = f.COD_PERSONAL 
         WHERE f.ESTADO = 1 AND f.ACTIVO = 1 AND f.COD_USUARIO = " . $_SESSION['IdUsuario'];
$resulb = mysqli_query($conex, $sqlb);
$totalb = mysqli_fetch_assoc($resulb);
$borradores = $totalb['TOTAL'];

$sqlr = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f INNER JOIN personal p ON p.COD_PERSONAL = f.COD_PERSONAL 
         WHERE f.ESTADO = 5 AND f.ACTIVO = 1 AND f.COD_USUARIO = " . $_SESSION['IdUsuario'];
$resulr = mysqli_query($conex, $sqlr);
$totalr = mysqli_fetch_assoc($resulr);
$rechazado = $totalr['TOTAL'];

$sqlb1 = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f INNER JOIN personal p ON p.COD_PERSONAL = f.COD_PERSONAL 
          WHERE f.LEIDO = 0 AND f.ESTADO = 1 AND f.ACTIVO = 1 AND f.COD_USUARIO = " . $_SESSION['IdUsuario'];
$resulb1 = mysqli_query($conex, $sqlb1);
$totalb1 = mysqli_fetch_assoc($resulb1);
$ttipob1 = $totalb1['TOTAL'];

$sqlr1 = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f INNER JOIN personal p ON p.COD_PERSONAL = f.COD_PERSONAL 
          WHERE f.LEIDO = 0 AND f.ESTADO = 5 AND f.ACTIVO = 1 AND f.COD_USUARIO = " . $_SESSION['IdUsuario'];
$resulr1 = mysqli_query($conex, $sqlr1);
$totalr1 = mysqli_fetch_assoc($resulr1);
$ttipor1 = $totalr1['TOTAL'];

// Retrasos y faltas sin revisión
$total_sin_revision = 0;
$total_sin_revisionretraso = 0;

$sqlCountFormEMD = "SELECT COUNT(df.CODFORMULARIO) AS cantidad 
                    FROM emd e 
                    INNER JOIN visualizadores_evaluaciond df ON e.COD_EMD = df.CODFORMULARIO 
                    INNER JOIN personal p ON p.COD_PERSONAL = df.CODPERSONA 
                    WHERE e.ACTIVO = 1 AND df.ACTIVO = 1 AND df.CODPERSONA = $codpersona AND df.ESTADO_EF = 1";
$resEMD = mysqli_query($conex, $sqlCountFormEMD);
$totalEMD = mysqli_fetch_assoc($resEMD);
$tcountEMD = $totalEMD['cantidad'];

// Salida JSON
echo json_encode([
    "success" => true,
    "message" => [
        "reason" => $bandejarevisor . "-" . $pendiente . "-" . $borradores . "-" . $rechazado . "-" . $ttipob1 . "-" . $ttipor1 . "-" . $total_sin_revision . "-" . $total_sin_revisionretraso . "-" . $tcountEMD
    ]
]);

// Cerrar conexión
mysqli_close($conex);
?>
