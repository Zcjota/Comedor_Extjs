<?php
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
include("../lib/conex.php");

$cod_perfil = isset($_POST['codperfil']) ? $_POST['codperfil'] : '';
$roles = isset($_POST['roles']) ? $_POST['roles'] : '';

if (!VerificaConBD()) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
    exit;
}

$conex = ConectarConBD();
mysqli_set_charset($conex, "utf8");

// Consulta principal
$sql = 'SELECT A.COD_SUB_MENU AS CODS, A.DESCRIPCION AS SUBM, A.COD_MENU AS CODM, B.DESCRIPCION AS MENU
        FROM submenu A, menu B 
        WHERE A.COD_MENU = B.COD_MENU AND A.ACTIVO = 1 
        ORDER BY A.COD_MENU';

// Consulta de configuración
$sqltram = 'SELECT DP.* FROM detalle_perfil DP WHERE ACTIVO = 1 AND DP.COD_TIPOU = ' . mysqli_real_escape_string($conex, $cod_perfil);

// Ejecutar consultas
$resultado = mysqli_query($conex, $sql);
if (!$resultado) {
    echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al ejecutar la consulta principal']]);
    exit;
}

$data = [];
$tick = 0;
$comparacion = false;

while ($row = mysqli_fetch_assoc($resultado)) {
    $resTram = mysqli_query($conex, $sqltram);
    if (!$resTram) {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'Error al ejecutar la consulta de configuración']]);
        exit;
    }

    while ($rowConfig = mysqli_fetch_assoc($resTram)) {
        $rol = $rowConfig['ROL'];

        if ($rowConfig['COD_SUB_MENU'] == $row['CODS']) {
            $comparacion = true;

            if ($roles == 'Modulo') {
                $data[] = [
                    "codigosub" => $row['CODS'],
                    "nombresub" => $row['SUBM'],
                    "codigomen" => $row['CODM'],
                    "nombremen" => $row['MENU'],
                    "ticket" => 1,
                    "rol" => $roles,
                ];
                $tick = 0;
            } else {
                if ($rol[0] == 1 && $roles == 'Alta') {
                    $tick = 1;
                }
                if ($rol[1] == 1 && $roles == 'Baja') {
                    $tick = 1;
                }
                if ($rol[2] == 1 && $roles == 'Modf') {
                    $tick = 1;
                }
                $data[] = [
                    "codigosub" => $row['CODS'],
                    "nombresub" => $row['SUBM'],
                    "codigomen" => $row['CODM'],
                    "nombremen" => $row['MENU'],
                    "ticket" => $tick,
                    "rol" => $roles,
                ];
                $tick = 0;
            }
        }
    }

    if (!$comparacion) {
        $data[] = [
            "codigosub" => $row['CODS'],
            "nombresub" => $row['SUBM'],
            "codigomen" => $row['CODM'],
            "nombremen" => $row['MENU'],
            "ticket" => $tick,
            "rol" => $roles,
        ];
    } else {
        $comparacion = false;
    }
}

// Respuesta JSON
$paging = [
    'success' => true,
    'data' => $data,
];

echo json_encode($paging);

// Cerrar la conexión
mysqli_close($conex);
?>
