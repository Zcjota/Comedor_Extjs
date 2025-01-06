<?php
	include("../lib/conex.php");       			  
	$conex = ConectarConBD(); // Inicializa la conexión correctamente
	if (!$conex) {
		die("Error al conectar con la base de datos");
	}
			
	$start = isset($_POST['start'])?$_POST['start']:0;	
	$limit = isset($_POST['limit'])?$_POST['limit']:25;
	$fechai = $_REQUEST["fechai"];//fecha busqueda
	$horario = $_REQUEST["horario"];
	$fechai=substr($fechai,0,10);
	
	// if (!VerificaConBD())	
	// {
	// echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
	// exit;
	// }
	//separo los valores de la fecha
	$valores = explode ("-", $fechai); 
	$gestion = $valores[0] ;
	$mes = $valores[1] ;
	$dia = $valores[2] ;
	
	$sqlaux = '';

	if ($fechai <> '' )
	{
		$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechai' ";
	}
	 else
	{	
		$sqlaux = '';
	}
	 $st = mysqli_query($conex, 'SELECT m.CODIGO,m.GESTION,m.MES,m.DIA FROM `marcacion_comedor` m  '.
		               '   WHERE m.ACTIVO = 1 '.$sqlaux. '  order by m.COD_MARCACION,m.CODIGO,m.GESTION,m.MES,DIA ASC ');
				
		$tot=0;
		$w=0;
		$x;
		$x1;
		$x2;
		$x3;
		$y=1;
		$t;
		while ($row = mysqli_fetch_array($st)) 
		{	
		
			if($w==0)
			{
				$x=$row['DIA'];
				$x1=$row['MES'];
				$x2=$row['GESTION'];
				$x3=$row['CODIGO'];
				$w=1;
			}
			else
			{
				if($x==$row['DIA'] && $x1==$row['MES'] && $x2==$row['GESTION'] && $x3==$row['CODIGO'])
				{
					$y++;
					
				}
				else
				{
					$t[$tot]=$y;
					$tot++;
					$x=$row['DIA'];
					$x1=$row['MES'];
					$x2=$row['GESTION'];
					$x3=$row['CODIGO'];
					$y=1;
				}
			}
		
			
			
		}
		$t[$tot]=$y;
	function restaHoras($horaIni, $horaFin){
			return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
	}	
	function MixMAx($h1,$h2)//funcion de probalidad respecto al horario
	{	
		
		
		$min="";
		$hora1=strtotime($h1);
		$hora2=strtotime($h2);
		if($hora1<$hora2)
		{
			$min=restaHoras($h1,$h2);
		}
		else
		{
			if($hora1>$hora2)
			{
				$min=restaHoras($h2,$h1);
			}
			else
			{
				$min="00:00:00";
			}
		}
		
		return $min;
		
	}

	$v;
	// function horario($HM)
	// {
		// $i=1;
		// $b=1;
		// $sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 // $rHorario=mysqli_query($sqlHorario,$conex); 
		 // while ($row= mysqli_fetch_array($rHorario)) 
		// {	
			
			// $v[$i]=MixMAx($HM,$row['HORARIO'].":00");
			
			// $i++;
		// }
		// $a=$v[1];
		// $b=1;
		
		// for($j=2;$j<$i;$j++)
		// {
		
			// $hora1=strtotime($a);
			// $hora2=strtotime($v[$j]);
			// if($hora1<=$hora2)
			// {
				
			// }
			// else
			// {
				// $a=$v[$j];
				// $b=$j;
			// }
		// }
					
		// echo "/*$b*/";
		// return $b;
		
	// }	
	function horario($conex,$HM)
	{
		echo "/*$HM*/";
		$i=1;
		
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_array($rHorario)) 
		{	
			
				$horario_Marcacion = strtotime($HM);
				echo "/*hora->$horario_Marcacion*/";
				$horario_inicio = strtotime($row['HORARIO'].":00");
				echo "/*$horario_inicio*/";
				$horario_fin = strtotime($row['HORARIO_SALIDA'].":00");
				echo "/*$horario_fin*/";
				if($horario_Marcacion>=$horario_inicio and $horario_Marcacion<=$horario_fin)
				{
				   echo "/*$i*/";
				  return $i;
				}
				else
				{
					echo "/*fff*/";
				}
				
			
			
			$i++;
		}
		
	}
	function Nombrehorario($conex,$HM)
	{
		
		
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_array($rHorario)) 
		{	
				$horario_Marcacion = strtotime($HM);
				echo "/*hora->$horario_Marcacion*/";
				$horario_inicio = strtotime($row['HORARIO'].":00");
				echo "/*$horario_inicio*/";
				$horario_fin = strtotime($row['HORARIO_SALIDA'].":00");
				echo "/*$horario_fin*/";
				if($horario_Marcacion>=$horario_inicio and $horario_Marcacion<=$horario_fin)
				{
				  
				  return $row['CODIGO'];
				}
				else
				{
					
				}
			
		}
		
	}	
	function existeTarjeta($conex,$codigo)
	 {
		$sqlex1 = 'SELECT count(CODIGO) as TOTALE from  tarjetas_comedor where ACTIVO=1 AND CODIGO='.$codigo;
		echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function NombreTarjeta($conex,$codigo)
	 {
		$sqlex1 = 'SELECT NOMBRE as TOTALE from  tarjetas_comedor where ACTIVO=1 AND CODIGO='.$codigo;
		echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	
	$sql=' SELECT m.*'.
		 ' FROM `marcacion_comedor` m '.
		 ' WHERE m.ACTIVO =1 '.$sqlaux .
		 ' ORDER BY  m.COD_MARCACION,m.CODIGO,m.GESTION,m.MES,m.DIA ASC  ';
	// mysqli_query("SET NAMES 'utf8'");	
	$resultado=mysqli_query($conex,$sql);  //TRAEMOS RESULTADOS
	
	 $data = array();
	 $v1="";$v2="";$v3="";$v4="";$v5="";$v6="";$v7="";$v8="";$v9="";$v10="";$v11="";$v12="";$v13="";$v14="";$v15="";
	while ($row = mysqli_fetch_array($resultado)) 
	{	
		$sqlex3 = 'SELECT ct.COD_PERSONAL,p.NRO_TRABAJADOR from  codigotrabajador_personal ct inner join personal p on ct.COD_PERSONAL=p.COD_PERSONAL'.
		'   where ct.ACTIVO=1 and  ct.CODIGO_TRABAJADOR='.$row['CODIGO'];
		$resul3=mysqli_query($conex,$sqlex3);  //TRAEMOS RESULTADOS
		  if ($row3 = mysqli_fetch_array($resul3)) 
		  {
			$codigo=$row3['NRO_TRABAJADOR'];
		  }
		  else
		  {
			$codigo=$row['CODIGO'];
		  }
		$minut="";
		if((int)$row['MINUTO']<10)
			{
				$minut="0".(string)$row['MINUTO'];
			}
			else
			{
				$minut=(string)$row['MINUTO'];
			}
		$hora="";
		if((int)$row['HORA']<10)
			{
				$hora="0".(string)$row['HORA'];
			}
			else
			{
				$hora=(string)$row['HORA'];
			}
		$seg="";
		if((int)$row['SEGUNDO']<10)
			{
				$seg="0".(string)$row['SEGUNDO'];
			}
			else
			{
				$seg=(string)$row['SEGUNDO'];
			}
		$HoraMarcacion=(string)$hora.':'.(string)$minut.':00';
					
		$r=horario($conex,$HoraMarcacion);
		$HoraMarcacion=(string)$hora.':'.(string)$minut.':'.(string)$seg;
		$codigoT=$codigo;
		
		if($r==1){$v1=$HoraMarcacion."  ";}
		if($r==2){$v2=$HoraMarcacion."  ";}
		if($r==3){$v3=$HoraMarcacion."  ";}
		if($r==4){$v4=$HoraMarcacion."  ";}
		if($r==5){$v5=$HoraMarcacion."  ";}
		if($r==6){$v6=$HoraMarcacion."  ";}
		if($r==7){$v7=$HoraMarcacion."  ";}
		if($r==8){$v8=$HoraMarcacion."  ";}
		if($r==9){$v9=$HoraMarcacion."  ";}
		if($r==10){$v10=$HoraMarcacion."  ";}
		if($r==11){$v11=$HoraMarcacion."  ";}
		if($r==12){$v12=$HoraMarcacion."  ";}
		if($r==13){$v13=$HoraMarcacion."  ";}
		if($r==14){$v14=$HoraMarcacion."  ";}
		if($r==15){$v15=$HoraMarcacion."  ";}
		
			$nombre_completo="";
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
			'  where p.NRO_TRABAJADOR='.$codigo;
			$resultado1=mysqli_query($conex,$sql1);
			if ($row1 = mysqli_fetch_array($resultado1)) 
			{
			  $nombre_completo=$row1['AP_PATERNO'].' '.$row1['AP_MATERNO'].' '.$row1['NOMBRE'].' '.$row1['NOMBRE2'];
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
				'   where t.CODIGO='.$codigo;
				$resultado2=mysqli_query($conex,$sql2);
				if ($row2 = mysqli_fetch_array($resultado2)) 
				{
				  $nombre_completo=$row2['NOMBRE'];
				  $cargo="TARJETA";
				  $unidad=$row2['uDESCRIPCION'];
				  $subcentro=$row2['sDESCRIPCION'];
				  $centro=$row2['ccDESCRIPCION'];
				}
			}
				array_push($data, 
						array( 	"codigo"		=>$codigo, 
							"nombre" 	=>   $nombre_completo,
							"cargo"		=>$cargo, 
							"nombreunidad"		=>$unidad, 
							"nombresubcentro"		=>$subcentro, 
							"nombrecosto"		=>$centro, 
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
							"c15"		=>$v15, 
							
							
						));
			 $v1="";$v2="";$v3="";$v4="";$v5="";$v6="";$v7="";$v8="";$v9="";$v10="";$v11="";$v12="";$v13="";$v14="";$v15="";
		
	}
	
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o);

    
?>