<?php    
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */         

include("../lib/conex.php"); 
session_start();

// Obtiene la conexión activa
$conex = ConectarConBD();
if (!$conex) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;
}

// Parámetros
$start = isset($_POST['start']) ? $_POST['start'] : 0;		
$limit = isset($_POST['limit']) ? $_POST['limit'] : 25;	
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';	

// Condiciones de búsqueda
$sql_buscar = '';
if ((strcmp($buscar, '') != 0) && (strcmp(trim($buscar), '*') != 0)) { 		
    $sql_buscar = " AND (u.NOMBRE LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%'" .	
                " OR u.AP_PATERNO LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%'" .	
                " OR u.AP_MATERNO LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%')";	
}

// Configura la codificación
if (!mysqli_set_charset($conex, "utf8")) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "No se pudo configurar la codificación"]
    ]);
    exit;
}

// Consulta principal
// $sql = "SELECT u.COD_USUARIO, u.NOMBRE, u.AP_PATERNO, u.AP_MATERNO, u.LOGIN, u.PASSWORD, u.CORREO, u.COD_TIPOU, tu.NOMB_TIPOU, u.FLUJO_VISUALIZADOR, u.EMD, u.REPORT " .				 
//        "FROM `usuario` u LEFT JOIN tipo_usuario tu ON u.COD_TIPOU = tu.COD_TIPOU WHERE u.ACTIVO = 1 " . $sql_buscar .		   
//        "ORDER BY u.AP_PATERNO LIMIT $start, $limit";

       // Consulta principal
$sql = "SELECT u.COD_USUARIO, u.NOMBRE, u.AP_PATERNO, u.AP_MATERNO, u.LOGIN, u.PASSWORD, u.CORREO, u.COD_TIPOU, tu.NOMB_TIPOU " .				 
"FROM `usuario` u LEFT JOIN tipo_usuario tu ON u.COD_TIPOU = tu.COD_TIPOU WHERE u.ACTIVO = 1 " . $sql_buscar .		   
"ORDER BY u.AP_PATERNO LIMIT $start, $limit";

// Total de registros
$stotal = mysqli_query($conex, "SELECT COUNT(u.COD_USUARIO) AS TOTAL FROM `usuario` u WHERE u.ACTIVO = 1" . $sql_buscar);
if (!$stotal) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "Error al obtener el total de registros"]
    ]);
    mysqli_close($conex);
    exit;
}
$total = mysqli_fetch_array($stotal);

// Ejecución de la consulta principal
$resultado = mysqli_query($conex, $sql);
if (!$resultado) {
    echo json_encode([
        "Success" => false,
        "errors" => ["reason" => "Error al ejecutar la consulta principal"]
    ]);
    mysqli_close($conex);
    exit;
}

// Procesamiento de datos
$data = [];
$sqlconfig = 'SELECT * FROM detalle_perfil WHERE ACTIVO = 1 AND COD_SUB_MENU = 1 AND COD_TIPOU = ' . $_SESSION['tipoUser'];
$resultadoConfig = mysqli_query($conex, $sqlconfig);

$configRoles = '';
while ($rowConfig = mysqli_fetch_array($resultadoConfig)) {	
    $configRoles = $rowConfig['ROL'];
}

while ($row = mysqli_fetch_array($resultado)) {	
    // $revisor = ($row['FLUJO_VISUALIZADOR'] == 1) ? "REVISOR" : "";

    $data[] = array(
        "codigo" => $row['COD_USUARIO'], 
        "nombre" => $row['NOMBRE'], 
        "apellidopaterno" => $row['AP_PATERNO'], 
        "apellidomaterno" => $row['AP_MATERNO'], 
        "usuario" => $row['LOGIN'],  
        "contrasenia" => $row['PASSWORD'],
        "correo" => $row['CORREO'],
        "tipo_usuario" => $row['NOMB_TIPOU'],
        "cod_tu" => $row['COD_TIPOU'],
        "configuracion" => $configRoles,
        // "revisor" => $revisor,
        // "emd2" => $row['EMD'],
        // "emd" => $row['EMD'] == 1 ? 'ACTIVO' : 'INACTIVO',
        // "report2" => $row['REPORT'],
        // "report" => $row['REPORT'] == 1 ? 'ACTIVO' : 'INACTIVO',
    );
}

// Salida JSON
$paging = array(		
    'success' => true,		
    'total' => $total['TOTAL'],	
    'data' => $data
);			

echo json_encode($paging);

// Cierra la conexión
mysqli_close($conex);
?>
