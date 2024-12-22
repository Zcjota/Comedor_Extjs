<?php     
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */

include("../lib/conex.php");

// Validar la conexión a la base de datos
$conex = ConectarConBD();
if (!$conex) {	
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;	
}

// Configurar la codificación UTF-8
if (!mysqli_set_charset($conex, "utf8")) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se pudo configurar la codificación UTF-8"]
    ]);
    mysqli_close($conex);
    exit;
}

// Consulta SQL
$sql = 'SELECT p.COD_PERSONAL, p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2, p.NRO_TRABAJADOR, p.CI, p.FECHA_INGRESO, ' .
       'c.DESCRIPCION AS cDESCRIPCION, cc.DESCRIPCION AS ccDESCRIPCION ' .
       'FROM `personal` p ' .
       'INNER JOIN cargo c ON p.COD_CARGO = c.COD_CARGO ' .
       'INNER JOIN centro_de_costo cc ON p.COD_CENTRO = cc.COD_CENTRO ' .
       'WHERE p.ACTIVO = 1 ' .
       'ORDER BY p.AP_PATERNO';

// Ejecutar la consulta
$resultado = mysqli_query($conex, $sql);
if (!$resultado) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "Error al ejecutar la consulta"]
    ]);
    mysqli_close($conex);
    exit;
}

// Procesar los resultados
$data = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $nombre_completo = $row['AP_PATERNO'] . ' ' . $row['AP_MATERNO'] . ' ' . $row['NOMBRE'] . ' ' . $row['NOMBRE2'];
    $nombre = $row['NOMBRE'] . ' ' . $row['NOMBRE2'];
    $data[] = [
        "codigo" => $row['COD_PERSONAL'], 
        "nombre" => $nombre_completo,
        "nombreP" => $nombre,
        "app" => $row['AP_PATERNO'],
        "apm" => $row['AP_MATERNO'],
        "codtrabajador" => $row['NRO_TRABAJADOR'],
        "cargo" => $row['cDESCRIPCION'],
        "cedula" => $row['CI'],
        "area" => $row['ccDESCRIPCION'],
        "fecha_ingreso" => $row['FECHA_INGRESO']
    ];				
}

// Generar la salida JSON
$o = [
    "total" => count($data),
    "data" => $data
];      
echo json_encode($o);

// Cerrar la conexión
mysqli_close($conex);
?>
