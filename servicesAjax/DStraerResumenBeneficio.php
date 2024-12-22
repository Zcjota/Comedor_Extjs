	<?php     
/*!
 * DSoft-CACC
 * Copyright(c) 2018
 */
	include("../lib/conex.php");
	$start = isset($_POST['start'])?$_POST['start']:0;	
	$limit = isset($_POST['limit'])?$_POST['limit']:25;
	$conex = ConectarConBD();
	mysqli_set_charset($conex, "utf8");
	if (!VerificaConBD())	{	
		echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
		exit;	
	}
	
		$fechaf = $_REQUEST["fechaf"];
		$fechai = $_REQUEST["fechai"];
		
		// mysqli_query("SET NAMES 'utf8'");
	
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
	function horario($conex,$HM)
	{
		$i=1;
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
			
				$horario_Marcacion = strtotime($HM);
				$horario_inicio = strtotime($row['HORARIO'].":00");
				$horario_fin = strtotime($row['HORARIO_SALIDA'].":00");
				if($horario_Marcacion>=$horario_inicio and $horario_Marcacion<=$horario_fin)
				{
				  return $i;
				}
				else
				{
					
				}
			$i++;
		}
		
	}
	
	$sqlm=' SELECT m.COD_MARCACION,m.CODIGO,m.GESTION,m.MES,m.DIA,m.HORA,m.MINUTO,m.SEGUNDO'.
		 ' FROM `marcacion_comedor` m '.
		 ' WHERE m.ACTIVO =1 '.$sqlaux .
		 ' ORDER BY m.CODIGO ASC  ';
	$resultadom=mysqli_query($conex,$sqlm);  //TRAEMOS RESULTADOS
	$num_reg = mysqli_num_rows($resultadom);
	$w=0;
	$totalid=0;
	 $data = array();
	 $v1=0;$v2=0;$v3=0;$v4=0;$v5=0;$v6=0;$v7=0;$v8=0;$v9=0;$v10=0;$v11=0;$v12=0;$v13=0;$v14=0;$v15=0;
	while ($row = mysqli_fetch_assoc($resultadom)) 
	{	
		$sqlex3 = 'SELECT ct.COD_PERSONAL,p.NRO_TRABAJADOR from  codigotrabajador_personal ct inner join personal p on ct.COD_PERSONAL=p.COD_PERSONAL'.
		'   where ct.ACTIVO=1 and  ct.CODIGO_TRABAJADOR='.$row['CODIGO'];
		$resul3=mysqli_query($conex,$sqlex3);  //TRAEMOS RESULTADOS
	  if ($row3 = mysqli_fetch_assoc($resul3)) 
	  {
	    $codigo=$row3['NRO_TRABAJADOR'];
	  }
	  else
	  {
		$codigo=$row['CODIGO'];
	  }
	 $totalid=$totalid+1;
		if($w==0)
		{
			$minut="";
			if((int)$row['MINUTO']<10)
				{
					$minut="0".(string)$row['MINUTO'];
				}
				else
				{
					$minut=(string)$row['MINUTO'];
				}
			$HoraMarcacion1=(string)$row['HORA'].':'.(string)$minut.':00';
			$r=horario($conex,$HoraMarcacion1);
			   if($r==1){$v1++;}
				if($r==2){$v2++;}
				if($r==3){$v3++;}
				if($r==4){$v4++;}
				if($r==5){$v5++;}
				if($r==6){$v6++;}
				if($r==7){$v7++;}
				if($r==8){$v8++;}
				if($r==9){$v9++;}
				if($r==10){$v10++;}
				if($r==11){$v11++;}
				if($r==12){$v12++;}
				if($r==13){$v13++;}
				if($r==14){$v14++;}
				if($r==15){$v15++;}
			  $codigo1=$codigo;
			  $nombre="";
			  $cargo="";
			  $unidad="";
			  $subcentro="";
			  $centro="";
			$sql1=' SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,cc.COD_CENTRO,cc.DESCRIPCION as ccDESCRIPCION,u.COD_UNIDAD,u.DESCRIPCION as uDESCRIPCION,s.COD_SUBCENTRO'.
			 '  ,s.DESCRIPCION as sDESCRIPCION,c.DESCRIPCION as cDESCRIPCION FROM `personal` p ' .
			'	left join centro_de_costo cc on cc.COD_CENTRO=p.COD_CENTRO ' .
			'	left join unidad u on u.COD_UNIDAD=cc.COD_UNIDAD ' .
			'	left join subcentro s on s.COD_SUBCENTRO=cc.COD_SUBCENTRO ' .
			'	left join cargo c on c.COD_CARGO=p.COD_CARGO ' .
			'  where p.NRO_TRABAJADOR='.$codigo1;
			$resultado1=mysqli_query($conex,$sql1);
			if ($row1 = mysqli_fetch_assoc($resultado1)) 
			{
			  $nombre=$row1['AP_PATERNO'].' '.$row1['AP_MATERNO'].' '.$row1['NOMBRE'].' '.$row1['NOMBRE2'];
			  $cargo=$row1['cDESCRIPCION'];
			  $unidad=$row1['uDESCRIPCION'];
			  $subcentro=$row1['sDESCRIPCION'];
			  $centro=$row1['ccDESCRIPCION'];
			}
			else
			{
				
				$sql2=' SELECT t.NOMBRE,cc.DESCRIPCION as ccDESCRIPCION,u.COD_UNIDAD,u.DESCRIPCION as uDESCRIPCION,s.COD_SUBCENTRO'.
				 '  ,s.DESCRIPCION as sDESCRIPCION FROM `tarjetas_comedor` t  ' .
				'	left join centro_de_costo cc on cc.COD_CENTRO=t.COD_CENTRO ' .
				'	left join unidad u on u.COD_UNIDAD=cc.COD_UNIDAD ' .
				'	left join subcentro s on s.COD_SUBCENTRO=cc.COD_SUBCENTRO ' .
				'   where t.CODIGO='.$codigo1;
				$resultado2=mysqli_query($conex,$sql2);
				if ($row2 = mysqli_fetch_assoc($resultado2)) 
				{
				  $nombre=$row2['NOMBRE'];
				  $cargo="TARJETA";
				  $unidad=$row2['uDESCRIPCION'];
				  $subcentro=$row2['sDESCRIPCION'];
				  $centro=$row2['ccDESCRIPCION'];
				}
			}
			$w=1;
			if($num_reg==$totalid)
			{
					array_push($data, array(
					"codigo" => $codigo1,
					"nombre" => $nombre,
					"cargo" => $cargo,
					"unidad" => $unidad,
					"subcentro" => $subcentro,
					"centro" => $centro,
					"c1"		=>$v1, 
					"c2"		=>$v2, 
					"c3"		=>$v3, 
					"c4"		=>$v4, 
					"c5"		=>$v5, 
					"c6"		=>$v6, 
					"c7"		=>$v7, 
					"c8"		=>$v8, 
					"c9"		=>$v8, 
					"c10"		=>$v10, 
					"c11"		=>$v11, 
					"c12"		=>$v12, 
					"c13"		=>$v13, 
					"c14"		=>$v14, 
					"c15"		=>$v15
				));
				$v1=0;$v2=0;$v3=0;$v4=0;$v5=0;$v6=0;$v7=0;$v8=0;$v9=0;$v10=0;$v11=0;$v12=0;$v13=0;$v14=0;$v15=0;
			}
		}
		else
		{
			if((int)$codigo1==(int)$codigo)
			{
				$minut="";
				if((int)$row['MINUTO']<10)
					{
						$minut="0".(string)$row['MINUTO'];
					}
					else
					{
						$minut=(string)$row['MINUTO'];
					}
				$HoraMarcacion1=(string)$row['HORA'].':'.(string)$minut.':00';
				$r=horario($conex,$HoraMarcacion1);
				   if($r==1){$v1++;}
					if($r==2){$v2++;}
					if($r==3){$v3++;}
					if($r==4){$v4++;}
					if($r==5){$v5++;}
					if($r==6){$v6++;}
					if($r==7){$v7++;}
					if($r==8){$v8++;}
					if($r==9){$v9++;}
					if($r==10){$v10++;}
					if($r==11){$v11++;}
					if($r==12){$v12++;}
					if($r==13){$v13++;}
					if($r==14){$v14++;}
					if($r==15){$v15++;}
				if($num_reg==$totalid)
					{
						array_push($data, array(
								"codigo" => $codigo1,
								"nombre" => $nombre,
								"cargo" => $cargo,
								"unidad" => $unidad,
								"subcentro" => $subcentro,
								"centro" => $centro,
								"c1"		=>$v1, 
								"c2"		=>$v2, 
								"c3"		=>$v3, 
								"c4"		=>$v4, 
								"c5"		=>$v5, 
								"c6"		=>$v6, 
								"c7"		=>$v7, 
								"c8"		=>$v8, 
								"c9"		=>$v8, 
								"c10"		=>$v10, 
								"c11"		=>$v11, 
								"c12"		=>$v12, 
								"c13"		=>$v13, 
								"c14"		=>$v14, 
								"c15"		=>$v15
						));
						$v1=0;$v2=0;$v3=0;$v4=0;$v5=0;$v6=0;$v7=0;$v8=0;$v9=0;$v10=0;$v11=0;$v12=0;$v13=0;$v14=0;$v15=0;
					}
			}
			else
			{
				
					array_push($data, array(
								"codigo" => $codigo1,
								"nombre" => $nombre,
								"cargo" => $cargo,
								"unidad" => $unidad,
								"subcentro" => $subcentro,
								"centro" => $centro,
								"c1"		=>$v1, 
								"c2"		=>$v2, 
								"c3"		=>$v3, 
								"c4"		=>$v4, 
								"c5"		=>$v5, 
								"c6"		=>$v6, 
								"c7"		=>$v7, 
								"c8"		=>$v8, 
								"c9"		=>$v8, 
								"c10"		=>$v10, 
								"c11"		=>$v11, 
								"c12"		=>$v12, 
								"c13"		=>$v13, 
								"c14"		=>$v14, 
								"c15"		=>$v15
					));
					$v1=0;$v2=0;$v3=0;$v4=0;$v5=0;$v6=0;$v7=0;$v8=0;$v9=0;$v10=0;$v11=0;$v12=0;$v13=0;$v14=0;$v15=0;
					$minut="";
					if((int)$row['MINUTO']<10)
						{
							$minut="0".(string)$row['MINUTO'];
						}
						else
						{
							$minut=(string)$row['MINUTO'];
						}
					$HoraMarcacion=(string)$row['HORA'].':'.(string)$minut.':00';
					$r=horario($conex,$HoraMarcacion);
					   if($r==1){$v1++;}
						if($r==2){$v2++;}
						if($r==3){$v3++;}
						if($r==4){$v4++;}
						if($r==5){$v5++;}
						if($r==6){$v6++;}
						if($r==7){$v7++;}
						if($r==8){$v8++;}
						if($r==9){$v9++;}
						if($r==10){$v10++;}
						if($r==11){$v11++;}
						if($r==12){$v12++;}
						if($r==13){$v13++;}
						if($r==14){$v14++;}
						if($r==15){$v15++;}
					$codigo1=$codigo;
					$nombre="";
					 $cargo="";
					 $unidad="";
					 $subcentro="";
					 $centro="";
					$sql1=' SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,cc.COD_CENTRO,cc.DESCRIPCION as ccDESCRIPCION,u.COD_UNIDAD,u.DESCRIPCION as uDESCRIPCION,s.COD_SUBCENTRO'.
					 '  ,s.DESCRIPCION as sDESCRIPCION,c.DESCRIPCION as cDESCRIPCION FROM `personal` p ' .
					'	left join centro_de_costo cc on cc.COD_CENTRO=p.COD_CENTRO ' .
					'	left join unidad u on u.COD_UNIDAD=cc.COD_UNIDAD ' .
					'	left join subcentro s on s.COD_SUBCENTRO=cc.COD_SUBCENTRO ' .
					'	left join cargo c on c.COD_CARGO=p.COD_CARGO ' .
					'  where p.NRO_TRABAJADOR='.$codigo1;
					$resultado1=mysqli_query($conex,$sql1);
					if ($row1 = mysqli_fetch_assoc($resultado1)) 
					{
					  $nombre=$row1['AP_PATERNO'].' '.$row1['AP_MATERNO'].' '.$row1['NOMBRE'].' '.$row1['NOMBRE2'];
					  $cargo=$row1['cDESCRIPCION'];
					  $unidad=$row1['uDESCRIPCION'];
					  $subcentro=$row1['sDESCRIPCION'];
					  $centro=$row1['ccDESCRIPCION'];
					}
					else
					{
						
						$sql2=' SELECT t.NOMBRE,cc.DESCRIPCION as ccDESCRIPCION,u.COD_UNIDAD,u.DESCRIPCION as uDESCRIPCION,s.COD_SUBCENTRO'.
						 '  ,s.DESCRIPCION as sDESCRIPCION FROM `tarjetas_comedor` t  ' .
						'	left join centro_de_costo cc on cc.COD_CENTRO=t.COD_CENTRO ' .
						'	left join unidad u on u.COD_UNIDAD=cc.COD_UNIDAD ' .
						'	left join subcentro s on s.COD_SUBCENTRO=cc.COD_SUBCENTRO ' .
						'   where t.CODIGO='.$codigo1;
						$resultado2=mysqli_query($conex,$sql2);
						if ($row2 = mysqli_fetch_assoc($resultado2)) 
						{
						  $nombre=$row2['NOMBRE'];
						  $cargo="TARJETA";
						  $unidad=$row2['uDESCRIPCION'];
						  $subcentro=$row2['sDESCRIPCION'];
						  $centro=$row2['ccDESCRIPCION'];
						}
					}
					if($num_reg==$totalid)
					{
							array_push($data, array(
							"codigo" => $codigo1,
								"nombre" => $nombre,
								"cargo" => $cargo,
								"unidad" => $unidad,
								"subcentro" => $subcentro,
								"centro" => $centro,
								"c1"		=>$v1, 
								"c2"		=>$v2, 
								"c3"		=>$v3, 
								"c4"		=>$v4, 
								"c5"		=>$v5, 
								"c6"		=>$v6, 
								"c7"		=>$v7, 
								"c8"		=>$v8, 
								"c9"		=>$v8, 
								"c10"		=>$v10, 
								"c11"		=>$v11, 
								"c12"		=>$v12, 
								"c13"		=>$v13, 
								"c14"		=>$v14, 
								"c15"		=>$v15
						));
						$v1=0;$v2=0;$v3=0;$v4=0;$v5=0;$v6=0;$v7=0;$v8=0;$v9=0;$v10=0;$v11=0;$v12=0;$v13=0;$v14=0;$v15=0;
					}
			}
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
   
?> 