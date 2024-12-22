<?php
    include("../lib/conex.php"); 

    $start = isset($_POST['start']) ? $_POST['start'] : 0;    
    $limit = isset($_POST['limit']) ? $_POST['limit'] : 1000;
    $buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

    $sql_buscar = '';
    if (strcmp(trim($buscar), '') !== 0 && strcmp(trim($buscar), '*') !== 0) {
        $sql_buscar = " AND (t.nombre LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%')";
    }

    $conex = ConectarConBD();
    if (!$conex) {
        echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
        exit;
    }

    $sql = "SELECT t.* 
            FROM tipo_justificacion t 
            WHERE t.activo = 1 $sql_buscar 
            ORDER BY t.nombre ASC 
            LIMIT ?, ?";
    
    $stmt = $conex->prepare($sql);
    $stmt->bind_param('ii', $start, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $sql_total = "SELECT COUNT(t.id) AS TOTAL 
                  FROM tipo_justificacion t 
                  WHERE t.activo = 1 $sql_buscar";
    $stmt_total = $conex->prepare($sql_total);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $total = $result_total->fetch_assoc();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "_id" => $row['id'],
            "nombre" => $row['nombre']
        ];
    }

    $paging = [
        'success' => true,
        'total' => $total['TOTAL'],
        'data' => $data
    ];
    echo json_encode($paging);
?>
