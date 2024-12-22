<?php     
    include("../lib/conex.php");

    // if (!VerificaConBD()) {
    //     echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
    //     exit;
    // }
    // Verificar conexión
    $conex = ConectarConBD();
    if (!$conex) {	
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;	
    }

    // Configurar UTF-8
    mysqli_set_charset($conex, "utf8");

    // Obtener parámetro
    $Unidad = "'" . mysqli_real_escape_string($conex, $_REQUEST['cbUnidad']) . "'";

    // Consulta SQL
    $sql = 'SELECT DISTINCT S.COD_SUBCENTRO, S.DESCRIPCION ' .
           'FROM `subcentro` S ' .
           'INNER JOIN centro_de_costo C ON S.COD_SUBCENTRO = C.COD_SUBCENTRO ' .
           'WHERE S.ACTIVO = 1 AND C.COD_UNIDAD = ' . $Unidad . ' ' .
           'ORDER BY S.DESCRIPCION';

    // Ejecutar consulta
    $resultado = mysqli_query($conex, $sql);
    if (!$resultado) {
        echo json_encode(["Success" => false, "errors" => ["reason" => mysqli_error($conex)]]);
        exit;
    }

    // Procesar resultados
    $data = array();
    while ($row = mysqli_fetch_assoc($resultado)) {			
        array_push($data, array( 	
            "codigop" => $row['COD_SUBCENTRO'], 
            "nombrep" => $row['DESCRIPCION']
        ));				
    }

    // Preparar salida
    $o = array(              
        "total" => count($data),  
        "data" => $data  
    );      
    echo json_encode($o);

    // Cerrar conexión
    mysqli_close($conex); 	
?>
