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
		mysql_query("SET NAMES 'utf8'");
	
	function asignacion($cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador==7)
			{
				$sqlAsignacion=' select count(COD_USUARIO) as TOT from personal_flujo  where COD_USUARIO ='.$idusuario.' and COD_PERSONAL='.$personalE.' and  ACTIVO=1 ';
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

	function str2date($in)
	{
		$t = explode("-",$in);
		if (count($t)!=3) $t = explode("-",$in);
		if (count($t)!=3) $t = explode(" ",$in);
		if (count($t)!=3) return -1;
		if (!is_numeric($t[0])) return -1;
		if (!is_numeric($t[1])) return -2;
		if (!is_numeric($t[2])) return -3;

		if ($t[2]<1902 || $t[2]>2037) return -3;
		return mktime (0,0,0, $t[1], $t[0], $t[2]);
	}
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
		//$sqlaux = " AND MONTH(P.FECHA_PEDIDO) = MONTH(CURDATE()) ";
			$sqlaux = '';
		}
			
	  $st = mysql_query( 'SELECT m.COD_PERSONAL,m.GESTION,m.MES,m.DIA FROM `marcacion` m inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR inner join horario h on p.COD_HORARIO=h.COD_HORARIO inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD '.
		               '   WHERE m.ACTIVO = 1 '.$sqlaux. '  order by m.COD_PERSONAL,m.GESTION,m.MES,DIA,m.COD_MARCACION ASC ', $_SESSION['BD']);
				
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
				//	echo "/*---$t[$tot]---*/";
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
		//echo "/*---$t[$tot]---*/";

		
		
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
			}
			if($i==2)
			{
				if($h2!=0)
				{
					$v[$i]=MixMAx($HM,$h2);
					
				}
				else{ $v[$i]="23:59:59";}
			}
			if($i==3)
			{
				if($h3!=0)
				{
					$v[$i]=MixMAx($HM,$h3);
					
				}
				else{ $v[$i]="23:59:59";}
			}
			if($i==4)
			{
					$v[$i]=MixMAx($HM,$h4,$i);
				
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
	function minutosAtraso($matraso)
	{
		list($horas, $minutos, $segundos) = explode(':', $matraso);
		$hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
		$hora_en_segundos=$hora_en_segundos/60;
		 $hora_en_segundos=number_format($hora_en_segundos,0,',','.');
		return $hora_en_segundos;
	}
	function HorasExtras($mextras)
	{
		//ECHO "/*HORAESTRAS-----$mextras*/";
		list($horas, $minutos, $segundos) = explode(':', $mextras);
		
		$hora_Extras = ($horas * 60 ) + $minutos ;
		$hora_Extras=$hora_Extras/60;
		 $hora_Extras=number_format($hora_Extras,2,',','.');
		return $hora_Extras;
	}
		$sql = 'SELECT m.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
		' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion` m '.
		' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
		' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE m.ACTIVO = 1 '.$sqlaux.
		' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC  '; 
	
	$data = array();
	 function existe($cod_personal,$gestion,$mes,$dia,$horario,$cargo,$centro,$HE1,$HS1,$HE2,$HS2)
	 {
		$sqlex = 'SELECT count(mv.COD_PERSONAL) as TOTALE from  marcacion_valida mv where mv.COD_PERSONAL='.$cod_personal.' and mv.GESTION='.$gestion.' and  mv.MES='.$mes.' and  mv.DIA='.$dia;
		$resultadoex=mysql_query($sqlex,$_SESSION['BD']);
		$tot1 = mysql_fetch_array($resultadoex);
		$t1=$tot1['TOTALE'];
		//echo "/*-$t1-*/";
		if($t1==0)
		{
		
			$sqlreg = "INSERT INTO marcacion_valida(COD_PERSONAL,GESTION,MES,DIA,COD_HORARIO,HIE,HIS,HFE,HFS,COD_CARGO,COD_CENTRO,ACTIVO) ".
										  "values('$cod_personal','$gestion','$mes','$dia','$horario','$HE1','$HS1','$HE2','$HS2','$cargo','$centro','1')";
						//echo "/*$sqlreg*/";					
										$resultadoreg = mysql_query($sqlreg , $_SESSION['BD']);
		}
		
		
			return $t1;
	 }
	  function existe1($cod_personal,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(mv.COD_PERSONAL) as TOTALE from  marcacion_valida mv where mv.COD_PERSONAL='.$cod_personal.' and mv.GESTION='.$gestion.' and  mv.MES='.$mes.' and  mv.DIA='.$dia;
		//echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function modificar($cod_personal,$gestion,$mes,$dia,$HE1,$HS1,$HE2,$HS2)
	 {
		
		
			$sqlreg1 = "update marcacion_valida set HIE='$HE1',HIS='$HS1',HFE='$HE2',HFS='$HS2' where COD_PERSONAL=$cod_personal and GESTION=$gestion and  MES=$mes and DIA=$dia ";
										  //echo "/*$sqlreg1*/";
										
										$resultadoreg1 = mysql_query($sqlreg1 , $_SESSION['BD']);
		
	 }
	$resultado=mysql_query($sql,$_SESSION['BD']);    	
	$horario_Real="";
	$cont2=0;
	$cont3=-1;
	$aux=0;
	$acu=1;
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
	$minutoE=0;
	$aux3=1;
	$tipoAsignacion=0;
	$nn=0;
	$e5=$tot;
	$tipoHorario=0;
	$codHorario=0;
	$nombreHorario="";
	$prueba=0;
	$tick=0;//0:verde 1:rojo
	$horarioPersona=0;
	$horasDeHorario=0;
	while ($row = mysql_fetch_array($resultado)){
		$horasDeHorario=0;
		//echo "/*hola que tal*/";
		$fv=$row['COD_PERSONAL'];
		//echo "/*$fv*/";
		$tipoAsignacion=asignacion($rcargador,$ridcargador,$row['COD_PERSONAL']);
		$prueba=0;
		$tick=0;
		if($tipoAsignacion==1 || $rcargador !=7 )
		{
		//	echo "/*hola ES*/";
			$nn=existe1($row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA']);
			if($nn==0)
				{
					
					 $i1 = strtotime($fechai); 
					$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
					if($nombreDia==0)
					{$nombreDia=7;}
					$sqla = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
					' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
					'   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$row['NRO_TRABAJADOR'];
					$res=mysql_query($sqla,$_SESSION['BD']);  
					if ($row4 = mysql_fetch_array($res)){
						$tipoHorario=$row4['COD_HORARIO'];
						$horarioPersona=$row4['COD_HORARIOPERSONA'];
						$codHorario=$row4['COD_TIPOHORARIO'];
						$nombreHorario=$row4['NOMBRE_HORARIO'];
						$HE1=(string)$row4['INICIO_ENTRADAH'].':'.(string)$m[$row4['INICIO_ENTRADAM']].':00';
						$HS2=(string)$row4['FINAL_SALIDAH'].':'.(string)$m[$row4['FINAL_SALIDAM']].':00';
						if($codHorario==1)
						{
							$horasDeHor=restaHoras($HE1,$HS2)	;
							$horasDeHorario=HorasExtras($horasDeHor);
		
							$HS1=0;
							$HE2=0;
						}
						else
						{
							
							
							$HS1=(string)$row4['FINAL_ENTRADAH'].':'.(string)$m[$row4['FINAL_ENTRADAM']].':00';
							$HE2=(string)$row4['INICIO_SALIDAH'].':'.(string)$m[$row4['INICIO_SALIDAM']].':00';
							$hora1=restaHoras($HE1,$HS1)	;
							
							$hora1=HorasExtras($hora1);
							
							$hora2=restaHoras($HE2,$HS2)	;
							$hora2=HorasExtras($hora2);
							$horasDeHorario=(double)$hora1+(double)$hora2;
						}

					}
					else
					{
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
					}
					$nombre_completo=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					$HoraMarcacion=(string)$row['HORA'].':'.(string)$row['MINUTO'].':'.(string)$row['SEGUNDO'];
					
					$r=horario($HoraMarcacion,$HE1,$HS1,$HE2,$HS2);
					if($r==1){$v1=$HoraMarcacion;}
					if($r==2){$v2=$HoraMarcacion;}
					if($r==3){$v3=$HoraMarcacion;}
					if($r==4){$v4=$HoraMarcacion;}
				
				}
	
			if(($con)==$t[$aux])
			{	
					if($nn==0)
					{
						if($codHorario==1)
						{
							$k="HE:".$v1.",HS:".$v4;
							$horarioOficial="HE:".$HE1.",HS:".$HS2;
						}
						else
						{
							$k="HE:".$v1.",HS:".$v2.",HE:".$v3.",HS:".$v4;
							$horarioOficial="HE:".$HE1.",HS:".$HS1.",HE:".$HE2.",HS:".$HS2;
						}
						
					}
						$n=existe($row['NRO_TRABAJADOR'],$row['GESTION'],$row['MES'],$row['DIA'],$tipoHorario,$row['COD_CARGO'],$row['COD_CENTRO'],$v1,$v2,$v3,$v4);
						if($n==0)
						{
							
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
								if($v4!="")//HORAS EXTRAS
								{
									$ch1=CompararHoras($v4,$HS2);
										if($ch1==1)
										{
												$hextras=restaHoras($HS2,$v4);
												$minutoE=HorasExtras($hextras);
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
								if($codHorario==1)
								{
									$HS1="---";
									$HE2="---";
								}
								if($horarioPersona==1)
								{
									$tick=0;
								}
								if($prueba==1)
								{
									$HE1="---";
									$HS2="---";
									$minutoR=0;
									$minutoE=0;
									$tick=1;
								}
								array_push($data, 
								array( 	"codigo"		=> $row['NRO_TRABAJADOR'], 
									"nombre" 	=>   $nombre_completo,
									"horarioOficial"		=> $tipoHorario,
									"nombreHorario" => $nombreHorario,
									"IEH"		=> "",
									"IEM"		=> "",
									"IFH"		=> "",
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
									"hiem"  => $v1,
									"hism"  => $v2,
									"hfem"  => $v3,
									"hfsm"  => $v4,
									"minuto" =>$minutoR,
									"he"		=> substr( $HE1 , 0, strlen($HE1) - 3),
									"hs"		=> substr( $HS1 , 0, strlen($HS1) - 3),
									"he1"		=>  substr( $HE2 , 0, strlen($HE2) - 3),
									"hs1"		=>  substr( $HS2 , 0, strlen($HS2) - 3),
									"horasExtras" =>$minutoE,
									"tick" =>$tick,
									"validacionRetraso"=>1,
									"nvalidacionRetraso"=>"SIN ACCION",
									"validacionFaltas"=>1,
									"nvalidacionFaltas"=>"SIN ACCION",
									"validador"=>"",
									"horasdehorario"=>$horasDeHorario
									
								));
						}
					else
						{
							//echo "/*-----------------------REVISION DE DUPLICADOS---------------------------------------------------------------------------------------------*/";
							$tick=0;
							$tick1=0;
							$aux3=1;
							$horasDeHorario=0;
							$validacionRetraso=0;
							$nvalidacionRetraso="";
							$validacionFalta=0;
							$nvalidacionFalta="";
							$sqlt='SELECT  count(m.COD_PERSONAL) as tot FROM `marcacion` m  inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR'.
					
							'  WHERE m.ACTIVO = 1   and  m.COD_PERSONAL='.$row['NRO_TRABAJADOR'].
							' and m.GESTION='.$row['GESTION'].' and m.MES='.$row['MES'].' and m.DIA='.$row['DIA'].' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC';
							//echo "/*---$sqlt---*/";
							$resultadot=mysql_query($sqlt,$_SESSION['BD']);  
							$sqlt1='SELECT  mv.COD_HORARIO as COD_HO FROM `marcacion_valida` mv  '.
					
							'  WHERE mv.ACTIVO = 1   and  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].
							' and mv.GESTION='.$row['GESTION'].' and mv.MES='.$row['MES'].' and mv.DIA='.$row['DIA'];
							//echo "/*----$sqlt1*/";
							$resultadot1=mysql_query($sqlt1,$_SESSION['BD']);  
							$tt1 = mysql_fetch_array($resultadot1);
							$tH=$tt1['COD_HO'];
				
							$tt = mysql_fetch_array($resultadot);
							$t2=$tt['tot'];
							$sqlx= 'SELECT m.*,p.* FROM `marcacion` m  inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR   WHERE m.ACTIVO = 1   and  m.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and m.GESTION='.$row['GESTION'].' and m.MES='.$row['MES'].' and m.DIA='.$row['DIA'].'  order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA,m.COD_MARCACION ASC';
						
							echo "/*----$sqlx----*/";
				
							$resultadoreg = mysql_query($sqlx , $_SESSION['BD']);
							while ($row1 = mysql_fetch_array($resultadoreg))
							{
								
								$nombre_completo=$row1['AP_PATERNO'].' '.$row1['AP_MATERNO'].' '.$row1['NOMBRE'].' '.$row1['NOMBRE2'];
								$HoraMarcacion1=(string)$row1['HORA'].':'.(string)$row1['MINUTO'].':'.(string)$row1['SEGUNDO'];
								
								$sqlw='SELECT mv.COD_PERSONAL,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_HORARIOPERSONA,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH, h.FINAL_ENTRADAM,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv  inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR  inner join horario h on mv.COD_HORARIO=h.COD_HORARIO inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE mv.ACTIVO = 1   and  mv.COD_PERSONAL='.$row['NRO_TRABAJADOR'].' and mv.GESTION='.$row['GESTION'].' and mv.MES='.$row['MES'].' and mv.DIA='.$row['DIA'].' order by mv.COD_PERSONAL,mv.GESTION,mv.MES,mv.DIA ASC'; 
								echo "/*----$sqlw----*/";
								$resultadoreg3 = mysql_query($sqlw , $_SESSION['BD']);
								while ($roww = mysql_fetch_array($resultadoreg3))
								{
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
												if($roww['COD_TIPOHORARIO']==1)
												{
													$k1="HE:".$v11.",HS:".$v14;
													
													$horarioOficial1="HE:".$HE11.",HS:".$HS12;
													//$horasDeHorario=restaHoras($HE11,$HS12)	;
													$horasDeHor=restaHoras($HE11,$HS12)	;
													$horasDeHorario=HorasExtras($horasDeHor);
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
													if($v14!="")//HORAS EXTRAS
													{
														$ch1=CompararHoras($v14,$HS12);
														if($ch1==1)
														{
															
															$hextras=restaHoras($HS12,$v14);
															$minutoE=HorasExtras($hextras);
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
													
													
													$ee=$roww['RETRASO'];
													ECHO "/*subir------$ee*/";
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
													if($horarioPersona==1)
													{
														$tick=0;
													}
													if($roww['horariodia']==0)
													{
														$HE11='---';
														$HS12='---';
														$minutoR=0;
														$minutoE=0;
														$tick=1;
													}
													
											array_push($data, 
											array( 	"codigo"		=> $row1['NRO_TRABAJADOR'], 
												"nombre" 	=>   $nombre_completo,
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
												"hiem"  => $v11,
												"hism"  => $v12,
												"hfem"  => $v13,
												"hfsm"  => $v14,
												"minuto" =>$minutoR,
												"he"		=> substr( $HE11 , 0, strlen($HE11) - 3),
												"hs"		=> substr( $HS11 , 0, strlen($HS11) - 3),
												"he1"		=>  substr( $HE12 , 0, strlen($HE12) - 3),
												"hs1"		=>  substr( $HS12 , 0, strlen($HS12) - 3),
												"horasExtras" =>$minutoE,
												"tick"		=>$tick,
												"validacionRetraso"=>$validacionRetraso,
												"nvalidacionRetraso"=>$nvalidacionRetraso,
												// "validacionFaltas"=>$validacionFalta,
												// "nvalidacionFaltas"=>$nvalidacionFalta,
													"validacionFaltas"=>1,
													"nvalidacionFaltas"=>"SIN ACCION",
													"validador"=>$roww['VALIDADOR'],
													"horasdehorario"=>$horasDeHorario,
												));
									
											modificar($row1['NRO_TRABAJADOR'],$row1['GESTION'],$row1['MES'],$row1['DIA'],$v11,$v12,$v13,$v14);
										}
								}
								
								
					
								$aux3++;
				
							}
						}
			//echo "/*---------punto aparte--------*/";
		//	echo "/*---------$tot--------*/";
		//	echo "/*$acu*/";
			// if($tot==$acu)
			if($acu==1)
			{
				$cont2=1;
				 $sqly= 'select p.*,C.DESCRIPCION,cc.DESCRIPCION as cDESCRIPCION,s.DESCRIPCION as sDESCRIPCION,u.DESCRIPCION as uDESCRIPCION FROM personal p inner join cargo C on p.COD_CARGO=C.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO inner join unidad u on cc.COD_UNIDAD=u.COD_UNIDAD  WHERE p.NRO_TRABAJADOR NOT IN (SELECT COD_PERSONAL FROM marcacion where GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia.') AND p.ACTIVO=1';
				echo "/*aqui esta la primera prueba*/";
				echo "/*$sqly*/";
				$resultadoy=mysql_query($sqly,$_SESSION['BD']);  
				while ($row2 = mysql_fetch_array($resultadoy))
				{
						$horasDeHorario=0;
						$tipoAsignacion=asignacion($rcargador,$ridcargador,$row2['COD_PERSONAL']);
						if($tipoAsignacion==1 || $rcargador !=7 )
						{
						
						 $i1 = strtotime($fechai); 
								$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
								if($nombreDia==0)
								{$nombreDia=7;}
								
							 $sqla2 = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
								' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
								 '   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$row2['NRO_TRABAJADOR'];
								$res2=mysql_query($sqla2,$_SESSION['BD']);
								if ($row3 = mysql_fetch_array($res2)){
								$tick=1;
								$horarioPersona=$row3['COD_HORARIOPERSONA'];
									$tHorario=$row3['COD_HORARIO'];
									$codHorario=$row3['COD_TIPOHORARIO'];
									$nombreHorario1=$row3['NOMBRE_HORARIO'];
									$HEE1=(string)$row3['INICIO_ENTRADAH'].':'.(string)$m[$row3['INICIO_ENTRADAM']].':00';
									$HSS2=(string)$row3['FINAL_SALIDAH'].':'.(string)$m[$row3['FINAL_SALIDAM']].':00';
									if($codHorario==1)
									{
										$HSS1="---";
										$HEE2="---";
										$horasDeHor=restaHoras($HEE1,$HSS2)	;
										$horasDeHorario=HorasExtras($horasDeHor);
										//$horasDeHorario=restaHoras($HEE1,$HSS2)	;
									}
									else
									{
									
										$HSS1=(string)$row3['FINAL_ENTRADAH'].':'.(string)$m[$row3['FINAL_ENTRADAM']].':00';
										$HEE2=(string)$row3['INICIO_SALIDAH'].':'.(string)$m[$row3['INICIO_SALIDAM']].':00';
										//$hora1=restaHoras($HEE1,$HSS1)	;
												//	$horas2=restaHoras($HEE2,$HSS2)	;
													//$horasDeHorario=(int)$hora1+(int)$horas2;
													
													$hora1=restaHoras($HEE1,$HSS1)	;
													$hora1=HorasExtras($hora1);
													$hora2=restaHoras($HEE2,$HSS2)	;
													$hora2=HorasExtras($hora2);
													$horasDeHorario=(double)$hora1+(double)$hora2;
									}
									 $nombre_completo=$row2['AP_PATERNO'].' '.$row2['AP_MATERNO'].' '.$row2['NOMBRE'].' '.$row2['NOMBRE2'];
									 $nn=existe1($row3['NRO_TRABAJADOR'],$gestion,$mes,$dia);
								if($nn==0)
									{
											if($horarioPersona==1)
													{
														$tick=0;
													}
											 existe($row3['NRO_TRABAJADOR'],$gestion,$mes,$dia,$tHorario,$row2['COD_CARGO'],$row2['COD_CENTRO'],"","","","");
										
									array_push($data, 
											array( 	"codigo"		=>$row3['NRO_TRABAJADOR'], 
												"nombre" 	=>   $nombre_completo,
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
												"cod_cargo"    => $row2['COD_CARGO'],
												"nombrecargo"    => $row2['DESCRIPCION'],
												"nombrecosto"    => $row2['cDESCRIPCION'],
											 "nombresubcentro"    => $row2['sDESCRIPCION'],
												"nombreunidad"    => $row2['uDESCRIPCION'],
												 "cod_centro"    => $row2['COD_CENTRO'],
													"gestion"  => "",
													"mes"  => "",
													"dia"  => "",
												"hiem"  => "",
												"hism"  => "",
												"hfem"  => "",
												"hfsm"  => "",
												"minuto" =>"F",
												"he"		=>  substr( $HEE1 , 0, strlen($HEE1) - 3),
												"hs"		=> substr( $HSS1 , 0, strlen($HSS1) - 3),
												"he1"		=> substr( $HEE2 , 0, strlen($HEE2) - 3),
												"hs1"		=>  substr( $HSS2 , 0, strlen($HSS2) - 3),
												"horasExtras" =>"F",
												"fechaMarcacion"		=>$dia."-".$mes."-".$gestion, 
												"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
												"tick"		=>$tick,
												"validacionRetraso"=>1,
												"nvalidacionRetraso"=>"SIN ACCION",
												"validacionFaltas"=>1,
												"nvalidacionFaltas"=>"SIN ACCION",
												"validador"=>"",
												"horasdehorario"=>$horasDeHorario,
											));
									
									}
									else
									{
										$horasDeHorario=0;
										$tick1=0;
										$sqlx1 = 'SELECT   mv.COD_PERSONAL as codPer,mv.COD_HORARIO as horariodia,mv.RETRASO,mv.FALTA,mv.VALIDADOR,p.*,c.COD_CARGO,c.DESCRIPCION,h.COD_TIPOHORARIO,h.TOLERANCIA_ENTRADA,h.INICIO_ENTRADAH,h.INICIO_ENTRADAM,h.FINAL_ENTRADAH,'.
										' h.FINAL_ENTRADAM,h.COD_HORARIOPERSONA,h.INICIO_SALIDAH,h.INICIO_SALIDAM,h.FINAL_SALIDAH,h.FINAL_SALIDAM,h.NOMBRE_HORARIO,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` mv '.
										' inner join personal p on mv.COD_PERSONAL=p.NRO_TRABAJADOR '.
										' inner join horario h on mv.COD_HORARIO=h.COD_HORARIO'.
										' inner join cargo c on c.COD_CARGO=mv.COD_CARGO inner join centro_de_costo cc on mv.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE mv.ACTIVO = 1  '.
										' and  mv.COD_PERSONAL='.$row3['NRO_TRABAJADOR'].' and mv.GESTION='.$gestion.' and mv.MES='.$mes.' and mv.DIA='.$dia;
										
										$resultadoreg5 = mysql_query($sqlx1 , $_SESSION['BD']);
										// $validacionRetraso=0;
										// $nvalidacionRetraso="";
										// $tick=0;
										while ($row5 = mysql_fetch_array($resultadoreg5))
										{
											$horarioPersona=$row5['COD_HORARIOPERSONA'];
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
											$tick1=1;
													
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
												$nvalidacionFalta="VACACION";
												
												$tick1=0;
											}
										
											$HEE11=(string)$row5['INICIO_ENTRADAH'].':'.(string)$m[$row5['INICIO_ENTRADAM']].':00';
											$HSS21=(string)$row5['FINAL_SALIDAH'].':'.(string)$m[$row5['FINAL_SALIDAM']].':00';
											if($row5['COD_TIPOHORARIO']==1)
											{
												$HSS11="---";
												$HEE21="---";
												//$horasDeHorario=restaHoras($HEE11,$HSS21)	;
												$horasDeHor=restaHoras($HEE11,$HSS21)	;
												$horasDeHorario=HorasExtras($horasDeHor);
											}
											else
											{
											
												$HSS11=(string)$row5['FINAL_ENTRADAH'].':'.(string)$m[$row5['FINAL_ENTRADAM']].':00';
												$HEE21=(string)$row5['INICIO_SALIDAH'].':'.(string)$m[$row5['INICIO_SALIDAM']].':00';
												//$hora1=restaHoras($HEE11,$HSS11)	;
													//$horas2=restaHoras($HEE21,$HSS21)	;
													//$horasDeHorario=(int)$hora1+(int)$horas2;
													
													$hora1=restaHoras($HEE11,$HSS11)	;
													$hora1=HorasExtras($hora1);
													$hora2=restaHoras($HEE21,$HSS21)	;
													$hora2=HorasExtras($hora2);
													$horasDeHorario=(double)$hora1+(double)$hora2;
											
											}
											if($horarioPersona==1)
													{
														$tick=0;
													}
											array_push($data, 
											array( 	"codigo"		=>$row5['codPer'], 
												"nombre" 	=>   $nombre_completo,
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
												"cod_cargo"    => $row2['COD_CARGO'],
												"nombrecargo"    => $row2['DESCRIPCION'],
												"nombrecosto"    => $row2['cDESCRIPCION'],
											 "nombresubcentro"    => $row2['sDESCRIPCION'],
												"nombreunidad"    => $row2['uDESCRIPCION'],
												 "cod_centro"    => $row2['COD_CENTRO'],
													"gestion"  => "",
													"mes"  => "",
													"dia"  => "",
												"hiem"  => "",
												"hism"  => "",
												"hfem"  => "",
												"hfsm"  => "",
												"minuto" =>"F",
												"he"		=>  substr( $HEE11 , 0, strlen($HEE11) - 3),
												"hs"		=> substr( $HSS11 , 0, strlen($HSS11) - 3),
												"he1"		=> substr( $HEE21 , 0, strlen($HEE21) - 3),
												"hs1"		=>  substr( $HSS21 , 0, strlen($HSS21) - 3),
												"horasExtras" =>"F",
												"fechaMarcacion"		=>$dia."-".$mes."-".$gestion, 
												"fechaMarcacion1"		=>$gestion."-".$mes."-".$dia, 
												"tick"		=>$tick1,
												"validacionRetraso"=>1,
												"nvalidacionRetraso"=>"SIN ACCION",
												"validacionFaltas"=>$validacionFalta,
												"nvalidacionFaltas"=>$nvalidacionFalta,
												"validador"=>$row5['VALIDADOR'],
												"horasdehorario"=>$horasDeHorario,
											));
										}
				
									}
								} 
								 
							
					}
				}
			
			}
			$acu++;
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
			$cont3++;
			
		}
			
			
	}
	else
	{
		if(($con)==$t[$aux])
		{
			$con=0;
			$aux++;
			$e5=$e5-1;
		}
		
		
	}
	$con++;

}  
										 
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
?> 