<?php
    include("../lib/conex.php");       			  
		  
    $start = isset($_POST['start']) ? $_POST['start'] : 0;	
    $limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
    $buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

    if ((strcmp(trim($buscar), '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
        $sql_buscar = '';
    } else { 
        $sql_buscar = " AND (r.NOMBRE LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%')";
        echo "/*$sql_buscar*/";	
    }

    // Conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
        exit;
    }

    // Consulta principal
    $sql = 'SELECT r.* '.
           'FROM `reloj_comedor` r '.
           'WHERE r.ACTIVO = 1 ' . $sql_buscar .
           'ORDER BY r.NOMBRE '.
           'LIMIT ' . $start . ',' . $limit;

    echo "/*$sql*/";	

    // Obtener el total
    $count_sql = "SELECT COUNT(r.COD_RELOJ) AS TOTAL FROM `reloj` r WHERE r.ACTIVO = 1 " . $sql_buscar;
    $stotal = mysqli_query($conex, $count_sql);
    if (!$stotal) {
        echo json_encode(['success' => false, 'errors' => ['reason' => mysqli_error($conex)]]);
        exit;
    }
    $total = mysqli_fetch_assoc($stotal);

    // Obtener los resultados
    $resultado = mysqli_query($conex, $sql);
    if (!$resultado) {
        echo json_encode(['success' => false, 'errors' => ['reason' => mysqli_error($conex)]]);
        exit;
    }

    // Procesar resultados
    $data = array();
    while ($row = mysqli_fetch_assoc($resultado)) {	
        array_push($data, array( 
            "codigo"       => $row['COD_RELOJ'],
            "descripcion"  => $row['NOMBRE'],
            "ip"           => $row['IP'],
            "oct1"         => $row['OC1'],	
            "oct2"         => $row['OC2'],	
            "oct3"         => $row['OC3'],	
            "oct4"         => $row['OC4']
        ));
    }

    // Respuesta final
    $paging = array(
        'success' => true,
        'total'   => $total['TOTAL'],
        'data'    => $data
    );
    echo json_encode($paging);

    // Cerrar conexión
    mysqli_close($conex);
?>
