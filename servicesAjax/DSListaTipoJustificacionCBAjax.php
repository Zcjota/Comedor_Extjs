<?php     
include("../lib/conex.php");

if (!VerificaConBD()) {  
    echo json_encode([
        "Success" => false, 
        "errors" => ["reason" => "No se puede conectar con la BD"]
    ]);
    exit;  
}

// Conexión a la base de datos
$conex = ConectarConBD();

// Consulta SQL
$sql = 'SELECT id, nombre FROM `tipo_justificacion` WHERE activo = 1 ORDER BY nombre';  
$resultado = mysqli_query($conex, $sql);

// Manejo de errores en la consulta
if (!$resultado) {
    echo json_encode([
        "Success" => false, 
        "errors" => ["reason" => "Error al realizar la consulta en la base de datos."]
    ]);
    exit;
}

$data = [];

// Recolección de resultados
while ($row = mysqli_fetch_assoc($resultado)) {
    $data[] = [
        "codigop" => $row['id'], 
        "nombrep" => $row['nombre']
    ];
}

// Respuesta JSON
$response = [
    "total" => count($data),
    "data" => $data
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);

// Liberar recursos y cerrar la conexión
mysqli_free_result($resultado);
mysqli_close($conex);
?>
