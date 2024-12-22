<?php
include_once("../lib/conex.php");

function agrupar($x)
{
    $itemstabs1 = " {xtype: 'buttongroup',".
                  "  columns: 2,".
                  " defaults: {".
                  " scale: 'medium'},".
                  "  x:".($x).",".
                  " items:[";
    return $itemstabs1;
}

function asignacionAprobar($cargador, $idusuario, $personalE)
{
    $conexion = ConectarConBD();
    $cant = 0;

    if ($cargador != 2) {
        $sqlAsignacion = 'SELECT COUNT(COD_USUARIO) AS TOT FROM flujo_aprobador WHERE COD_USUARIO = '.$idusuario.' AND COD_PERSONAL = '.$personalE.' AND ACTIVO = 1';
        $resultadoAsig = mysqli_query($conexion, $sqlAsignacion);

        if ($resultadoAsig) {
            $totAsig = mysqli_fetch_array($resultadoAsig, MYSQLI_ASSOC);
            $tAsig = $totAsig['TOT'];
            if ($tAsig != 0) {
                $cant = 1;
            }
        }
    }

    return $cant;
}

function DevuelvesubMenuItem($menu)
{
    $conexion = ConectarConBD();

    $sq1 = 'SELECT M.DESCRIPCION AS MENU, M.ICON AS IMENU, S.DESCRIPCION, S.RUTA, S.COD_SUB_MENU, S.ICON AS SICON '.
           'FROM detalle_perfil DP '.
           'INNER JOIN submenu S ON DP.COD_SUB_MENU = S.COD_SUB_MENU '.
           'INNER JOIN menu M ON S.COD_MENU = M.COD_MENU '.
           'WHERE DP.ACTIVO = 1 AND DP.COD_TIPOU = '.$_SESSION['tipoUser'].
           ' AND M.COD_MENU = '.$menu.
           ' ORDER BY M.ORDEN, S.ORDENS';

    mysqli_set_charset($conexion, 'utf8');
    $cmenu1 = '';
    $resultad1 = mysqli_query($conexion, $sq1);

    while ($row1 = mysqli_fetch_array($resultad1, MYSQLI_ASSOC)) {
        $cadena = $row1['DESCRIPCION'];

        switch ($row1['COD_SUB_MENU']) {
            case 15:
                $cadena = "Faltas* (Sin Revision)";
                break;
            case 63:
                $cadena = "Retrasos* (Sin Revision)";
                break;
            case 45:
                $cadena = "Horas Extras* (Aprobacion)";
                break;
            case 24:
                $cadena = "Bandeja (Borradores)";
                break;
            case 25:
                $cadena = "Bandeja (Revisores)";
                break;
            case 29:
                $cadena = "Bandeja (Rechazado)";
                break;
            case 26:
                $cadena = "Pendientes de Aprobacion";
                break;
        }

        $buscar = '*';
        $reemplazar = '</br>';
        $titulo = str_replace($buscar, $reemplazar, $cadena);
        $cadena = str_replace('*', '', $cadena);

        $l = '<a style ="color:#15428B; font: bold 8.5px tahoma,arial,verdana,sans-serif;">';
        $cmenu1 .= "{ text: '".$l.$titulo."</a>',".
                   "  iconCls:'".$row1['SICON']."',".
                   "  id:'c".$row1['COD_SUB_MENU']."',".
                   "  name:'c".$row1['COD_SUB_MENU']."',".
                   "  handler:  handleActionDinamico.createCallback('".$row1['COD_SUB_MENU']."','".$cadena."','".$row1['RUTA']."'),".
                   " },'-',";
    }

    $rmenu = $cmenu1;
    $data = " tbar:  new Ext.Toolbar({".
            " autoScroll: true,".
            " defaults: {".
            " scale: 'large'},".
            " items:[".$rmenu."]})";

    return $data;
}

function DevuelveListaMenuItem1()
{
    $conexion = ConectarConBD();

    $sq = 'SELECT DISTINCT M.COD_MENU, M.DESCRIPCION AS MENU, M.ICON AS IMENU, M.ORDEN, S.ORDENS '.
          'FROM detalle_perfil DP '.
          'INNER JOIN submenu S ON DP.COD_SUB_MENU = S.COD_SUB_MENU '.
          'INNER JOIN menu M ON S.COD_MENU = M.COD_MENU '.
          'WHERE DP.ACTIVO = 1 AND DP.COD_TIPOU = '.$_SESSION['tipoUser'].
          ' ORDER BY M.ORDEN, S.ORDENS';

    mysqli_set_charset($conexion, 'utf8');
    $resultad = mysqli_query($conexion, $sq);

    if (!$resultad) {
        die("Error en la consulta SQL: " . mysqli_error($conexion));
    }

    $cmenu = '';
    while ($row = mysqli_fetch_array($resultad, MYSQLI_ASSOC)) {
        $hijo = DevuelvesubMenuItem($row['COD_MENU']);
        $cmenu .= "{ title: '<B style=color:#15428B><font size=1>".$row['MENU']."</font></B>',".
                  " layout: 'absolute',".
                  " frame: true,".
                  " id: 'Me".$row['COD_MENU']."',".
                  " iconCls: '".$row['IMENU']."',".$hijo.
                  " },";
    }

    $rmenu = substr($cmenu, 0, strlen($cmenu) - 1);

    $data = "{ xtype: 'tabpanel',".
            " activeTab: 0,".
            " enableTabScroll: true,".
            " height: 85,".
            " y: 0,".
            " width: screen.width,".
            " items:[".$rmenu."] }";

    return $data;
}
?>
