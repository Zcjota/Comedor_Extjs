<?php
    include("../lib/conex.php");       			  
		  
    $start = isset($_POST['start']) ? $_POST['start'] : 0;	
    $limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
    $buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';
    
    if ((strcmp(trim($buscar), '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
        $sql_buscar = '';
    } else { 
        $sql_buscar = " AND (tc.NOMBRE LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%')";
        echo "/*$sql_buscar*/";	
    }

    // Conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {	
        echo json_encode(["success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;
    }

    // Configurar UTF-8
    mysqli_set_charset($conex, "utf8");

    // Consulta principal
    $sql = 'SELECT tc.*, u.COD_UNIDAD, s.COD_SUBCENTRO, cc.DESCRIPCION as ccDESCRIPCION, u.DESCRIPCION as uDESCRIPCION, s.DESCRIPCION as sDESCRIPCION ' .
           'FROM `tarjetas_comedor` tc ' .
           'LEFT JOIN centro_de_costo cc ON cc.COD_CENTRO = tc.COD_CENTRO ' .
           'LEFT JOIN unidad u ON u.COD_UNIDAD = cc.COD_UNIDAD ' .
           'LEFT JOIN subcentro s ON s.COD_SUBCENTRO = cc.COD_SUBCENTRO ' .
           'WHERE tc.ACTIVO = 1 ' . $sql_buscar .
           'ORDER BY tc.NOMBRE ' .
           'LIMIT ' . $start . ',' . $limit;

    echo "/*$sql*/";	

    // Obtener total de registros
    $stotal_query = "SELECT COUNT(tc.CODIGO) AS TOTAL FROM `tarjetas_comedor` tc WHERE tc.ACTIVO = 1 " . $sql_buscar;
    $stotal = mysqli_query($conex, $stotal_query);
    if (!$stotal) {
        echo json_encode(["success" => false, "errors" => ["reason" => mysqli_error($conex)]]);
        exit;
    }
    $total = mysqli_fetch_assoc($stotal);

    // Ejecutar consulta de resultados
    $resultado = mysqli_query($conex, $sql);
    if (!$resultado) {
        echo json_encode(["success" => false, "errors" => ["reason" => mysqli_error($conex)]]);
        exit;
    }

    // Procesar resultados
    $data = array();
    while ($row = mysqli_fetch_assoc($resultado)) {	
        array_push($data, array( 
            "codigo"       => $row['CODIGO'],
            "descripcion"  => $row['NOMBRE'],
            "unidad"       => $row['COD_UNIDAD'],
            "subcentro"    => $row['COD_SUBCENTRO'],
            "centro"       => $row['COD_CENTRO'],
            "nunidad"      => $row['uDESCRIPCION'],
            "nsubcentro"   => $row['sDESCRIPCION'],
            "ncentro"      => $row['ccDESCRIPCION']
        ));
    }

    // Respuesta final
    $paging = array(
        'success' => true,
        'total' => $total['TOTAL'],
        'data' => $data
    );
    echo json_encode($paging);

    // Cerrar conexión
    mysqli_close($conex);
?>
