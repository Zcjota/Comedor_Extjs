<?php     
	// include("lib/conex.php"); 
	// DevuelveListaMenuItem1();
	function agrupar($x)
	{
		$itemstabs1= " {xtype: 'buttongroup',".
					   "  columns: 2,".
					   " defaults: {".
					  // " iconAlign:'top',".
					   " scale: 'medium'},".
					    "  x:".($x).",".
					  // " rowspan: 3,".
					   " items:[";
		return $itemstabs1;
	}
	function asignacionAprobar($cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador!=2)
			{
				$sqlAsignacion=' select count(COD_USUARIO) as TOT from  flujo_aprobador  where COD_USUARIO ='.$idusuario.' and COD_PERSONAL='.$personalE.' and  ACTIVO=1 ';
				//echo "/*-----consulta-------------$sqlAsignacion*/";
				$resultadoAsig=mysql_query($sqlAsignacion,$_SESSION['BD']);
				$totAsig = mysql_fetch_array($resultadoAsig);
				$tAsig=$totAsig['TOT'];
				if($tAsig!=0)
				{
					$cant=1;
				}
			}
			
			return $cant;
	}
    function DevuelvesubMenuItem($menu) { 
	if (VerificaConBD()) {			
		$sq1 = ' SELECT  M.DESCRIPCION AS MENU, M.ICON AS IMENU,S.DESCRIPCION,S.RUTA,S.COD_SUB_MENU,S.ICON AS SICON'.
			' FROM `detalle_perfil` DP inner join `submenu` S on DP.COD_SUB_MENU = S.COD_SUB_MENU'.
			' inner join `menu` M on S.COD_MENU = M.COD_MENU'.			
			' where DP.ACTIVO = 1 and DP.COD_TIPOU = '.$_SESSION['tipoUser'].
			' and  M.COD_MENU = '.$menu.		
			' ORDER BY M.ORDEN, S.ORDENS ';
		
		//echo $sq1;
		//rowspan: 3,
		$itemstabs=" tbar:  new Ext.Toolbar({".
					" autoScroll: true,".
					   " defaults: {".
					    " scale: 'large'},".
					   " items:[";
		mysql_query("SET NAMES 'utf8'");
		$cmenu1="";
		$resultad1 = mysql_query($sq1, $_SESSION['BD']);	
			while ($row1 = mysql_fetch_array($resultad1)) {	
								$cadena = $row1['DESCRIPCION'] ;
								if($row1['COD_SUB_MENU']==15)
								{
									$cadena="Retrasos / Faltas* (Sin Revision)";
								}
								if($row1['COD_SUB_MENU']==45)
								{
									$cadena="Horas Extras* (Aprobacion)";
								}
								if($row1['COD_SUB_MENU']==24)
								{
									$cadena="Bandeja (Borradores)";
								}
								if($row1['COD_SUB_MENU']==25)
								{
									$cadena="Bandeja (Revisores)";
								}
								if($row1['COD_SUB_MENU']==29)
								{
									$cadena="Bandeja (Rechazado)";
								}
								if($row1['COD_SUB_MENU']==26)
								{
									$cadena="Pendientes de Aprobacion";
								}
								$buscar = '*';
								$reemplazar = '</br>';
								$titulo= str_replace($buscar, $reemplazar, $cadena);
								$cadena=str_replace('*', '', $cadena);
								$l='<a style ="color:#15428B ; font: bold 8.5px tahoma,arial,verdana,sans-serif;">';
								  $cmenu1 = $cmenu1."{ text: '".$l. $titulo. "</a>',".
														 "  iconCls:'".$row1['SICON']."',".
														 "  id:'c".$row1['COD_SUB_MENU']."',".
														 "  name:'c".$row1['COD_SUB_MENU']."',".
													     " handler:  handleActionDinamico.createCallback('".$row1['COD_SUB_MENU']."','".$cadena."','".$row1['RUTA']."'),".
													   " },'-',";
													  
								
		}	
		
		
		 $rmenu = $cmenu1;  
		 $data=$itemstabs.$rmenu."]})";
		//echo $data."////////////////////////////////////////////////";
		return $data; 
	} else echo '';
	
}	
/////////////////////////////////////////////////////
function DevuelveListaMenuItem1() { 
	if (VerificaConBD()) {			
		$sq = ' SELECT DISTINCT M.COD_MENU, M.DESCRIPCION AS MENU, M.ICON AS IMENU'.
			' FROM `detalle_perfil` DP inner join `submenu` S on DP.COD_SUB_MENU = S.COD_SUB_MENU'.
			' inner join `menu` M on S.COD_MENU = M.COD_MENU'.			
			' where DP.ACTIVO = 1 and DP.COD_TIPOU ='.$_SESSION['tipoUser'].
			' ORDER BY M.ORDEN, S.ORDENS ';
		///////////////////////////////////////// bandeja borradores sin leer
				$sqlb1 = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL from formulario f  inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL  where  f.LEIDO=0 and f.ESTADO=1 AND f.ACTIVO=1 and f.COD_USUARIO=".$_SESSION['IdUsuario'];
				
				$resulb1=mysql_query($sqlb1,$_SESSION['BD']);
				$totalb1 = mysql_fetch_array($resulb1);
				$ttipob1=$totalb1['TOTAL'];
			//////////////////////////////////////////
		$sqlrevisor = ' SELECT count(FLUJO_VISUALIZADOR)as total'.
			' FROM `usuario`  '.
			
			' where FLUJO_VISUALIZADOR = 1 and ACTIVO=1 and COD_USUARIO= '.$_SESSION['IdUsuario'];
			$resultrev=mysql_query($sqlrevisor,$_SESSION['BD']);
				$totrevi = mysql_fetch_array($resultrev);
				$trevi=$totrevi['total'];
		$sql1 = ' SELECT count(COD_FORMULARIO)as total'.
			' FROM `formulario` f '.
			
			' where f.ESTADO = 2 and f.ACTIVO=1 ';
			$resultform=mysql_query($sql1,$_SESSION['BD']);
				$totrform = mysql_fetch_array($resultform);
				$ttipo=$totrform['total'];
		$sqla = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f  inner join asignar_flujo a on f.COD_FORMULARIO=a.COD_FORMULARIO inner join detalle_flujo df on a.COD_ASIGNAR =df.COD_FLUJO  where  df.ESTADO=1 AND f.ACTIVO=1 AND df.COD_USUARIO= ".$_SESSION['IdUsuario'];
				
				$resulaprob=mysql_query($sqla,$_SESSION['BD']);
				$totalSA = mysql_fetch_array($resulaprob);
				$ttipo1=$totalSA['TOTAL'];
				
			$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		date_default_timezone_set('America/La_Paz');
		$fecha=date("Y-m-d");
		$fechaf = $fecha;
		$fechai = "2015-07-01";
		$valores = explode ("-", $fechai); 
		$gestion = $valores[0] ;
		$mes = $valores[1] ;
		$dia = $valores[2] ;
		
		$sqlaux = '';
	    if ($fechai <> '' and $fechaf <>'')
		{
			$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechaf' ";
		}
		 else
		{	
			$sqlaux = '';
		}	
		$sqlhoras = 'SELECT p.*,c.COD_CARGO,c.DESCRIPCION,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion from personal p  inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO'.
	       ' INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE p.ACTIVO=1  order by p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2';
		    //' LIMIT '.$start.','.$limit;
	
	$resultadohoras=mysql_query($sqlhoras,$_SESSION['BD']);  
	$cont=0;
	while ($row = mysql_fetch_array($resultadohoras)){
		
		 $tipoAsignacion1=asignacionAprobar($rcargador,$ridcargador,$row['COD_PERSONAL']);
		if($tipoAsignacion1==1)
		{
		
					$codigo=$row['NRO_TRABAJADOR'];
						
						$sql1 = 'SELECT m.*,h.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
							' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` m '.
							' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
							' inner join horario h on h.COD_HORARIO=m.COD_HORARIO '.
							' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  p.NRO_TRABAJADOR=' .'"'.$codigo.'"'.$sqlaux.
							' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA ASC  ';
							
						//echo "/*esto nada -->$sql1*/";
						 $resultado1=mysql_query($sql1,$_SESSION['BD']); 
						 while ($row1 = mysql_fetch_array($resultado1)){
						 	
							if(strtotime(date($row1['FECHA_INGRESO']))<= strtotime( date($row1['GESTION']."-".$row1['MES']."-".$row1['DIA'])))
							{	
									
									if((($row1['HEN']!="" and $row1['HEN']!="0") or $row1['HEF']!="" or $row1['HED']!="" or ($row1['RECARGO_NOCTURNO']!="" and $row1['RECARGO_NOCTURNO']!="0")) and $row1['APROBADOR']=="")
									{
										if($row1['VALIDADORHE']!="")
										{
										
												$cont++;
										
								    }
								}
								
							}
						 }
						
							
							
					
		}
	}  
				
		$encabezado="{ xtype:'tabpanel',".
					"  activeTab:0,".	
					"  enableTabScroll:true,".
					
					"  height:85,".
					"  y:0,".
					"  width:screen.width,".
					//"  autoScroll:true,".
				   // "  defaults:{autoScroll:true},".
					"  items:[";
	
		mysql_query("SET NAMES 'utf8'");
		$cmenu="";
		
		$resultad = mysql_query($sq, $_SESSION['BD']);	
			while ($row = mysql_fetch_array($resultad)) {		
						$hijo=DevuelvesubMenuItem($row['COD_MENU']);
						// $l='<a style =" font: bold 9px tahoma,arial,verdana,sans-serif;">';   <img src=".$img."/>
								if(($row['COD_MENU']==9 and $trevi>0 and $ttipo>0) or ($row['COD_MENU']==10 and $ttipo1>0) or ($row['COD_MENU']==6 and $cont>0) or ($row['COD_MENU']==9 and $ttipob1>0) )
								{
									 $cmenu = $cmenu. "{	title: '<B><font size=1>". $row['MENU']. "</font></B><b style =color:red;  ><font size=1> (*)</font></b>',".
								           "    layout: 'absolute',".
										   "    frame: true,".
										   "  id:'Me".$row['COD_MENU']."',".
										 
										   "  iconCls:'MAN',".$hijo.
										   
										   " },";
								}
								else
								{
									 $cmenu = $cmenu. "{	title: '<B style =color:#15428B ><font size=1>". $row['MENU']. "</font></B>',".
								           "    layout: 'absolute',".
										   "    frame: true,".
										    "  id:'Me".$row['COD_MENU']."',".
										 
										   "  iconCls:'MAN',".$hijo.
										   
										   " },";
								}
								 
								
		}	
		 $rmenu = substr($cmenu,0,strlen($cmenu) -1); 
		$l='<a style ="color:##15428B; font: bold 7.5px tahoma,arial,verdana,sans-serif;">';
		 $l1='<a style ="color:##15428B; font: bold 8.5px tahoma,arial,verdana,sans-serif;">';
		 $data=$encabezado.$rmenu.
		 
								// "{".
											// " title:'</br>',".
											// " layout:'absolute',".
											// "	id: 't2',	".
											// " frame:true,".
											// " iconCls:'cerrar16',".
											// " tbar:  new Ext.Toolbar({ ".
											// " defaults: {".
											// " scale: 'large'},".
											// "  items:[".
												// " '->',{ text: '".$l1. "Salir del Sistema</a>',".
												// "  iconCls:'cerrar',".	
												// " handler:  function(){  window.location = 'DScerrarsesion.php';}".
												// " } ]}) },".
										// "{".
											// " title:'dd</br>',".
											// " layout:'absolute',".
											// "	id: 't3',	".
											// " frame:true,".
											// " iconCls:'reseteo16',".
											// " tbar:  new Ext.Toolbar({ ".
											// " defaults: {".
											// " scale: 'large'},".
											// "  items:[".
												// " '->',{ text: '".$l1. "Cambiar Password</a>',".
												// "  iconCls:'cambiar',".	
												// " handler:  function(){  window.location = 'DSlists/DSConfirmarInicioSessionReseteado.php';}".
												// " } ]}) }".
		 " ] ".
		" ,  listeners: { ".
					" 'tabchange': function(tabPanel, tab){".
							
								// " yy=tab.id;  alert(yy);".
								// " var ch1 = Ext.getCmp('c1'); ".
								// " ch1.setText('fffd'); ".
								" Actualizar();".
							
						
				"	}".
			"	}".
		 
		" }";
		 
		 
		 
	//	echo $data."////////////////////////////////////////////////";
		return $data; 
	} else echo '';
	
}	

?> 