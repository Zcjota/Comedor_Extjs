<?php     
    include("../lib/conex.php");        

    $start = isset($_POST['start']) ? $_POST['start'] : 0;	
    $limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
    $buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';
	
    if ((strcmp($buscar, '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
        $sql_buscar = '';
    } else {
        $sql_buscar = " AND NOMB_TIPOU LIKE '" . str_replace('*', '%', trim(strtoupper($buscar))) . "'";
    }	  	
	
    // Verificar conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {	
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);		
        exit;
    }	

    // Consulta principal
    $sql = 'SELECT COD_TIPOU, NOMB_TIPOU ' .
           'FROM `tipo_usuario` ' .
           'WHERE ACTIVO = 1 ' . $sql_buscar .
           'ORDER BY NOMB_TIPOU ' .
           'LIMIT ' . $start . ',' . $limit; 
	
    // Contar total de registros
    $stotal_query = "SELECT COUNT(COD_TIPOU) AS TOTAL FROM `tipo_usuario` WHERE ACTIVO = 1";
    $stotal = mysqli_query($conex, $stotal_query);
    if (!$stotal) {
        echo json_encode(["Success" => false, "errors" => ["reason" => mysqli_error($conex)]]);
        exit;
    }
    $total = mysqli_fetch_assoc($stotal);

    // Ejecutar consulta de datos
    $resultado = mysqli_query($conex, $sql);
    if (!$resultado) {
        echo json_encode(["Success" => false, "errors" => ["reason" => mysqli_error($conex)]]);
        exit;
    }

    // Procesar resultados
    $data = array();     
    while ($row = mysqli_fetch_assoc($resultado)) {
        array_push($data, array(
            "codigo" => $row['COD_TIPOU'],
            "nombre" => $row['NOMB_TIPOU']
        ));							
    }      				
	
    // Construir respuesta
    $paging = array(
        'success' => true,
        'total' => $total['TOTAL'],
        'data' => $data
    );
    echo json_encode($paging);

    // Cerrar conexión
    mysqli_close($conex);
?>
