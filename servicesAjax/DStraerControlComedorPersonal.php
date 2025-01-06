	<?php     
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
	  			  
		  
	
	include("../lib/conex.php");

			
	 session_start();
		$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		$nombreValidador=$_SESSION['Apellido1']." ".$_SESSION['Apellido2']." ".$_SESSION['Nombre'];	
		
		$conex = ConectarConBD(); // Inicializa la conexión correctamente
		if (!$conex) {
			die("Error al conectar con la base de datos");
		}
	// if (!VerificaConBD())	{	
	// 	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
	// 	exit;	
	// }
		$fechai = $_REQUEST["fechai"];
		 $fechai=substr($fechai,0,10);
		$codTrabajador = $_REQUEST["codigoT"];
		$codTrabajador = $_REQUEST["codigoT"];
		$codcargo = $_REQUEST["codcargo"];
			$codcentro = $_REQUEST["codcentro"];
		$codigo = $_REQUEST["codigo"];
		$fechaf =  $_REQUEST["fechaf"];
		$fechaf=substr($fechaf,0,10);
		// mysqli_query("SET NAMES 'utf8'");
		mysqli_set_charset($conex, "utf8");

		$sqlaux = '';
	
		if ($fechai <> '' and $fechaf <>'')
		{
			$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechaf' ";
		}
		 else
		{	
			$sqlaux = '';
		}
	
	  $st = mysqli_query($conex, 'SELECT m.CODIGO,m.GESTION,m.MES,m.DIA FROM `marcacion_comedor` m  '.
		               '   WHERE m.ACTIVO = 1 AND m.CODIGO='.$codTrabajador.$sqlaux. '  order by m.COD_MARCACION,m.CODIGO,m.GESTION,m.MES,DIA ASC ');
				
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
	function horario($conex,$HM)
	{
		echo "/*$HM*/";
		$i=1;
		
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex, $sqlHorario); 
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
	$v;
	function Nombrehorario($conex,$HM)
	{
		
		
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex, $sqlHorario); 
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
		$resultadoex1=mysqli_query($conex, $sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function NombreTarjeta($conex,$codigo)
	 {
		$sqlex1 = 'SELECT NOMBRE as TOTALE from  tarjetas_comedor where ACTIVO=1 AND CODIGO='.$codigo;
		echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex, $sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
		$sql = 'SELECT m.* '.
		' FROM `marcacion_comedor` m '.
		'   WHERE  m.ACTIVO = 1 and  m.CODIGO=' .$codTrabajador.$sqlaux.
		' order by m.COD_MARCACION,m.CODIGO,m.GESTION,m.MES,m.DIA ASC  '; 
		echo "/*$sql*/";
	
	   $data = array();
	 
	   $resultado=mysqli_query($conex, $sql);    			
	$d[1]="LUNES";$d[2]="MARTES";$d[3]="MIERCOLES";$d[4]="JUEVES";$d[5]="VIERNES";$d[6]="SABADO";$d[7]="DOMINGO";
	$Ndia="";$nombreDia=0;
	
	 $aux=0;
	 $con=1; 
	
	 $v1="";$v2="";$v3="";$v4="";$v5="";$v6="";$v7="";$v8="";$v9="";$v10="";$v11="";$v12="";$v13="";$v14="";$v15="";
	while ($row = mysqli_fetch_array($resultado)){
	
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
		$codigoT=$row['CODIGO'];
		$st = mysqli_query($conex, "SELECT COUNT(CODIGO) AS TOTALE FROM `tarjetas_comedor`  where CODIGO=$codigoT ");
		$tot = mysqli_fetch_array($st);
		$to=$tot['TOTALE'];
		if($to>0)
		{
			if($r==1){$v1=$v1.$HoraMarcacion."  ";}
			if($r==2){$v2=$v2.$HoraMarcacion."  ";}
			if($r==3){$v3=$v3.$HoraMarcacion."  ";}
			if($r==4){$v4=$v4.$HoraMarcacion."  ";}
			if($r==5){$v5=$v5.$HoraMarcacion."  ";}
			if($r==6){$v6=$v6.$HoraMarcacion."  ";}
			if($r==7){$v7=$v7.$HoraMarcacion."  ";}
			if($r==8){$v8=$v8.$HoraMarcacion."  ";}
			if($r==9){$v9=$v9.$HoraMarcacion."  ";}
			if($r==10){$v10=$v10.$HoraMarcacion."  ";}
			if($r==11){$v11=$v11.$HoraMarcacion."  ";}
			if($r==12){$v12=$v12.$HoraMarcacion."  ";}
			if($r==13){$v13=$v13.$HoraMarcacion."  ";}
			if($r==14){$v14=$v14.$HoraMarcacion."  ";}
			if($r==15){$v15=$v15.$HoraMarcacion."  ";}
		}
		else
		{
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
		}
		
		
		
		// if(($con)==$t[$aux])
		// {	
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
			
		array_push($data, 
		array( 	"codigo"		=> $row['CODIGO'], 
			
							"fechaMarcacion"		=>$fehaM, 
							"Ndia"		=>$Ndia,
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
		$aux++;
		$con=0;
	
	//}
		
	$con++;
	
  
}  
	
											 
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
?> 