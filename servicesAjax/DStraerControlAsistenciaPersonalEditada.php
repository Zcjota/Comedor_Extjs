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
		
	if (!VerificaConBD())	{	
		echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
		exit;	
	}
		$fechai = $_REQUEST["fechai"];
		 $fechai=substr($fechai,0,10);
		$codTrabajador = $_REQUEST["codigoT"];
		$codTrabajador = $_REQUEST["codigoT"];
		$codcargo = $_REQUEST["codcargo"];
			$codcentro = $_REQUEST["codcentro"];
		$codigo = $_REQUEST["codigo"];
		$fechaf =  $_REQUEST["fechaf"];
		$fechaf=substr($fechaf,0,10);
		mysql_query("SET NAMES 'utf8'");

		$sqlaux = '';
	
		if ($fechai <> '' and $fechaf <>'')
		{
			$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechaf' ";
		}
		 else
		{	
			$sqlaux = '';
		}
	
	  $st = mysql_query( 'SELECT m.COD_PERSONAL,m.GESTION,m.MES,m.DIA FROM `marcacion` m inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR  '.
		               '   WHERE m.ACTIVO = 1 AND p.NRO_TRABAJADOR='.$codTrabajador.$sqlaux. '  order by m.COD_PERSONAL,m.GESTION,m.MES,DIA,m.COD_MARCACION ASC ', $_SESSION['BD']);
				
		$tot=0;
		$w=0;
		$x;
		$x1;
		$x2;
		$x3;
		$y=1;
		$t;
		while ($row = mysql_fetch_array($st)) 
		{	
			if($w==0)
			{
				$x=$row['DIA'];
				$x1=$row['MES'];
				$x2=$row['GESTION'];
				$x3=$row['COD_PERSONAL'];
				
				$w=1;
			}
			else
			{
				if($x==$row['DIA'] && $x1==$row['MES'] && $x2==$row['GESTION'] && $x3==$row['COD_PERSONAL'])
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
					$x3=$row['COD_PERSONAL'];
					$y=1;
				}
			}
		
			
			
		}
		$t[$tot]=$y;

		function restaHoras($horaIni, $horaFin){
			return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
		}
			
		function CompararHoras($h1,$h2)
		{
		
			$aux=0;
			$hora1=strtotime($h1);
			
			$hora2=strtotime($h2);
			if( $hora1 > $hora2 ) {
				$aux=1;
			} 
			else
			{
				if( $hora1 < $hora2 ) {
					$aux=2;
				} 
			}
			
			return $aux;
		}

	function MixMAx($h1,$h2)
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
	function asignacionAprobar($cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador==7)
			{
				$sqlAsignacion=' select count(COD_USUARIO) as TOT from  flujo_aprobador  where COD_USUARIO ='.$idusuario.' and COD_PERSONAL='.$personalE.' and  ACTIVO=1 ';
				//// echo "/*-----consulta-------------$sqlAsignacion*/";
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
	$aprob=0;
	$tipoAsignacion1=asignacionAprobar($rcargador,$ridcargador,$codigo);
	if($tipoAsignacion1==1)
	{
		$aprob=1;
	}
	//// echo "/*a ver si es sierto --->$tipoAsignacion1*/";
	//// echo "/*a ver si es sierto --->$aprob*/";
	//asignacionAprobar()
	$v;
	function horario($HM,$h1,$h2,$h3,$h4)
	{
		
		$i=1;
		$b=1;
		while($i<=4)
		{
			if($i==1)
			{	
				
				$v[$i]=MixMAx($HM,$h1);
				$ff=$v[$i];
	
			}
			if($i==2)
			{
				if($h2!=0)
				{
					
					$v[$i]=MixMAx($HM,$h2);
					$ff=$v[$i];	
				}
				else{ $v[$i]="23:59:59";}
			}
			if($i==3)
			{
				if($h3!=0)
				{	
					
					$v[$i]=MixMAx($HM,$h3);
					$ff=$v[$i];
				}
				else{ $v[$i]="23:59:59";}
			}
			if($i==4)
			{		
					
					$v[$i]=MixMAx($HM,$h4,$i);
					$ff=$v[$i];
					
					$a=$v[1];
					$b=1;
					
					for($j=2;$j<=4;$j++)
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
			}
			$i++;
		}
		return $b;
	}
			function traerjustificacion($fecha,$codigo)
		{
		   $cant=0;
		   $valores = explode ("-", $fecha); 
	       $gestion = (int)$valores[0] ;
		   $gestion1 = (int)$valores[0] ;
		   $mes = (int)$valores[1] ;
		   $mes1 = (int)$valores[1] ;
		   $dia = (int)$valores[2] ;
	       $dia1 = (int)$valores[2] ;
			if((int)$mes<10)
			{
				$mes="0".(string)$mes;
			}
			
			if((int)$dia<10)
			{
				$dia="0".(string)$dia;
			}
		
			$fehaM=date($gestion.'-'.$mes.'-'.$dia);
			$sql = 'SELECT * from historico_justificacion where COD_PERSONAL="'. $codigo . '" and FECHA="'.$fehaM.'"';  	
			//// echo "/*---$sql----*/";
			mysql_query("SET NAMES 'utf8'");
			$resultado=mysql_query($sql,$_SESSION['BD']);    	
			$data = array();	
	
			while ($row = mysql_fetch_array($resultado)) 	{
			$sq = 'SELECT MIN_JUSTIFICADOS as min from marcacion_valida where COD_PERSONAL="'. $codigo . '" and GESTION="'.$gestion1. '" and MES="'.$mes1. '" and DIA="'.$dia1.  ' "';  	
			//// echo "/*$sq*/";
				$resultadoAsig=mysql_query($sq,$_SESSION['BD']);
				$totAsig = mysql_fetch_array($resultadoAsig);
				$tAsig=$totAsig['min'];
				if($row['MOTIVO']!="" or $row['MOTIVO_HE']!="" or $row['MOTIVO_APROBADOR']!="" or $tAsig!=0)
				  $cant=1;
			} 
		  return $cant;
		}
	function minutosAtraso($matraso)
	{
		list($horas, $minutos, $segundos) = explode(':', $matraso);
		$hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
		$hora_en_segundos=$hora_en_segundos/60;
		 $hora_en_segundos=number_format($hora_en_segundos,0,',','.');
		return $hora_en_segundos;
	}
	function redondearNumeros($cadena) {
		$tamanio = strlen ($cadena) ;
		$xy=0;
		$val=0.0;
		$cadena_decimal ="";
		$cadena_entera="";
		for ($x = 0;$x < $tamanio; $x++) {
			
			$t=$cadena[$x];
			//// echo "/*$t*/";
			if($cadena[$x]==".")
			{
				$xy=1;
			}
			else
			{
				if($xy==0)
				{
					$cadena_entera=$cadena_entera. $cadena[$x];
				}
			}
			if($xy==1 and $cadena[$x]!="." )
			{
				$cadena_decimal = $cadena_decimal . $cadena[$x];
			}
			
		
		
		}
		if((int)$cadena_decimal>=5)
		{
			$val=$cadena_entera.'.'. 5;
		}
		else
		{
			$val=$cadena_entera.'.'. 0;
		}
		if($cadena_decimal>=8)
		{
			$cadena_entera++;
			$val=$cadena_entera.'.'. 0;
		}
		// // echo "/*cadenaentera---------------->$cadena_entera*/";
		// // echo "/*cadenadecimal--------------->$cadena_decimal*/";
		// // echo "/*redondeado--------------->$val*/";
		return $val;
	}
	function HorasExtras($mextras)
	{
		list($horas, $minutos, $segundos) = explode(':', $mextras);
		
		$hora_Extras = ($horas * 60 ) + $minutos ;
		$hora_Extras=$hora_Extras/60;
		 $hora_Extras=number_format($hora_Extras,1,'.','.');
		 $t=redondearNumeros($hora_Extras);
		return $t;
	}
	function HorasExtrasN($mextras)
	{
		//// echo "/*HORAS RECARGO-----$mextras*/";
		list($horas, $minutos, $segundos) = explode(':', $mextras);
		
		$hora_Extras = ($horas * 60 ) + $minutos ;
		$hora_Extras=$hora_Extras/60;
		 $hora_Extras=number_format($hora_Extras,1,'.','.');
		// $t=redondearNumeros($hora_Extras);
		return $hora_Extras;
	}

		$sql = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
		' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
		' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
		' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  p.NRO_TRABAJADOR=' .$codTrabajador.$sqlaux.
		' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
		// echo "/*$sql*/";
	
	$data = array();
	 function existe($cod_personal,$gestion,$mes,$dia,$horario,$cargo,$centro,$HE1,$HS1,$HE2,$HS2,$RN,$nocturno)
	 {
		$sqlex = 'SELECT count(mv.COD_PERSONAL) as TOTALE from  marcacion_valida mv where mv.COD_PERSONAL='.$cod_personal.' and mv.GESTION='.$gestion.' and  mv.MES='.$mes.' and  mv.DIA='.$dia;
		$resultadoex=mysql_query($sqlex,$_SESSION['BD']);
		$tot1 = mysql_fetch_array($resultadoex);
		$t1=$tot1['TOTALE'];
		if($t1==0)
		{
			$recargonoc="";
			$hen="";
			if($HE1!="" && $HS2!="" && $RN!='SR')
			{
				//$recargonoc=$RN;
				if($nocturno==1)
				{
					//$hen="1";
				}
			}
			$sqlreg = "INSERT INTO marcacion_valida(COD_PERSONAL,GESTION,MES,DIA,COD_HORARIO,HIE,HIS,HFE,HFS,COD_CARGO,COD_CENTRO,ACTIVO) ".
										  "values('$cod_personal','$gestion','$mes','$dia','$horario','$HE1','$HS1','$HE2','$HS2','$cargo','$centro','1')";				
										$resultadoreg = mysql_query($sqlreg , $_SESSION['BD']);
		}
			return $t1;
	 }
	  function existe1($cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(mv.COD_PERSONAL) as TOTALE from  marcacion_valida mv where mv.COD_PERSONAL='.$cod_personal.' and mv.GESTION='.$gestion.' and  mv.MES='.$mes.' and  mv.DIA='.$dia;
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
			return $t2;
	 }
	 function modificar($cod_personal,$gestion,$mes,$dia,$HE1,$HS1,$HE2,$HS2,$RN,$nocturno,$bandera)
	 {
			if($bandera==0)
		{
			$recargonoc="";
				$hen="";
				if($HE1!="" && $HS2!="" && $RN!='SR')
				{
				//	$recargonoc=$RN;
					if((int)$nocturno==1)
					{
					//	$hen="1";
					}
				}
			
				$sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
											  //// echo "/*$sqlreg1*/";
											
											$resultadoreg1 = mysql_query($sqlreg1 , $_SESSION['BD']);
		}
		else
		{
				$sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
											  //// echo "/*$sqlreg1*/";
											
											$resultadoreg1 = mysql_query($sqlreg1 , $_SESSION['BD']);
		}
	 
	 
			$sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
			$resultadoreg1 = mysql_query($sqlreg1 , $_SESSION['BD']);
	 }
	 function recargo_nocturno($v1,$v4,$nocturno)
		 {
			$rn=0;
			$n=CompararHoras($v1,"20:00:00");
			if($n==1 or $n==0)
			{
				$n2=CompararHoras($v4,"6:00:00");
				if($n2==1 or $n2==0)
				{
					$rn=restaHoras($v1,"6:00:00");
				}
				else{$rn=restaHoras($v1,$v4);}
				//$rn=restaHoras($v1,$v4);
			}
			else{
					$n1=CompararHoras($v4,"20:00:00");
					if($n1==1 or $n1==0)
					{
						$rn=restaHoras("20:00:00",$v4);
					}
					else
					{
						$rn=0;
						if($nocturno==1)
						{
							if($v1!="" && $v4!="")
							{
								$n2=CompararHoras($v4,"6:00:00");
								if($n2==1 or $n2==0)
								{
									$rn=restaHoras("20:00:00","6:00:00");
								}
								else{$rn=restaHoras("20:00:00",$v4);}
								
								
							}
						}
						
					}
				}
			return $rn;
		}
		 function recargo_nocturno1($v4)
		 {
			$rn=0;
			$n=CompararHoras($v4,"20:00:00");
			if($n==1 or $n==0)
			{
				
					$rn=restaHoras("20:00:00",$v4);
				
			//	else{$rn=restaHoras($v1,$v4);}
				//// echo "/*$n2*/";
				
			}
			else{
					
				}
			return $rn;
		}
		 function PerteneAGrupo($cod_personal)
	 {
		$sqlex1 = 'SELECT count(gp.COD_GRUPO) as TOTALE from  grupo_persona gp where gp.COD_PERSONA='.$cod_personal.' and gp.ACTIVO=1';
	//	// echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function PerteneNombreGrupo($cod_personal)
	 {
		$sqlex1 = 'SELECT gp.COD_GRUPO as TOTALE from  grupo_persona gp where gp.COD_PERSONA='.$cod_personal.' and gp.ACTIVO=1';
		//// echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	  function obtenerHorarioGrupo($codGrupo,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT gp.CODHORARIO as TOTALE from  horario_grupo gp where gp.COD_GRUPO='.$codGrupo.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
		//// echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	   function Licencia($cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(gp.COD_PERSONA) as TOTALE from  licencias gp where gp.COD_PERSONA='.$cod_personal.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
	//	// echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	  function LicenciaAprobador($cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT gp.VALIDADOR as TOTALE from  licencias gp where gp.COD_PERSONA='.$cod_personal.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
	//	// echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function es_feriado($gestion,$mes,$dia)
	{
		$t2=0;
		$sqlex1 = 'SELECT COD_FERIADO as TOTALE from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
		//// echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		return $t2;
	}
	$resultado=mysql_query($sql,$_SESSION['BD']);    	
	$horario_Real="";
	$cont2=0;
	$cont3=0;
	$aux=0;
	$con=1;
	$min=1;
	$HoraMarcacion;
	$HE1;
	$HS1;
	$HE2;
	$HS2;
	$m[1]="00";$m[5]="05";$m[10]="10";$m[15]="15";$m[20]="20";$m[25]="25";$m[30]="30";$m[35]="35";$m[40]="40";$m[45]="45";$m[50]="50";$m[55]="55";
	$r;
	$v1="";
	$v2="";
	$v3="";
	$v4="";
	$horarioOficial="";
	$r1;
	$v11="";
	$v12="";
	$v13="";
	$v14="";
	$horarioOficial1="";
	$retraso;
	$minutoR=0;
	$minutoR1=0;
	$minutoE=0;
	$aux3=1;
	$nn=0;
	$fehaM;
	$tipoHorario=0;
	$codHorario=0;
	$nombreHorario="";
				
	$d[1]="LUNES";$d[2]="MARTES";$d[3]="MIERCOLES";$d[4]="JUEVES";$d[5]="VIERNES";$d[6]="SABADO";$d[7]="DOMINGO";
	$Ndia="";$nombreDia=0;
	$fechaii=$fechai;
	$fehaM2;
	$prueba=0;
	$tick=0;
	$horarioPersona=0;
	$horasDeHorario=0;
	$horasEfectivas=0;
	$minutoT="";
	$nocturno=0;
	$nocturno1=0;
	$recargoNocturno=0;
	$bandera=0;
	$toleranciaSemaforo=0;
	$existe=0;
	while ($row = mysql_fetch_array($resultado)){
	$minutoR="0"; 
		$minutoR1="0";
	$existe=1;
		$bandera=0;
		$horasEfectivas=0;
		$horasDeHorario=0;
		$recargoNocturno=0;
		$nocturno=0;
		$nocturno1=0;
		$tick=0;
		$gestion1 = $row['GESTION'] ;
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
		 $fehaM2=date($gestion1.'-'.$mes1.'-'.$dia1);
		
		 for($i=$fechaii;$i<$fehaM2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
		 $licencia=0;
						$aprobadorfaltas="";
						$vacaFalta=1;
						$nomVacaFalta="SIN ACCION";
		 $horasDeHorario=0;
			$nocturno=0;
			$HorasE="F";
			$v4="";
			$valores = explode ("-", $i); 
				$gestion = $valores[0] ;
				$mes = $valores[1] ;
				$dia = $valores[2] ;
					 $HEE1="";
					 $HSS1="";
					 $HEE2 ="";
					 $HSS2="";
					 $licencia=Licencia($codigo,$gestion,$mes,$dia);
					 
					 $G=PerteneAGrupo($codigo);
						if($G!=0)
						{		
								$Gp=PerteneNombreGrupo($codigo);
								$horar=obtenerHorarioGrupo($Gp,$gestion,$mes,$dia);
								if($horar!="")
								{
								$sqlac = 'update horario_personal  set COD_HORARIO='.$horar.' where COD_PERSONAL='.$codigo.' and ACTIVO=1';
								//// echo "/*$sqlac*/";
								$res=mysql_query($sqlac,$_SESSION['BD']); } 		
						}
					 $i1 = strtotime($i); 
					$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
					if($nombreDia==0)
					{$nombreDia=7;}
					$Ndia=$d[$nombreDia];
				 $sqla1 = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
					' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
					 '   WHERE  hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador.' and  date(p.FECHA_INGRESO) <= date("'.$gestion.'-'.$mes.'-'.$dia.'")';
					$res1=mysql_query($sqla1,$_SESSION['BD']);
					if ($row2 = mysql_fetch_array($res1)){
					$tick=1;
						$nn=existe1($codTrabajador,$gestion,$mes,$dia);
						
						//////////////////////////////////////////////////
						$feriado=es_feriado($gestion,$mes,$dia);
						$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row['COD_REGIONAL'];
												
												$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
												$toferiado = mysql_fetch_array($rferiado);
												$tferiado=$toferiado['tot'];
											if($tferiado!=0)
											{
												$sqlferiado = 'SELECT APROBADOR as total from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												 $resultadofer=mysql_query($sqlferiado,$_SESSION['BD']);
												
												$totfer = mysql_fetch_array($resultadofer);
												$aprobadorFeriado=$totfer['total'];
												
												$sqljustificacion = 'SELECT MOTIVO as total from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												 $resultadoferjust=mysql_query($sqljustificacion,$_SESSION['BD']);
												
												$totferjust = mysql_fetch_array($resultadoferjust);
												$justificacion=$totferjust['total'];
												$fechajustificación=$gestion."-".$mes."-".$dia;
												$fechajustificación1=$gestion."/".$mes."/".$dia;
												////////////////////////////
												$cod_trabajador=$row['NRO_TRABAJADOR'];
												$scount="select count(COD_PERSONAL) as tot from historico_justificacion where COD_PERSONAL='$cod_trabajador' and FECHA='$fechajustificación' ";
												//// echo "/*count-->$scount*/";
												$resultado1=mysql_query($scount,$_SESSION['BD']);  
												
												$totAsig = mysql_fetch_array($resultado1);
												$tAsig=$totAsig['tot'];
												////////////////////////////
												if($tAsig==0)
												{
													$sqljust = "insert into `historico_justificacion`(MOTIVO,FECHA,FECHA_APROBACION ,COD_PERSONAL) values('$justificacion','$fechajustificación','$fechajustificación1', ".$row['NRO_TRABAJADOR'].")";
			
													$resultadojus=mysql_query($sqljust,$_SESSION['BD']); 
												}
												else
												{
													$sqlreg = "update historico_justificacion set MOTIVO='$justificacion', FECHA_APROBACION='$fechajustificación1' where COD_PERSONAL='$cod_trabajador' and FECHA='$fechajustificación'";
													IF($resulreg = mysql_query($sqlreg , $_SESSION['BD']))
													{
													}
												}
												$sqlli = 'update `marcacion_valida` set FALTA=1,VALIDADOR="'.$aprobadorFeriado. '" where COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													 //  // echo "/*$sqlli------dddd*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']); 
												$vacaFalta=1;
												$tick=0;
												$nomVacaFalta="JUSTIFICADO";
											}
											
						/////////////////////////////////////////////////
						if($nn==0)
						{
							$tHorario=$row2['COD_HORARIO'];
							$horarioPersona=$row2['COD_HORARIOPERSONA'];
							$codHorario=$row2['COD_TIPOHORARIO'];
							$nombreHorario=$row2['NOMBRE_HORARIO'];
							if((int)$row2['INICIO_ENTRADAH']<10)
							{
								$HoE1="0".(string)$row2['INICIO_ENTRADAH'];
							}
							else
							{
								$HoE1=(string)$row2['INICIO_ENTRADAH'];
							}
							if((int)$row2['FINAL_SALIDAH']<10)
							{
								$HoS2="0".(string)$row2['FINAL_SALIDAH'];
							}
							else
							{
								$HoS2=(string)$row2['FINAL_SALIDAH'];
							}
							$HEE1=(string)$HoE1.':'.(string)$m[$row2['INICIO_ENTRADAM']].':00';
							$HSS2=(string)$HoS2.':'.(string)$m[$row2['FINAL_SALIDAM']].':00';
							
							$nocturno=CompararHoras($HEE1,$HSS2);
							if($codHorario==1)
							{
								$horasDeHor=restaHoras($HEE1,$HSS2)	;
								$horasDeHorario=(double)HorasExtras($horasDeHor);
								$HSS1="---";
								$HEE2="---";
								
							}
							else
							{
							
								$HSS1=(string)$row2['FINAL_ENTRADAH'].':'.(string)$m[$row2['FINAL_ENTRADAM']].':00';
								$HEE2=(string)$row2['INICIO_SALIDAH'].':'.(string)$m[$row2['INICIO_SALIDAM']].':00';
								$hora1=restaHoras($HEE1,$HSS1)	;
								
								$hora1=HorasExtras($hora1);
								
								$hora2=restaHoras($HEE2,$HSS2)	;
								$hora2=HorasExtras($hora2);
								$horasDeHorario=(double)$hora1+(double)$hora2;
							
							}
						
						if($nocturno==1)
						
						{
							$v4="";
							
							$i2 = strtotime($i ."+ 1 days"); 
							$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
							$nro=$row2['NRO_TRABAJADOR'];
							
							 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
								$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
								' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
								' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
								' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlauxn.
								' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
								
								$resultadoq=mysql_query($sqla,$_SESSION['BD']); 
									while ($rowq = mysql_fetch_array($resultadoq)){
									$minut="";
										if((int)$rowq['MINUTO']<10)
										{
											$minut="0".(string)$rowq['MINUTO'];
										}
										else
										{
											$minut=(string)$rowq['MINUTO'];
										}
									$horam="";
										if((int)$rowq['HORA']<10)
										{
											$horam="0".(string)$rowq['HORA'];
										}
										else
										{
											$horam=(string)$rowq['HORA'];
										}
									$HoraMarcacion=(string)$horam.':'.(string)$minut.':00';
								
										$r=horario($HoraMarcacion,$HEE1,$HSS1,$HEE2,$HSS2);
									if($r==4){
										$ttr=CompararHoras($HoraMarcacion,"11:00:00"); 
																	if($ttr!=1)
																	{
																	$v4=$HoraMarcacion;
																	//$HorasE=restaHoras($HSS2,$v4);
																	//$HorasE=HorasExtras($HorasE);
																	$ch1=CompararHoras($v4,$HSS2);
																			if($ch1==1)
																			{
																					$HorasE=restaHoras($HSS2,$v4);
																					$HorasE=HorasExtrasN($HorasE);	
																			}
																			else
																			{
																					$HorasE="0";
																			}
																	
																	
																	}
										//$v4=$HoraMarcacion;
									
									}
									
								}
						}
						if($v4!="")
						{
							$tick=3;
						}
						if($horarioPersona==1)
								{
									//$tick=0;
								}
						 existe($codTrabajador,$gestion,$mes,$dia,$tHorario,$row['COD_CARGO'],$row['COD_CENTRO'],"","","",$v4,"SR",$nocturno);
						  if($licencia==1)
												{
													$aprobadorfaltas=LicenciaAprobador($codigo,$gestion,$mes,$dia);
													$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													  // // echo "/*$sqlli*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']);  
												$vacaFalta=3;
													$tick=2;

												$nomVacaFalta="LICENCIA";
												}
							if($v4==""){$v4="---";}
							$fechaini=$gestion."-".$mes."-".$dia;
							$justificacion=traerjustificacion($fechaini,$row['NRO_TRABAJADOR']);
							if($horarioPersona==3)
							{
								$tick=0;
							}
							/////////////////////////////////////////////////////////////
							$fehaHistorico=$gestion."-".$mes."-".$dia;
							$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
							' where COD_PERSONAL="'. $row['NRO_TRABAJADOR']. '" and FECHA="'.$fehaHistorico.'"'; 
							//// echo "/*-------------Historico-->$sqlhisto-------------------*/";
							$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
							$fecha_marcacionEditada="";
							$fecha_cambioJustificacion="";
							$fechaHorasExtras="";
							$fechaAprobarHorasExtras="";
							if ($rowq = mysql_fetch_array($resHisto)){
								
								 if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
								 {
									  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
								 }
								 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
								 {
									 if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
									 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
								 }
								 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
								 {
									 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
								 }								 
								if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
								 {
									 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
								 }	
								
							}
							/////////////////////////////////////////////////////////////
						array_push($data, 
								array( 	"codigo"		=>$row['NRO_TRABAJADOR'], 
								"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row['NRO_TRABAJADOR'], $gestion, $mes, $dia),
									"nombre" 	=>   "",
									"horarioOficial"		=> $tHorario,
									"nombreHorario" => $nombreHorario,
									"IEH"		=> "",
									"IEM"		=> "",
									"IFH"		=>"",
									"IFM"		=> "",
									"horaEntradaR" => "",
									"minutoEntradaR" => "",
									"segundoEntradaR" => "",
									"marcacion"		=> "",
									"horario_oficial" =>"",
									"cod_cargo"    => "",
										"nombrecargo"    => "",
										"nombrecosto"    => "",
										"nombresubcentro"    => "",
										"nombreunidad"    => "",
										"cod_centro"    => "",
										"gestion"  => "",
										"mes"  => "",
										"dia"  => "",
									"hiem"  => "",
									"hism"  => "",
									"hfem"  => "",
									"hfsm"  =>  substr( $v4 , 0, strlen($v4) - 3),
									"minuto" =>"F",
									"minuto1" =>"F",
									"he"		=>  substr( $HEE1 , 0, strlen($HEE1) - 3),
									"he1"		=> substr( $HEE2 , 0, strlen($HEE2) - 3),
									"hs"		=> substr( $HSS1 , 0, strlen($HSS1) - 3),
									"hs1"		=>  substr( $HSS2 , 0, strlen($HSS2) - 3),
									"horasExtras" =>$HorasE,
									"fechaMarcacion"		=>$dia."/".$mes."/".$gestion, 
									"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
									"Ndia"		=>$Ndia,
									"tick" =>$tick,
									"validacionRetraso"=>1,
									"nvalidacionRetraso"=>"SIN ACCION",
									
										"validacionFaltas"=>$vacaFalta,
												"nvalidacionFaltas"=>$nomVacaFalta,
												"validador"=>$aprobadorfaltas,
									// "validacionFaltas"=>1,
									// "nvalidacionFaltas"=>"SIN ACCION",
									// "validador"=>"",
									"horasdehorario"=>$horasDeHorario,
									"horasEfectivas"=>"F",
									"HEN"=>"",
									"HEF"=>"",
									"HED"=>"",
									"editorHE"=>"",
									"recargoNocturno"=>"SR",
									"editorRN"=>"",
									"editorRNM"=>"",
									"aprobador" => "",
									"color" =>"SI",
									"colorr" =>"SI",
									"codcolor" =>"2",
									// "color" =>"NO",
									// "colorr" =>"NO",
									// "codcolor" =>"2",
									"aprob" =>$aprob,
									"justificacion"=>$justificacion,
									"marcacionEnt1Edit" =>0,
									"marcacionSal1Edit" =>0,
									"marcacionEnt2Edit" =>0,
									"marcacionSal2Edit" =>0,
									"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
									"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
									"fechaHorasExtras" => $fechaHorasExtras,
									"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
									 
								));
						
						
								
						}
						else{
							$tick1=1;
							//$licencia=0;
							  if($licencia==1)
								{
									$aprobadorfaltas=LicenciaAprobador($codigo,$gestion,$mes,$dia);
									$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
									
									 $resultado1=mysql_query($sqlli,$_SESSION['BD']);  
									
								}
							$color="";
										$sqlx1 = 'SELECT   mv.COD_PERSONAL as codPer,mv.BANDERA,mv.APROBADOR,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
										' h.FINAL_ENTRADAM,h.INICIO_SALIDAH,h.COD_HORARIOPERSONA,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv '.
										' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
										' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
										' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  '.
									'   mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
										
										$resultadoreg5 = mysql_query($sqlx1 , $_SESSION['BD']);
									while ($row5 = mysql_fetch_array($resultadoreg5))
										{
											
											$horarioPersona=$row5['COD_HORARIOPERSONA'];
											if((int)$row5['INICIO_ENTRADAH']<10)
											{
												$HoE1="0".(string)$row5['INICIO_ENTRADAH'];
											}
											else
											{
												$HoE1=(string)$row5['INICIO_ENTRADAH'];
											}
											if((int)$row5['FINAL_SALIDAH']<10)
											{
												$HoS2="0".(string)$row5['FINAL_SALIDAH'];
											}
											else
											{
												$HoS2=(string)$row5['FINAL_SALIDAH'];
											}
										
											$HEE11=(string)$HoE1.':'.(string)$m[$row5['INICIO_ENTRADAM']].':00';
											$HSS21=(string)$HoS2.':'.(string)$m[$row5['FINAL_SALIDAM']].':00';
											$nocturno=CompararHoras($HEE11,$HSS21);
											if($row5['COD_TIPOHORARIO']==1)
											{
												$horasDeHor=restaHoras($HEE11,$HSS21)	;
												$horasDeHorario=(double)HorasExtras($horasDeHor);
												$HSS11="---";
												$HEE21="---";
											}
											else
											{
											
												$HSS11=(string)$row5['FINAL_ENTRADAH'].':'.(string)$m[$row5['FINAL_ENTRADAM']].':00';
												$HEE21=(string)$row5['INICIO_SALIDAH'].':'.(string)$m[$row5['INICIO_SALIDAM']].':00';
												$hora1=restaHoras($HEE11,$HSS11)	;
							
												$hora1=HorasExtras($hora1);
												
												$hora2=restaHoras($HEE21,$HSS21)	;
												$hora2=HorasExtras($hora2);
												$horasDeHorario=(double)$hora1+(double)$hora2;
											
											}
											
											if($nocturno==1)
						
											{
												$v4="";
												
												$i2 = strtotime($i ."+ 1 days"); 
												$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
												$nro=$row['NRO_TRABAJADOR'];
												
												 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
													$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
													' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
													' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
													' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlauxn.
													' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
													
													$resultadoq=mysql_query($sqla,$_SESSION['BD']); 
														while ($rowq = mysql_fetch_array($resultadoq)){
															$minut="";
															if((int)$rowq['MINUTO']<10)
															{
																$minut="0".(string)$rowq['MINUTO'];
															}
															else
															{
																$minut=(string)$rowq['MINUTO'];
															}
															$horam="";
															if((int)$rowq['HORA']<10)
															{
																$horam="0".(string)$rowq['HORA'];
															}
															else
															{
																$horam=(string)$rowq['HORA'];
															}
														$HoraMarcacion=(string)$horam.':'.(string)$minut.':00';
													
															$r=horario($HoraMarcacion,$HEE11,$HSS11,$HEE21,$HSS21);
														if($r==4){
															$ttr=CompararHoras($HoraMarcacion,"11:00:00"); 
																	if($ttr!=1)
																	{
																	$v4=$HoraMarcacion;
																	 // $HorasE=restaHoras($HSS21,$v4);
																	 // $HorasE=HorasExtras($HorasE);
																	 $ch1=CompararHoras($v4,$HSS21);
																			if($ch1==1)
																			{
																					$HorasE=restaHoras($HSS21,$v4);
																					$HorasE=HorasExtrasN($HorasE);	
																			}
																			else
																			{
																					$HorasE="0";
																			}
																	}
														}
														
													}
											}
											if($v4!="")
													{
														$tick1=3;
													}
											else
											{$tick1=1;}
											if($row5['FALTA']==1)
											{
											$validacionFalta=2;
											$nvalidacionFalta="JUSTIFICADO";
										
												$tick1=0;
											}
											if($row5['FALTA']==0)
											{
												$validacionFalta=1;
											$nvalidacionFalta="SIN ACCION";
											//$tick1=1;
													
											}
											if($row5['FALTA']==2)
											{
											$validacionFalta=3;
											$nvalidacionFalta="INJUSTIFICADO";
									
											$tick1=0;
											}
											if($row5['FALTA']==3)
											{
												$validacionFalta=4;
												$nvalidacionFalta="LICENCIA";
												$licencia=1;
												$tick1=0;
											}
											if($horarioPersona==1)
											{
											//	$tick1=0;
											}
											modificar($row5['codPer'],$gestion,$mes,$dia,"","","",$v4,"SR",$nocturno,$row5['BANDERA']);
											
											if($licencia==1)
												{
												$tick1=2;
												}
											if($v4==""){$v4="---";}
											// $color="NO";
											// $codcolor=2;
											$color="SI";
											$codcolor=2;
											$fechaini=$gestion."-".$mes."-".$dia;
											$justificacion=traerjustificacion($fechaini,$row5['codPer']);
											if($row5['APROBADOR']!=""){$color="APROBADO";$codcolor=1;}
											if($horarioPersona==3)
											{
												$tick1=0;
											}
											/////////////////////////////////////////////////////////////
										$fehaHistorico=$gestion."-".$mes."-".$dia;
										$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
										' where COD_PERSONAL="'. $row5['codPer']. '" and FECHA="'.$fehaHistorico.'"'; 
										//// echo "/*-------------Historico-->$sqlhisto-------------------*/";
										$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
										$fecha_marcacionEditada="";
										$fecha_cambioJustificacion="";
										$fechaHorasExtras="";
										$fechaAprobarHorasExtras="";
										if ($rowq = mysql_fetch_array($resHisto)){
											 if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
												 {
													  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
												 }
												 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
												 {
													  if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
												 }
												 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
												 {
													 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
												 }								 
												if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
												 {
													 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
												 }	
										}
										/////////////////////////////////////////////////////////////
											array_push($data, 
											array( 	"codigo"		=>$row5['codPer'], 
											"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row5['codPer'], $gestion, $mes, $dia),
												"nombre" 	=>   "",
												"horarioOficial"		=> $row5['horariodia'], 
												"nombreHorario" => $row5['NOMBRE_HORARIO'], 
												"IEH"		=> "",
												"IEM"		=> "",
												"IFH"		=>"",
												"IFM"		=> "",
												"horaEntradaR" => "",
												"minutoEntradaR" => "",
												"segundoEntradaR" => "",
												"marcacion"		=> "",
												"horario_oficial" =>"",
												"cod_cargo"    => "",
												"nombrecargo"    => "",
												"nombrecosto"    => "",
											 "nombresubcentro"    => "",
												"nombreunidad"    => "",
												 "cod_centro"    => "",
													"gestion"  => "",
													"mes"  => "",
													"dia"  => "",
												"hiem"  => "",
												"hism"  => "",
												"hfem"  => "",
												"hfsm"  =>  substr( $v4 , 0, strlen($v4) - 3),
												"minuto" =>"F",
												"minuto1" =>"F",
												"he"		=>  substr( $HEE11 , 0, strlen($HEE11) - 3),
												"he1"		=> substr( $HEE21 , 0, strlen($HEE21) - 3),
												"hs"		=> substr( $HSS11 , 0, strlen($HSS11) - 3),
												"hs1"		=>  substr( $HSS21 , 0, strlen($HSS21) - 3),
												"horasExtras" =>$HorasE,
												"fechaMarcacion"		=>$dia."/".$mes."/".$gestion, 
												"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
												"Ndia"		=>$Ndia,
												"tick"		=>$tick1,
												"validacionRetraso"=>1,
												"nvalidacionRetraso"=>"SIN ACCION",
												"validacionFaltas"=>$validacionFalta,
												"nvalidacionFaltas"=>$nvalidacionFalta,
												"validador"=>$row5['VALIDADOR'],
												"horasdehorario"=>$horasDeHorario,
												"horasEfectivas"=>"F",
												"HEN"=>"",
												"HEF"=>"",
												"HED"=>"",
												"editorHE"=>"",
												"recargoNocturno"=>"SR",
												"editorRN"=>"",
												"editorRNM"=>"",
												"aprobador" => $row5['APROBADOR'],
													"color" =>$color,
													"colorr" =>$color,
													"codcolor" =>$codcolor,
													
													"aprob" =>$aprob,
													"justificacion"=>$justificacion,
													"marcacionEnt1Edit" =>0,
												"marcacionSal1Edit" =>0,
												"marcacionEnt2Edit" =>0,
												"marcacionSal2Edit" =>0,
												"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
												"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
												"fechaHorasExtras" => $fechaHorasExtras,
												"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
											));
											
										}
						
						}
					}
			
	}
		$fechaii=date("Y-m-d", strtotime($fehaM2 ."+ 1 days"));
		$prueba=0;
		$nocturno=0;
		$nocturno1=0;
		$horasDeHorario=0;
		$dd=$row['DIA'];
		
		//// echo "/*$dd*/";
			$nn=existe1($row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA']);
			 $licencia=Licencia($codigo,$row['GESTION'],$row['MES'],$row['DIA']);
			// if($nn==0)
				// {	
					$G=PerteneAGrupo($codigo);
						if($G!=0)
						{		
								$Gp=PerteneNombreGrupo($codigo);
								$horar=obtenerHorarioGrupo($Gp,$row['GESTION'],$row['MES'],$row['DIA']);
								if($horar!="")
								{
								$sqlac = 'update horario_personal  set COD_HORARIO='.$horar.' where COD_PERSONAL='.$codigo.' and ACTIVO=1';
								//// echo "/*$sqlac*/";
								$res=mysql_query($sqlac,$_SESSION['BD']); } 		
						}
					$fehaM1=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
					 $i1 = strtotime($fehaM1); 
					$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
					if($nombreDia==0)
					{$nombreDia=7;}
					
					 
					$sqla = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
					' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
					'   WHERE  hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador;
				
					//// echo "/*$sqla*/";
					$res=mysql_query($sqla,$_SESSION['BD']);   
					if ($row1 = mysql_fetch_array($res)){
						$horarioPersona=$row1['COD_HORARIOPERSONA'];
						$tipoHorario=$row1['COD_HORARIO'];
						$codHorario=$row1['COD_TIPOHORARIO'];
						$nombreHorario=$row1['NOMBRE_HORARIO'];
						$toleranciaSemaforo=$row1['TOLERANCIA_SEMAFORO'];
						if((int)$row1['INICIO_ENTRADAH']<10)
							{
								$HoE1="0".(string)$row1['INICIO_ENTRADAH'];
							}
							else
							{
								$HoE1=(string)$row1['INICIO_ENTRADAH'];
							}
							if((int)$row1['FINAL_SALIDAH']<10)
							{
								$HoS2="0".(string)$row1['FINAL_SALIDAH'];
							}
							else
							{
								$HoS2=(string)$row1['FINAL_SALIDAH'];
							}
						$HE1=(string)$HoE1.':'.(string)$m[$row1['INICIO_ENTRADAM']].':00';
						$HS2=(string)$HoS2.':'.(string)$m[$row1['FINAL_SALIDAM']].':00';
						$nocturno=CompararHoras($HE1,$HS2);
						if($codHorario==1)
						{
							$horasDeHor=restaHoras($HE1,$HS2)	;
							$horasDeHorario=(double)HorasExtras($horasDeHor);
							
							$HS1=0;
							$HE2=0;
						}
						else
						{
						
							$HS1=(string)$row1['FINAL_ENTRADAH'].':'.(string)$m[$row1['FINAL_ENTRADAM']].':00';
							$HE2=(string)$row1['INICIO_SALIDAH'].':'.(string)$m[$row1['INICIO_SALIDAM']].':00';
							$hora1=restaHoras($HE1,$HS1)	;
							
												$hora1=HorasExtras($hora1);
												
												$hora2=restaHoras($HE2,$HS2)	;
												$hora2=HorasExtras($hora2);
												$horasDeHorario=(double)$hora1+(double)$hora2;
						
						}
						
						
						
						
					
					}
					else
					{
					//	// echo "/*TE LO DIJE*/";
						$HE1="06:00:00";
						$HS1=0;
						$HE2=0;
						$HS2="18:00:00";
						$tipoHorario=0;
						$codHorario=1;
						$horarioPersona=2;
						$nombreHorario="SIN DEFINIR";
						$horasDeHorario=0;
						$prueba=1;
						$fehaM2=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
						 $i2 = strtotime($fehaM2 ."- 2 days"); 
						$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
						
						$nn1=existe1($row['NRO_TRABAJADOR'],(string) date("Y",$i2),(string)date("m",$i2),(string)date("d",$i2));
						if($nn1==0)
						{
						 $i1 = strtotime($fec); 
						$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
						
						if($nombreDia==0)
						{$nombreDia=7;}
						
							$sqltn = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
							' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
							'   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$row['NRO_TRABAJADOR'];
							
							$restn=mysql_query($sqltn,$_SESSION['BD']);  
							if ($rowtn = mysql_fetch_array($restn)){
								if((int)$rowtn['INICIO_ENTRADAH']<10)
								{
									$HoE1="0".(string)$rowtn['INICIO_ENTRADAH'];
								}
								else
								{
									$HoE1=(string)$rowtn['INICIO_ENTRADAH'];
								}
								if((int)$rowtn['FINAL_SALIDAH']<10)
								{
									$HoS2="0".(string)$rowtn['FINAL_SALIDAH'];
								}
								else
								{
									$HoS2=(string)$rowtn['FINAL_SALIDAH'];
								}
								$HE1=(string)$HoE1.':'.(string)$m[$rowtn['INICIO_ENTRADAM']].':00';
								$HS2=(string)$HoS2.':'.(string)$m[$rowtn['FINAL_SALIDAM']].':00';
								$tipoHorario=$rowtn['COD_HORARIO'];
								$nombreHorario=$rowtn['NOMBRE_HORARIO'];
								$nocturno=CompararHoras($HE1,$HS2);
									$toleranciaSemaforo=$rowtn['TOLERANCIA_SEMAFORO'];
								if($nocturno!=1){
										$HE1="8:00:00";
										$HS1="12:00:00";
										$HE2="14:00:00";
										$HS2="18:00:00";
										
										$tipoHorario=31;
										$toleranciaSemaforo=10;
										$nombreHorario="FERIADO / SABADO Y/O DOMINGO";
									}
							}
						
						}
						else{
							$sqlw1='SELECT mv.COD_PERSONAL,mv.COD_HORARIO as horariodia,h.* from `marcacion_valida` mv  inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR  inner join horario h on mv.COD_HORARIO=h.COD_HORARIO   WHERE  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.(string) date("Y",$i2).' and mv.MES='.(string)date("m",$i2).' and mv.DIA='.(string)date("d",$i2).' order by mv.COD_PERSONAL,mv.GESTION,mv.MES,mv.DIA ASC'; 
							$restn1=mysql_query($sqlw1,$_SESSION['BD']); 
								if ($rowtn1 = mysql_fetch_array($restn1)){
									if((int)$rowtn1['INICIO_ENTRADAH']<10)
									{
										$HoE1="0".(string)$rowtn1['INICIO_ENTRADAH'];
									}
									else
									{
										$HoE1=(string)$rowtn1['INICIO_ENTRADAH'];
									}
									if((int)$rowtn1['FINAL_SALIDAH']<10)
									{
										$HoS2="0".(string)$rowtn1['FINAL_SALIDAH'];
									}
									else
									{
										$HoS2=(string)$rowtn1['FINAL_SALIDAH'];
									}
								$HE1=(string)$HoE1.':'.(string)$m[$rowtn1['INICIO_ENTRADAM']].':00';
								$HS2=(string)$HoS2.':'.(string)$m[$rowtn1['FINAL_SALIDAM']].':00';
								$tipoHorario=$rowtn1['COD_HORARIO'];
								$nombreHorario=$rowtn1['NOMBRE_HORARIO'];
								$nocturno=CompararHoras($HE1,$HS2);
								$toleranciaSemaforo=$rowtn1['TOLERANCIA_SEMAFORO'];
								if($nocturno!=1){
										$HE1="8:00:00";
										$HS1="12:00:00";
										$HE2="14:00:00";
										$HS2="18:00:00";
										
										$tipoHorario=31;
										$toleranciaSemaforo=10;
										$nombreHorario="FERIADO / SABADO Y/O DOMINGO";
									}
								
							}
						}
						
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
					$horam="";
					if((int)$row['HORA']<10)
					{
						$horam="0".(string)$row['HORA'];
					}
					else
					{
						$horam=(string)$row['HORA'];
					}
					$nombre_completo=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					$HoraMarcacion=(string)$horam.':'.(string)$minut.':00';
					
					$r=horario($HoraMarcacion,$HE1,$HS1,$HE2,$HS2);
					if($r==1){$v1=$HoraMarcacion;}
					if($r==2 and $v2=="")
					{
					  $v2=$HoraMarcacion;
					}
					else
					{
						if($v3=="" and  $r==2)
						{
							$v3=$HoraMarcacion;
						}
						else
						{
							if($r==2)
							 $v2=$HoraMarcacion;
						}
						
					}
					if($r==3  and $v3==""){
					$v3=$HoraMarcacion;
					
					}
					else
					{
						if($v2=="" and  $r==3)
						{
							$v2=$v3;
							$v3=$HoraMarcacion;
						}
						else
						{
							if($r==3)
							$v3=$HoraMarcacion;
						}
					}
					if($r==4){$v4=$HoraMarcacion;}
				
			
			if(($con)==$t[$aux])
			{	
			//AQUI---------------------------------------------------------------------------------------------------
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
						//if($nocturno==1 && $nocturno1==0)
						if($nocturno==1)
						{
							$p1=CompararHoras($v4,"11:00:00"); 
							if($p1!=1)
							{
							
							}
							else{
							$v1=$v4;
							}
							$v4="";
							$pri=0;
							$i2 = strtotime($fehaM1 ."+ 1 days"); 
							$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
							$nro=$row['NRO_TRABAJADOR'];
							
							 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
								$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
								' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
								' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
								' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlauxn.
								' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
								
								$resultadoq=mysql_query($sqla,$_SESSION['BD']); 
									while ($rowq = mysql_fetch_array($resultadoq)){
										$minut="";
										if((int)$rowq['MINUTO']<10)
										{
										 $minut="0".(string)$rowq['MINUTO'];
										}
										else
										{
										  $minut=(string)$rowq['MINUTO'];
										}
										$horam="";
										if((int)$rowq['HORA']<10)
										{
											$horam="0".(string)$rowq['HORA'];
										}
										else
										{
											$horam=(string)$rowq['HORA'];
										}
									$HoraMarcacion=(string)$horam.':'.(string)$minut.':00';
									
										$r=horario($HoraMarcacion,$HE1,$HS1,$HE2,$HS2);
									
									if($r==4){
											$ttr=CompararHoras($HoraMarcacion,"11:00:00"); 
																	if($ttr!=1)
																	{
																	$v4=$HoraMarcacion;$pri=1;
																	// $HorasE=restaHoras($HSS2,$v4);
																	// $HorasE=HorasExtras($hextras);
																	}
										
										
										}
									
									
									
								}
						}
						else
						{
							
							if($v4=="" || $v4=="---")
							{
								
								$i2 = strtotime($fehaM1 ."+ 1 days"); 
								$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
								$nro=$row['NRO_TRABAJADOR'];
								
								 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
									$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
									' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
									' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
									' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlauxn.
									' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
									
									$resultadoq=mysql_query($sqla,$_SESSION['BD']); 
							
									while ($rowq = mysql_fetch_array($resultadoq)){
										$minut="";
										if((int)$rowq['MINUTO']<10)
										{
										 $minut="0".(string)$rowq['MINUTO'];
										}
										else
										{
										  $minut=(string)$rowq['MINUTO'];
										}
										$horam="";
										if((int)$rowq['HORA']<10)
										{
											$horam="0".(string)$rowq['HORA'];
										}
										else
										{
											$horam=(string)$rowq['HORA'];
										}
									$HoraMarcacion=(string)$horam.':'.(string)$minut.':00';
									
										$r=horario($HoraMarcacion,$HE1,$HS1,$HE2,$HS2);
									
									if($r==1){
											$ttr=CompararHoras($HoraMarcacion,"02:30:00"); 
																	if($ttr!=1)
																	{
																	$v4=$HoraMarcacion;
																	// $HorasE=restaHoras($HSS2,$v4);
																	// $HorasE=HorasExtras($hextras);
																	}
										
										
										}
									
									
									
								}
							}
						}
				
				
				$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
					if($nombreDia==0)
					{$nombreDia=7;}
				$Ndia=$d[$nombreDia];
					if($nn==0)
					{
						if($codHorario==1)
						{
							$k="HE:".$v1.",HS:".$v4;
							$horarioOficial="HE:".$HE1.",HS:".$HS2;
							if($v1!="" and $v4!="")
							{
								$horasEfec=restaHoras($v1,$v4)	;
								$horasEfectivas=(double)HorasExtras($horasEfec);
								
								$ttr=CompararHoras($HE1,$v1); 
								if($ttr==1)
								{
									$recargoNocturno=recargo_nocturno($HE1,$v4,$nocturno);
								}
								else
								{
								$recargoNocturno=recargo_nocturno($v1,$v4,$nocturno);
								}
								
								//$recargoNocturno=recargo_nocturno($v1,$v4,$nocturno);
								//// echo "/*$recargoNocturno*/";
								 if($recargoNocturno!=0)
									{
										$recargoNo=HorasExtrasN($recargoNocturno);
										$recargoNocturno=HorasExtras($recargoNocturno);
									}
								else
									 {
									 $recargoNo="0";
									 $recargoNocturno="0";
									}
							//$recargoNocturno=HorasExtras($recargoNocturno);
							}
							else
							{
								$horasEfectivas="FP";
								if($v4!="")
								{
									$recargoNocturno=recargo_nocturno1($v4);
									if($recargoNocturno!=0)
									{
										$recargoNo=HorasExtrasN($recargoNocturno);
										$recargoNocturno=HorasExtras($recargoNocturno);
										
									}
									else
									{
										 $recargoNo="0";
										$recargoNocturno="0";
									}	
								}
								else
								{
									$recargoNo="SR";
									$recargoNocturno="SR";
								}
								//$recargoNocturno="SR";
							}
							
						}
						else
						{
							$k="HE:".$v1.",HS:".$v2.",HE:".$v3.",HS:".$v4;
							$horarioOficial="HE:".$HE1.",HS:".$HS1.",HE:".$HE2.",HS:".$HS2;
							if($v1!="" and $v4!="" and $v2!="" and $v3!="")
							{
								
								$hor1=restaHoras($v1,$v2)	;
								
								$hor1=HorasExtras($hor1);
								
								$hor2=restaHoras($v3,$v4)	;
								$hor2=HorasExtras($hor2);
								$horasEfectivas=(double)$hor1+(double)$hor2;
								
							}
							else
							{ $horasEfectivas="FP";}
								if($v1!="" and $v4!="")
								{
									$ttr=CompararHoras($HE1,$v1); 
									if($ttr==1)
									{
										$recargoNocturno=recargo_nocturno($HE1,$v4,$nocturno);
									}
									else
									{
									$recargoNocturno=recargo_nocturno($v1,$v4,$nocturno);
									}
									//$recargoNocturno=recargo_nocturno($v1,$v4,$nocturno);
									//// echo "/*$recargoNocturno*/";
									if($recargoNocturno!=0)
									{
										$recargoNo=HorasExtrasN($recargoNocturno);
										$recargoNocturno=HorasExtras($recargoNocturno);
									}
									else
									{
										$recargoNo="0";
										$recargoNocturno="0";
									}
									
								}
								else
									{
											if($v4!="")
											{
												$recargoNocturno=recargo_nocturno1($v4);
												if($recargoNocturno!=0)
												{
													$recargoNo=HorasExtrasN($recargoNocturno);
													$recargoNocturno=HorasExtras($recargoNocturno);
													
												}
												else
												{
													$recargoNo="0";
													$recargoNocturno="0";
												}	
											}
											else
											{
												$recargoNo="SR";
												$recargoNocturno="SR";
											}
											//$recargoNocturno="SR";
									}
						}
					}
								$diad=$row['GESTION']."-".$row['MES']."-".$row['DIA'];
							
					if($nocturno1==0)
						{

							if($prueba==1 and $v4=="" and $nocturno==1)
							 {
		
								if($v1!="")
								{
						
									$n=existe($row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA'],$tipoHorario,$row['COD_CARGO'],$row['COD_CENTRO'],$v1,$v2,$v3,$v4,$recargoNocturno,$nocturno);
								}
								else
								{
									$n=0;
									$bandera=1;
								}
								 
							 }
							 else{
								
							$n=existe($row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA'],$tipoHorario,$row['COD_CARGO'],$row['COD_CENTRO'],$v1,$v2,$v3,$v4,$recargoNocturno,$nocturno);
							}
							
						}
						else{$n=0;}
						
						if($n==0)
						{
							$tick=0;
								if($v1!="")//minutosAtraso
								{
									$ch=CompararHoras($v1,$HE1);
										if($ch==1)
										{
												$retraso=restaHoras($HE1,$v1);
												$minutoR=minutosAtraso($retraso);
												$tick=1;
										}
										else
										{
												$minutoR="0";
										}
					
					
								}
								else
									{
											$minutoR="SM";
											$tick=1;
									}
								
								if($v3!="")//minutosAtraso
								{
									$ch=CompararHoras($v3,$HE2);
										if($ch==1)
										{
												$retraso=restaHoras($HE2,$v3);
												$minutoR1=minutosAtraso($retraso);
												//$tick=1;
										}
										else
										{
												$minutoR1="0";
										}
					
					
								}
								else
									{
											$minutoR1="SM";
											//$tick=1;
									}
								$minutoT=$minutoR;
								if($minutoR!='SM' && $minutoR1!="SM")
								{
									$minutoT=(int)$minutoR+(int)$minutoR1;
								}
								if($minutoT=="0" and $minutoR1!="SM")
								{
									$minutoT=$minutoR1;
								}								
								if($v4!="")//HORAS EXTRAS
								{
									$ch1=CompararHoras($v4,$HS2);
										if($ch1==1)
										{
												$hextras=restaHoras($HS2,$v4);
												$minutoE=HorasExtrasN($hextras);
												//$minutoE=minutosAtraso($extra);
										}
										else
										{
												$minutoE="0";
										}
					
					
								}
								else
									{
											$minutoE="0";
									}
								$banamarilla=0;
								if($v1=="" && $v4!="")
								{
									$tick=3;
									$banamarilla=1;
								}
								if($v4=="" && $v1!="")
								{
									$tick=3;
									$banamarilla=1;
								}
								if($codHorario==1)
								{
									$HS1="---";
									$HE2="---";
								}
								
								if($prueba==1)
								{
									// $HE1="---";
									// $HS2="---";
									$minutoR=0;
									$minutoE=0;
									$tick=1;
									$horasDeHorario=0;
									$minutoT=0;
								}
								if($v1==""){$v1="---";}
								if($v2==""){$v2="---";}
								if($v3==""){$v3="---";}
								if($v4==""){$v4="---";}
								if($minutoT!="F" AND $minutoT!="SM")
								{
									if($toleranciaSemaforo>=$minutoT && $banamarilla==0)
									{
										$tick=0;
									}
									else
									{
										$tick=3;
										
									}
								}
								$feriado=es_feriado($row['GESTION'],$row['MES'],$row['DIA']);
								$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row['COD_REGIONAL'];
												
												$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
												$toferiado = mysql_fetch_array($rferiado);
												$tferiado=$toferiado['tot'];
								if($prueba==1 || $tferiado!=0)
								{
									$minutoT=0;
									$tick=0;
									$minutoR1=0;
									$she1="";
									$she2="";
									$c1=1;
									$tick=1;
									$m1=substr( $v1, 0, strlen($v1) - 3);
									if($m1!=""){$she1=$m1;$c1++;}
									
									$m2=substr( $v2 , 0, strlen($v2) - 3);
									if($m2!=""){if($c1==1){$she1=$m2;$c1++;} else{$she2=$m2;}}
									$m3= substr( $v3 , 0, strlen($v3) - 3);
									if($m3!=""){if($c1==1){$she1=$m3;$c1++;} else{$she2=$m3;}}
									 $m4=substr( $v4 , 0, strlen($v4) - 3);
									if($m4!=""){if($c1==1){$she1=$m4;$c1++;} else{$she2=$m4;}}
									
									if($she1!="" and $she2!="")
									{
										$horaextraordinario=restaHoras($she1,$she2)	;
										$horaextraordinario=(double)HorasExtras($horaextraordinario);
										$minutoE=$horaextraordinario;
									}
								}
								if($horarioPersona==1)
								{
									$fechanueva="2015-09-01";
									if(strtotime(date($fechanueva)) > strtotime( date($row['GESTION']."-".$row['MES']."-".$row['DIA'])))
									{	
										$tick=0;
									}
									else
									{
									
										//////////modificar aqui
										if($codHorario==2)
											{
												if($v1!="---" and $v3!="---"){
													$tick=0;
												}
												else
												{
													$tick=3;
												}
											}
										else
										{
											if($v1!="---"){
													$tick=0;
													}
													else
													{
														$tick=3;
													}
										}
									}
									
								}
								else
								{
									$fechanueva="2015-09-01";
									if(strtotime(date($fechanueva)) > strtotime( date($row['GESTION']."-".$row['MES']."-".$row['DIA'])))
									{	
										
									}
									else
									{
										if($codHorario==2)
										{
												if($v1!="---" and $v2!="---" and $v3!="---" and  $v4!="---"){
														//$tick=0;
													}
													else
													{
														if($v1=="---" and $v2=="---" and $v3=="---" and  $v4=="---"){
															$tick=1;
														}
														else
														{
															$tick=3;
														}
														
													}
										}
									}
									
									
								////////////////////////
								}
								if($nocturno1==0 and $bandera==0)
								{
								$recargoN="";
										if($recargoNocturno=='SR')
										{
											$recargoN='';
										}
										else{
											if($v1!="---" and $v4!="---"){
											//$recargoN=$recargoNocturno;
											}
										
										}
										$hen="";
										if($nocturno==1)
										{
											if($v1!="---" and $v4!="---"){
											//$hen=1;
											}
										}
										else
										{
											$hen="";
										}
								$fechaini=$fehaM1;
								$justificacion=traerjustificacion($fechaini,$row['NRO_TRABAJADOR']);
								if($tipoHorario==31)
								{
									$minutoT=0;		
									$minutoR1=0;
									$she1="";
									$she2="";
									$c1=1;
									
									$m1=substr( $v1, 0, strlen($v1) - 3);
									if($m1!=""){$she1=$m1;$c1++;}
									
									$m2=substr( $v2 , 0, strlen($v2) - 3);
									if($m2!=""){if($c1==1){$she1=$m2;$c1++;} else{$she2=$m2;}}
									$m3= substr( $v3 , 0, strlen($v3) - 3);
									if($m3!=""){if($c1==1){$she1=$m3;$c1++;} else{$she2=$m3;}}
									 $m4=substr( $v4 , 0, strlen($v4) - 3);
									if($m4!=""){if($c1==1){$she1=$m4;$c1++;} else{$she2=$m4;}}
									
									if($she1!="" and $she2!="")
									{
										$horaextraordinario=restaHoras($she1,$she2)	;
										$horaextraordinario=(double)HorasExtras($horaextraordinario);
										$minutoE=$horaextraordinario;
									}
								}
								if($licencia==1)
								{
									$validacionFalta=3;
									$nvalidacionFalta="LICENCIA";
									$tick=2;
									$minutoT=0;		
									$minutoR1=0;
								}
								else
								{
									$validacionFalta=1;
									$nvalidacionFalta="SIN ACCION";
								}
								if($horarioPersona==3)
								{
									$tick=0;
								}
								/////////////////////////////////////////////////////////////
										$diax=$row['DIA'];
										if((int)$diax<10)
										{
										$diax="0".$row['DIA'];
										}
										$mesx=$row['MES'];
										if((int)$mesx<10)
										{
										$mesx="0".$row['MES'];
										}
										$fehaHistorico= $row['GESTION']."-".$mesx."-". $diax;
										$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
										' where COD_PERSONAL="'. $row['NRO_TRABAJADOR']. '" and FECHA="'.$fehaHistorico.'"'; 
										// // echo "/*-------------Historico-->$sqlhisto-------------------*/";
										$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
										$fecha_marcacionEditada="";
										$fecha_cambioJustificacion="";
										$fechaHorasExtras="";
										$fechaAprobarHorasExtras="";
										if ($rowq = mysql_fetch_array($resHisto)){
											 if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
												 {
													  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
												 }
												 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
												 {
													  if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
												 }
												 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
												 {
													 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
												 }								 
												if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
												 {
													 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
												 }	
										}
								array_push($data, 
								array( 	"codigo"		=> $row['NRO_TRABAJADOR'], 
								"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row['NRO_TRABAJADOR'], $row['GESTION'], $row['MES'], $row['DIA']),
									"nombre" 	=>   "",
									"horarioOficial"		=> $tipoHorario,
									"nombreHorario" => $nombreHorario,
									"IEH"		=> "",
									"IEM"		=> "",
									"IFH"		=>"",
									"IFM"		=> "",
									"horaEntradaR" => $row['HORA'],
									"minutoEntradaR" => $row['MINUTO'],
									"segundoEntradaR" => $row['SEGUNDO'],
									// "marcacion"		=>$horario_Real
									"marcacion"		=> $k,
									"horario_oficial" =>$horarioOficial,
									"cod_cargo"    => $row['COD_CARGO'],
									"nombrecargo"    => $row['DESCRIPCION'],
									"nombrecosto"    => $row['cDescripcion'],
									"nombresubcentro"    => $row['sDescripcion'],
									"nombreunidad"    => $row['uDescripcion'],
									"cod_centro"    => $row['COD_CENTRO'],
									"gestion"  => $row['GESTION'],
									"mes"  => $row['MES'],
									"dia"  => $row['DIA'],
									"hiem"  =>  substr( $v1 , 0, strlen($v1) - 3),
									"hism"  =>  substr( $v2 , 0, strlen($v2) - 3),
									"hfem"  => substr( $v3 , 0, strlen($v3) - 3),
									"hfsm"  => substr( $v4 , 0, strlen($v4) - 3),
									"minuto" =>$minutoT,
									"minuto1" =>$minutoR1,
									"he"		=> substr( $HE1 , 0, strlen($HE1) - 3),
									"hs"		=> substr( $HS1 , 0, strlen($HS1) - 3),
									"he1"		=>  substr( $HE2 , 0, strlen($HE2) - 3),
									"hs1"		=>  substr( $HS2 , 0, strlen($HS2) - 3),
									"horasExtras" =>$minutoE,
									"fechaMarcacion"		=>$fehaM, 
									"fechaMarcacion1"		=>$fehaM1, 
									"Ndia"		=>$Ndia,
									"tick" =>$tick,
									"validacionRetraso"=>1,
									"nvalidacionRetraso"=>"SIN ACCION",
									"validacionFaltas"=>$validacionFalta,
									"nvalidacionFaltas"=>$nvalidacionFalta,
									"validador"=>"",
									"horasdehorario"=>$horasDeHorario,
									"horasEfectivas"=>$horasEfectivas,
									"HEN"=>$hen,
									"HEF"=>"",
									"HED"=>"",
									"editorHE"=>"",
									"recargoNocturno"=>$recargoNocturno,
										"editorRN"=>$recargoN,
										"editorRNM"=>$recargoNo,
										"aprobador" =>"",
										"color" =>"SI",
										
										"colorr" =>"SI",
										"codcolor" =>"2",
										
										"aprob" =>$aprob,
										"justificacion" =>$justificacion,
										"marcacionEnt1Edit" =>0,
												"marcacionSal1Edit" =>0,
												"marcacionEnt2Edit" =>0,
												"marcacionSal2Edit" =>0,
												"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
												"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
												"fechaHorasExtras" => $fechaHorasExtras,
												"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
								));}
						}
					else
						{
							//// echo "/*-----------------------REVISION DE DUPLICADOS---------------------------------------------------------------------------------------------*/";
							$nocturno1=0;
							$nocturno=0;
							$tick=0;
							$tick1=0;
							$aux3=1;
							$validacionRetraso=0;
							$nvalidacionRetraso="";
							
							$validacionFalta=0;
							$nvalidacionFalta="SIN ACCION";
							$sqlt='SELECT  count(m.COD_PERSONAL) as tot FROM `marcacion` m  inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR'.
					
							'  WHERE  m.COD_PERSONAL='.$row['NRO_TRABAJADOR'].
							' and m.GESTION='.$row['GESTION'].' and m.MES='.$row['MES'].' and m.DIA='.$row['DIA'].' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC';
							//// echo "/*---$sqlt---*/";
							$resultadot=mysql_query($sqlt,$_SESSION['BD']);  
							$sqlt1='SELECT  mv.COD_HORARIO as COD_HO FROM `marcacion_valida` mv  '.
					
							'  WHERE mv.ACTIVO = 1   and  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].
							' and mv.GESTION='.$row['GESTION'].' and mv.MES='.$row['MES'].' and mv.DIA='.$row['DIA'];
							// // echo "/*----$sqlt1*/";
							$resultadot1=mysql_query($sqlt1,$_SESSION['BD']);  
							$tt1 = mysql_fetch_array($resultadot1);
							$tH=$tt1['COD_HO'];
				
							$tt = mysql_fetch_array($resultadot);
							$t2=$tt['tot'];
							$sqlx= 'SELECT m.*,p.* FROM `marcacion` m  inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR   WHERE   m.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and m.GESTION='.$row['GESTION'].' and m.MES='.$row['MES'].' and m.DIA='.$row['DIA'].'  order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC';
							
				
							$resultadoreg = mysql_query($sqlx , $_SESSION['BD']);
							while ($row1 = mysql_fetch_array($resultadoreg))
							{
				
								$nombre_completo=$row1['AP_PATERNO'].' '.$row1['AP_MATERNO'].' '.$row1['NOMBRE'].' '.$row1['NOMBRE2'];
								$minut="";
										if((int)$row1['MINUTO']<10)
										{
										 $minut="0".(string)$row1['MINUTO'];
										}
										else
										{
										  $minut=(string)$row1['MINUTO'];
										}
										$horam="";
										if((int)$row1['HORA']<10)
										{
											$horam="0".(string)$row1['HORA'];
										}
										else
										{
											$horam=(string)$row1['HORA'];
										}
								$HoraMarcacion1=(string)$horam.':'.(string)$minut.':00';
								
								$sqlw='SELECT mv.COD_PERSONAL,mv.COD_HORARIO as horariodia,mv.BANDERA,mv.APROBADOR,mv.RECARGO_NOCTURNO,mv.HEN,mv.HEF,mv.HED,mv.VALIDADORHE,mv.RETRASO,mv.FALTA,mv.VALIDADOR,mv.MIN_JUSTIFICADOS,mv.HE1E,mv.HS1E,mv.HE2E,mv.HS2E,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_HORARIOPERSONA,h.TOLERANCIA_SEMAFORO,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH, h.FINAL_ENTRADAM,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv  inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR  inner join horario h on mv.COD_HORARIO=h.COD_HORARIO inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$row['GESTION'].' and mv.MES='.$row['MES'].' and mv.DIA='.$row['DIA'].' order by mv.COD_PERSONAL,mv.GESTION,mv.MES,mv.DIA ASC'; 
								//// echo "/*----$sqlw----*/";
								$resultadoreg3 = mysql_query($sqlw , $_SESSION['BD']);
								while ($roww = mysql_fetch_array($resultadoreg3))
								{
											$toleranciaSemaforo=$roww['TOLERANCIA_SEMAFORO'];
											$horarioPersona=$roww['COD_HORARIOPERSONA'];
											if((int)$roww['INICIO_ENTRADAH']<10)
											{
												$HoE1="0".(string)$roww['INICIO_ENTRADAH'];
											}
											else
											{
												$HoE1=(string)$roww['INICIO_ENTRADAH'];
											}
											if((int)$roww['FINAL_SALIDAH']<10)
											{
												$HoS2="0".(string)$roww['FINAL_SALIDAH'];
											}
											else
											{
												$HoS2=(string)$roww['FINAL_SALIDAH'];
											}
											$HE11=(string)$HoE1.':'.(string)$m[$roww['INICIO_ENTRADAM']].':00';
											if($roww['FINAL_ENTRADAH']!='')
											{
												$HS11=(string)$roww['FINAL_ENTRADAH'].':'.(string)$m[$roww['FINAL_ENTRADAM']].':00';
											}
											else
											{
												$HS11="---";
											}
											if($roww['INICIO_SALIDAH']!='')
											{
												$HE12=(string)$roww['INICIO_SALIDAH'].':'.(string)$m[$roww['INICIO_SALIDAM']].':00';
											}
											else
											{
												$HE12="---";
											}
					
					
											$HS12=(string)$HoS2.':'.(string)$m[$roww['FINAL_SALIDAM']].':00';
											
											$r1=horario($HoraMarcacion1,$HE11,$HS11,$HE12,$HS12);
											if($r1==1){$v11=$HoraMarcacion1;}
											if($r1==2 and $v12==""){$v12=$HoraMarcacion1;} else{if($v13=="" and  $r1==2){$v13=$HoraMarcacion1;}else{if($r1==2)$v12=$HoraMarcacion1;}}
											if($r1==3 and $v13==""){$v13=$HoraMarcacion1;}else{if($v12=="" and $r1==3){$v12=$v13;
											$v13=$HoraMarcacion1;}else{if($r1==3)$v13=$HoraMarcacion1;}}
											if($r1==4){$v14=$HoraMarcacion1;}
								
											if($aux3==$t2)
											{
													$nocturno=CompararHoras($HE11,$HS12);
													if($nocturno==1)
													{
														$p1=CompararHoras($v14,"11:00:00"); 
															if($p1!=1)
															{
															
															}
															else{
															$v11=$v14;
															}
														$v14="";
														$pri=0;
														//// echo "/*horario nocturno*/";
														$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
														$i2 = strtotime($fehaM11 ."+ 1 days"); 
														$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
														$nro=$row['NRO_TRABAJADOR'];
														//// echo "/*$nro*/";
													//	// echo "/*$fec*/";
														 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
														
															$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
															' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
															' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
															' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlauxn.
															' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
														//	// echo "/*$sqla*/";
															$resultadoq=mysql_query($sqla,$_SESSION['BD']); 
																while ($rowq = mysql_fetch_array($resultadoq)){
																$minut="";
																if((int)$rowq['MINUTO']<10)
																{
																 $minut="0".(string)$rowq['MINUTO'];
																}
																else
																{
																  $minut=(string)$rowq['MINUTO'];
																}
																$horam="";
																if((int)$rowq['HORA']<10)
																{
																	$horam="0".(string)$rowq['HORA'];
																}
																else
																{
																	$horam=(string)$rowq['HORA'];
																}
																$HoraMarcacion1=(string)$horam.':'.(string)$minut.':00';
																//// echo "/*$HoraMarcacion1*/";
																		$r1=horario($HoraMarcacion1,$HE11,$HS11,$HE12,$HS12);
																if($pri==0){
																	if($r1==4){
																				$ttr=CompararHoras($HoraMarcacion1,"11:00:00"); 
																				if($ttr!=1)
																				{
																				$v14=$HoraMarcacion1;$pri=1;
																				// $HorasE=restaHoras($HSS2,$v4);
																				// $HorasE=HorasExtras($hextras);
																				}
																				//$v14=$HoraMarcacion1;$pri=1;
																			}
																	
																	}
																
															//	// echo "/*$v14*/";
															}
													
													}
													else
														{
															
															if($v14=="" || $v14=="---")
															{
																$fehaM1=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
																$i2 = strtotime($fehaM1 ."+ 1 days"); 
																$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
																$nro=$row['NRO_TRABAJADOR'];
																
																 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
														
																$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
																' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
																' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
																' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlauxn.
																' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
																	
																	$resultadoq=mysql_query($sqla,$_SESSION['BD']); 
																	while ($rowq = mysql_fetch_array($resultadoq)){
																		$minut="";
																		if((int)$rowq['MINUTO']<10)
																		{
																		 $minut="0".(string)$rowq['MINUTO'];
																		}
																		else
																		{
																		  $minut=(string)$rowq['MINUTO'];
																		}
																		$horam="";
																		if((int)$rowq['HORA']<10)
																		{
																			$horam="0".(string)$rowq['HORA'];
																		}
																		else
																		{
																			$horam=(string)$rowq['HORA'];
																		}
																		$HoraMarcacion1=(string)$horam.':'.(string)$minut.':00';
																		
															
																		$r1=horario($HoraMarcacion1,$HE11,$HS11,$HE12,$HS12);
																		
																			if($r1==1){
																						$ttr=CompararHoras($HoraMarcacion1,"02:30:00"); 
																						if($ttr!=1)
																						{
																						$v14=$HoraMarcacion1;
																						// $HorasE=restaHoras($HSS2,$v4);
																						// $HorasE=HorasExtras($hextras);
																						}
																						//$v14=$HoraMarcacion1;$pri=1;
																					}
																			
																			
																		
																	//	// echo "/*$v14*/";
																	}
																	
															}
														}
													
													$tick=0;
													if($roww['COD_TIPOHORARIO']==1)
													{
														$k1="HE:".$v11.",HS:".$v14;
														$horarioOficial1="HE:".$HE11.",HS:".$HS12;
														$horasDeHor=restaHoras($HE11,$HS12)	;
														$horasDeHorario=(double)HorasExtras($horasDeHor);
														
														if($v11!="" and $v14!="")
															{
															$horasEfec=restaHoras($v11,$v14)	;
															$horasEfectivas=(double)HorasExtras($horasEfec);
															
															$ttr=CompararHoras($HE11,$v11); 
															if($ttr==1)
															{
																$recargoNocturno=recargo_nocturno($HE11,$v14,$nocturno);
															}
															else
															{
															$recargoNocturno=recargo_nocturno($v11,$v14,$nocturno);
															}
															
															
															//$recargoNocturno=recargo_nocturno($v11,$v14,$nocturno);
																 if($recargoNocturno!=0)
																{
																	$recargoNo=HorasExtrasN($recargoNocturno);
																	 $recargoNocturno=HorasExtras($recargoNocturno);
																 }
																 else
																 {
																	$recargoNo="0";
																	 $recargoNocturno="0";
																 }
															//$recargoNocturno=HorasExtras($recargoNocturno);
															}
															else
															{
																$horasEfectivas="FP";
																if($v14!="")
																	{
																		$recargoNocturno=recargo_nocturno1($v14);
																		if($recargoNocturno!=0)
																		{
																			$recargoNo=HorasExtrasN($recargoNocturno);
																			$recargoNocturno=HorasExtras($recargoNocturno);
																			
																		}
																		else
																		{
																			$recargoNo="0";
																			$recargoNocturno="0";
																		}	
																	}
																	else
																	{
																		$recargoNo="SR";
																		$recargoNocturno="SR";
																	}
																//$recargoNocturno="SR";
															}
													}
													else
													{
														$k1="HE:".$v11.",HS:".$v12.",HE:".$v13.",HS:".$v14;
														$horarioOficial1="HE:".$HE11.",HS:".$HS11.",HE:".$HE12.",HS:".$HS12;
														$hora1=restaHoras($HE11,$HS11)	;
							
														$hora1=HorasExtras($hora1);
														
														$hora2=restaHoras($HE12,$HS12)	;
														$hora2=HorasExtras($hora2);
														$horasDeHorario=(double)$hora1+(double)$hora2;
														
														if($v11!="" and $v14!="" and $v12!="" and $v13!="")
														{
															$hora11=restaHoras($v11,$v12)	;
															
															$hora11=HorasExtras($hora11);
															
															$hora12=restaHoras($v13,$v14)	;
															$hora12=HorasExtras($hora12);
															$horasEfectivas=(double)$hora11+(double)$hora12;
															
														}
														else
														{ $horasEfectivas="FP";}
														if($v11!="" and $v14!="")
															{
																$ttr=CompararHoras($HE11,$v11); 
																if($ttr==1)
																{
																	$recargoNocturno=recargo_nocturno($HE11,$v14,$nocturno);
																}
																else
																{
																$recargoNocturno=recargo_nocturno($v11,$v14,$nocturno);
																}
															
														//	$recargoNocturno=recargo_nocturno($v11,$v14,$nocturno);
															if($recargoNocturno!=0)
																{
																	$recargoNo=HorasExtrasN($recargoNocturno);
																	$recargoNocturno=HorasExtras($recargoNocturno);
																}
																else
																{
																	$recargoNo="0";
																	$recargoNocturno="0";
																}
															//$recargoNocturno=HorasExtras($recargoNocturno);
															}
															else
															{
																if($v14!="")
																	{
																		$recargoNocturno=recargo_nocturno1($v14);
																		if($recargoNocturno!=0)
																		{
																			$recargoNo=HorasExtrasN($recargoNocturno);
																			$recargoNocturno=HorasExtras($recargoNocturno);
																			
																		}
																		else
																		{
																			$recargoNo="0";
																			$recargoNocturno="0";
																		}	
																	}
																	else
																	{
																		$recargoNo="SR";
																		$recargoNocturno="SR";
																	}
																//$recargoNocturno="SR";
															}
													}
													if($v11!="")
														{
															
															$ch=CompararHoras($v11,$HE11);
															if($ch==1)
															{
																$retraso=restaHoras($HE11,$v11);
															
																$minutoR=minutosAtraso($retraso);
																$tick=1;
															}
															else
															{
																$minutoR=0;
															}
														
														
														}
													else
													{
														$minutoR="SM";
														$tick=1;
													}
													
															if($v13!="")//minutosAtraso
															{
																$ch=CompararHoras($v13,$HE12);
																	if($ch==1)
																	{
																			$retraso=restaHoras($HE12,$v13);
																			$minutoR1=minutosAtraso($retraso);
																			//$tick=1;
																	}
																	else
																	{
																			$minutoR1="0";
																	}
												
												
															}
															else
																{
																		$minutoR1="SM";
																		//$tick=1;
																}
															$minutoT=$minutoR;
															if($minutoR!='SM' && $minutoR1!="SM")
															{
																$minutoT=(int)$minutoR +(int)$minutoR1;
															}	
															if($minutoT=="0" and $minutoR1!="SM")
															{
																$minutoT=$minutoR1;
															}
														if($v14!="")//HORAS EXTRAS
														{
															$ch1=CompararHoras($v14,$HS12);
															if($ch1==1)
															{
																
																$hextras=restaHoras($HS12,$v14);
																$minutoE=HorasExtrasN($hextras);
																//$minutoE=minutosAtraso($extra);
															}
															else
															{
																$minutoE="0";
															}
								
								
														}
														else
														{
														$minutoE="0";
														}
														
														if((int)$roww['RETRASO']==1)
														{
															$validacionRetraso=2;
															$nvalidacionRetraso="JUSTIFICADO";
															$tick=0;
														}
														if((int)$roww['RETRASO']==0)
														{
																$validacionRetraso=1;
																$nvalidacionRetraso="SIN ACCION";
																//$tick=1;
														}
														if((int)$roww['RETRASO']==2)
														{
															
															$validacionRetraso=3;
															$nvalidacionRetraso="INJUSTIFICADO";
															$tick=0;
														}
														
														$nocturno=0;
														if($roww['horariodia']==0)
														{
															$horasDeHorario=0;
															$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
															$i2 = strtotime($fehaM11 ."- 1 days"); 
															$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
														 //$i1 = strtotime($fec); 
														// $nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
														
														// if($nombreDia==0)
														// {$nombreDia=7;}
														//if($nn1==0)
														//{
														$sqlw1='SELECT mv.COD_PERSONAL,mv.COD_HORARIO as horariodia ,'.
															' h.*'.
													
														'  FROM `marcacion_valida` mv  inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '. 
														' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO  '.
														
														'   WHERE   mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.(string) date("Y",$i2).' and mv.MES='.(string)date("m",$i2).' and mv.DIA='.(string)date("d",$i2).' order by mv.COD_PERSONAL,mv.GESTION,mv.MES,mv.DIA ASC'; 
															//// echo "/*---------$sqlw1*/";
															// $sqltn = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
															// ' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
															// '   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$row['NRO_TRABAJADOR'];
															
															$restn1=mysql_query($sqlw1,$_SESSION['BD']);  
															if ($rowtn = mysql_fetch_array($restn1)){
																if((int)$rowtn['INICIO_ENTRADAH']<10)
																	{
																		$HoE1="0".(string)$rowtn['INICIO_ENTRADAH'];
																	}
																	else
																	{
																		$HoE1=(string)$rowtn['INICIO_ENTRADAH'];
																	}
																	if((int)$rowtn['FINAL_SALIDAH']<10)
																	{
																		$HoS2="0".(string)$rowtn['FINAL_SALIDAH'];
																	}
																	else
																	{
																		$HoS2=(string)$rowtn['FINAL_SALIDAH'];
																	}
																$HE1=(string)$HoE1.':'.(string)$m[$rowtn['INICIO_ENTRADAM']].':00';
																$HS2=(string)$HoS2.':'.(string)$m[$rowtn['FINAL_SALIDAM']].':00';
																$nocturno=CompararHoras($HE1,$HS2);
																	if($nocturno==1)
																	{
																		$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
																		$i3 = strtotime($fehaM11); 
																		$fec1=(string) date("Y",$i3)."-".(string)date("m",$i3)."-".(string)date("d",$i3);
																		//// echo "/*es antiguo---------------------*/";
																		//// echo "/*$sqlw1*/";
																		$sqla2 = 'update  marcacion_valida set ACTIVO=0 where COD_PERSONAL='.$row['NRO_TRABAJADOR'].'  and GESTION="'.(string) date("Y",$i3).'" and MES="'.(string)date("m",$i3).'" and DIA="'.(string)date("d",$i3).'"';
																				$restn3=mysql_query($sqla2,$_SESSION['BD']); 
																				
																	//	// echo "/*$sqla2 */";
																		//// echo "/*$nombreDia*/";
																		//// echo "/*---------------$sqltn*/";
																		
																	}
																	else
																	{
																	$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
																	$i3 = strtotime($fehaM11); 
																		$fec1=(string) date("Y",$i3)."-".(string)date("m",$i3)."-".(string)date("d",$i3);
																	$sqla2 = 'update  marcacion_valida set ACTIVO=1 where COD_PERSONAL='.$row['NRO_TRABAJADOR'].'  and GESTION="'.(string) date("Y",$i3).'" and MES="'.(string)date("m",$i3).'" and DIA="'.(string)date("d",$i3).'"';
																				$restn3=mysql_query($sqla2,$_SESSION['BD']);
																//	// echo "/*CHEQUEAR ESTIO---------------------*/";
																//	// echo "/*$sqla2 */";																				
																	$nocturno=0;
																	}
																	
																// // echo "/*$HE1*/";
																// // echo "/*$HS2*/";
																
															}
															
															
															$HE11='---';
															$HS12='---';
															$minutoR=0;
															$minutoE=0;
															$tick=1;
														}
															$nocturno=0;
											 if($nocturno==0)
											{
												$banderaAmarilla=0;
												if($v11=="" && $v14!="")
													{
														$tick=3;
														$banderaAmarilla=1;
													}
													if($v14=="" && $v11!="")
													{
														$tick=3;
														$banderaAmarilla=1;
													}
										
											if($minutoT!="F" AND $minutoT!="SM" && $banderaAmarilla==0)
											{
												
												if((int)$toleranciaSemaforo>=(int)$minutoT)
												{
													$tick=0;
									
												}
												else
												{
													$tick=3;
													if((int)$roww['RETRASO']==1)
														{
															$validacionRetraso=2;
															$nvalidacionRetraso="JUSTIFICADO";
															$tick=0;
														}
														if((int)$roww['RETRASO']==0)
														{
																$validacionRetraso=1;
																$nvalidacionRetraso="SIN ACCION";
																//$tick=1;
														}
														if((int)$roww['RETRASO']==2)
														{
															
															$validacionRetraso=3;
															$nvalidacionRetraso="INJUSTIFICADO";
															$tick=0;
														}
												}
												if($banderaAmarilla==1)
												{
													if((int)$roww['FALTA']==1)
													{
														$validacionFalta=1;
														$nvalidacionFalta="JUSTIFICADO";
														$tick=0;
														
													}
													if((int)$roww['FALTA']==0)
													{
															$validacionFalta=0;
														$nvalidacionFalta="SIN ACCION";
														//$tick=1;
															
													}
													if((int)$roww['FALTA']==2)
													{
														$validacionFalta=3;
														$nvalidacionFalta="INJUSTIFICADO";
														$tick=0;
													}
													$validacionRetraso=1;
													$nvalidacionRetraso="SIN ACCION";
												}
											}
											else
											{
												if((int)$roww['FALTA']==1)
													{
														$validacionFalta=1;
														$nvalidacionFalta="JUSTIFICADO";
														$tick=0;
														$minutoT=0;		
														$minutoR1=0;
														
													}
													if((int)$roww['FALTA']==0)
													{
															$validacionFalta=0;
														$nvalidacionFalta="SIN ACCION";
														//$tick=1;
														
													}
													if((int)$roww['FALTA']==2)
													{
														$validacionFalta=3;
														$nvalidacionFalta="INJUSTIFICADO";
														$tick=0;
													}
												$validacionRetraso=1;
												$nvalidacionRetraso="SIN ACCION";
											}
											if($horarioPersona==1)
											{
											
												//$tick=0;
												$fechanueva="2015-09-01";
													if(strtotime(date($fechanueva)) > strtotime( date($row1['GESTION']."-".$row1['MES']."-".$row1['DIA'])))
													{	
														$tick=0;
													}
													else
													{
													
														//////////modificar aqui
														if($roww['COD_TIPOHORARIO']==2)
															{
																if($v11!="" and $v13!=""){
																	$tick=0;
																}
																else
																{
																	if((int)$roww['FALTA']==1)
																	{
																		$validacionFalta=1;
																		$nvalidacionFalta="JUSTIFICADO";
																		$tick=0;
																		$minutoT=0;		
																		$minutoR1=0;
																		
																	}
																	else
																	{
																		$tick=3;
																	}
																	
																}
															}
														else
														{
															if($v11!=""){
																	$tick=0;
																}
																else
																{
																	if((int)$roww['FALTA']==1)
																	{
																		$validacionFalta=1;
																		$nvalidacionFalta="JUSTIFICADO";
																		$tick=0;
																		$minutoT=0;		
																		$minutoR1=0;
																		
																	}
																	else
																	{
																		$tick=3;
																	}
																}
														}
													}
											}
											else
											{
												$fechanueva="2015-09-01";
												if(strtotime(date($fechanueva)) > strtotime( date($row1['GESTION']."-".$row1['MES']."-".$row1['DIA'])))
												{	
													
												}
												else
												{
													if($roww['COD_TIPOHORARIO']==2)
													{
															if($v11!="" and $v12!="" and $v13!="" and  $v14!=""){
																	//$tick=0;
															}
															else
															{
																if($v11=="" and $v12=="" and $v13=="" and  $v14==""){
																	if((int)$roww['FALTA']==1)
																	{
																		$validacionFalta=1;
																		$nvalidacionFalta="JUSTIFICADO";
																		$tick=0;
																		$minutoT=0;		
																		$minutoR1=0;
																		
																	}
																	else
																	{$tick=1;}
																}
																else
																{
																	if((int)$roww['FALTA']==1)
																	{
																		$validacionFalta=1;
																		$nvalidacionFalta="JUSTIFICADO";
																		$tick=0;
																		$minutoT=0;		
																		$minutoR1=0;
																		
																	}else{
																	$tick=3;}
																}
																
															}
													}
												}
												
												
											////////////////////////
											}
											$minutoT=$minutoT-(int)$roww['MIN_JUSTIFICADOS'];
											
											$nocturno=CompararHoras($v11,$v14);
											modificar($row1['NRO_TRABAJADOR'],$row1['GESTION'],$row1['MES'],$row1['DIA'],$v11,$v12,$v13,$v14,$recargoNocturno,$nocturno,$roww['BANDERA']);
											$color="SI";
											$codcolor=2;
											if($roww['APROBADOR']!=""){$color="APROBADO";$codcolor=1;}
											if($v11==""){$v11="---";}
											if($v12==""){$v12="---";}
											if($v13==""){$v13="---";}
											if($v14==""){$v14="---";}
											$recargoN="";
											$hen="";
											if($roww['BANDERA']==0)
											{
												if($recargoNocturno=='SR')
												{
													$recargoN='';
												}
												else{
													if($v11!="---" and $v14!="---"){
														if($roww['APROBADOR']!="")
														{
															$recargoN=$recargoNocturno;
														}
													
													}
												
												}
											
												if($nocturno==1)
												{
													if($v11!="---" and $v14!="---"){
														if($roww['APROBADOR']!="")
														{
															$hen=1;
														}
													
													}
												}
												else
												{
													$hen="";
												}
											}
											else
											{
												$recargoN=$roww['RECARGO_NOCTURNO'];
												$hen=$roww['HEN'];
											}
											$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
											
								        $sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
												$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
												$toferiado = mysql_fetch_array($rferiado);
												$tferiado=$toferiado['tot'];
											if($prueba==1 || $tferiado!=0)
												{
														$minutoT=0;		
														$minutoR1=0;
														$she1="";
														$she2="";
														$c1=1;
														$tick=0;
														$m1=substr( $v11 , 0, strlen($v11) - 3);
														if($m1!=""){$she1=$m1;$c1++;}
														
														$m2=substr( $v12 , 0, strlen($v12) - 3);
														if($m2!=""){if($c1==1){$she1=$m2;$c1++;} else{$she2=$m2;}}
														$m3= substr( $v13 , 0, strlen($v13) - 3);
														if($m3!=""){if($c1==1){$she1=$m3;$c1++;} else{$she2=$m3;}}
														 $m4=substr( $v14 , 0, strlen($v14) - 3);
														if($m4!=""){if($c1==1){$she1=$m4;$c1++;} else{$she2=$m4;}}
														
														if($she1!="" and $she2!="")
														{
															$horaextraordinario=restaHoras($she1,$she2)	;
															$horaextraordinario=(double)HorasExtras($horaextraordinario);
															$minutoE=$horaextraordinario;
														}
												}
												$fechaini=$fehaM1;
												$justificacion=traerjustificacion($fechaini,$row1['NRO_TRABAJADOR']);
													if((int)$roww['horariodia']==31)
													{
														$minutoT=0;		
														$minutoR1=0;
														$she1="";
														$she2="";
														$c1=1;
														
														$m1=substr( $v11 , 0, strlen($v11) - 3);
														if($m1!=""){$she1=$m1;$c1++;}
														
														$m2=substr( $v12 , 0, strlen($v12) - 3);
														if($m2!=""){if($c1==1){$she1=$m2;$c1++;} else{$she2=$m2;}}
														$m3= substr( $v13 , 0, strlen($v13) - 3);
														if($m3!=""){if($c1==1){$she1=$m3;$c1++;} else{$she2=$m3;}}
														 $m4=substr( $v14 , 0, strlen($v14) - 3);
														if($m4!=""){if($c1==1){$she1=$m4;$c1++;} else{$she2=$m4;}}
														
														if($she1!="" and $she2!="")
														{
															$horaextraordinario=restaHoras($she1,$she2)	;
															$horaextraordinario=(double)HorasExtras($horaextraordinario);
															$minutoE=$horaextraordinario;
														}
													}
													 $licencia=Licencia($codigo,$row1['GESTION'],$row1['MES'],$row1['DIA']);
													 if($licencia==1)
													 {
														$validacionFalta=3;
														$nvalidacionFalta="LICENCIA";
														$tick=2;
														$minutoT=0;		
														$minutoR1=0;
														$aprobadorfaltas=LicenciaAprobador($codigo,$row1['GESTION'],$row1['MES'],$row1['DIA']);
														$sqll4 = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$row1['NRO_TRABAJADOR'].' and GESTION='.$row1['GESTION'].' and MES='.$row1['MES'].' and DIA='.$row1['DIA'];
															   //// echo "/*$sqll4*/";
														 $resultado1=mysql_query($sqll4,$_SESSION['BD']); 
													 }
												if($horarioPersona==3)
												{
													$tick=0;
												}
												/////////////////////////////////////////////////////////////
												$diax=$row1['DIA'];
												if((int)$diax<10)
												{
												$diax="0".$row1['DIA'];
												}
												$mesx=$row1['MES'];
												if((int)$mesx<10)
												{
												$mesx="0".$row1['MES'];
												}
										$fehaHistorico= $row1['GESTION']."-".$mesx."-". $diax;
												//$fehaHistorico= $row1['GESTION']."-". $row1['MES']."-". $row1['DIA'];
												$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
												' where COD_PERSONAL="'. $row1['NRO_TRABAJADOR']. '" and FECHA="'.$fehaHistorico.'"'; 
												// // echo "/*-------------Historico-->$sqlhisto-------------------*/";
												$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
												$fecha_marcacionEditada="";
												$fecha_cambioJustificacion="";
												$fechaHorasExtras="";
												$fechaAprobarHorasExtras="";
												if ($rowq = mysql_fetch_array($resHisto)){
													  if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
														 {
															  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
														 }
														 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
														 {
															  if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
														 }
														 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
														 {
															 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
														 }								 
														if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
														 {
															 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
														 }	
												}
												///////////////////////////////////////////////////////////////
												array_push($data, 
												array( 	"codigo"		=> $row1['NRO_TRABAJADOR'], 
												"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row1['NRO_TRABAJADOR'], $row1['GESTION'], $row1['MES'], $row1['DIA']),
													"nombre" 	=>   "",
													"horarioOficial"		=> $roww['horariodia'],
													"nombreHorario" => $roww['NOMBRE_HORARIO'],
													"IEH"		=> $roww['INICIO_ENTRADAH'],
													"IEM"		=> $roww['INICIO_ENTRADAM'],
													"IFH"		=> $roww['FINAL_ENTRADAH'],
													"IFM"		=> $roww['FINAL_ENTRADAM'],
													"horaEntradaR" => $row1['HORA'],
													"minutoEntradaR" => $row1['MINUTO'],
													"segundoEntradaR" => $row1['SEGUNDO'],
													// "marcacion"		=>$horario_Real
													"marcacion"		=> $k1,
													"horario_oficial" =>$horarioOficial1,
													"cod_cargo"    => $roww['COD_CARGO'],
													"nombrecargo"    => $roww['DESCRIPCION'],
													"nombrecosto"    => $roww['cDescripcion'],
													"nombresubcentro"    => $roww['sDescripcion'],
													"nombreunidad"    => $roww['uDescripcion'],
													"cod_centro"    => $roww['COD_CENTRO'],
													"gestion"  => $row1['GESTION'],
													"mes"  => $row1['MES'],
													"dia"  => $row1['DIA'],
													"hiem"  => substr( $v11 , 0, strlen($v11) - 3),
													"hism"  => substr( $v12 , 0, strlen($v12) - 3),
													"hfem"  => substr( $v13 , 0, strlen($v13) - 3),
													"hfsm"  => substr( $v14 , 0, strlen($v14) - 3),
													"minuto" =>$minutoT,
													"minuto1" =>$minutoR1,
													"he"		=> substr( $HE11 , 0, strlen($HE11) - 3),
													"hs"		=> substr( $HS11 , 0, strlen($HS11) - 3),
													"he1"		=>  substr( $HE12 , 0, strlen($HE12) - 3),
													"hs1"		=>  substr( $HS12 , 0, strlen($HS12) - 3),
													"horasExtras" =>$minutoE,
													"fechaMarcacion"		=>$fehaM, 
													"fechaMarcacion1"		=>$fehaM1, 
													"Ndia"		=>$Ndia,
													"tick"		=>$tick,
													"validacionRetraso"=>$validacionRetraso,
													"nvalidacionRetraso"=>$nvalidacionRetraso,
													"validacionFaltas"=>$validacionFalta,
												 "nvalidacionFaltas"=>$nvalidacionFalta,
													// "validacionFaltas"=>1,
														// "nvalidacionFaltas"=>"SIN ACCION",
														"validador"=>$roww['VALIDADOR'],
														"horasdehorario"=>$horasDeHorario,
														"horasEfectivas"=>$horasEfectivas,
														"HEN"=>$hen,
													"HEF"=>$roww['HEF'],
													"HED"=>$roww['HED'],
													"editorHE"=>$roww['VALIDADORHE'],
													"recargoNocturno"=>$recargoNocturno,
													"editorRN"=>$recargoN,
													"editorRNM"=>$recargoNo,
													"aprobador" => $roww['APROBADOR'],
													"color" =>$color,
													
										
													"colorr" =>$color,
													"codcolor" =>$codcolor,
													"aprob" =>$aprob,
													"justificacion"=>$justificacion,
													"marcacionEnt1Edit" =>$roww['HE1E'],
													"marcacionSal1Edit" =>$roww['HS1E'],
													"marcacionEnt2Edit" =>$roww['HE2E'],
													"marcacionSal2Edit" =>$roww['HS2E'],
												"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
													"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
													"fechaHorasExtras" => $fechaHorasExtras,
													"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
													));
										
												}
											}
								}
								$aux3++;
				
							}
						}
						
						if($aux==$tot)
						{
						for($i=$fechaii;$i<=$fechaf;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
						 $licencia=0;
						$aprobadorfaltas="";
						$vacaFalta=1;
						$nomVacaFalta="SIN ACCION";
						$horasDeHorario=0;
						$valores = explode ("-", $i); 
							$gestion = $valores[0] ;
							$mes = $valores[1] ;
							$dia = $valores[2] ;
							
							 $licencia=Licencia($codigo,$gestion,$mes,$dia);
							 $G=PerteneAGrupo($codigo);
								if($G!=0)
								{		
										$Gp=PerteneNombreGrupo($codigo);
										$horar=obtenerHorarioGrupo($Gp,$gestion,$mes,$dia);
										if($horar!="")
										{
										$sqlac = 'update horario_personal  set COD_HORARIO='.$horar.' where COD_PERSONAL='.$codigo.' and ACTIVO=1';
										//// echo "/*$sqlac*/";
										$res=mysql_query($sqlac,$_SESSION['BD']); } 		
								}
								 $HEE1="";
								 $HSS1="";
								 $HEE2 ="";
								 $HSS2="";
								 $i1 = strtotime($i); 
								$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
								if($nombreDia==0)
								{$nombreDia=7;}
								$Ndia=$d[$nombreDia];
							 $sqla2 = 'SELECT p.COD_REGIONAL,p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
								' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
								 '   WHERE hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador.' and  date(p.FECHA_INGRESO) <= date("'.$gestion.'-'.$mes.'-'.$dia.'")';
								$res2=mysql_query($sqla2,$_SESSION['BD']);
								if ($row3 = mysql_fetch_array($res2)){
									$nn=existe1($codTrabajador,$gestion,$mes,$dia);
									//////////////////////////////////////////////////
						$feriado=es_feriado($gestion,$mes,$dia);
						 $sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row3['COD_REGIONAL'];
												
												$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
												$toferiado = mysql_fetch_array($rferiado);
												$tferiado=$toferiado['tot'];
											if($tferiado!=0)
											{
												$sqlferiado = 'SELECT APROBADOR as total from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												 $resultadofer=mysql_query($sqlferiado,$_SESSION['BD']);
												
												$totfer = mysql_fetch_array($resultadofer);
												$aprobadorFeriado=$totfer['total'];
												
												$sqljustificacion = 'SELECT MOTIVO as total from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												 $resultadoferjust=mysql_query($sqljustificacion,$_SESSION['BD']);
												
												$totferjust = mysql_fetch_array($resultadoferjust);
												$justificacion=$totferjust['total'];
												$fechajustificación=$gestion."-".$mes."-".$dia;
												$fechajustificación1=$gestion."/".$mes."/".$dia;
												////////////////////////////
												$cod_trabajador=$row['NRO_TRABAJADOR'];
												$scount="select count(COD_PERSONAL) as tot from historico_justificacion where COD_PERSONAL='$cod_trabajador' and FECHA='$fechajustificación' ";
												//// echo "/*count-->$scount*/";
												$resultado1=mysql_query($scount,$_SESSION['BD']);  
												
												$totAsig = mysql_fetch_array($resultado1);
												$tAsig=$totAsig['tot'];
												////////////////////////////
												if($tAsig==0)
												{
													$sqljust = "insert into `historico_justificacion`(MOTIVO,FECHA,FECHA_APROBACION ,COD_PERSONAL) values('$justificacion','$fechajustificación','$fechajustificación1', ".$row['NRO_TRABAJADOR'].")";
			
													$resultadojus=mysql_query($sqljust,$_SESSION['BD']); 
												}
												else
												{
													$sqlreg = "update historico_justificacion set MOTIVO='$justificacion', FECHA_APROBACION='$fechajustificación1' where COD_PERSONAL='$cod_trabajador' and FECHA='$fechajustificación'";
													IF($resulreg = mysql_query($sqlreg , $_SESSION['BD']))
													{
													}
												}
												$sqlli = 'update `marcacion_valida` set FALTA=1,VALIDADOR="'.$aprobadorFeriado. '" where COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													   //// echo "/*$sqlli*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']); 
												$vacaFalta=1;
												$tick=0;
												$nomVacaFalta="JUSTIFICADO";
											}
						/////////////////////////////////////////////////
									 if($nn==0)
										{
											$tick=1;
											$horarioPersona=$row3['COD_HORARIOPERSONA'];
											$tHorario=$row3['COD_HORARIO'];
											$codHorario=$row3['COD_TIPOHORARIO'];
											$nombreHorario1=$row3['NOMBRE_HORARIO'];
											if((int)$row3['INICIO_ENTRADAH']<10)
											{
												$HoE1="0".(string)$row3['INICIO_ENTRADAH'];
											}
											else
											{
												$HoE1=(string)$row3['INICIO_ENTRADAH'];
											}
											if((int)$row3['FINAL_SALIDAH']<10)
											{
												$HoS2="0".(string)$row3['FINAL_SALIDAH'];
											}
											else
											{
												$HoS2=(string)$row3['FINAL_SALIDAH'];
											}
											$HEE1=(string)$HoE1.':'.(string)$m[$row3['INICIO_ENTRADAM']].':00';
											$HSS2=(string)$HoS2.':'.(string)$m[$row3['FINAL_SALIDAM']].':00';
											if($codHorario==1)
											{
												$horasDeHor=restaHoras($HEE1,$HSS2)	;
												$horasDeHorario=(double)HorasExtras($horasDeHor);
												$HSS1="---";
												$HEE2="---";
											}
											else
											{
											
												$HSS1=(string)$row3['FINAL_ENTRADAH'].':'.(string)$m[$row3['FINAL_ENTRADAM']].':00';
												$HEE2=(string)$row3['INICIO_SALIDAH'].':'.(string)$m[$row3['INICIO_SALIDAM']].':00';
												$hora1=restaHoras($HEE1,$HSS1)	;
							
														$hora1=HorasExtras($hora1);
														
														$hora2=restaHoras($HEE2,$HSS2)	;
														$hora2=HorasExtras($hora2);
														$horasDeHorario=(double)$hora1+(double)$hora2;
											
											}
											if($horarioPersona==1)
											{
												//$tick=0;
											}
											 if($licencia==1)
												{
													$aprobadorfaltas=LicenciaAprobador($codigo,$gestion,$mes,$dia);
													$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													  // // echo "/*$sqlli*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']);  
												$vacaFalta=3;
													$tick=2;

												$nomVacaFalta="LICENCIA";
												}
												$fechaini=$gestion."-".$mes."-".$dia;
												$justificacion=traerjustificacion($fechaini,$row3['NRO_TRABAJADOR']);
												if($horarioPersona==3)
												{
													$tick=0;
												}
											/////////////////////////////////////////////////////////////
												$fehaHistorico= $gestion."-". $mes."-". $dia;
												$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
												' where COD_PERSONAL="'. $row3['NRO_TRABAJADOR']. '" and FECHA="'.$fehaHistorico.'"'; 
												//// echo "/*-------------Historico-->$sqlhisto-------------------*/";
												$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
												$fecha_marcacionEditada="";
												$fecha_cambioJustificacion="";
												$fechaHorasExtras="";
												$fechaAprobarHorasExtras="";
												if ($rowq = mysql_fetch_array($resHisto)){
													   if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
														 {
															  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
														 }
														 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
														 {
															 if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
														 }
														 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
														 {
															 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
														 }								 
														if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
														 {
															 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
														 }	
												}
											//////////////////////////////////////////////////////////////
											array_push($data, 
													array( 	"codigo"		=>$row3['NRO_TRABAJADOR'], 
													"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row3['NRO_TRABAJADOR'], $gestion, $mes, $dia),
														"nombre" 	=>   "",
														"horarioOficial"		=> $tHorario,
														"nombreHorario" => $nombreHorario1,
														"IEH"		=> "",
														"IEM"		=> "",
														"IFH"		=>"",
														"IFM"		=> "",
														"horaEntradaR" => "",
														"minutoEntradaR" => "",
														"segundoEntradaR" => "",
														"marcacion"		=> "",
														"horario_oficial" =>"",
														"cod_cargo"    => "",
															"nombrecargo"    => "",
															"nombrecosto"    => "",
															"nombresubcentro"    => "",
															"nombreunidad"    => "",
															"cod_centro"    => "",
															"gestion"  => "",
															"mes"  => "",
															"dia"  => "",
														"hiem"  => "",
														"hism"  => "",
														"hfem"  => "",
														"hfsm"  => "",
														"minuto" =>"F",
														"minuto1" =>"F",
														"he"		=>  substr( $HEE1 , 0, strlen($HEE1) - 3),
														"hs"		=> substr( $HSS1 , 0, strlen($HSS1) - 3),
														"he1"		=> substr( $HEE2 , 0, strlen($HEE2) - 3),
														"hs1"		=>  substr( $HSS2 , 0, strlen($HSS2) - 3),
														"horasExtras" =>"F",
														"fechaMarcacion"		=>$dia."/".$mes."/".$gestion, 
														"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
														"Ndia"		=>$Ndia,
														"tick"		=>$tick,
														"validacionRetraso"=>1,
														"nvalidacionRetraso"=>"SIN ACCION",
														"validacionFaltas"=>$vacaFalta,
												"nvalidacionFaltas"=>$nomVacaFalta,
												"validador"=>$aprobadorfaltas,
														
														"horasdehorario"=>$horasDeHorario,
														"horasEfectivas"=>"F",
														"HEN"=>"",
														"HEF"=>"",
														"HED"=>"",
														"editorHE"=>"",
														"recargoNocturno"=>"",
														"editorRN"=>"",
														"editorRNM"=>"",
														"aprobador" => "",
													"color" =>"SI",
													"colorr" =>"SI",
													"codcolor" =>"2",
													"aprob" =>$aprob,
													"justificacion" =>$justificacion,
													"marcacionEnt1Edit" =>0,
													"marcacionSal1Edit" =>0,
													"marcacionEnt2Edit" =>0,
													"marcacionSal2Edit" =>0,
													"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
												"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
												"fechaHorasExtras" => $fechaHorasExtras,
												"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,	
													));
											
											
													 existe($codTrabajador,$gestion,$mes,$dia,$tHorario,$row['COD_CARGO'],$row['COD_CENTRO'],"","","","","SR",2);
										}
								else{
											$tick1=0;
											 if($licencia==1)
											{
												$aprobadorfaltas=LicenciaAprobador($codigo,$gestion,$mes,$dia);
												$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']);  
												
											}
											$sqlx2 = 'SELECT   mv.COD_PERSONAL as codPer,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,mv.APROBADOR,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
											' h.FINAL_ENTRADAM,h.COD_HORARIOPERSONA,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv '.
											' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
											' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
											' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE   '.
											'  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
										//	// echo "/*-----------------------$sqlx2*/";
											$resultadoreg52 = mysql_query($sqlx2 , $_SESSION['BD']);
											while ($row52 = mysql_fetch_array($resultadoreg52))
												{
												$horarioPersona=$row52['COD_HORARIOPERSONA'];
												if($row52['FALTA']==1)
												{
												$validacionFalta=2;
												$nvalidacionFalta="JUSTIFICADO";
											
													$tick1=0;
												}
												if($row52['FALTA']==0)
												{
													$validacionFalta=1;
												$nvalidacionFalta="SIN ACCION";
												$tick1=1;
														
												}
												if($row52['FALTA']==2)
												{
												$validacionFalta=3;
												$nvalidacionFalta="INJUSTIFICADO";
										
												$tick1=0;
												}
												if($row52['FALTA']==3)
												{
													$validacionFalta=4;
													$nvalidacionFalta="LICENCIA";
													$licencia=1;
													$tick1=0;
												}
												if((int)$row52['INICIO_ENTRADAH']<10)
												{
													$HoE1="0".(string)$row52['INICIO_ENTRADAH'];
												}
												else
												{
													$HoE1=(string)$row52['INICIO_ENTRADAH'];
												}
												if((int)$row52['FINAL_SALIDAH']<10)
												{
													$HoS2="0".(string)$row52['FINAL_SALIDAH'];
												}
												else
												{
													$HoS2=(string)$row52['FINAL_SALIDAH'];
												}
												$HEE11=(string)$HoE1.':'.(string)$m[$row52['INICIO_ENTRADAM']].':00';
												$HSS21=(string)$HoS2.':'.(string)$m[$row52['FINAL_SALIDAM']].':00';
												if($row52['COD_TIPOHORARIO']==1)
												{
													$horasDeHor=restaHoras($HEE11,$HSS21)	;
													$horasDeHorario=(double)HorasExtras($horasDeHor);
													$HSS11="---";
													$HEE21="---";
												}
												else
												{
												
													$HSS11=(string)$row52['FINAL_ENTRADAH'].':'.(string)$m[$row52['FINAL_ENTRADAM']].':00';
													$HEE21=(string)$row52['INICIO_SALIDAH'].':'.(string)$m[$row52['INICIO_SALIDAM']].':00';
													$hora1=restaHoras($HEE11,$HSS11)	;
							
														$hora1=HorasExtras($hora1);
														
														$hora2=restaHoras($HEE21,$HSS21)	;
														$hora2=HorasExtras($hora2);
														$horasDeHorario=(double)$hora1+(double)$hora2;
												
												}
												if($horarioPersona==1)
													{
													//	$tick1=0;
													}
												if($licencia==1)
												{
												$tick1=2;
												}
												$color="SI";
												$codcolor=2;
												if($row52['APROBADOR']!=""){$color="APROBADO";$codcolor=1;}
												$fechaini=$gestion."-".$mes."-".$dia;
												$justificacion=traerjustificacion($fechaini,$row52['codPer']);
												if($horarioPersona==3)
												{
													$tick1=0;
												}
													/////////////////////////////////////////////////////////////
												$fehaHistorico= $gestion."-". $mes."-". $dia;
												$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
												' where COD_PERSONAL="'. $row52['codPer']. '" and FECHA="'.$fehaHistorico.'"'; 
												// // echo "/*-------------Historico-->$sqlhisto-------------------*/";
												$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
												$fecha_marcacionEditada="";
												$fecha_cambioJustificacion="";
												$fechaHorasExtras="";
												$fechaAprobarHorasExtras="";
												if ($rowq = mysql_fetch_array($resHisto)){
													 if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
														 {
															  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
														 }
														 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
														 {
															  if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
														 }
														 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
														 {
															 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
														 }								 
														if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
														 {
															 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
														 }	
												}
											//////////////////////////////////////////////////////////////
												array_push($data, 
												array( 	"codigo"		=>$row52['codPer'], 
												"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row52['codPer'], $gestion, $mes, $dia),
													"nombre" 	=>   "",
													"horarioOficial"		=> $row52['horariodia'], 
													"nombreHorario" => $row52['NOMBRE_HORARIO'], 
													"IEH"		=> "",
													"IEM"		=> "",
													"IFH"		=>"",
													"IFM"		=> "",
													"horaEntradaR" => "",
													"minutoEntradaR" => "",
													"segundoEntradaR" => "",
													"marcacion"		=> "",
													"horario_oficial" =>"",
													"cod_cargo"    => $row52['COD_CARGO'],
													"nombrecargo"    => $row52['DESCRIPCION'],
													// "nombrecosto"    => $row52['cDESCRIPCION'],
												 // "nombresubcentro"    => $row52['sDESCRIPCION'],
													// "nombreunidad"    => $row52['uDESCRIPCION'],
													 // "cod_centro"    => $row52['COD_CENTRO'],
														"gestion"  => "",
														"mes"  => "",
														"dia"  => "",
													"hiem"  => "",
													"hism"  => "",
													"hfem"  => "",
													"hfsm"  => "",
													"minuto" =>"F",
													"minuto1" =>"F",
													"he"		=>  substr( $HEE11 , 0, strlen($HEE11) - 3),
													"hs"		=> substr( $HSS11 , 0, strlen($HSS11) - 3),
													"he1"		=> substr( $HEE21 , 0, strlen($HEE21) - 3),
													"hs1"		=>  substr( $HSS21 , 0, strlen($HSS21) - 3),
													"horasExtras" =>"F",
													"fechaMarcacion"		=>$dia."/".$mes."/".$gestion, 
													"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
													"Ndia"		=>$Ndia,
													"tick"		=>$tick1,
													"validacionRetraso"=>1,
													"nvalidacionRetraso"=>"SIN ACCION",
													"validacionFaltas"=>$validacionFalta,
													"nvalidacionFaltas"=>$nvalidacionFalta,
													"validador"=>$row52['VALIDADOR'],
													"horasdehorario"=>$horasDeHorario,
													"horasEfectivas"=>"F",
													"HEN"=>"",
													"HEF"=>"",
													"HED"=>"",
													"editorHE"=>"",
													"recargoNocturno"=>"",
													"editorRN"=>"",
													"editorRNM"=>"",
													"aprobador" => "",
													"color" =>$color,
													"colorr" =>$color,
													"codcolor" =>$codcolor,
													"aprob" =>$aprob,
													"justificacion"=>$justificacion,
													"marcacionEnt1Edit" =>0,
													"marcacionSal1Edit" =>0,
													"marcacionEnt2Edit" =>0,
													"marcacionSal2Edit" =>0,
													"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
													"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
													"fechaHorasExtras" => $fechaHorasExtras,
													"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
												));
											}
						
									}
								}
						
				}
							
							
							
							
						}
						//// echo "/*aux--$aux*/";
			//// echo "/*tot--$tot*/";
		
			$aux++;
			$con=0;
			
			$horario_Real="";
			$v1="";
			$v2="";
			$v3="";
			$v4="";
			$v11="";
			$v12="";
			$v13="";
			$v14="";
			$min=1;
			
			
		}
				
		$cont3++;	
		
	
	$con++;
	
}       
	
	if($existe==0)
	{
		 
		for($i=$fechaii;$i<=$fechaf;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
		
						 $licencia=0;
						$aprobadorfaltas="";
						$vacaFalta=1;
						$nomVacaFalta="SIN ACCION";
						$horasDeHorario=0;
						$valores = explode ("-", $i); 
							$gestion = $valores[0] ;
							$mes = $valores[1] ;
							$dia = $valores[2] ;
							
							 $licencia=Licencia($codigo,$gestion,$mes,$dia);
							
							  $G=PerteneAGrupo($codigo);
								if($G!=0)
								{		
										$Gp=PerteneNombreGrupo($codigo);
										$horar=obtenerHorarioGrupo($Gp,$gestion,$mes,$dia);
										if($horar!="")
										{
										$sqlac = 'update horario_personal  set COD_HORARIO='.$horar.' where COD_PERSONAL='.$codigo.' and ACTIVO=1';
										//// echo "/*$sqlac*/";
										$res=mysql_query($sqlac,$_SESSION['BD']); } 		
								}
								 $HEE1="";
								 $HSS1="";
								 $HEE2 ="";
								 $HSS2="";
								 $i1 = strtotime($i); 
								$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
								if($nombreDia==0)
								{$nombreDia=7;}
								$Ndia=$d[$nombreDia];
							 $sqla2 = 'SELECT p.COD_REGIONAL,p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
								' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
								 '   WHERE  hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador.' and  date(p.FECHA_INGRESO) <= date("'.$gestion.'-'.$mes.'-'.$dia.'")';
								// // echo "/*hola --->$sqla2*/";
								$res2=mysql_query($sqla2,$_SESSION['BD']);
								if ($row3 = mysql_fetch_array($res2)){
									$nn=existe1($codTrabajador,$gestion,$mes,$dia);
									//////////////////////////////////////////////////
										$feriado=es_feriado($gestion,$mes,$dia);
										 $sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row3['COD_REGIONAL'];
												
												$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
												$toferiado = mysql_fetch_array($rferiado);
												$tferiado=$toferiado['tot'];
											if($tferiado!=0)
											{
												$sqlferiado = 'SELECT APROBADOR as total from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												 $resultadofer=mysql_query($sqlferiado,$_SESSION['BD']);
												
												$totfer = mysql_fetch_array($resultadofer);
												$aprobadorFeriado=$totfer['total'];
												
												$sqljustificacion = 'SELECT MOTIVO as total from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												 $resultadoferjust=mysql_query($sqljustificacion,$_SESSION['BD']);
												
												$totferjust = mysql_fetch_array($resultadoferjust);
												$justificacion=$totferjust['total'];
												$fechajustificación=$gestion."-".$mes."-".$dia;
												$fechajustificación1=$gestion."/".$mes."/".$dia;
												////////////////////////////
												$cod_trabajador=$codTrabajador;
												$scount="select count(COD_PERSONAL) as tot from historico_justificacion where COD_PERSONAL='$cod_trabajador' and FECHA='$fechajustificación' ";
											//	// echo "/*count-->$scount*/";
												$resultado1=mysql_query($scount,$_SESSION['BD']);  
												
												$totAsig = mysql_fetch_array($resultado1);
												$tAsig=$totAsig['tot'];
												////////////////////////////
												if($tAsig==0)
												{
													$sqljust = "insert into `historico_justificacion`(MOTIVO,FECHA,FECHA_APROBACION ,COD_PERSONAL) values('$justificacion','$fechajustificación','$fechajustificación1', ".$row['NRO_TRABAJADOR'].")";
			
													$resultadojus=mysql_query($sqljust,$_SESSION['BD']); 
												}
												else
												{
													$sqlreg = "update historico_justificacion set MOTIVO='$justificacion', FECHA_APROBACION='$fechajustificación1' where COD_PERSONAL='$cod_trabajador' and FECHA='$fechajustificación'";
													IF($resulreg = mysql_query($sqlreg , $_SESSION['BD']))
													{
													}
												}
												$sqlli = 'update `marcacion_valida` set FALTA=1,VALIDADOR="'.$aprobadorFeriado. '" where COD_PERSONAL='.$cod_trabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													  // // echo "/*$sqlli----tata*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']); 
												$vacaFalta=1;
												$tick=0;
												$nomVacaFalta="JUSTIFICADO";
											}
						/////////////////////////////////////////////////
									 if($nn==0)
										{
											$tick=1;
											$horarioPersona=$row3['COD_HORARIOPERSONA'];
											$tHorario=$row3['COD_HORARIO'];
											$codHorario=$row3['COD_TIPOHORARIO'];
											$nombreHorario1=$row3['NOMBRE_HORARIO'];
											if((int)$row3['INICIO_ENTRADAH']<10)
												{
													$HoE1="0".(string)$row3['INICIO_ENTRADAH'];
												}
												else
												{
													$HoE1=(string)$row3['INICIO_ENTRADAH'];
												}
												if((int)$row3['FINAL_SALIDAH']<10)
												{
													$HoS2="0".(string)$row3['FINAL_SALIDAH'];
												}
												else
												{
													$HoS2=(string)$row3['FINAL_SALIDAH'];
												}
											$HEE1=(string)$HoE1.':'.(string)$m[$row3['INICIO_ENTRADAM']].':00';
											$HSS2=(string)$HoS2.':'.(string)$m[$row3['FINAL_SALIDAM']].':00';
											if($codHorario==1)
											{
												$horasDeHor=restaHoras($HEE1,$HSS2)	;
												$horasDeHorario=(double)HorasExtras($horasDeHor);
												$HSS1="---";
												$HEE2="---";
											}
											else
											{
											
												$HSS1=(string)$row3['FINAL_ENTRADAH'].':'.(string)$m[$row3['FINAL_ENTRADAM']].':00';
												$HEE2=(string)$row3['INICIO_SALIDAH'].':'.(string)$m[$row3['INICIO_SALIDAM']].':00';
												$hora1=restaHoras($HEE1,$HSS1)	;
							
														$hora1=HorasExtras($hora1);
														
														$hora2=restaHoras($HEE2,$HSS2)	;
														$hora2=HorasExtras($hora2);
														$horasDeHorario=(double)$hora1+(double)$hora2;
											
											}
											if($horarioPersona==1)
											{
												//$tick=0;
											}
											 if($licencia==1)
												{
													$aprobadorfaltas=LicenciaAprobador($codigo,$gestion,$mes,$dia);
													$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													//   // echo "/*$sqlli*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']);  
												$vacaFalta=3;
													$tick=2;

												$nomVacaFalta="LICENCIA";
												}
												$fechap=$gestion."-".$mes."-".$dia;
												$justificacion=traerjustificacion($fechap,$row3['NRO_TRABAJADOR']);
												if($horarioPersona==3)
												{
													$tick=0;
												}
											$fehaHistorico= $gestion."-". $mes."-". $dia;
												$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
												' where COD_PERSONAL="'. $row3['NRO_TRABAJADOR']. '" and FECHA="'.$fehaHistorico.'"'; 
												// // echo "/*-------------Historico-->$sqlhisto-------------------*/";
												$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
												$fecha_marcacionEditada="";
												$fecha_cambioJustificacion="";
												$fechaHorasExtras="";
												$fechaAprobarHorasExtras="";
												if ($rowq = mysql_fetch_array($resHisto)){
													  if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
													 {
														  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
													 }
													 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
													 {
														  if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
													 }
													 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
													 {
														 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
													 }								 
													if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
													 {
														 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
													 }	
												}
											array_push($data, 
													array( 	"codigo"		=>$row3['NRO_TRABAJADOR'], 
													"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row3['NRO_TRABAJADOR'], $gestion, $mes, $dia),
														"nombre" 	=>   "",
														"horarioOficial"		=> $tHorario,
														"nombreHorario" => $nombreHorario1,
														"IEH"		=> "",
														"IEM"		=> "",
														"IFH"		=>"",
														"IFM"		=> "",
														"horaEntradaR" => "",
														"minutoEntradaR" => "",
														"segundoEntradaR" => "",
														"marcacion"		=> "",
														"horario_oficial" =>"",
														"cod_cargo"    => "",
															"nombrecargo"    => "",
															"nombrecosto"    => "",
															"nombresubcentro"    => "",
															"nombreunidad"    => "",
															"cod_centro"    => "",
															"gestion"  => "",
															"mes"  => "",
															"dia"  => "",
														"hiem"  => "",
														"hism"  => "",
														"hfem"  => "",
														"hfsm"  => "",
														"minuto" =>"F",
														"minuto1" =>"F",
														"he"		=>  substr( $HEE1 , 0, strlen($HEE1) - 3),
														"hs"		=> substr( $HSS1 , 0, strlen($HSS1) - 3),
														"he1"		=> substr( $HEE2 , 0, strlen($HEE2) - 3),
														"hs1"		=>  substr( $HSS2 , 0, strlen($HSS2) - 3),
														"horasExtras" =>"F",
														"fechaMarcacion"		=>$dia."/".$mes."/".$gestion, 
														"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
														"Ndia"		=>$Ndia,
														"tick"		=>$tick,
														"validacionRetraso"=>1,
														"nvalidacionRetraso"=>"SIN ACCION",
														"validacionFaltas"=>$vacaFalta,
												"nvalidacionFaltas"=>$nomVacaFalta,
												"validador"=>$aprobadorfaltas,
														
														"horasdehorario"=>$horasDeHorario,
														"horasEfectivas"=>"F",
														"HEN"=>"",
														"HEF"=>"",
														"HED"=>"",
														"editorHE"=>"",
														"recargoNocturno"=>"",
														"editorRN"=>"",
														"aprobador" => "",
													"color" =>"NO",
													"colorr" =>"NO",
													"codcolor" =>"2",
													"aprob" =>$aprob,
													"marcacionEnt1Edit" =>0,
													"marcacionSal1Edit" =>0,
													"marcacionEnt2Edit" =>0,
													"marcacionSal2Edit" =>0,
													"justificacion" =>$justificacion,
													"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
													"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
													"fechaHorasExtras" => $fechaHorasExtras,
													"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
													));
										
													 existe($codTrabajador,$gestion,$mes,$dia,$tHorario,$codcargo,$codcentro,"","","","","SR",$nocturno);
										}
								else{
											$tick1=0;
										//	// echo "/*jjjfjjjfjjfjfjfjjfjfjfjfjfjjfjf*/";
											 if($licencia==1)
											{
												$aprobadorfaltas=LicenciaAprobador($codigo,$gestion,$mes,$dia);
												$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												//// echo "/*que pasaffffffffffffffffff*/";
												 $resultado1=mysql_query($sqlli,$_SESSION['BD']);  
												
											}
											$sqlx2 = 'SELECT   mv.COD_PERSONAL as codPer,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,mv.APROBADOR,p.*,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
											' h.FINAL_ENTRADAM,h.COD_HORARIOPERSONA,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO FROM `marcacion_valida` mv '.
											' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
											' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
											//' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE   '.
											' WHERE mv.COD_PERSONAL='.$codTrabajador.' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
											//// echo "/*-----------------------$sqlx2*/";
											$resultadoreg52 = mysql_query($sqlx2 , $_SESSION['BD']);
											while ($row52 = mysql_fetch_array($resultadoreg52))
												{
												$horarioPersona=$row52['COD_HORARIOPERSONA'];
												if($row52['FALTA']==1)
												{
												$validacionFalta=2;
												$nvalidacionFalta="JUSTIFICADO";
											
													$tick1=0;
												}
												if($row52['FALTA']==0)
												{
													$validacionFalta=1;
												$nvalidacionFalta="SIN ACCION";
												$tick1=1;
														
												}
												if($row52['FALTA']==2)
												{
												$validacionFalta=3;
												$nvalidacionFalta="INJUSTIFICADO";
										
												$tick1=0;
												}
												if($row52['FALTA']==3)
												{
													$validacionFalta=4;
													$nvalidacionFalta="LICENCIA";
													$licencia=1;
													$tick1=0;
												}
												if((int)$row52['INICIO_ENTRADAH']<10)
												{
													$HoE1="0".(string)$row52['INICIO_ENTRADAH'];
												}
												else
												{
													$HoE1=(string)$row52['INICIO_ENTRADAH'];
												}
												if((int)$row52['FINAL_SALIDAH']<10)
												{
													$HoS2="0".(string)$row52['FINAL_SALIDAH'];
												}
												else
												{
													$HoS2=(string)$row52['FINAL_SALIDAH'];
												}
												$HEE11=(string)$HoE1.':'.(string)$m[$row52['INICIO_ENTRADAM']].':00';
												$HSS21=(string)$HoS2.':'.(string)$m[$row52['FINAL_SALIDAM']].':00';
												if($row52['COD_TIPOHORARIO']==1)
												{
													$horasDeHor=restaHoras($HEE11,$HSS21)	;
													$horasDeHorario=(double)HorasExtras($horasDeHor);
													$HSS11="---";
													$HEE21="---";
												}
												else
												{
												
													$HSS11=(string)$row52['FINAL_ENTRADAH'].':'.(string)$m[$row52['FINAL_ENTRADAM']].':00';
													$HEE21=(string)$row52['INICIO_SALIDAH'].':'.(string)$m[$row52['INICIO_SALIDAM']].':00';
													$hora1=restaHoras($HEE11,$HSS11)	;
							
														$hora1=HorasExtras($hora1);
														
														$hora2=restaHoras($HEE21,$HSS21)	;
														$hora2=HorasExtras($hora2);
														$horasDeHorario=(double)$hora1+(double)$hora2;
												
												}
												if($horarioPersona==1)
													{
														//$tick1=0;
													}
												if($licencia==1)
												{
												$tick1=2;
												}
												$color="NO";
												$codcolor=2;
												if($row52['APROBADOR']!=""){$color="SI";$codcolor=1;}
												$fechap=$gestion."-".$mes."-".$dia;
												$justificacion=traerjustificacion($fechap,$row3['NRO_TRABAJADOR']);
												if($horarioPersona==3)
												{
													$tick1=0;
												}
												$fehaHistorico= $gestion."-". $mes."-". $dia;
												$sqlhisto = 'SELECT FECHA_HORARIO as fechaCambioHorario,FECHA_CAMBIOJUSTIFICACION,FECHA_HORAS_EXTRAS,FECHA_APROBAR_HE  from historico_justificacion'.
												' where COD_PERSONAL="'. $row52['codPer']. '" and FECHA="'.$fehaHistorico.'"'; 
												// // echo "/*-------------Historico-->$sqlhisto-------------------*/";
												$resHisto=mysql_query($sqlhisto,$_SESSION['BD']);
												$fecha_marcacionEditada="";
												$fecha_cambioJustificacion="";
												$fechaHorasExtras="";
												$fechaAprobarHorasExtras="";
												if ($rowq = mysql_fetch_array($resHisto)){
													  if($rowq['fechaCambioHorario']!='0000-00-00 00:00:00')
														 {
															  $fecha_marcacionEditada=date("d/m/Y H:i:s", strtotime($rowq['fechaCambioHorario']));
														 }
														 if($rowq['FECHA_CAMBIOJUSTIFICACION']!='0000-00-00 00:00:00')
														 {
															 if($fecha_marcacionEditada!=""){$fecha_cambioJustificacion=" | ";}
															 $fecha_cambioJustificacion.=date("d/m/Y H:i:s", strtotime($rowq['FECHA_CAMBIOJUSTIFICACION']));
														 }
														 if($rowq['FECHA_HORAS_EXTRAS']!='0000-00-00 00:00:00')
														 {
															 $fechaHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_HORAS_EXTRAS']));
														 }								 
														if($rowq['FECHA_APROBAR_HE']!='0000-00-00 00:00:00')
														 {
															 $fechaAprobarHorasExtras=date("d/m/Y H:i:s", strtotime($rowq['FECHA_APROBAR_HE']));
														 }	
												}
												//$justificacion=traerjustificacion($fechaMarcacion1,$row3['NRO_TRABAJADOR']);
												array_push($data, 
												array( 	"codigo"		=>$row52['codPer'], 
												"val_hrs_extra" 	=>   verificarAlerta_hrsExtra($row52['codPer'], $gestion, $mes, $dia),
													"nombre" 	=>   "",
													"horarioOficial"		=> $row52['horariodia'], 
													"nombreHorario" => $row52['NOMBRE_HORARIO'], 
													"IEH"		=> "",
													"IEM"		=> "",
													"IFH"		=>"",
													"IFM"		=> "",
													"horaEntradaR" => "",
													"minutoEntradaR" => "",
													"segundoEntradaR" => "",
													"marcacion"		=> "",
													"horario_oficial" =>"",
													"cod_cargo"    => $codcargo,
													"nombrecargo"    => $codcentro,
													// "nombrecosto"    => $row52['cDESCRIPCION'],
												 // "nombresubcentro"    => $row52['sDESCRIPCION'],
													// "nombreunidad"    => $row52['uDESCRIPCION'],
													 // "cod_centro"    => $row52['COD_CENTRO'],
														"gestion"  => "",
														"mes"  => "",
														"dia"  => "",
													"hiem"  => "",
													"hism"  => "",
													"hfem"  => "",
													"hfsm"  => "",
													"minuto" =>"F",
													"minuto1" =>"F",
													"he"		=>  substr( $HEE11 , 0, strlen($HEE11) - 3),
													"hs"		=> substr( $HSS11 , 0, strlen($HSS11) - 3),
													"he1"		=> substr( $HEE21 , 0, strlen($HEE21) - 3),
													"hs1"		=>  substr( $HSS21 , 0, strlen($HSS21) - 3),
													"horasExtras" =>"F",
													"fechaMarcacion"		=>$dia."/".$mes."/".$gestion, 
													"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
													"Ndia"		=>$Ndia,
													"tick"		=>$tick1,
													"validacionRetraso"=>1,
													"nvalidacionRetraso"=>"SIN ACCION",
													"validacionFaltas"=>$validacionFalta,
													"nvalidacionFaltas"=>$nvalidacionFalta,
													"validador"=>$row52['VALIDADOR'],
													"horasdehorario"=>$horasDeHorario,
													"horasEfectivas"=>"F",
													"HEN"=>"",
													"HEF"=>"",
													"HED"=>"",
													"editorHE"=>"",
													"recargoNocturno"=>"",
													"editorRN"=>"",
													"aprobador" => "",
													"color" =>$color,
													"colorr" =>$color,
													"codcolor" =>$codcolor,
													"aprob" =>$aprob,
													"marcacionEnt1Edit" =>0,
													"marcacionSal1Edit" =>0,
													"marcacionEnt2Edit" =>0,
													"marcacionSal2Edit" =>0,
													"justificacion"  =>$justificacion,
													"fecha_marcacionEditada" => $fecha_marcacionEditada.$fecha_cambioJustificacion,
												"fecha_cambioJustificacion" => $fecha_cambioJustificacion,
												"fechaHorasExtras" => $fechaHorasExtras,
												"fechaAprobarHorasExtras" => $fechaAprobarHorasExtras,
												));
											}
						
									}
								}
						
				}
	}										 
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	

	function verificarAlerta_hrsExtra($codigo, $gestion, $mes, $dia)
	{
		// $gestion = date('Y');
		// $mes = date('m');	
		if($dia > 21){
			$fechai =  $gestion . '-' . $mes . '-21';
			$fechaf = $mes=='12'?(($gestion +1) .'-01-20'):( $gestion . '-' . ($mes + 1) . '-20');
		}else{
			$fechaf = $gestion . '-' . $mes . '-20';
			$fechai = $mes=='1'?(($gestion -1) .'-12-21'):( $gestion . '-' . ($mes -1) . '-21');
		}
		// $fechaf = $gestion . '-' . $mes . '-20';
		// $fechai = $mes=='1'?(($gestion -1) .'-12-21'):( $gestion . '-' . ($mes -1) . '-21');
		$sql1 = "
			SELECT p.COD_PERSONAL, p.NRO_TRABAJADOR,  A.GESTION, A.MES, A.DIA, 
			SUM(A.HEN) as HEN_total, sum(IF(A.APROBADOR ='',0,A.HEN)) as HEN_a, sum(IF(A.APROBADOR ='',A.HEN,0)) as HEN_sa,
			SUM(A.HEF) as HEF_total, sum(IF(A.APROBADOR ='',0,A.HEF)) as HEF_a, sum(IF(A.APROBADOR ='',A.HEF,0)) as HEF_sa,
			SUM(A.HED) as HED_total, sum(IF(A.APROBADOR ='',0,A.HED)) as HED_a, sum(IF(A.APROBADOR ='',A.HED,0)) as HED_sa,
			concat(p.AP_PATERNO, ' ', p.AP_MATERNO, ' ', p.NOMBRE, ' ', p.NOMBRE2) as NOMBRE_COMPLETO		
			FROM marcacion_valida A
			inner join personal p  on A.COD_PERSONAL = p.NRO_TRABAJADOR		
			WHERE A.ACTIVO = 1  and p.ACTIVO = 1 and A.COD_PERSONAL = $codigo AND date(CONCAT(A.GESTION,'-',A.MES,'-',A.DIA)) BETWEEN '$fechai' AND '$fechaf'
			GROUP BY p.COD_PERSONAL			
			";
			// // // // echo "/*$sql1*/";
		$resultado=mysql_query($sql1,$_SESSION['BD']);
		$totalhe = 0;
		while ($row = mysql_fetch_array($resultado)){
			$totalhe = $row['HEN_total'] + $row['HEF_total'] + $row['HED_total'];
		
		}
		return $totalhe;
						
	}
?> 