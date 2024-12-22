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
		$conex = ConectarConBD();
	if (!VerificaConBD())	{	
		echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
		exit;	
	}
		$fechai = $_REQUEST["fechai"];
		$codTrabajador = $_REQUEST["codigoT"];
		$codTrabajador = $_REQUEST["codigoT"];
		$codcargo = $_REQUEST["codcargo"];
			$codcentro = $_REQUEST["codcentro"];
		$codigo = $_REQUEST["codigo"];
		$fechaf =  $_REQUEST["fechaf"];
		mysqli_set_charset($conex, "utf8");
		// mysqli_query("SET NAMES 'utf8'");

		$sqlaux = '';
	
		if ($fechai <> '' and $fechaf <>'')
		{
			$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechaf' ";
		}
		 else
		{	
			$sqlaux = '';
		}
	
	  $st = mysqli_query( $conex ,'SELECT m.COD_PERSONAL,m.GESTION,m.MES,m.DIA FROM `marcacion` m inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR  '.
		               '   WHERE m.MARCACION_EDITADA=0 and m.ACTIVO = 1 AND p.NRO_TRABAJADOR='.$codTrabajador.$sqlaux. '  order by m.COD_PERSONAL,m.GESTION,m.MES,DIA,m.COD_MARCACION ASC ');
				
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
	function asignacionAprobar($conex,$cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador==7)
			{
				$sqlAsignacion=' select count(COD_USUARIO) as TOT from  flujo_aprobador  where COD_USUARIO ='.$idusuario.' and COD_PERSONAL='.$personalE.' and  ACTIVO=1 ';
				//echo "/*-----consulta-------------$sqlAsignacion*/";
				$resultadoAsig=mysqli_query($conex,$sqlAsignacion);
				$totAsig = mysqli_fetch_array($resultadoAsig);
				$tAsig=$totAsig['TOT'];
				if($tAsig!=0)
				{
					$cant=1;
				}
			}
			
			return $cant;
	}
	$aprob=0;
	$tipoAsignacion1=asignacionAprobar($conex,$rcargador,$ridcargador,$codigo);
	if($tipoAsignacion1==1 || $rcargador !=7 )
	{
		$aprob=1;
	}
	// echo "/*a ver si es sierto --->$tipoAsignacion1*/";
	// echo "/*a ver si es sierto --->$aprob*/";
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
			function traerjustificacion($conex,$fecha,$codigo)
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
			// echo "/*---$sql----*/";
			// mysqli_query("SET NAMES 'utf8'");
			mysqli_set_charset($conex, "utf8");
			$resultado=mysqli_query($conex,$sql);    	
			$data = array();	
	
			while ($row = mysqli_fetch_array($resultado)) 	{
			$sq = 'SELECT MIN_JUSTIFICADOS as min from marcacion_valida where COD_PERSONAL="'. $codigo . '" and GESTION="'.$gestion1. '" and MES="'.$mes1. '" and DIA="'.$dia1.  ' "';  	
			// echo "/*$sq*/";
				$resultadoAsig=mysqli_query($conex,$sq);
				$totAsig = mysqli_fetch_array($resultadoAsig);
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
		$tamanio = strlen($cadena);
		$xy = 0;
		$val = 0.0;
		$cadena_decimal = "";
		$cadena_entera = "";
	
		for ($x = 0; $x < $tamanio; $x++) {
			$t = $cadena[$x]; // Cambiar {} por []
			// echo "/*$t*/";
			if ($cadena[$x] == ".") { // Cambiar {} por []
				$xy = 1;
			} else {
				if ($xy == 0) {
					$cadena_entera .= $cadena[$x]; // Cambiar {} por []
				}
			}
			if ($xy == 1 && $cadena[$x] != ".") { // Cambiar {} por []
				$cadena_decimal .= $cadena[$x]; // Cambiar {} por []
			}
		}
	
		if ((int)$cadena_decimal >= 5) {
			$val = $cadena_entera . '.' . 5;
		} else {
			$val = $cadena_entera . '.' . 0;
		}
		if ($cadena_decimal >= 8) {
			$cadena_entera++;
			$val = $cadena_entera . '.' . 0;
		}
		// echo "/*cadenaentera---------------->$cadena_entera*/";
		// echo "/*cadenadecimal--------------->$cadena_decimal*/";
		// echo "/*redondeado--------------->$val*/";
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
		//ECHO "/*HORAS RECARGO-----$mextras*/";
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
		' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  m.MARCACION_EDITADA=0 and p.NRO_TRABAJADOR=' .$codTrabajador.$sqlaux.
		' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
		// echo "/*$sql*/";
	
	$data = array();
	 function existe($conex,$cod_personal,$gestion,$mes,$dia,$horario,$cargo,$centro,$HE1,$HS1,$HE2,$HS2,$RN,$nocturno)
	 {
		$sqlex = 'SELECT count(mv.COD_PERSONAL) as TOTALE from  marcacion_valida mv where mv.COD_PERSONAL='.$cod_personal.' and mv.GESTION='.$gestion.' and  mv.MES='.$mes.' and  mv.DIA='.$dia;
		$resultadoex=mysqli_query($conex,$sqlex);
		$tot1 = mysqli_fetch_array($resultadoex);
		$t1=$tot1['TOTALE'];
		if($t1==0)
		{
			$recargonoc="";
			$hen="";
			if($HE1!="" && $HS2!="" && $RN!='SR')
			{
				$recargonoc=$RN;
				if($nocturno==1)
				{
					$hen="1";
				}
			}
			$sqlreg = "INSERT INTO marcacion_valida(COD_PERSONAL,GESTION,MES,DIA,COD_HORARIO,HIE,HIS,HFE,HFS,COD_CARGO,COD_CENTRO,RECARGO_NOCTURNO,HEN,ACTIVO) ".
										  "values('$cod_personal','$gestion','$mes','$dia','$horario','$HE1','$HS1','$HE2','$HS2','$cargo','$centro','$recargonoc','$hen','1')";				
										$resultadoreg = mysqli_query($conex,$sqlreg);
		}
			return $t1;
	 }
	  function existe1($conex,$cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(mv.COD_PERSONAL) as TOTALE from  marcacion_valida mv where mv.COD_PERSONAL='.$cod_personal.' and mv.GESTION='.$gestion.' and  mv.MES='.$mes.' and  mv.DIA='.$dia;
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
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
					$recargonoc=$RN;
					if((int)$nocturno==1)
					{
						$hen="1";
					}
				}
			
				// $sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2',RECARGO_NOCTURNO='$recargonoc', HEN='$hen' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
											  // //echo "/*$sqlreg1*/";
											
											// $resultadoreg1 = mysqli_query($sqlreg1 , $conex);
		}
		else
		{
				// $sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
											  // //echo "/*$sqlreg1*/";
											
											// $resultadoreg1 = mysqli_query($sqlreg1 , $conex);
		}
	 
	 
			// $sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
			// $resultadoreg1 = mysqli_query($sqlreg1 , $conex);
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
				//echo "/*$n2*/";
				
			}
			else{
					
				}
			return $rn;
		}
		 function PerteneAGrupo($conex,$cod_personal)
	 {
		$sqlex1 = 'SELECT count(gp.COD_GRUPO) as TOTALE from  grupo_persona gp where gp.COD_PERSONA='.$cod_personal.' and gp.ACTIVO=1';
		// echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function PerteneNombreGrupo($conex,$cod_personal)
	 {
		$sqlex1 = 'SELECT gp.COD_GRUPO as TOTALE from  grupo_persona gp where gp.COD_PERSONA='.$cod_personal.' and gp.ACTIVO=1';
		// echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	  function obtenerHorarioGrupo($conex,$codGrupo,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT gp.CODHORARIO as TOTALE from  horario_grupo gp where gp.COD_GRUPO='.$codGrupo.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
		// echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	   function Licencia($conex,$cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(gp.COD_PERSONA) as TOTALE from  licencias gp where gp.COD_PERSONA='.$cod_personal.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
		// echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	  function LicenciaAprobador($conex,$cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT gp.VALIDADOR as TOTALE from  licencias gp where gp.COD_PERSONA='.$cod_personal.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
		// echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	$resultado=mysqli_query($conex,$sql);    	
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
	while ($row = mysqli_fetch_array($resultado)){
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
					 $licencia=Licencia($conex,$codigo,$gestion,$mes,$dia);
					 $G=PerteneAGrupo($conex,$codigo);
						if($G!=0)
						{		
								$Gp=PerteneNombreGrupo($conex,$codigo);
								$horar=obtenerHorarioGrupo($conex,$Gp,$gestion,$mes,$dia);
								if($horar!="")
								{
								$sqlac = 'update horario_personal  set COD_HORARIO='.$horar.' where COD_PERSONAL='.$codigo.' and ACTIVO=1';
								// echo "/*$sqlac*/";
								$res=mysqli_query($conex,$sqlac); } 		
						}
					 $i1 = strtotime($i); 
					$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
					if($nombreDia==0)
					{$nombreDia=7;}
					$Ndia=$d[$nombreDia];
				 $sqla1 = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
					' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
					 '   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador;
					$res1=mysqli_query($conex,$sqla1);
					if ($row2 = mysqli_fetch_array($res1)){
					$tick=1;
						$nn=existe1($conex,$codTrabajador,$gestion,$mes,$dia);
						if($nn==0)
						{
							$tHorario=$row2['COD_HORARIO'];
							$horarioPersona=$row2['COD_HORARIOPERSONA'];
							$codHorario=$row2['COD_TIPOHORARIO'];
							$nombreHorario=$row2['NOMBRE_HORARIO'];
							
							$HEE1=(string)$row2['INICIO_ENTRADAH'].':'.(string)$m[$row2['INICIO_ENTRADAM']].':00';
							$HSS2=(string)$row2['FINAL_SALIDAH'].':'.(string)$m[$row2['FINAL_SALIDAM']].':00';
							
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
								' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.MARCACION_EDITADA=0 and m.ACTIVO = 1 '.$sqlauxn.
								' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
								
								$resultadoq=mysqli_query($conex,$sqla); 
									while ($rowq = mysqli_fetch_array($resultadoq)){
									$minut="";
										if((int)$rowq['MINUTO']<10)
										{
											$minut="0".(string)$rowq['MINUTO'];
										}
										else
										{
											$minut=(string)$rowq['MINUTO'];
										}
									$HoraMarcacion=(string)$rowq['HORA'].':'.(string)$minut.':00';
								
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
						 existe($conex,$codTrabajador,$gestion,$mes,$dia,$tHorario,$row['COD_CARGO'],$row['COD_CENTRO'],"","","",$v4,"SR",$nocturno);
						  if($licencia==1)
												{
													$aprobadorfaltas=LicenciaAprobador($conex,$codigo,$gestion,$mes,$dia);
													$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													//    echo "/*$sqlli*/";
												 $resultado1=mysqli_query($conex,$sqlli);  
												$vacaFalta=3;
													$tick=2;

												$nomVacaFalta="LICENCIA";
												}
							if($v4==""){$v4="---";}
							$fechaini=$gestion."-".$mes."-".$dia;
							$justificacion=traerjustificacion($conex,$fechaini,$row['NRO_TRABAJADOR']);
						array_push($data, 
								array( 	"codigo"		=>$row['NRO_TRABAJADOR'], 
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
									"justificacion"=>$justificacion
								));
						
						
								
						}
						else{
							$tick1=1;
							//$licencia=0;
							  if($licencia==1)
								{
									$aprobadorfaltas=LicenciaAprobador($conex,$codigo,$gestion,$mes,$dia);
									$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
									
									 $resultado1=mysqli_query($conex,$sqlli);  
									
								}
							$color="";
										$sqlx1 = 'SELECT   mv.COD_PERSONAL as codPer,mv.BANDERA,mv.APROBADOR,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
										' h.FINAL_ENTRADAM,h.INICIO_SALIDAH,h.COD_HORARIOPERSONA,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv '.
										' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
										' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
										' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  '.
									'   mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
										
										$resultadoreg5 = mysqli_query($conex,$sqlx1);
									while ($row5 = mysqli_fetch_array($resultadoreg5))
										{
											
											$horarioPersona=$row5['COD_HORARIOPERSONA'];
											
										
											$HEE11=(string)$row5['INICIO_ENTRADAH'].':'.(string)$m[$row5['INICIO_ENTRADAM']].':00';
											$HSS21=(string)$row5['FINAL_SALIDAH'].':'.(string)$m[$row5['FINAL_SALIDAM']].':00';
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
													' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.MARCACION_EDITADA=0 and m.ACTIVO = 1 '.$sqlauxn.
													' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
													
													$resultadoq=mysqli_query($conex,$sqla); 
														while ($rowq = mysqli_fetch_array($resultadoq)){
															$minut="";
															if((int)$rowq['MINUTO']<10)
															{
																$minut="0".(string)$rowq['MINUTO'];
															}
															else
															{
																$minut=(string)$rowq['MINUTO'];
															}
														$HoraMarcacion=(string)$rowq['HORA'].':'.(string)$minut.':00';
													
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
												//$tick1=0;
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
											$justificacion=traerjustificacion($conex,$fechaini,$row5['codPer']);
											if($row5['APROBADOR']!=""){$color="APROBADO";$codcolor=1;}
											array_push($data, 
											array( 	"codigo"		=>$row5['codPer'], 
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
													"justificacion"=>$justificacion
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
		// echo "/*$dd*/";
			$nn=existe1($conex,$row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA']);
			// if($nn==0)
				// {	
					$G=PerteneAGrupo($conex,$codigo);
						if($G!=0)
						{		
								$Gp=PerteneNombreGrupo($conex,$codigo);
								$horar=obtenerHorarioGrupo($conex,$Gp,$row['GESTION'],$row['MES'],$row['DIA']);
								if($horar!="")
								{
								$sqlac = 'update horario_personal  set COD_HORARIO='.$horar.' where COD_PERSONAL='.$codigo.' and ACTIVO=1';
								// echo "/*$sqlac*/";
								$res=mysqli_query($conex,$sqlac); } 		
						}
					$fehaM1=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
					 $i1 = strtotime($fehaM1); 
					$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
					if($nombreDia==0)
					{$nombreDia=7;}
					
					 
					$sqla = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
					' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
					'   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador;
					// echo "/*consultaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa*/";
					// echo "/*$sqla*/";
					$res=mysqli_query($conex,$sqla);   
					if ($row1 = mysqli_fetch_array($res)){
						$horarioPersona=$row1['COD_HORARIOPERSONA'];
						$tipoHorario=$row1['COD_HORARIO'];
						$codHorario=$row1['COD_TIPOHORARIO'];
						$nombreHorario=$row1['NOMBRE_HORARIO'];
						$toleranciaSemaforo=$row1['TOLERANCIA_SEMAFORO'];
						$HE1=(string)$row1['INICIO_ENTRADAH'].':'.(string)$m[$row1['INICIO_ENTRADAM']].':00';
						$HS2=(string)$row1['FINAL_SALIDAH'].':'.(string)$m[$row1['FINAL_SALIDAM']].':00';
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
					//	ECHO "/*TE LO DIJE*/";
						$HE1="6:00:00";
						$HS1=0;
						$HE2=0;
						$HS2="18:00:00";
						$tipoHorario=0;
						$codHorario=1;
						$horarioPersona=2;
						$nombreHorario="SIN DEFINIR";
						$horasDeHorario=0;
						$prueba=1;
						// echo "/*pruebangaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa*/";
						$fehaM2=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
						 $i2 = strtotime($fehaM2 ."- 2 days"); 
						$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
						
						$nn1=existe1($conex,$row['NRO_TRABAJADOR'],(string) date("Y",$i2),(string)date("m",$i2),(string)date("d",$i2));
						if($nn1==0)
						{
						 $i1 = strtotime($fec); 
						$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
						
						if($nombreDia==0)
						{$nombreDia=7;}
						
							$sqltn = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
							' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
							'   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$row['NRO_TRABAJADOR'];
							
							$restn=mysqli_query($conex,$sqltn);  
							if ($rowtn = mysqli_fetch_array($restn)){
								$HE1=(string)$rowtn['INICIO_ENTRADAH'].':'.(string)$m[$rowtn['INICIO_ENTRADAM']].':00';
								$HS2=(string)$rowtn['FINAL_SALIDAH'].':'.(string)$m[$rowtn['FINAL_SALIDAM']].':00';
								$tipoHorario=$rowtn['COD_HORARIO'];
								$nombreHorario=$rowtn['NOMBRE_HORARIO'];
								$nocturno=CompararHoras($HE1,$HS2);
									$toleranciaSemaforo=$rowtn['TOLERANCIA_SEMAFORO'];
							}
						
						}
						else{
							$sqlw1='SELECT mv.COD_PERSONAL,mv.COD_HORARIO as horariodia,h.* from `marcacion_valida` mv  inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR  inner join horario h on mv.COD_HORARIO=h.COD_HORARIO   WHERE  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.(string) date("Y",$i2).' and mv.MES='.(string)date("m",$i2).' and mv.DIA='.(string)date("d",$i2).' order by mv.COD_PERSONAL,mv.GESTION,mv.MES,mv.DIA ASC'; 
							$restn1=mysqli_query($conex,$sqlw1); 
								if ($rowtn1 = mysqli_fetch_array($restn1)){
								$HE1=(string)$rowtn1['INICIO_ENTRADAH'].':'.(string)$m[$rowtn1['INICIO_ENTRADAM']].':00';
								$HS2=(string)$rowtn1['FINAL_SALIDAH'].':'.(string)$m[$rowtn1['FINAL_SALIDAM']].':00';
								$tipoHorario=$rowtn1['COD_HORARIO'];
								$nombreHorario=$rowtn1['NOMBRE_HORARIO'];
								$nocturno=CompararHoras($HE1,$HS2);
								$toleranciaSemaforo=$rowtn1['TOLERANCIA_SEMAFORO'];
								
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
					$nombre_completo=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					$HoraMarcacion=(string)$row['HORA'].':'.(string)$minut.':00';
					
					$r=horario($HoraMarcacion,$HE1,$HS1,$HE2,$HS2);
					if($r==1){$v1=$HoraMarcacion;}
					if($r==2){$v2=$HoraMarcacion;}
					if($r==3){$v3=$HoraMarcacion;}
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
							$v4="";
							$pri=0;
							$i2 = strtotime($fehaM1 ."+ 1 days"); 
							$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
							$nro=$row['NRO_TRABAJADOR'];
							
							 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
								$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
								' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
								' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
								' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.MARCACION_EDITADA=0 and m.ACTIVO = 1 '.$sqlauxn.
								' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
								
								$resultadoq=mysqli_query($conex,$sqla); 
									while ($rowq = mysqli_fetch_array($resultadoq)){
										$minut="";
										if((int)$rowq['MINUTO']<10)
										{
										 $minut="0".(string)$rowq['MINUTO'];
										}
										else
										{
										  $minut=(string)$rowq['MINUTO'];
										}
									$HoraMarcacion=(string)$rowq['HORA'].':'.(string)$minut.':00';
									
										$r=horario($HoraMarcacion,$HE1,$HS1,$HE2,$HS2);
									if($pri==0)
									{
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
								//echo "/*$recargoNocturno*/";
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
									//echo "/*$recargoNocturno*/";
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
							// echo "/*holaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa*/";
							// echo "/*prueba-->$prueba*/";
							// echo "/*v4-->$v4*/";
							// echo "/*nocturno-->$nocturno*/";
							if($prueba==1 and $v4=="" and $nocturno==1)
							 {
									// echo "/*v1-->$v1*/";
									// echo "/*v4-->$v4*/";
								if($v1!="")
								{
									// $n=0;
									// $bandera=0;
									$n=existe($conex,$row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA'],$tipoHorario,$row['COD_CARGO'],$row['COD_CENTRO'],$v1,$v2,$v3,$v4,$recargoNocturno,$nocturno);
								}
								else
								{
									$n=0;
									$bandera=1;
								}
								 
							 }
							 else{
									 // if($prueba==1  and $nocturno==1)
									 // {
									 
									 // }
							$n=existe($conex,$row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA'],$tipoHorario,$row['COD_CARGO'],$row['COD_CENTRO'],$v1,$v2,$v3,$v4,$recargoNocturno,$nocturno);
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
								if($horarioPersona==1)
								{
									$tick=0;
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
											$recargoN=$recargoNocturno;}
										
										}
										$hen="";
										if($nocturno==1)
										{
											if($v1!="---" and $v4!="---"){
											$hen=1;}
										}
										else
										{
											$hen="";
										}
								$fechaini=$fehaM1;
								$justificacion=traerjustificacion($conex,$fechaini,$row['NRO_TRABAJADOR']);
								array_push($data, 
								array( 	"codigo"		=> $row['NRO_TRABAJADOR'], 
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
									"validacionFaltas"=>1,
									"nvalidacionFaltas"=>"SIN ACCION",
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
										"justificacion" =>$justificacion
								));}
						}
					else
						{
							//echo "/*-----------------------REVISION DE DUPLICADOS---------------------------------------------------------------------------------------------*/";
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
					
							'  WHERE  m.MARCACION_EDITADA=0 and m.COD_PERSONAL='.$row['NRO_TRABAJADOR'].
							' and m.GESTION='.$row['GESTION'].' and m.MES='.$row['MES'].' and m.DIA='.$row['DIA'].' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC';
							//echo "/*---$sqlt---*/";
							$resultadot=mysqli_query($conex,$sqlt);  
							$sqlt1='SELECT  mv.COD_HORARIO as COD_HO FROM `marcacion_valida` mv  '.
					
							'  WHERE mv.ACTIVO = 1   and  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].
							' and mv.GESTION='.$row['GESTION'].' and mv.MES='.$row['MES'].' and mv.DIA='.$row['DIA'];
							//echo "/*----$sqlt1*/";
							$resultadot1=mysqli_query($conex,$sqlt1);  
							$tt1 = mysqli_fetch_array($resultadot1);
							$tH=$tt1['COD_HO'];
				
							$tt = mysqli_fetch_array($resultadot);
							$t2=$tt['tot'];
							$sqlx= 'SELECT m.*,p.* FROM `marcacion` m  inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR   WHERE   m.MARCACION_EDITADA=0 and m.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and m.GESTION='.$row['GESTION'].' and m.MES='.$row['MES'].' and m.DIA='.$row['DIA'].'  order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC';
							
				
							$resultadoreg = mysqli_query($conex,$sqlx);
							while ($row1 = mysqli_fetch_array($resultadoreg))
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
								$HoraMarcacion1=(string)$row1['HORA'].':'.(string)$minut.':00';
								
								$sqlw='SELECT mv.COD_PERSONAL,mv.COD_HORARIO as horariodia,mv.BANDERA,mv.APROBADOR,mv.RECARGO_NOCTURNO,mv.HEN,mv.HEF,mv.HED,mv.VALIDADORHE,mv.RETRASO,mv.FALTA,mv.VALIDADOR,mv.MIN_JUSTIFICADOS,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_HORARIOPERSONA,h.TOLERANCIA_SEMAFORO,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH, h.FINAL_ENTRADAM,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv  inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR  inner join horario h on mv.COD_HORARIO=h.COD_HORARIO inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$row['GESTION'].' and mv.MES='.$row['MES'].' and mv.DIA='.$row['DIA'].' order by mv.COD_PERSONAL,mv.GESTION,mv.MES,mv.DIA ASC'; 
								//echo "/*----$sqlw----*/";
								$resultadoreg3 = mysqli_query($conex,$sqlw);
								while ($roww = mysqli_fetch_array($resultadoreg3))
								{
											$toleranciaSemaforo=$roww['TOLERANCIA_SEMAFORO'];
											$horarioPersona=$roww['COD_HORARIOPERSONA'];
											$HE11=(string)$roww['INICIO_ENTRADAH'].':'.(string)$m[$roww['INICIO_ENTRADAM']].':00';
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
					
					
											$HS12=(string)$roww['FINAL_SALIDAH'].':'.(string)$m[$roww['FINAL_SALIDAM']].':00';
											
											$r1=horario($HoraMarcacion1,$HE11,$HS11,$HE12,$HS12);
											if($r1==1){$v11=$HoraMarcacion1;}
											if($r1==2){$v12=$HoraMarcacion1;}
											if($r1==3){$v13=$HoraMarcacion1;}
											if($r1==4){$v14=$HoraMarcacion1;}
								
											if($aux3==$t2)
											{
													$nocturno=CompararHoras($HE11,$HS12);
													if($nocturno==1)
													{
														$v14="";
														$pri=0;
														//echo "/*horario nocturno*/";
														$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
														$i2 = strtotime($fehaM11 ."+ 1 days"); 
														$fec=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
														$nro=$row['NRO_TRABAJADOR'];
														//echo "/*$nro*/";
													//	echo "/*$fec*/";
														 $sqlauxn=" AND p.NRO_TRABAJADOR='$nro' AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fec' AND '$fec' ";
														
															$sqla = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
															' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
															' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
															' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.MARCACION_EDITADA=0 and m.ACTIVO = 1 '.$sqlauxn.
															' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
														//	echo "/*$sqla*/";
															$resultadoq=mysqli_query($conex,$sqla); 
																while ($rowq = mysqli_fetch_array($resultadoq)){
																$minut="";
																if((int)$rowq['MINUTO']<10)
																{
																 $minut="0".(string)$rowq['MINUTO'];
																}
																else
																{
																  $minut=(string)$rowq['MINUTO'];
																}
																$HoraMarcacion1=(string)$rowq['HORA'].':'.(string)$minut.':00';
																//echo "/*$HoraMarcacion1*/";
																		$r1=horario($HoraMarcacion1,$HE11,$HS11,$HE12,$HS12);
															//	if($pri==0){
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
																	
																//	}
																
															//	echo "/*$v14*/";
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
															//echo "/*---------$sqlw1*/";
															// $sqltn = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
															// ' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
															// '   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$row['NRO_TRABAJADOR'];
															
															$restn1=mysqli_query($conex,$sqlw1);  
															if ($rowtn = mysqli_fetch_array($restn1)){
																$HE1=(string)$rowtn['INICIO_ENTRADAH'].':'.(string)$m[$rowtn['INICIO_ENTRADAM']].':00';
																$HS2=(string)$rowtn['FINAL_SALIDAH'].':'.(string)$m[$rowtn['FINAL_SALIDAM']].':00';
																$nocturno=CompararHoras($HE1,$HS2);
																	if($nocturno==1)
																	{
																		$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
																		$i3 = strtotime($fehaM11); 
																		$fec1=(string) date("Y",$i3)."-".(string)date("m",$i3)."-".(string)date("d",$i3);
																		//echo "/*es antiguo---------------------*/";
																		//echo "/*$sqlw1*/";
																		$sqla2 = 'update  marcacion_valida set ACTIVO=0 where COD_PERSONAL='.$row['NRO_TRABAJADOR'].'  and GESTION="'.(string) date("Y",$i3).'" and MES="'.(string)date("m",$i3).'" and DIA="'.(string)date("d",$i3).'"';
																				$restn3=mysqli_query($conex,$sqla2); 
																				
																	//	echo "/*$sqla2 */";
																		//echo "/*$nombreDia*/";
																		//echo "/*---------------$sqltn*/";
																		
																	}
																	else
																	{
																	$fehaM11=(string)$row['GESTION'].'-'.(string)$row['MES'].'-'.(string)$row['DIA'];
																	$i3 = strtotime($fehaM11); 
																		$fec1=(string) date("Y",$i3)."-".(string)date("m",$i3)."-".(string)date("d",$i3);
																	$sqla2 = 'update  marcacion_valida set ACTIVO=1 where COD_PERSONAL='.$row['NRO_TRABAJADOR'].'  and GESTION="'.(string) date("Y",$i3).'" and MES="'.(string)date("m",$i3).'" and DIA="'.(string)date("d",$i3).'"';
																				$restn3=mysqli_query($conex,$sqla2);
																//	echo "/*CHEQUEAR ESTIO---------------------*/";
																//	echo "/*$sqla2 */";																				
																	$nocturno=0;
																	}
																	
																// echo "/*$HE1*/";
																// echo "/*$HS2*/";
																
															}
															
															
															$HE11='---';
															$HS12='---';
															$minutoR=0;
															$minutoE=0;
															$tick=1;
														}
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
											// echo "/*-------------------------->$minutoT*/";
											if($minutoT!="F" AND $minutoT!="SM" && $banderaAmarilla==0)
											{
												// echo "/*holassssssssssssss*/";
												// echo "/*tolerancia----->$toleranciaSemaforo*/";
												if((int)$toleranciaSemaforo>=(int)$minutoT)
												{
													$tick=0;
													// echo "/*ddddddddddddddddddddddddddddddd*/";
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
															$tick=0;
														}
											$minutoT=$minutoT-(int)$roww['MIN_JUSTIFICADOS'];
											// echo "/*minutosjustificaods------->$minutoT*/";
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
													$recargoN=$recargoNocturno;}
												
												}
											
												if($nocturno==1)
												{
													if($v11!="---" and $v14!="---"){
													$hen=1;}
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
												$fechaini=$fehaM1;
												$justificacion=traerjustificacion($conex,$fechaini,$row1['NRO_TRABAJADOR']);
												array_push($data, 
												array( 	"codigo"		=> $row1['NRO_TRABAJADOR'], 
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
													"justificacion"=>$justificacion
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
							
							 $licencia=Licencia($conex,$codigo,$gestion,$mes,$dia);
								 $HEE1="";
								 $HSS1="";
								 $HEE2 ="";
								 $HSS2="";
								 $i1 = strtotime($i); 
								$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
								if($nombreDia==0)
								{$nombreDia=7;}
								$Ndia=$d[$nombreDia];
							 $sqla2 = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
								' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
								 '   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador;
								$res2=mysqli_query($conex,$sqla2);
								if ($row3 = mysqli_fetch_array($res2)){
									$nn=existe1($conex,$codTrabajador,$gestion,$mes,$dia);
									 if($nn==0)
										{
											$tick=1;
											$horarioPersona=$row3['COD_HORARIOPERSONA'];
											$tHorario=$row3['COD_HORARIO'];
											$codHorario=$row3['COD_TIPOHORARIO'];
											$nombreHorario1=$row3['NOMBRE_HORARIO'];
											$HEE1=(string)$row3['INICIO_ENTRADAH'].':'.(string)$m[$row3['INICIO_ENTRADAM']].':00';
											$HSS2=(string)$row3['FINAL_SALIDAH'].':'.(string)$m[$row3['FINAL_SALIDAM']].':00';
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
													$aprobadorfaltas=LicenciaAprobador($conex,$codigo,$gestion,$mes,$dia);
													$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													//    echo "/*$sqlli*/";
												 $resultado1=mysqli_query($conex,$sqlli);  
												$vacaFalta=3;
													$tick=2;

												$nomVacaFalta="LICENCIA";
												}
												$fechaini=$gestion."-".$mes."-".$dia;
												$justificacion=traerjustificacion($conex,$fechaini,$row3['NRO_TRABAJADOR']);
											array_push($data, 
													array( 	"codigo"		=>$row3['NRO_TRABAJADOR'], 
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
													"justificacion" =>$justificacion
														
													));
											
											
													 existe($conex,$codTrabajador,$gestion,$mes,$dia,$tHorario,$row['COD_CARGO'],$row['COD_CENTRO'],"","","","","SR",2);
										}
								else{
											$tick1=0;
											 if($licencia==1)
											{
												$aprobadorfaltas=LicenciaAprobador($conex,$codigo,$gestion,$mes,$dia);
												$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												
												 $resultado1=mysqli_query($conex,$sqlli);  
												
											}
											$sqlx2 = 'SELECT   mv.COD_PERSONAL as codPer,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,mv.APROBADOR,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
											' h.FINAL_ENTRADAM,h.COD_HORARIOPERSONA,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv '.
											' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
											' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
											' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE   '.
											'  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
										//	echo "/*-----------------------$sqlx2*/";
											$resultadoreg52 = mysqli_query($conex,$sqlx2);
											while ($row52 = mysqli_fetch_array($resultadoreg52))
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
											
												$HEE11=(string)$row52['INICIO_ENTRADAH'].':'.(string)$m[$row52['INICIO_ENTRADAM']].':00';
												$HSS21=(string)$row52['FINAL_SALIDAH'].':'.(string)$m[$row52['FINAL_SALIDAM']].':00';
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
												$color="SI";
												$codcolor=2;
												if($row52['APROBADOR']!=""){$color="APROBADO";$codcolor=1;}
												$fechaini=$gestion."-".$mes."-".$dia;
												$justificacion=traerjustificacion($conex,$fechaini,$row52['codPer']);
												array_push($data, 
												array( 	"codigo"		=>$row52['codPer'], 
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
													"justificacion"=>$justificacion
												));
											}
						
									}
								}
						
				}
							
							
							
							
						}
						//echo "/*aux--$aux*/";
			//echo "/*tot--$tot*/";
		
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
							
							 $licencia=Licencia($conex,$codigo,$gestion,$mes,$dia);
								 $HEE1="";
								 $HSS1="";
								 $HEE2 ="";
								 $HSS2="";
								 $i1 = strtotime($i); 
								$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
								if($nombreDia==0)
								{$nombreDia=7;}
								$Ndia=$d[$nombreDia];
							 $sqla2 = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
								' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
								 '   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codTrabajador;
								$res2=mysqli_query($conex,$sqla2);
								if ($row3 = mysqli_fetch_array($res2)){
									$nn=existe1($conex,$codTrabajador,$gestion,$mes,$dia);
									 if($nn==0)
										{
											$tick=1;
											$horarioPersona=$row3['COD_HORARIOPERSONA'];
											$tHorario=$row3['COD_HORARIO'];
											$codHorario=$row3['COD_TIPOHORARIO'];
											$nombreHorario1=$row3['NOMBRE_HORARIO'];
											$HEE1=(string)$row3['INICIO_ENTRADAH'].':'.(string)$m[$row3['INICIO_ENTRADAM']].':00';
											$HSS2=(string)$row3['FINAL_SALIDAH'].':'.(string)$m[$row3['FINAL_SALIDAM']].':00';
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
													$aprobadorfaltas=LicenciaAprobador($conex,$codigo,$gestion,$mes,$dia);
													$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
													//    echo "/*$sqlli*/";
												 $resultado1=mysqli_query($conex,$sqlli);  
												$vacaFalta=3;
													$tick=2;

												$nomVacaFalta="LICENCIA";
												}
											array_push($data, 
													array( 	"codigo"		=>$row3['NRO_TRABAJADOR'], 
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
													"aprob" =>$aprob
														
													));
										
													 existe($conex,$codTrabajador,$gestion,$mes,$dia,$tHorario,$codcargo,$codcentro,"","","","","SR",$nocturno);
										}
								else{
											$tick1=0;
											 if($licencia==1)
											{
												$aprobadorfaltas=LicenciaAprobador($conex,$codigo,$gestion,$mes,$dia);
												$sqlli = 'update `marcacion_valida` set FALTA=3,VALIDADOR="'.$aprobadorfaltas. '" where COD_PERSONAL='.$codTrabajador.' and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
												
												 $resultado1=mysqli_query($conex,$sqlli);  
												
											}
											$sqlx2 = 'SELECT   mv.COD_PERSONAL as codPer,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,mv.APROBADOR,p.*,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
											' h.FINAL_ENTRADAM,h.COD_HORARIOPERSONA,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO FROM `marcacion_valida` mv '.
											' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
											' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
											//' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE   '.
											' WHERE mv.COD_PERSONAL='.$codTrabajador.' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
											// echo "/*-----------------------$sqlx2*/";
											$resultadoreg52 = mysqli_query($conex,$sqlx2);
											while ($row52 = mysqli_fetch_array($resultadoreg52))
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
											
												$HEE11=(string)$row52['INICIO_ENTRADAH'].':'.(string)$m[$row52['INICIO_ENTRADAM']].':00';
												$HSS21=(string)$row52['FINAL_SALIDAH'].':'.(string)$m[$row52['FINAL_SALIDAM']].':00';
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
												array_push($data, 
												array( 	"codigo"		=>$row52['codPer'], 
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
													"aprob" =>$aprob
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
?> 