<?php
    include("../lib/conex.php");       			  
		  
    $start = isset($_POST['start']) ? $_POST['start'] : 0;	
    $limit = isset($_POST['limit']) ? $_POST['limit'] : 25;
    $buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

    if ((strcmp(trim($buscar), '') == 0) || (strcmp(trim($buscar), '*') == 0)) {
        $sql_buscar = '';
    } else { 
        $sql_buscar = " AND( p.nombre LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%')";
    }

    // Conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
        exit;
    }

    // Consulta principal
    $sql = 'SELECT p._id, p.nombre, p.representa_legal, p.nit, p.direccion '.
           'FROM `proveedor` p '.
           'WHERE p.activo = 1 ' . $sql_buscar .
           'ORDER BY p._id DESC '.
           'LIMIT ' . $start . ',' . $limit;

    mysqli_set_charset($conex, "utf8");

    // Obtener el total
    $count_sql = "SELECT COUNT(p._id) AS TOTAL FROM `proveedor` p WHERE p.activo = 1 " . $sql_buscar;
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

    $data = array();
    while ($row = mysqli_fetch_assoc($resultado)) {	
        array_push($data, array( 
            "codigo"          => $row['_id'],
            "nombre"          => $row['nombre'],
            "representa_legal"=> $row['representa_legal'],
            "nit"             => $row['nit'],
            "direccion"       => $row['direccion']
        ));
    }

    $paging = array(
        'success' => true,
        'total' => $total['TOTAL'],
        'data' => $data
    );

    echo json_encode($paging);

    // Cerrar conexión
    mysqli_close($conex);
?>
