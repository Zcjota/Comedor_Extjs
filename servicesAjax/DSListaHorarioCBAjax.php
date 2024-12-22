<?php     
    include("../lib/conex.php");
    session_start();
    $rcargador = $_SESSION['tipoUser'];
    $ridcargador = $_SESSION['IdUsuario'];
    $nombreValidador = $_SESSION['Apellido1'] . " " . $_SESSION['Apellido2'] . " " . $_SESSION['Nombre'];

    // Conexión a la base de datos
    $conex = ConectarConBD();
    if (!$conex) {	
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;	
    }

    function asignacion($conex, $cargador, $idusuario, $personalE) {
        $cant = 0;
        if ($cargador != 2) {
            $sqlAsignacion = 'SELECT COUNT(COD_USUARIO) AS TOT FROM usuario_horario WHERE COD_USUARIO = ' . $idusuario . ' AND COD_HORARIO = ' . $personalE . ' AND ACTIVO = 1';
            $resultadoAsig = mysqli_query($conex, $sqlAsignacion);
            if ($resultadoAsig) {
                $totAsig = mysqli_fetch_assoc($resultadoAsig);
                $tAsig = $totAsig['TOT'];
                if ($tAsig != 0) {
                    $cant = 1;
                }
            }
        }
        return $cant;
    }

    $sql = 'SELECT COD_HORARIO, NOMBRE_HORARIO FROM horario WHERE ACTIVO = 1 ORDER BY NOMBRE_HORARIO';  	
    $resultado = mysqli_query($conex, $sql);    	
    $data = array();	
    $ban = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {	
        $tipoAsignacion1 = asignacion($conex, $rcargador, $ridcargador, $row['COD_HORARIO']);
        if ($tipoAsignacion1 == 1 || $rcargador == 2) {
            $ban = 1;
            array_push($data, array(
                "codigop" => $row['COD_HORARIO'], 
                "nombrep" => $row['NOMBRE_HORARIO']
            ));
        }				
    }  

    if ($ban == 0) {
        $sql1 = 'SELECT COD_HORARIO, NOMBRE_HORARIO FROM horario WHERE ACTIVO = 1 ORDER BY NOMBRE_HORARIO';  	
        $resultado1 = mysqli_query($conex, $sql1); 
        while ($row1 = mysqli_fetch_assoc($resultado1)) {	
            array_push($data, array(
                "codigop" => $row1['COD_HORARIO'], 
                "nombrep" => $row1['NOMBRE_HORARIO']
            ));
        }  
    }

    $o = array(              
        "total" => count($data),  
        "data" => $data  
    );      
    echo json_encode($o);

    // Cerrar conexión
    mysqli_close($conex); 	
?>
