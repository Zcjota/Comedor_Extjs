<?php

include("lib/conex.php"); 
$conexion = ConectarConBD();

function DevuelveListaMenuItem($conexion) { 
    if (VerificaConBD()) {            

        $rcargador = $_SESSION['tipoUser'];
        $ridcargador = $_SESSION['IdUsuario'];
        date_default_timezone_set('America/La_Paz');

        $sql = 'SELECT DP.*, S.COD_MENU, S.COD_SUB_MENU, S.RUTA, S.DESCRIPCION, S.ICON, M.DESCRIPCION AS MENU, M.ICON AS IMENU ' .
               'FROM detalle_perfil DP ' .
               'INNER JOIN submenu S ON DP.COD_SUB_MENU = S.COD_SUB_MENU ' .
               'INNER JOIN menu M ON S.COD_MENU = M.COD_MENU ' .
               'WHERE DP.ACTIVO = 1 AND DP.COD_TIPOU = ' . $_SESSION['tipoUser'] . ' ' .
               'ORDER BY M.ORDEN, S.ORDENS';

        $resultado = mysqli_query($conexion, $sql);    
        $nreg = mysqli_num_rows($resultado);     
        $cmenu = '';
        $rmenu = '';
        $fmenu = "]}),    listeners: { 'render' : FNcentral, 'click' : FNcentralclick}}";
        $pmenu = '';    
        $data = '';
        $reg_cab = 1;          
        $i = 0;

        while ($row = mysqli_fetch_array($resultado)) {        
            $valor_menu = $row['COD_SUB_MENU'] * 1;    
            $cadena = $row['DESCRIPCION'];
            $buscar = '*';
            $reemplazar = '';
            $img = '"img/ala.gif"';
            $titulo = str_replace($buscar, $reemplazar, $cadena);

            if (strcmp($pmenu, $row['COD_MENU']) == 0) {                
                if (strlen($cmenu) == 0) {
                    $cmenu = "{ xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1><b style = color:GRAY ; >" . $row['MENU'] . "</b></FONT>', iconCls:'MAN1', id: 'MENU" . $row['COD_MENU'] . "', margins: '2 2 0 2', autoScroll: true, rootVisible: false, collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: [";
                }

                $rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style = color:GRAY ; >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenugris'},";
            } else {
                if (strcmp($pmenu, '') != 0) {
                    if (strlen($rmenu) > 0)
                        $rmenu = substr($rmenu, 0, strlen($rmenu) - 1);     
                    $data .= $cmenu . $rmenu . $fmenu . ',';    
                    $rmenu = ''; $reg_cab = 1;
                }    

                if ($reg_cab == 1) {    
                    $cmenu = "{ xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1><b style = color:GRAY ; >" . $row['MENU'] . "</b></FONT>', iconCls:'MAN1', id: 'MENU" . $row['COD_MENU'] . "', margins: '2 2 0 2', autoScroll: true, rootVisible: false, collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: [";
                    $reg_cab = 0; 
                }

                $rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style = color:GRAY ; >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenugris'},";
            }                   

            $pmenu = $row['COD_MENU'];

            if (($i + 1) == $nreg) {
                if (strlen($rmenu) > 0)
                    $rmenu = substr($rmenu, 0, strlen($rmenu) - 1);     
                $data .= $cmenu . $rmenu . $fmenu;
            }

            $i = $i + 1;                
        }    

        echo $data; 
    } else {
        echo '';
    }
}

?>
