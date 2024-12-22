<?php
include("../lib/conex.php");

function DevuelveCamposResumenComedor()
{
    $conex = ConectarConBD(); // Conexión activa
    mysqli_set_charset($conex, "utf8");

    if (!$conex) {
        echo '{"success": false, "errors": {"reason": "No se puede conectar con la BD"}}';
        exit;
    }

    $campos = "'codigo','nombre','cargo','unidad','subcentro','centro',";
    $h = 1;

    $sqlHorario = 'SELECT * FROM horario_comedor WHERE ACTIVO = 1 ORDER BY HORARIO';
    $rHorario = mysqli_query($conex, $sqlHorario);

    while ($row = mysqli_fetch_assoc($rHorario)) {
        $campos .= "'c" . $h . "',";
        $h++;
    }

    $campos = substr($campos, 0, -1); // Remueve la "," final
    return $campos;
}

function DevuelveColumnasResumenComedor()
{
    $conex = ConectarConBD(); // Conexión activa
    mysqli_set_charset($conex, "utf8");

    if (!$conex) {
        echo '{"success": false, "errors": {"reason": "No se puede conectar con la BD"}}';
        exit;
    }

    $sqlHorario = 'SELECT * FROM horario_comedor WHERE ACTIVO = 1 ORDER BY HORARIO';
    $rHorario = mysqli_query($conex, $sqlHorario);

    $columnas = "new Ext.grid.RowNumberer({width: 25}),
                 { header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CODIGO</a>',
                   dataIndex : 'codigo',
                   width: 80,
                   align: 'left',
                   renderer: formato },
                 { header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>NOMBRE</a>',
                   dataIndex : 'nombre',
                   width: 200,
                   align: 'left',
                   renderer: formato },
                 { header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CARGO</a>',
                   dataIndex : 'cargo',
                   width: 170,
                   align: 'left',
                   renderer: formato },
                 { header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>UNIDAD</a>',
                   dataIndex : 'unidad',
                   width: 100,
                   align: 'left',
                   renderer: formato },
                 { header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>SUBCENTRO</a>',
                   dataIndex : 'subcentro',
                   width: 100,
                   align: 'left',
                   renderer: formato },
                 { header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CENTRO</a>',
                   dataIndex : 'centro',
                   width: 120,
                   align: 'left',
                   renderer: formato }, ";

    $j = 1;
    while ($row = mysqli_fetch_assoc($rHorario)) {
        $columnas .= "{ header : '<a style=color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>HORARIO</BR>" . $row['DESCRIPCION'] . "</BR>(" . $row['HORARIO'] . "-" . $row['HORARIO_SALIDA'] . ")</a>',
                        dataIndex : 'c" . $j . "',
                        width: 100,
                        align: 'center',
                        renderer: formato },";
        $j++;
    }

    $columnas = substr($columnas, 0, -1); // Remueve la "," final
    return $columnas;
}
?>
