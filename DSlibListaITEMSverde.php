<?php     

include("lib/conex.php");        
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
function DevuelveListaMenuItem() { 
	if (VerificaConBD()) {			
		$sql = ' SELECT DP.*,S.COD_MENU, S.COD_SUB_MENU, S.RUTA, S.DESCRIPCION, S.ICON, M.DESCRIPCION AS MENU, M.ICON AS IMENU'.
			' FROM `detalle_perfil` DP inner join `submenu` S on DP.COD_SUB_MENU = S.COD_SUB_MENU'.
			' inner join `menu` M on S.COD_MENU = M.COD_MENU'.			
			' where DP.ACTIVO = 1 and DP.COD_TIPOU = '.$_SESSION['tipoUser'].
			' ORDER BY M.ORDEN, S.ORDENS ';
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
			// if($ttipo==0)
			// {
				// $ttipo="";
			// }
			$subm=	"Bandeja (Revisores)          [".$ttipo."]";
			$sql2 = " update submenu set DESCRIPCION='$subm' where COD_SUB_MENU='25'";
			$res = mysql_query($sql2, $_SESSION['BD']);
			
			//
				$sqla = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL FROM formulario f  inner join asignar_flujo a on f.COD_FORMULARIO=a.COD_FORMULARIO inner join detalle_flujo df on a.COD_ASIGNAR =df.COD_FLUJO  where  df.ESTADO=1 AND f.ACTIVO=1 AND df.COD_USUARIO= ".$_SESSION['IdUsuario'];
				
				$resulaprob=mysql_query($sqla,$_SESSION['BD']);
				$totalSA = mysql_fetch_array($resulaprob);
				$ttipo1=$totalSA['TOTAL'];

				$submenApro="Pendientes de Aprobacion          [".$ttipo1."]";
				
				 $sqlAprob = " update submenu set DESCRIPCION='$submenApro' where COD_SUB_MENU='26'";
			     $resAprob = mysql_query($sqlAprob, $_SESSION['BD']);
			//
			
			//
				$sqlb = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL from formulario f  inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL  where   f.ESTADO=1 AND f.ACTIVO=1 and f.COD_USUARIO=".$_SESSION['IdUsuario'];
				
				$resulb=mysql_query($sqlb,$_SESSION['BD']);
				$totalb = mysql_fetch_array($resulb);
				$ttipob=$totalb['TOTAL'];

				$submenb="Bandeja (Borradores)         [".$ttipob."]";
			///////////////////////////////////////// bandeja borradores sin leer
				$sqlb1 = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL from formulario f  inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL  where  f.LEIDO=0 and f.ESTADO=1 AND f.ACTIVO=1 and f.COD_USUARIO=".$_SESSION['IdUsuario'];
				
				$resulb1=mysql_query($sqlb1,$_SESSION['BD']);
				$totalb1 = mysql_fetch_array($resulb1);
				$ttipob1=$totalb1['TOTAL'];
			//////////////////////////////////////////
				 $sqlb = " update submenu set DESCRIPCION='$submenb' where COD_SUB_MENU='24'";
			     $resb = mysql_query($sqlb, $_SESSION['BD']);
				// SELECT f.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO from formulario f  inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL where f.COD_USUARIO=$codUsuario and f.ESTADO=5 AND f.ACTIVO=1
			//
			//
					$sqlr = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL from formulario f  inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL where  f.ESTADO=5 AND f.ACTIVO=1 and f.COD_USUARIO=".$_SESSION['IdUsuario'];
					$resulr=mysql_query($sqlr,$_SESSION['BD']);
					$totalr = mysql_fetch_array($resulr);
					$ttipor=$totalr['TOTAL'];

					$submenr="Bandeja (Rechazado)         [".$ttipor."]";
					
					 $sqlr = " update submenu set DESCRIPCION='$submenr' where COD_SUB_MENU='29'";
					 $resr = mysql_query($sqlr, $_SESSION['BD']);
			///////////// RECHAZADO SIN LEER
					$sqlr1 = "SELECT COUNT(f.COD_FORMULARIO) AS TOTAL from formulario f  inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL where  f.LEIDO=0 AND f.ESTADO=5 AND f.ACTIVO=1 and f.COD_USUARIO=".$_SESSION['IdUsuario'];
					$resulr1=mysql_query($sqlr1,$_SESSION['BD']);
					$totalr1 = mysql_fetch_array($resulr1);
					$ttipor1=$totalr1['TOTAL'];
			
					
			//
		
		$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		date_default_timezone_set('America/La_Paz');
		$fecha=date("Y-m-d");
		$fechaf = $fecha;
		$i2 = strtotime($fecha ."- 2 months"); 
		$fechai=(string) date("Y",$i2)."-".(string)date("m",$i2)."-01";
		//$fechai = "2015-07-01";
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
		$submenhr="Horas Extras* (Aprobacion) [".$cont."]";
					
					 $sqlr = " update submenu set DESCRIPCION='$submenhr' where COD_SUB_MENU='45'";
					 $resr = mysql_query($sqlr, $_SESSION['BD']);
		//////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////Retrasos y faltas sin revision
	$total_sin_revision=0;
	$total_sin_revisionretraso=0;
	date_default_timezone_set('America/La_Paz');
		$fecha=date("Y-m-d");
		$i2 = strtotime($fecha ."- 1 days"); 
		$fecha=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)date("d",$i2);
		$fechaf = $fecha;
		$fechai=(string) date("Y",$i2)."-".(string)date("m",$i2)."-".(string)("01");
		//$fechai = "2015-09-01";
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
	function asignacion($cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador!=2)
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
	function es_feriado($gestion,$mes,$dia)
	{
		$t2=0;
		$sqlex1 = 'SELECT COD_FERIADO as TOTALE from  feriado  where ACTIVO=1 and GESTION='.$gestion.' and MES='.$mes.' and DIA='.$dia;
		//echo "/*$sqlex1*/";
		$resultadoex1=mysql_query($sqlex1,$_SESSION['BD']);
		$tot2 = mysql_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		return $t2;
	}
		function minutosAtraso($matraso)
	{
		list($horas, $minutos, $segundos) = explode(':', $matraso);
		$hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
		$hora_en_segundos=$hora_en_segundos/60;
		 $hora_en_segundos=number_format($hora_en_segundos,0,'.','.');
		return $hora_en_segundos;
	}
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
	$sqlsr = 'SELECT p.*,c.COD_CARGO,c.DESCRIPCION,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion from personal p  inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO'.
	       ' INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE p.ACTIVO=1  order by p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2';
	
	$resultadosr=mysql_query($sqlsr,$_SESSION['BD']);    	

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
	
	$retraso;
	$minutoR=0;
	$minutoE=0;
	$aux3=1;
	$tipoAsignacion=0;
	$tipoAsignacion1=0;
	$nn=0;
	
	$tipoHorario=0;
	$codHorario=0;
	$nombreHorario="";
	$prueba=0;
	$tick=0;//0:verde 1:rojo
	$horarioPersona=0;
	$horasDeHorario=0;
	$nocturno=0;
	$nocturno1=0;
	$horasEfectivas=0;
	$recargoNocturno=0;
	$bandera=0;
	$aprob=0;
	$d[1]="LUNES";$d[2]="MARTES";$d[3]="MIERCOLES";$d[4]="JUEVES";$d[5]="VIERNES";$d[6]="SABADO";$d[7]="DOMINGO";
		$m[1]="00";$m[5]="05";$m[10]="10";$m[15]="15";$m[20]="20";$m[25]="25";$m[30]="30";$m[35]="35";$m[40]="40";$m[45]="45";$m[50]="50";$m[55]="55";
		
	$rdirecto = 1;
	$rextendido =0;
	while ($row = mysql_fetch_array($resultadosr)){
		
		 $tipoAsignacion=asignacion($rcargador,$ridcargador,$row['COD_PERSONAL']);
		// $tipoAsignacion1=asignacionAprobar($rcargador,$ridcargador,$row['COD_PERSONAL']);
		if($tipoAsignacion==1)
		{
				$op1=0;
				
				if($rdirecto==1 and $rextendido==0)
				{
					
					if($tipoAsignacion==1)
					{
						$op1=1;
						
					}
					else
					{
						$op1=2;
					}
					
				}
				
				
				if($op1==1)
				{
					$codigo=$row['NRO_TRABAJADOR'];
						$retrasomes=0;
						$retrasomes1=0;
						$retrasoT=0;
						$faltas=0;
						$hen=0;
						$hf=0;
						$hd=0;
						$rn=0;
						
						$sql1 = 'SELECT m.*,h.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
							' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` m '.
							' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
							' inner join horario h on h.COD_HORARIO=m.COD_HORARIO '.
							' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  p.NRO_TRABAJADOR=' .'"'.$codigo.'"'.$sqlaux.
							' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA ASC  ';
							
						//echo "/*esto nada -->$sql1*/";
						 $resultado1=mysql_query($sql1,$_SESSION['BD']); 
						 while ($row1 = mysql_fetch_array($resultado1)){
						 	$tick=0;
							$gestion=$row1['GESTION'];
							$mes=$row1['MES'];
							$dia=$row1['DIA'];
							
							
							if((int)$mes<10)
							{
								$mes="0".$mes;
							}
							if((int)$dia<10)
							{
								$dia="0".$dia;
							}
							$fecha=$dia."/".$mes."/".$gestion;
							$fecha1=$gestion."-".$mes."-".$dia;
							
							$i1 = strtotime($fecha1); 
							$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
							if($nombreDia==0)
							{$nombreDia=7;}
							$Ndia=$d[$nombreDia];
							if(strtotime(date($row1['FECHA_INGRESO']))<= strtotime( date($row1['GESTION']."-".$row1['MES']."-".$row1['DIA'])))
							{	
									$COD_HORARIOPERSONA=$row1['COD_HORARIOPERSONA'];
									$HE1="";
									$HS1="";
									$HS2="";
									$HE2="";
									$HE1=(string)$row1['INICIO_ENTRADAH'].':'.(string)$m[$row1['INICIO_ENTRADAM']];	
									if($row1['COD_TIPOHORARIO']==2)
									{
									$HS1=(string)$row1['FINAL_ENTRADAH'].':'.(string)$m[$row1['FINAL_ENTRADAM']];
									$HE2=(string)$row1['INICIO_SALIDAH'].':'.(string)$m[$row1['INICIO_SALIDAM']];
									}
									
									$HS2=(string)$row1['FINAL_SALIDAH'].':'.(string)$m[$row1['FINAL_SALIDAM']];
								//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								if($row1['HIE']!="")//minutosAtraso
								{
									$ch=CompararHoras($row1['HIE'],$HE1);
										if($ch==1)
										{
												$retraso=restaHoras($HE1,$row1['HIE']);
												$minutoR=minutosAtraso($retraso);
												
										}
										else
										{
												$minutoR="0";
										}
					
					
								}
								else
									{
											$minutoR="SM";
							
									} 
								
								if($row1['HFE']!="")//minutosAtraso
								{
									$ch=CompararHoras($row1['HFE'],$HE2);
										if($ch==1)
										{
												$retraso=restaHoras($HE2,$row1['HFE']);
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
								if($minutoT=="SM")
								{
									$minutoT=0;
								}
								if((int)$row1['FALTA']==1)
								{
									$minutoT=0;
								}
								$libre=0;//libre dia en que el trabajador opta por venir
								$sqla = 'SELECT p.COD_PERSONAL,p.NRO_TRABAJADOR,hd.COD_HORARIO,hd.COD_DIA,h.* from personal p inner join horario_personal hp on p.COD_PERSONAL=hp.COD_PERSONAL inner join horario h on hp.COD_HORARIO=h.COD_HORARIO '.
								' inner join horario_dia hd on hd.COD_HORARIO=h.COD_HORARIO'.
								'   WHERE p.ACTIVO = 1 and hp.ACTIVO=1 and hd.ACTIVO=1 and hd.COD_DIA='.$nombreDia.' and p.NRO_TRABAJADOR='.$codigo;
							$res=mysql_query($sqla,$_SESSION['BD']);   
							if ($rowres = mysql_fetch_array($res)){
							$libre=1;
							}
							if($libre==1)
							{
								//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								if(((int)$row1['FALTA']==0) or (int)$minutoT>10 )
									{
											 $nomretraso="";
													 $nomfalta="";
													 if($row1['RETRASO']==0){$nomretraso="SIN ACCION";}
													if($row1['RETRASO']==1){$nomretraso="JUSTIFICADO";}
													if($row1['RETRASO']==2){$nomretraso="INJUSTIFICADO";}
													
													if($row1['FALTA']==0){$nomfalta="SIN ACCION";}
													if($row1['FALTA']==1){$nomfalta="JUSTIFICADO";}
													if($row1['FALTA']==2){$nomfalta="INJUSTIFICADO";}
													if($row1['FALTA']==3){$nomfalta="LICENCIA";}		
										if($COD_HORARIOPERSONA==2)
										{
											$fechanueva="2015-09-01";
											if(strtotime(date($fechanueva)) > strtotime( date($row1['GESTION']."-".$row1['MES']."-".$row1['DIA'])))
											{
												 if(($row1['HIE']=="" or $row1['HFS']=="")){
												
														if($row1['HIE']=="" and $row1['HFS']=="" and $row1['HIS']=="" and $row1['HFE']==""){
															$tick=1;
														}
														if($row1['FALTA']!=3)
														{
																
															$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
															$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if($nomfalta=="SIN ACCION")
																$total_sin_revision=$total_sin_revision+1;
													
															}
														}
												   }
												   else
												   {
														if($row1['FALTA']!=3)
														{
																
															$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
															$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if(( int)$minutoT>10 and $nomretraso=="SIN ACCION")
																$total_sin_revisionretraso=$total_sin_revisionretraso+1;
													
															}
														}
												   }
											}
											else
											{
												if($row1['COD_TIPOHORARIO']==2)
											    {
													if(($row1['HIE']=="" or $row1['HFS']=="" or $row1['HIS']=="" or $row1['HFE']=="")){
												
														if($row1['HIE']=="" and $row1['HFS']=="" and $row1['HIS']=="" and $row1['HFE']==""){
															$tick=1;
														}
														if($row1['FALTA']!=3)
														{
																
															$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
															$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if($nomfalta=="SIN ACCION")
																$total_sin_revision=$total_sin_revision+1;
													
															}
														}
												   }
												   else
												   {
														if($row1['FALTA']!=3)
														{
																
															$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
															$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if(( int)$minutoT>10 and $nomretraso=="SIN ACCION")
																$total_sin_revisionretraso=$total_sin_revisionretraso+1;
													
															}
														}
												   }
												}
												else
												{
												if(($row1['HIE']=="" or $row1['HFS']=="")){
												
														if($row1['HIE']=="" and $row1['HFS']=="" and $row1['HIS']=="" and $row1['HFE']==""){
															$tick=1;
														}
														if($row1['FALTA']!=3)
														{
																
															$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
															$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if($nomfalta=="SIN ACCION")
																$total_sin_revision=$total_sin_revision+1;
													
															}
														}
												   }
												   else
												   {
														if($row1['FALTA']!=3)
														{
																
															$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
															$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if(( int)$minutoT>10 and $nomretraso=="SIN ACCION")
																$total_sin_revisionretraso=$total_sin_revisionretraso+1;
													
															}
														}
												   }
												 }
											}
											 
									  }
									  else
									  {
										if($COD_HORARIOPERSONA==1)
										{
											$fechanueva="2015-09-01";
											if(strtotime(date($fechanueva)) > strtotime( date($row1['GESTION']."-".$row1['MES']."-".$row1['DIA'])))
											{
												if($row1['HIE']=="" and $row1['HFS']=="" and $row1['HIS']=="" and $row1['HFE']==""){
												$tick=1;
												$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
												$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
													if($tferiado==0)
													{
														if($nomfalta=="SIN ACCION")
														$total_sin_revision=$total_sin_revision+1;
												
													}
											    }
											}
											else
											{
												if($row1['COD_TIPOHORARIO']==2)
											    {
													if($row1['HIE']!="" and $row1['HFE']!=""){
													
													}
													else
													{
														$tick=1;
														$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
														$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																	if($nomfalta=="SIN ACCION")
																$total_sin_revision=$total_sin_revision+1;
														
															}
													}
												}
												else
												{
													if($row1['HIE']!=""){
													
													}
													else
													{
														$tick=1;
														$feriado=es_feriado($row1['GESTION'],$row1['MES'],$row1['DIA']);
														$sferiadoregional="select count(CODFERIADO) as tot from feriado_region where CODFERIADO='$feriado' and CODREGION	= ".$row1['COD_REGIONAL'];
												
															$rferiado=mysql_query($sferiadoregional,$_SESSION['BD']);
															$toferiado = mysql_fetch_array($rferiado);
															$tferiado=$toferiado['tot'];
															if($tferiado==0)
															{
																if($nomfalta=="SIN ACCION")
																$total_sin_revision=$total_sin_revision+1;
														
															}
													}
												}
												
											}
										}
											
											
										/////////////
									  }
								    }
								}
								
							}
						 }
							
			}		
		}
	}  
		$submensinrevision="Faltas* (Sin Revision) [".$total_sin_revision."]";
					
					 $sqlr = " update submenu set DESCRIPCION='$submensinrevision' where COD_SUB_MENU='15'";
					 $resr = mysql_query($sqlr, $_SESSION['BD']);
					 
		$submensinrevision1="Retrasos * (Sin Revision) [".$total_sin_revisionretraso."]";
					
					 $sqlr1 = " update submenu set DESCRIPCION='$submensinrevision1' where COD_SUB_MENU='63'";
					 $resr1 = mysql_query($sqlr1, $_SESSION['BD']);
		//////////////////////////////////////////////////////////////////////
		
		
		
		mysql_query("SET NAMES 'utf8'");
		$resultado = mysql_query($sql, $_SESSION['BD']);	
		//echo mysql_error();		
		$nreg = mysql_num_rows($resultado); 	
		$cmenu = '';
		$rmenu = '';
		$fmenu = "]}),	listeners: { 'render' : FNcentral, 'click' : FNcentralclick}}";
		$pmenu = '';	
		$data = '';
			$reg_cab = 1;  		
			$i = 0;
			//<FONT FACE="ARIAL" COLOR="#FFB000" SIZE=5><MARQUEE BEHAVIOR="SLIDE" LOOP=3 SCROLLDELAY=200>
			//'<a style ="color:##green ; font: bold 8px tahoma,arial,verdana,sans-serif;">APROBADOR</a>',  
				
			while ($row = mysql_fetch_array($resultado)) {		
				$valor_menu = $row['COD_SUB_MENU'] * 1;	
						$cadena = $row['DESCRIPCION'];
								$buscar = '*';
								$reemplazar = '';
								$img='"img/ala.gif"';
								$titulo= str_replace($buscar, $reemplazar, $cadena);
						if (strcmp($pmenu, $row['COD_MENU']) == 0) {				
							  if (strlen($cmenu) == 0) {
									if(($row['COD_MENU']==9 and $trevi>0 and $ttipo>0) or ($row['COD_MENU']==10 and $ttipo1>0) or ($row['COD_MENU']==6 and $cont>0) or ($row['COD_MENU']==9 and $ttipob1>0) or ($row['COD_MENU']==9 and $ttipor1>0) or ($row['COD_MENU']==6 and $total_sin_revision>0) or ($row['COD_MENU']==6 and $total_sin_revisionretraso>0))
									{
										$cmenu = "{	xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1> <b style = color:red; >" . $row['MENU'] . "          <img src=".$img."/></b></FONT>', iconCls:'MAN2',	id: 'MENU" . $row['COD_MENU'] . 
										"',	margins: '2 2 0 2', autoScroll: true, rootVisible: false, collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: ["; 
									}
									else
									{
										$cmenu = "{	xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1> <b style = color:green ; >" . $row['MENU'] . "         </b></FONT>', iconCls:'MAN2',	id: 'MENU" . $row['COD_MENU'] . 
										"',	margins: '2 2 0 2', autoScroll: true, rootVisible: false, collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: ["; 
									}
									
							}
							if($row['COD_SUB_MENU']==25 and $ttipo>0)
							  $rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style = color:red; >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenuverde'},";
							else{
									if(($row['COD_SUB_MENU']==26 and $ttipo1>0) or ($row['COD_SUB_MENU']==45 and $cont>0) or ($row['COD_SUB_MENU']==24 and $ttipob1>0) or ($row['COD_SUB_MENU']==29 and $ttipor1>0) or ($row['COD_SUB_MENU']==15 and $total_sin_revision>0) or ($row['COD_SUB_MENU']==63 and $total_sin_revisionretraso>0))
									 $rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style = color:red; >" . $titulo . " </b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenuverde'},";
									else
									  $rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style = color:green ; >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenuverde'},";
							 }
					  	}	
						else {
									if (strcmp($pmenu, '') != 0) {
										if (strlen($rmenu) > 0)
									$rmenu = substr($rmenu,0,strlen($rmenu) -1);  	
								  if (strlen($cmenu) == 0) {
											if(($row['COD_MENU']==9 and $trevi>0 and $ttipo>0) or ($row['COD_MENU']==10 and $ttipo1>0) or ($row['COD_MENU']==6 and $cont>0) or ($row['COD_MENU']==9 and $ttipob1>0) or ($row['COD_MENU']==9 and $ttipor1>0) or ($row['COD_MENU']==6 and $total_sin_revision>0) or ($row['COD_MENU']==6 and $total_sin_revisionretraso>0) )
											{
												$cmenu = "{	xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1><b style = color:red; >" . $row['MENU'] . "          <img src=".$img."/></b></FONT>', iconCls:'MAN2',	id: 'MENU" . $row['COD_MENU'] . 
												  "',	margins: '2 2 0 2', autoScroll: true, rootVisible: false,collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: ["; 
											}
											else
											{
												$cmenu = "{	xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1><b style = color:green ; >" . $row['MENU'] . "          </b></FONT>', iconCls:'MAN2',	id: 'MENU" . $row['COD_MENU'] . 
												  "',	margins: '2 2 0 2', autoScroll: true, rootVisible: false,collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: ["; 
											}
										}
										$data .= $cmenu . $rmenu . $fmenu . ',';	 					  	
										$rmenu = ''; $reg_cab = 1;
									}	
									if ($reg_cab == 1){	
										if(($row['COD_MENU']==9 and $trevi>0 and $ttipo>0) or ($row['COD_MENU']==10 and $ttipo1>0) or ($row['COD_MENU']==6 and $cont>0) or ($row['COD_MENU']==9 and $ttipob1>0) or ($row['COD_MENU']==9 and $ttipor1>0) or ($row['COD_MENU']==6 and $total_sin_revision>0) or ($row['COD_MENU']==6 and $total_sin_revisionretraso>0))
										{
											$cmenu = "{	xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1><b style = color:red; >" . $row['MENU'] . "          <img src=".$img."/></b></FONT>', iconCls:'MAN2',	id: 'MENU" . $row['COD_MENU'] . 
											  "',	margins: '2 2 0 2', autoScroll: true, rootVisible: false,collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: ["; 
										}
										else
										{
											$cmenu = "{	xtype: 'treepanel', title:'<FONT FACE=ARIAL  SIZE=1><b style = color:green ; >" . $row['MENU'] . "          </b></FONT>', iconCls:'MAN2',	id: 'MENU" . $row['COD_MENU'] . 
											  "',	margins: '2 2 0 2', autoScroll: true, rootVisible: false,collapsed: true, root: new Ext.tree.AsyncTreeNode({ children: ["; 
										}
									$reg_cab = 0; 
								  }
								  if(($row['COD_SUB_MENU']==25 and $ttipo>0) or($row['COD_SUB_MENU']==45 and $cont>0) or ($row['COD_SUB_MENU']==24 and $ttipob1>0) or ($row['COD_SUB_MENU']==29 and $ttipor1>0) or ($row['COD_SUB_MENU']==15 and $total_sin_revision>0) or ($row['COD_SUB_MENU']==63 and $total_sin_revisionretraso>0))
								  $rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style =color:red;  >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenuverde'},";
								  else
									{
										if($row['COD_SUB_MENU']==26 and $ttipo1>0)
										$rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style =color:red;  >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenuverde'},";
										else
										$rmenu .= " {text: '<FONT FACE=ARIAL  SIZE=0><b style =color:green ;  >" . $titulo . "</b></FONT>', leaf: true, id:'s" . $row['COD_SUB_MENU'] . "', url: '" . $row['RUTA'] . "', iconCls:'submenuverde'},";
									}
					  }				  			
				$pmenu = $row['COD_MENU'];
				if (($i+1) == $nreg) {
					if (strlen($rmenu) > 0)
			      $rmenu = substr($rmenu,0,strlen($rmenu) -1);  	
				  $data .= $cmenu . $rmenu . $fmenu;
				}
				$i = $i + 1;				
		}	
		echo $data; 
	} else echo '';

}	

?> 