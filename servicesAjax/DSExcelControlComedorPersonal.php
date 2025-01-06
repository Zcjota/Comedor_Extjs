<?php     
/*!
 * DSoft-RJ
 * Copyright(c) 2013
 */
	include('../lib/conex.php');

		
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ReportedeControlDeAsistencia.XLS\";"); 
    $start = isset($_POST['start'])?$_POST['start']:0;	
	$limit = isset($_POST['limit'])?$_POST['limit']:30;
	$buscar = isset($_POST['buscar'])?$_POST['buscar']:'';

	$fechai =  $_REQUEST['fecha'];
	$fechafin =  $_REQUEST['fechaf'];
	$codTrabajador =  $_REQUEST['codPersona'];
	
	// if (!VerificaConBD())	
	// {
	// 	echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
	// 	exit;
	// }
	$conex = ConectarConBD(); // Inicializa la conexión correctamente
	if (!$conex) {
		die("Error al conectar con la base de datos");
	}
	$sqlaux = '';
	
		if ($fechai <> '' and $fechafin <>'' )
		{
			$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechafin'  ";
		}
		 else
		{	
			$sqlaux = '';
		}
	 $st = mysqli_query( $conex, 'SELECT m.CODIGO,m.GESTION,m.MES,m.DIA FROM `marcacion_comedor` m inner join personal p on m.CODIGO=p.NRO_TRABAJADOR  '.
		               '   WHERE m.ACTIVO = 1 AND p.NRO_TRABAJADOR='.$codTrabajador.$sqlaux. '  order by m.CODIGO,m.GESTION,m.MES,DIA,m.COD_MARCACION ASC ');
				
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
	function horario($conex,$HM)
	{
		$i=1;
		$b=1;
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_array($rHorario)) 
		{	
			
			$v[$i]=MixMAx($HM,$row['HORARIO'].":00");
			
			$i++;
		}
		$a=$v[1];
		$b=1;
		
		for($j=2;$j<$i;$j++)
		{
		
			$hora1=strtotime($a);
			$hora2=strtotime($v[$j]);
			if($hora1<=$hora2)
			{
				
			}
			else
			{
				$a=$v[$j];
				$b=$j;
			}
		}
					
		
		return $b;
		
	}	
	
	
	
	
		$sql = 'SELECT p.*,c.DESCRIPCION,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion from `personal` p '.
			" inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD   ".
						' WHERE  p.NRO_TRABAJADOR='.$codTrabajador; 
		 $resultado1 = mysqli_query($conex,$sql);
		
		$sqlx = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
		' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_comedor` m '.
		' inner join personal p on m.CODIGO=p.NRO_TRABAJADOR '.
		' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  p.NRO_TRABAJADOR=' .$codTrabajador.$sqlaux.
		' order by m.CODIGO,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
		
						
		//echo "/*$sqlx*/";
	 $resultado = mysqli_query($conex,$sqlx);	
	
	 $data = array(); 
	$Encabezados1= "<h3> CONTROL ASISTENCIA COMEDOR</h3> <B> FECHA CONTROL DEL: ".date("d-m-Y",strtotime($fechai))."   -    HASTA: ".date("d-m-Y",strtotime($fechafin))."</B>".
				"<table border = 0>" .
			 
	$Registros1 ='';
	while ($row = mysqli_fetch_array($resultado1)) 
		{
				$Registros1 = $Registros1 .
				"	<tr>" .
				"	<td colspan='3' style='text-align:left;font:12px' > "."<strong>CODIGO:</strong> ".  $row['NRO_TRABAJADOR']. " </td>" .	
				"	<td colspan='4' style='text-align:left;font:12px'> "."<strong>TRABAJADOR:</strong> ".  $row['AP_PATERNO'] .' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2']  ."</td>" .
				"	<td colspan='4' style='text-align:left;font:12px' > "."<strong>CARGO:</strong> ".  $row['DESCRIPCION']. " </td>" .	
				"	</tr>".
				"	<tr>" .
				"	<td colspan='3' style='text-align:left;font:12px' > "."<strong>UNIDAD:</strong> ".  $row['uDescripcion']. " </td>" .	
				"	<td colspan='4' style='text-align:left;font:12px'> "."<strong>SUBCENTRO:</strong> ".  $row['sDescripcion'] ."</td>" .
					"	<td colspan='4' style='text-align:left;font:12px'> "."<strong>CENTRO:</strong> ".  $row['cDescripcion'] ."</td>" .
				"	</tr>";
		}
		echo $Encabezados1.$Registros1."</table>";
		
	$Encabezados = 
			
			
				"<table border = 1>" .
			   
	
			  "		<tr>" .
					"<th style='text-align:center;font:12px'>  NRO  </th> ".
					"	<th style='text-align:center;font:12px'> DIA </th> ".
			  "			<th style='text-align:center;font:12px'> FECHA </th> ";
		 
	 $sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
	 $rHorario=mysqli_query($conex,$sqlHorario); 
	 $numHorario=0;
	 while ($row= mysqli_fetch_array($rHorario)) 
	{	
		$Encabezados.= "	<th style='text-align:center;font:12px'>HORARIO ".$row['DESCRIPCION']."  </th> ";
		 $numHorario++;
	}		
	 $Encabezados.= "		</tr>";
	 
	$Registros ='';	
	
        $i=1;  
    $d[1]="LUNES";$d[2]="MARTES";$d[3]="MIERCOLES";$d[4]="JUEVES";$d[5]="VIERNES";$d[6]="SABADO";$d[7]="DOMINGO";
	$Ndia="";$nombreDia=0;
	
	 $aux=0;
	 $con=1; 
	
	 $v1="";$v2="";$v3="";$v4="";$v5="";$v6="";$v7="";$v8="";$v9="";$v10="";$v11="";$v12="";$v13="";$v14="";$v15="";	
	while ($row = mysqli_fetch_array($resultado)) 
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
			
		$HoraMarcacion=(string)$row['HORA'].':'.(string)$minut.':00';
			
		$r=horario($conex,$HoraMarcacion);
		
	
		if($r==1){$v1=$HoraMarcacion;}
		if($r==2){$v2=$HoraMarcacion;}
		if($r==3){$v3=$HoraMarcacion;}
		if($r==4){$v4=$HoraMarcacion;}
		if($r==5){$v5=$HoraMarcacion;}
		if($r==6){$v6=$HoraMarcacion;}
		if($r==7){$v7=$HoraMarcacion;}
		if($r==8){$v8=$HoraMarcacion;}
		if($r==9){$v9=$HoraMarcacion;}
		if($r==10){$v10=$HoraMarcacion;}
		if($r==11){$v11=$HoraMarcacion;}
		if($r==12){$v12=$HoraMarcacion;}
		if($r==13){$v13=$HoraMarcacion;}
		if($r==14){$v14=$HoraMarcacion;}
		if($r==15){$v15=$HoraMarcacion;}
		
		
		if(($con)==$t[$aux])
		{	
				if((int)$row['MES']<10)
				{
					$mes1="0".(string)$row['MES'];
				}
				else
				{
					$mes1=(string)$row['MES'];
				}
				if((int)$row['DIA']<10)
				{
					$dia1="0".(string)$row['DIA'];
				}
				else
				{
					$dia1=(string)$row['DIA'];
				}
			$fehaM=(string)$dia1.'/'.(string)$mes1.'/'.(string)$row['GESTION'];
			$fehaM1=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
			$i1 = strtotime($fehaM1);
			$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
				if($nombreDia==0)
				{$nombreDia=7;}
			$Ndia=$d[$nombreDia];
						$Registros = $Registros .
				  "		<tr>" .
				  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
				   "		<td style='text-align:left;font:10px'> ". $Ndia . " </td>" .	
			   
				  "			<td style='text-align:center;font:10px'> ". $fehaM . " </td>" ;
				 
			
				if($numHorario>=1){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v1 ."</td>";} 								
				if($numHorario>=2){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v2 ."</td>";}  
				if($numHorario>=3){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v3 ."</td>";}   
				if($numHorario>=4){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v4 ."</td>";}   
				if($numHorario>=5){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v5 ."</td>";}   
				if($numHorario>=6){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v6 ."</td>";}   
				if($numHorario>=7){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v7 ."</td>";}   
				if($numHorario>=8){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v8 ."</td>";}   
				if($numHorario>=9){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v9 ."</td>";}   
				if($numHorario>=10){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v10 ."</td>";}   
				if($numHorario>=11){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v11 ."</td>";}   
				if($numHorario>=12){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v12 ."</td>";}   
				if($numHorario>=13){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v13 ."</td>";}   
				if($numHorario>=14){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v14 ."</td>";}   
				if($numHorario>=15){$Registros.=   "	<td style='text-align:center;font:10px'> ". $v15 ."</td>";}   
				$Registros.="		</tr>";
				$i++;	
		
					
		$aux++;
		$con=0;
	
	}
		
	$con++;
			
				
		
		 
	}
	
	
	
     //--------------------------------------------------------------------------------------------------------
	
    
	echo $Encabezados . $Registros . '</table>';
?> 