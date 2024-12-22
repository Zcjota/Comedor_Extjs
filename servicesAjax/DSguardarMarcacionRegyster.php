<?php
include("../lib/conex.php");

$reg = $_POST['registros'];
// if (!VerificaConBD()) {
//     echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';
//     exit;
// }

$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}

$records = json_decode(stripslashes($reg));
if ($records != '') {
    foreach ($records as $record) {
        $idmarcacion = $record->idmarcacion;
        $hora_marcacion = substr($record->fecha_marcacion, 11, 8); // Ajuste en posición
        $fecha_marcacion = substr($record->fecha_marcacion, 0, 10);
        $latitud = $record->latitud;
        $longitud = $record->longitud;
        $idproposito = $record->idproposito;
        $idtipo_marcacion = $record->idtipo_marcacion;
        $nombre_cliente = strtoupper($record->nombre_cliente);
        $celular = $record->celular;

        // Convertir fecha al formato adecuado
        $valores = explode("-", $fecha_marcacion);
        $gestion = $valores[0];
        $mes = $valores[1];
        $dia = $valores[2];
        $fecha_marcacion = $gestion . "-" . $mes . "-" . $dia;

        // Inserción condicional
        $sql = "INSERT INTO marcacion_movil (idmarcacion, fecha_marcacion, hora_marcacion, latitud, longitud, celular, activo, idtipo_marcacion, nombre_cliente, idproposito)
                SELECT '$idmarcacion', '$fecha_marcacion', '$hora_marcacion', '$latitud', '$longitud', '$celular', 1, '$idtipo_marcacion', '$nombre_cliente', '$idproposito'
                FROM DUAL 
                WHERE NOT EXISTS (
                    SELECT 1 FROM marcacion_movil WHERE idmarcacion = '$idmarcacion'
                )";

        $rst = mySQL_Query($conex,$sql);
        $error = 0;
        if (!$rst) {
            $error = 1;
        }

        if ($error == 1) {
            echo '{"Success": false, "errors":{"reason": "Error al guardar registro"}}';
        } else {
            if ($idtipo_marcacion != 3 && $idtipo_marcacion != '3') {
                $idmarcacion_movil = $idmarcacion;

                // Obtener datos de fecha y hora
                $valores = explode("-", $fecha_marcacion);
                $gestion = (int)$valores[0];
                $mes = (int)$valores[1];
                $dia = (int)$valores[2];

                $valores1 = explode(":", $hora_marcacion);
                $hora = (int)$valores1[0];
                $minuto = (int)$valores1[1];
                $segundo = (int)$valores1[2];

                // Buscar trabajador asociado al celular
                $sqlmm = "SELECT p.NRO_TRABAJADOR 
                          FROM personal p 
                          WHERE p.ACTIVO = 1 AND p.CELULAR2 = '$celular'";
                $resultadomm = mysql_query($conex,$sqlmm);
                while ($rowmm = mysql_fetch_array($resultadomm)) {
                    $codpersona = $rowmm['NRO_TRABAJADOR'];

                    // Insertar en la tabla marcacion
                    $sqlm1 = "INSERT INTO marcacion (COD_PERSONAL, HORA, MINUTO, SEGUNDO, GESTION, MES, DIA, ACTIVO, idmarcacionmovil)
                              VALUES ($codpersona, $hora, $minuto, $segundo, $gestion, $mes, $dia, 1, $idmarcacion_movil)";
                    mysql_query($conex,$sqlm1);
                }
            }
        }
    }
}
?>
