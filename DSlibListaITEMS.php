<?php

include("lib/conex.php");

// Crear la conexión y establecer el conjunto de caracteres
$conexion = ConectarConBD();
mysqli_set_charset($conexion, 'utf8');

function asignacionAprobar($conexion, $cargador, $idusuario, $personalE) {
    $cant = 0;
    if ($cargador != 2) {
        $sqlAsignacion = "SELECT COUNT(COD_USUARIO) AS TOT 
                          FROM flujo_aprobador 
                          WHERE COD_USUARIO = $idusuario 
                          AND COD_PERSONAL = $personalE 
                          AND ACTIVO = 1";
        $resultadoAsig = mysqli_query($conexion, $sqlAsignacion);
        $totAsig = mysqli_fetch_array($resultadoAsig);
        if ($totAsig['TOT'] != 0) {
            $cant = 1;
        }
    }
    return $cant;
}

function DevuelveListaMenuItem($conexion) {
    if (VerificaConBD()) {
        $sql = "SELECT DP.*, S.COD_MENU, S.COD_SUB_MENU, S.RUTA, S.DESCRIPCION, S.ICON, 
                       M.DESCRIPCION AS MENU, M.ICON AS IMENU
                FROM detalle_perfil DP
                INNER JOIN submenu S ON DP.COD_SUB_MENU = S.COD_SUB_MENU
                INNER JOIN menu M ON S.COD_MENU = M.COD_MENU
                WHERE DP.ACTIVO = 1 AND DP.COD_TIPOU = {$_SESSION['tipoUser']}
                ORDER BY M.ORDEN, S.ORDENS";

        $resultado = mysqli_query($conexion, $sql);
        $nreg = mysqli_num_rows($resultado);
        $data = '';
        $cmenu = '';
        $rmenu = '';
        $fmenu = "]}), listeners: { 'render' : FNcentral, 'click' : FNcentralclick }}";
        $pmenu = '';

        while ($row = mysqli_fetch_array($resultado)) {
            $valor_menu = (int) $row['COD_SUB_MENU'];
            $cadena = $row['DESCRIPCION'];
            $titulo = str_replace('*', '', $cadena);

            if ($pmenu === $row['COD_MENU']) {
                if (empty($cmenu)) {
                    $cmenu = "{ xtype: 'treepanel', title:'<b>{$row['MENU']}</b>', 
                                 iconCls:'{$row['IMENU']}', id: 'MENU{$row['COD_MENU']}', 
                                 margins: '2 2 0 2', autoScroll: true, rootVisible: false, collapsed: true, 
                                 root: new Ext.tree.AsyncTreeNode({ children: [";
                }
                $rmenu .= "{id:'s{$row['COD_SUB_MENU']}', text: '<b>{$titulo}</b>', leaf: true, url: '{$row['RUTA']}', iconCls:'submenu'},";
            } else {
                if (!empty($rmenu)) {
                    $rmenu = substr($rmenu, 0, -1);
                    $data .= $cmenu . $rmenu . $fmenu . ',';
                }
                $cmenu = "{ xtype: 'treepanel', title:'<b>{$row['MENU']}</b>', 
                             iconCls:'{$row['IMENU']}', id: 'MENU{$row['COD_MENU']}', 
                             margins: '2 2 0 2', autoScroll: true, rootVisible: false, collapsed: true, 
                             root: new Ext.tree.AsyncTreeNode({ children: [";
                $rmenu = "{id:'s{$row['COD_SUB_MENU']}', text: '<b>{$titulo}</b>', leaf: true, url: '{$row['RUTA']}', iconCls:'submenu'},";
            }
            $pmenu = $row['COD_MENU'];
        }

        if (!empty($rmenu)) {
            $rmenu = substr($rmenu, 0, -1);
            $data .= $cmenu . $rmenu . $fmenu;
        }

        echo $data;
    } else {
        echo '';
    }
}

?>
