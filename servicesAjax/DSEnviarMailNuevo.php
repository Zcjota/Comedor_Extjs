<?php
//require("../PHPMailer/class.phpmailer.php");	
require '../PHPMailer/PHPMailerAutoload.php';
	function QuitaAcentos($cadena){
		$p = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ','&');
		$r = array('a','e','i','o','u','A','E','I','O','U','n','N','y');
		return str_replace($p, $r, $cadena);}	
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
		function restaHoras($horaIni, $horaFin){
			return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
		}
		function minutosAtraso($matraso)
	{
		list($horas, $minutos, $segundos) = explode(':', $matraso);
		$hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
		$hora_en_segundos=$hora_en_segundos/60;
		 $hora_en_segundos=number_format($hora_en_segundos,0,'.','.');
		return $hora_en_segundos;
	}
function EnvioMailPersonal($correo,$nombre,$codigo,$fechai,$fechaf)
{
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $HOST;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $CREDENCIAL;                 // SMTP username
		$mail->Password = $CONTRASENA;                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->CharSet = 'UTF-8';
		$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
		$mail->addAddress($correo, $nombre);     // Add a recipient
		$mail->isHTML(true);
		$mail->Subject = "ALERTA DE OBSERVACIONES";
		
		
		$fechainicio=$fechai;
		$valores = explode ("-", $fechainicio); 
		$gestion = $valores[0] ;
		$mes = $valores[1] ;
		$dia = $valores[2] ;
		$fechainicio=$dia."-".$mes."-".$gestion;
		
		$fechafin=$fechaf;
		$valores = explode ("-", $fechafin); 
		$gestion = $valores[0] ;
		$mes = $valores[1] ;
		$dia = $valores[2] ;
		$fechafin=$dia."-".$mes."-".$gestion;
		if ($fechai <> '' and $fechaf <>'')
		{
			$sqlaux = "  AND date(CONCAT(m.GESTION,'-',m.MES,'-',m.DIA)) BETWEEN '$fechai' AND '$fechaf' ";
		}
		 else
		{	
			$sqlaux = '';
		}
		
		//////////////////////////////////////cuerpo del mail///////////////////////////////////////////
	
		$Registros ='';	
		
		
	
	$sql =  'SELECT m.*,h.*,p.*,c.COD_CARGO,c.DESCRIPCION,'.
		    ' cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion FROM `marcacion_valida` m '.
		    ' inner join personal p on m.COD_PERSONAL=p.NRO_TRABAJADOR '.
		    ' inner join horario h on h.COD_HORARIO=m.COD_HORARIO '.
			' inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD  WHERE  p.NRO_TRABAJADOR=' .$codigo.$sqlaux.
			' order by m.COD_PERSONAL,m.GESTION,m.MES,m.DIA ASC  '; 
			$resultado=mysql_query($sql,$_SESSION['BD']);    	
			$data = array();	
			$d[1]="LUNES";$d[2]="MARTES";$d[3]="MIERCOLES";$d[4]="JUEVES";$d[5]="VIERNES";$d[6]="SABADO";$d[7]="DOMINGO";
			$m[1]="00";$m[5]="05";$m[10]="10";$m[15]="15";$m[20]="20";$m[25]="25";$m[30]="30";$m[35]="35";$m[40]="40";$m[45]="45";$m[50]="50";$m[55]="55";
				
	 $sql1 = 'SELECT p.*,c.DESCRIPCION,cc.DESCRIPCION as cDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion from `personal` p '.
		    " inner join cargo c on c.COD_CARGO=p.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO INNER JOIN unidad u ON u.COD_UNIDAD=cc.COD_UNIDAD   ".
			' WHERE  p.NRO_TRABAJADOR='.$codigo; 
	
	$resultado1 = mysql_query($sql1,$_SESSION['BD']);
	mysql_query("SET NAMES 'utf8'");
	$Encabezados = "".
			   	 
	$Registros1 ='';
	while ($row = mysql_fetch_array($resultado1)) 
		{
				$Registros1 = $Registros1 .
				
				 "<table border = 1>" .
				 "		<tr>" .
			  "<th style='text-align:center;font:12px'> NRO  </th> ".
						"<th style='text-align:center;font:12px'> DIA  </th> ".
			  "			<th style='text-align:center;font:12px'> FECHA </th> ".
			  "			<th style='text-align:center;font:12px'> TOTAL  </th> ".
			  "			<th style='text-align:center;font:12px'> OBSERVACIÓN  </th> ".
			  "		</tr>";
		}
		
	$Registros ='';	   
    $i=1;  
	while ($row1 = mysql_fetch_array($resultado)) 	{
		$fecha=$row1['GESTION']."-".$row1['MES'].'-'.$row1['DIA'];
		$fecha1=$row1['DIA']."-".$row1['MES'].'-'.$row1['GESTION'];
		$i1 = strtotime($fecha); 
		$nombreDia= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i1),date("d",$i1), date("Y",$i1)) , 0 );
		if($nombreDia==0)
					{$nombreDia=7;}
					$Ndia=$d[$nombreDia];
							$he=$row1['HIE'];
							$hes=$row1['HFE'];
							$hs=$row1['HFS'];
							$hs1=$row1['HIS'];
							
							// $he=$row1['HIE'];
							// $hes=$row1['HFE'];
							// $hs=$row1['HFS'];
							$cont=1;
							$retrasomes=0;
							$retra=$row1['RETRASO'];
									if($row1['COD_HORARIOPERSONA']==2)
									{
										
										
														
														if($he!="" and  $hs!="")
														{
																
																if((int)$row1['RETRASO']==2 || (int)$row1['RETRASO']==0)
																{
																	if($row1['COD_TIPOHORARIO']==1)
																	{
																		$horaoficial=(string)$row1['INICIO_ENTRADAH'].':'.(string)$m[$row1['INICIO_ENTRADAM']].':00';
																			
																		
																				$ch=CompararHoras($horaoficial,$he);
																				
																				if((int)$ch==2)
																				{
																					$retraso=restaHoras($horaoficial,$he);
																					$retrasomes=minutosAtraso($retraso);
																					$Registros = $Registros .
																						  "		<tr>" .
																						  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
																						  "			<td style='text-align:left;font:10px';> ".  $Ndia . "  </td>" .
																						  "			<td style='text-align:center;font:10px'> ". $fecha1 . " </td>" .
																						  "			<td style='text-align:center;font:10px'> ". (string)$retrasomes . " MIN </td>" .
																						  "			<td style='text-align:center;font:10px'> ". "RETRASO" . " </td>" .
																						 
																						   "		</tr>";
																											
																					
																					$i++;
																						
																				}
																	}
																	if($row1['COD_TIPOHORARIO']==2)
																	{
																		$horaoficial=(string)$row1['INICIO_ENTRADAH'].':'.(string)$m[$row1['INICIO_ENTRADAM']].':00';
																			
																		
																				$ch=CompararHoras($horaoficial,$he);
																				
																				if((int)$ch==2)
																				{
																					$retraso=restaHoras($horaoficial,$he);
																					$retrasomes=minutosAtraso($retraso);
																							
																				}
																		
																		if($hes!="")
																			{
																				$horaofi=(string)$row1['INICIO_SALIDAH'].':'.(string)$m[$row1['INICIO_SALIDAM']].':00';
																		
																		
																				$ch=CompararHoras($horaofi,$hes);
																			
																				if((int)$ch==2)
																				{
																						
																						$retraso=restaHoras($horaofi,$hes);
																						$retrasomes=(int)$retrasomes+(int)minutosAtraso($retraso);
																				}
																			}
																		if($retrasomes>0)
																		{
																			$Registros = $Registros .
																						  "		<tr>" .
																						  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
																						  "			<td style='text-align:left;font:10px';> ".  $Ndia . " </td>" .
																						  "			<td style='text-align:center;font:10px'> ". $fecha1 . " </td>" .
																						  "			<td style='text-align:center;font:10px'> ". (string)$retrasomes . " MIN </td>" .
																						  "			<td style='text-align:center;font:10px'> ". "RETRASO" . " </td>" .
																						 
																						   "		</tr>";
																											
																					
																			$i++;
																		}
																	}
																}
																else
																{
																		if($row1['COD_TIPOHORARIO']==1)
																		{
																			$horaoficial=(string)$row1['INICIO_ENTRADAH'].':'.(string)$m[$row1['INICIO_ENTRADAM']].':00';
																			$ch=CompararHoras($horaoficial,$he);
																			if((int)$ch==2)
																			{
																					$retraso=restaHoras($horaoficial,$he);
																						$retrasomes=minutosAtraso($retraso);
																						$retrasomes=$retrasomes-(int)$row1['MIN_JUSTIFICADOS'];
																						if($retrasomes>0)
																						{
																							$Registros = $Registros .
																										  "		<tr>" .
																										  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
																										  "			<td style='text-align:left;font:10px';> ".  $Ndia . " </td>" .
																										  "			<td style='text-align:center;font:10px'> ". $fecha1 . " </td>" .
																										  "			<td style='text-align:center;font:10px'> ". (string)$retrasomes . " MIN</td>" .
																										  "			<td style='text-align:center;font:10px'> ". "RETRASO" . " </td>" .
																										 
																										   "		</tr>";
																															
																									
																							$i++;
																						
																						}
																						
																				}
																	}
																	if($row1['COD_TIPOHORARIO']==2)
																	{
																		$horaoficial=(string)$row1['INICIO_ENTRADAH'].':'.(string)$m[$row1['INICIO_ENTRADAM']].':00';
																			
																		
																				$ch=CompararHoras($horaoficial,$he);
																				
																				if((int)$ch==2)
																				{
																					$retraso=restaHoras($horaoficial,$he);
																						$retrasomes=minutosAtraso($retraso);

																				}
																		
																		if($hes!="")
																			{
																				$horaofi=(string)$row1['INICIO_SALIDAH'].':'.(string)$m[$row1['INICIO_SALIDAM']].':00';
																		
																		
																				$ch=CompararHoras($horaofi,$hes);
																			
																				if((int)$ch==2)
																				{
																						
																						$retraso=restaHoras($horaofi,$hes);
																						$retrasomes=(int)$retrasomes+(int)minutosAtraso($retraso);
																						
																						// echo "retrasomes---->$retrasomes";
																				}
																			}
																			$retrasomes=$retrasomes-(int)$row1['MIN_JUSTIFICADOS'];
																			if($retrasomes>0)
																			{
																				$Registros = $Registros .
																							  "		<tr>" .
																							  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
																							  "			<td style='text-align:left;font:10px';> ".  $Ndia . " </td>" .
																							  "			<td style='text-align:center;font:10px'> ". $fecha1 . " </td>" .
																							  "			<td style='text-align:center;font:10px'> ". (string)$retrasomes . " MIN</td>" .
																							  "			<td style='text-align:center;font:10px'> ". "RETRASO" . " </td>" .
																							 
																							   "		</tr>";
																												
																						
																				$i++;
																			}
																		//
																	}
																	
																	//
																
																}
														}
														else
														{
															 if((int)$row1['FALTA']==2 || (int)$row1['FALTA']==0)
															{
																$Registros = $Registros .
																			  "		<tr>" .
																			  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
																			  "			<td style='text-align:left;font:10px';> ".  $Ndia . "</td>" .
																			  "			<td style='text-align:center;font:10px'> ". $fecha1 . " </td>" .
																			  "			<td style='text-align:center;font:10px'> ". "1" . " DIA </td>" .
																			  "			<td style='text-align:center;font:10px'> ". "FALTA" . " </td>" .
																			 
																			   "		</tr>";
																								
																		
																$i++;
															
															}
														}
										
											
								}		
								else
								{
									if($he=="" and $hes==""  and  $hs=="" and $hs1=="")
									{
									 if((int)$row1['FALTA']==2 || (int)$row1['FALTA']==0)
											{
												$Registros = $Registros .
																			  "		<tr>" .
																			  "			<td style='text-align:center;font:10px'> ". $i . " </td>" .	
																			  "			<td style='text-align:left;font:10px';> ".  $Ndia . "</td>" .
																			  "			<td style='text-align:center;font:10px'> ". $fecha1 . " </td>" .
																			  "			<td style='text-align:center;font:10px'> ". "1" . " DIA </td>" .
																			  "			<td style='text-align:center;font:10px'> ". "FALTA" . " </td>" .
																			 
																			   "		</tr>";
																								
																		
																$i++;
											}
									}
								}
	}  
	$body = '<body>'.
			'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.   
			'<br>'.
			'<br>'.
			'  <strong>Estimado(a):  '.$nombre.' </strong> <br><br>	'.
			'  <strong>Se le informa a usted que el Sistema Web de Recursos Humanos ha detectado las siguientes observaciones:</strong> <br><br>	'.
			'  <strong>Observaciones del '.$fechainicio.' al '.$fechafin.'</strong> <br><br>	'.			
	$body =$body.$Encabezados .$Registros1. $Registros . '</table>';
				//'  <strong> link: http://www.google.com.bo </strong><br> '.
				
			$body=$body.	' <br><br> <strong> Le recomendamos revisar y/o regularizar las mismas cuanto antes con su Jefe Inmediato Superior con la finalidad de </strong><br>'.
				'  <strong> evitar malos entendidos posteriores. </strong><br><br> '.
				'  <strong> Se agradece de antemano su atención. </strong><br> '.
				'<br>'.
				'<br>'.
				'<b>Atentamente, </b>'.
				'<br>'.
				'<b>Recursos Humanos</b> '.
				'</div>'.
				'</body>';
	$mail->Body    = $body;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		return false;
	} else {
		return true;
	}
		
}
function EnvioMail($mailCliente,$cliente,$tipoform,$nombresolicitante)
{
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $HOST;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $CREDENCIAL;                 // SMTP username
		$mail->Password = $CONTRASENA;                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->CharSet = 'UTF-8';
		$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
		$mail->addAddress($mailCliente, $cliente);     // Add a recipient
		$mail->isHTML(true);   
		if($tipoform==1)
			$mail->Subject = "Requerimiento de Personal";
		if($tipoform==2)
		$mail->Subject = "Vacaciones y Licencias";	
		
		if($tipoform==3)
		$mail->Subject = "Desvinculación de Personal";

		if($tipoform==4)
		$mail->Subject = "Cambios Contractuales";
		if($tipoform==5)
		$mail->Subject = "Solicitud de Viaje";
		if($tipoform==6)
		$mail->Subject = "Rendición de Viaticos";

		$Registros ='';	
		$tipoform1="";
		if($tipoform==1)
		$tipoform1= "Requerimiento de Personal";
		if($tipoform==2)
		$tipoform1 = "Vacaciones y Licencias";	
		
		if($tipoform==3)
		$tipoform1 = "Desvinculación de Personal";
		if($tipoform==4)
		$tipoform1 = "Cambios Contractuales";
		if($tipoform==5)
		$tipoform1 = "Viaje";
		if($tipoform==6)
		$tipoform1 = "Rendición de Viaticos";
		
		$body = '<body>'.
				'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.
				   
				//'<div align="center"><a href="http://Swrh.madepa.com.bo:8181"><img src="swrh.madepa.com.bo:8181/MADEPA/img/CaratulaMail.jpg"></a></div><br>'.
				'<br>'.
				 $Registros . '</table>'.
				'<br>'.
				'  <strong>Se le informa a usted  que existe una Solicitud de '.$tipoform1.' cargada en el Sistema Web de RRHH y Administración que requiere de validación de su parte. </strong> <br><br>	'.
				
				
				'  <strong> Por favor ingrese a la aplicación de RRHH para aprobar o bien rechazar la solicitud de '.$nombresolicitante.'. </strong><br> '.
				//'  <strong> link: http://www.google.com.bo </strong><br> '.
				// '  <strong>  Pinche aquí para ingresar al sistema:  http://swrh.madepa.com.bo/ </strong><br><br><br> '.
				'  <strong>  Pinche aquí para ingresar al sistema:  http://www.google.com.bo </strong><br><br><br> '.
				'  <strong>  MENÚ PRINCIPAL > APROBACIONES > PENDIENTES DE APROBACIÓN </strong><br><br><br> '.
				'  <strong> NOTA: Este mensaje es de caracter informativo, favor no responder. </strong><br> '.
				'<br>'.
				'<br>'.
				'<b>Atentamente, </b>'.
				'<br>'.
				'<b>Sistema Web de RR.HH. y Administración</b> '.
				'</div>'.
				'</body>';
		$mail->Body    = $body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		} else {
			return true;
		}

}
function EnvioMailCargador($mailuser,$usuario,$tipoform,$nombresolicitante,$cod_form)
{
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $HOST;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $CREDENCIAL;                 // SMTP username
		$mail->Password = $CONTRASENA;                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->CharSet = 'UTF-8';
		$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
		$mail->addAddress($mailuser, $usuario);     // Add a recipient
		/*$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('info@example.com', 'Information');
		$mail->addCC('cc@example.com');
		$mail->addBCC('bcc@example.com');

		$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		*/
		$mail->isHTML(true);   
		if($tipoform==1){
			$mail->Subject = "Requerimiento de Personal";
			///////////////////////////////////////////////////////////////////////////////////////////
			require('../fpdf17/fpdf.php');
			session_start();
			$codigo = $cod_form;

			if (!VerificaConBD())	
			{	
				echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';		
				exit;
			}
		
			$data = array(); 
			$sql =  'SELECT f.*,fr.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,c.DESCRIPCION,r.DESCRIPCION as des,cc.DESCRIPCION as cDESCRIPCION FROM formulario f inner join form_requerimiento_personal fr on f.COD_FORMULARIO=fr.COD_FORMULARIO inner join personal p on f.COD_PERSONAL=p.COD_PERSONAL inner join cargo c on fr.COD_CARGO_REQUERIDO=c.COD_CARGO inner join region_trabajo r on fr.REGION_TRABAJO=r.COD_REGION inner join centro_de_costo cc on cc.COD_CENTRO=fr.AREA '.
					' WHERE  f.COD_FORMULARIO= '.$codigo;
			
			//echo "/*$sql*/";
			if ($resultado = mysql_query($sql, $_SESSION['BD']))
			{	
				while($row = mysql_fetch_array($resultado))
				{
					$nombreSolicitante=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					$ncargo=$row['COD_PERSONAL'];
					$sqlcargo="SELECT c.DESCRIPCION as nombre_cargo from  personal p INNER JOIN cargo c on p.COD_CARGO=c.COD_CARGO where  p.COD_PERSONAL=$ncargo ";
					
					
					$result=mysql_query($sqlcargo,$_SESSION['BD']);
					mysql_query("SET NAMES 'utf8'");
						$totAsig = mysql_fetch_array($result);
						$cargo=$totAsig['nombre_cargo'];
					array_push($data, 
					array(	"codigo" 		     => $row['COD_FORMULARIO'],
							"nombreSolitante"	=> $nombreSolicitante,
							"cargoSolicitante" 	=> $cargo,
							"cargoRequerido" 	=> $row['DESCRIPCION'],
							"region"					=> $row['des'],
							"area"					=> $row['cDESCRIPCION'],
							"numVacantes"					=> $row['NUM_VACANTES_SOLICITADAS'],
							"justificacion"					=> $row['JUSTIFICACION_REQUERIMIENTO'],
							"resultados_esperados"					=> $row['RESULTADOS_ESPERADOS'],
							"posicion_solicitada"					=> $row['POSICION_SOLICITADA'], 	
							"motivo"					=> $row['MOTIVO'],
							"reemplazo"					=> $row['REEMPLAZO'],
							"tipo_contrato"					=> $row['TIPO_CONTRATO'],
							"fecha_termino"					=> $row['FECHA_TERMINO'],
							"observacion"					=> $row['OBSERVACION'],
							"fecha_recepcion"					=> $row['FECHA_RECEPCION_REQUERIMIENTO'],
							"fecha_estimada"					=> $row['FECHA_ESTIMADA_CIERRE'],
			
						));	
				}
			}
	
			$justificacion=nl2br($data[0]['justificacion']);
			
			$vec[0]=$justificacion;
			
			///////////////////////////////////////////////////////////
			$resultados_esperados=nl2br($data[0]['resultados_esperados']);
			 
			 
			$vec1[0]=$resultados_esperados;
			/////////
			
			
			$presupuestada="X";
			$fueraDePresupuestada="X";
			$posicion_solicitada=$data[0]['posicion_solicitada'];
			if($posicion_solicitada==1)
			{
				$fueraDePresupuestada="";
			}
			else{
				$presupuestada="";
			}
			$motivo=$data[0]['motivo'];
			$alta="X";
			$reposicion="X";
			
			if($motivo==1)
			{
				$reposicion="";
			}
			else
			{
				$alta="";
			}
			$indefinido="";
			$porTemporada="";
			$servicioExterno="";
			$pasantias="";
			$tipo_contrato=$data[0]['tipo_contrato'];
			if($tipo_contrato==1){$indefinido="X";}
			if($tipo_contrato==2){$porTemporada="X";}
			if($tipo_contrato==3){$servicioExterno="X";}
			if($tipo_contrato==4){$pasantias="X";}
			$observacion=nl2br($data[0]['observacion']);
			
			$vec2[0]=$observacion;
		
		$vecflujo;
		$vecfecha;
		$dim=0;
	
		$sqlcargador =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,DATE_FORMAT(f.FECHA_INI, "%d/%m/%Y")  AS FECHA FROM formulario f  inner join usuario u on f.COD_USUARIO=u.COD_USUARIO inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
			' WHERE  f.COD_FORMULARIO= '.$codigo;
			$resultcargador=mysql_query($sqlcargador,$_SESSION['BD']);
			while ($rowcarg = mysql_fetch_array($resultcargador)) {
				$vecflujo[$dim]	=$rowcarg['NOMBRE']." ".$rowcarg['AP_PATERNO']." ".$rowcarg['AP_MATERNO'];
				$vecfecha[$dim]=$rowcarg['FECHA'];
				$dim++;
			}
		$sqlflujo =  'SELECT  af.COD_ASIGNAR as flujo FROM asignar_flujo af '.
			' WHERE  af.COD_FORMULARIO= '.$codigo;	
		$resultflujo=mysql_query($sqlflujo,$_SESSION['BD']);
		$totflujo = mysql_fetch_array($resultflujo);
		$tflujo=$totflujo['flujo'];
			
		$sqldetalleflujo =  'SELECT COD_USUARIO,DATE_FORMAT(FECHA, "%d/%m/%Y")  AS FECHAS FROM detalle_flujo  '.
			' WHERE  COD_FLUJO= '.$tflujo.
			' order by ORDEN asc';
		$resuldetalle=mysql_query($sqldetalleflujo,$_SESSION['BD']);  
		while ($rowd = mysql_fetch_array($resuldetalle)) {
				$sqlusuario =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO FROM usuario u  inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
				' WHERE  u.COD_USUARIO= '.$rowd['COD_USUARIO'];
				$resultuserdetalle=mysql_query($sqlusuario,$_SESSION['BD']);
				while ($rowuser = mysql_fetch_array($resultuserdetalle)) {
					$vecflujo[$dim]	=$rowuser['NOMBRE']." ".$rowuser['AP_PATERNO']." ".$rowuser['AP_MATERNO'];
					$vecfecha[$dim]=$rowd['FECHAS'];
					$dim++;
				}
			
		}
		
class PDF extends FPDF
{
    
	var $B;
	var $I;
	var $U;
	var $HREF;
	function WriteHTML($html)
	{
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(3,$e);
			}
			else
			{
				// Etiqueta
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraer atributos
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}
	function OpenTag($tag, $attr)
	{
		// Etiqueta de apertura
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(3);
	}

	function CloseTag($tag)
	{
		// Etiqueta de cierre
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
		// Modificar estilo y escoger la fuente correspondiente
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}
	function PutLink($URL, $txt)
	{
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(3,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
}

	$pdf = new PDF();
	$pdf->AddPage('P','Letter');					
    $pdf-> Image('../images/MadepaMarcaDeAgua.png',0,0,216,280);
	$pdf-> SetFont('Times','B',10);
	$pdf-> SetLineWidth(0.2);
	$pdf-> text(43,35,'                             FORMULARIO DE REQUERIMIENTO DE PERSONAL ');
	$pdf-> rect(10,29,195,8,'D');
	$pdf-> rect(8,10,200,263,'D');
	$pdf-> SetFont('Times','B',10);
	$pdf-> text(15,45,'1.     Requerimiento de Personal ');
	$pdf-> rect(10,40,195,7,'D');
			
			$pdf-> SetFont('Times','',9);
			$pdf-> rect(10,51,55,5,'D');
			$pdf-> rect(65,51,140,5,'D');
			$pdf-> rect(10,56,55,5,'D');
			$pdf-> rect(65,56,140,5,'D');
			$pdf-> rect(10,61,55,5,'D');
			$pdf-> rect(65,61,140,5,'D');
			$pdf-> rect(10,66,55,5,'D');
			$pdf-> rect(65,66,55,5,'D');
			$pdf-> rect(120,66,15,5,'D');
			$pdf-> rect(135,66,70,5,'D');
			$pdf-> text(17,55,'     Nombre del Solicitante:');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(70,55, $data[0]['nombreSolitante']);
			$pdf-> SetFont('Times','',9);
			$pdf-> text(17,60,'     Cargo del Solicitante: ');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(70,60, $data[0]['cargoSolicitante']);
			$pdf-> SetFont('Times','',9);
			$pdf-> text(17,65,'     Nombre del Cargo requerido: ');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(70,65, $data[0]['cargoRequerido']); 
			$pdf-> SetFont('Times','',9);
			$pdf-> text(17,70,'     Regional(Sede del Cargo): ');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(70,70, $data[0]['region']);
			$pdf-> SetFont('Times','',9);
			$pdf-> text(120,70,'     Area: ');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(136,70, $data[0]['area']);
			$pdf-> SetFont('Times','B',10);
			
			$pdf-> text(20,80, utf8_decode('Número de Vacantes Solicitadas para el Cargo '));
			$pdf-> SetFont('Times','',9);
			$pdf-> text(110,80, $data[0]['numVacantes']);
			$pdf-> rect(10,75,95,7,'D');
			$pdf-> rect(105,75,15,7,'D');
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(15,90,utf8_decode('2.     Justificación del Requerimiento : '));
			$pdf-> rect(10,85,195,7,'D');
			$pdf-> rect(10,95,195,18,'D');
			$pdf-> SetFont('Times','',8);
			//$pdf->Ln(87);
			 $pdf->SetY(97);
			 $pdf->SetFontSize(6);
			$pdf-> WriteHTML('<font size=1>'.$vec[0].'</font>');
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(15,120,utf8_decode('3.     Resultados Esperados con la Contratación : '));
			$pdf-> rect(10,115,195,7,'D');
			
			$pdf-> rect(10,125,195,18,'D');
			$pdf-> SetFont('Times','',8);
			 $pdf->SetY(127);
			 $pdf->SetFontSize(6);
			$pdf-> WriteHTML('<font size=1>'.$vec1[0].'</font>');
			
			
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(15,151,'4.    Condiciones del Requerimiento ( Marque con una x )  ');
			$pdf-> rect(10,146,195,7,'D');
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,160,utf8_decode('Posición Solicitada :'));
			$pdf-> rect(10,155,45,7,'D');
			$pdf-> SetFont('Times','',10);
			$pdf-> text(64,160,'Presupuestada :');
			$pdf-> rect(55,155,40,7,'D');
			$pdf-> rect(95,155,10,7,'D');
			$pdf-> text(99,160,$presupuestada);
			$pdf-> rect(105,155,40,7,'D');
			$pdf-> text(108,160,'Fuera de Presupuesta :');
			$pdf-> rect(145,155,10,7,'D');
			$pdf-> text(149,160,$fueraDePresupuestada);
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,170,'Motivo :');
			$pdf-> rect(10,165,30,7,'D');
			$pdf-> rect(40,165,30,7,'D');
			
			$pdf-> SetFont('Times','',10);
			$pdf-> text(43,170,'Alta Nueva :');
			$pdf-> rect(70,165,10,7,'D');
			$pdf-> text(74,170,$alta);
			$pdf-> rect(80,165,30,7,'D');
			$pdf-> text(83,170,'Reposicion :');
			$pdf-> rect(110,165,10,7,'D');
			$pdf-> text(114,170,$reposicion);
			$pdf-> rect(120,165,30,7,'D');
			$pdf-> text(123,170,'Que reemplaza a :');
			$pdf-> rect(150,165,55,7,'D');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(151,170,$data[0]['reemplazo']);
		
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,180,'Tipo de Contrato :');
			$pdf-> rect(10,175,45,7,'D');
			$pdf-> rect(55,175,25,7,'D');
			$pdf-> SetFont('Times','',10);
			$pdf-> text(58,180,'Indefinido :');
			$pdf-> rect(80,175,10,7,'D');
			$pdf-> text(84,180,$indefinido);
			$pdf-> rect(90,175,30,7,'D');
			$pdf-> text(93,180,'Por Temporada :');
			$pdf-> rect(120,175,10,7,'D');
			$pdf-> text(124,180,$porTemporada);
			$pdf-> rect(130,175,35,7,'D');
			$pdf-> text(133,180,'Servicios Externos :');
			$pdf-> rect(165,175,10,7,'D');
			$pdf-> text(169,180,$servicioExterno);
			$pdf-> rect(175,175,20,7,'D');
			$pdf-> text(178,180,'Pasantias:');
			$pdf-> rect(195,175,10,7,'D');
			$pdf-> text(199,180,$pasantias);
			
			$pdf-> text(20,187,utf8_decode('Para contratos que no sean de tipo indefinido, debéra especificar la fecha de término :'));
			$pdf-> text(147,190,$data[0]['fecha_termino']);
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(10,195,'OBSERVACIONES');
			$pdf-> rect(10,200,195,18,'D');
			$pdf-> SetFont('Times','',8);
			$pdf->SetY(202);
			$pdf->SetFontSize(6);
			$pdf-> WriteHTML('<font size=1>'.$vec2[0].'</font>');
			
			$pdf-> SetFont('Times','',10);
			$pdf-> text(20,225,utf8_decode('Fecha de Recepción del Requerimiento de Personal completamente aprobado:'));
			$pdf-> rect(10,220,145,7,'D');
			$pdf-> rect(155,220,50,7,'D');
			$pdf-> text(160,225,$data[0]['fecha_recepcion']);
			$pdf-> SetFont('Times','',10);
			$pdf-> text(20,232,utf8_decode('Fecha estimada de cierre del proceso de Reclutamiento & Selección:'));
			$pdf-> rect(10,227,145,7,'D');
			$pdf-> rect(155,227,50,7,'D');
			$pdf-> text(160,232,$data[0]['fecha_estimada']);
			//$vecflujo[$dim]
			$x=70;
			$y=240;
			$pdf-> SetFont('Times','B',8);
			$pdf-> text(20,240,utf8_decode('FLUJO DE APROBACIÓN :'));
			$pdf-> SetFont('Times','',8);
			$pdf-> text(125,240,'CARGADOR');
			$pdf-> text(160,240,$vecfecha[0]);
			for($i=0;$i<$dim;$i++)
			{
				$pdf-> SetFont('Times','',8);
				$pdf-> text($x,$y,utf8_decode($vecflujo[$i]));
				$d=$dim-1;
				if($i>0 and  $i!=$d){
				$pdf-> text(125,$y,'APROBADOR');
				$pdf-> text(160,$y,$vecfecha[$i]);
				}
				if($i==$d){
				$pdf-> text(125,$y,'EJECUTOR');
				$pdf-> text(160,$y,$vecfecha[$i]);
				}
				$y=$y+5;
			}
		$pdf-> text(20,270,'Recursos Humanos - Formulario de Requerimiento de Personal ');
			
		sleep(2);
		$pdf->Output("../Documentacion/Formularios/form".$cod_form.".pdf","F");
		///////////////////////////////////////////////////////////////////////////////////////////
		
		}
		if($tipoform==2){
		$mail->Subject = "Vacaciones y Licencias";	
		///////////////////////////////////////////////
			require('../fpdf17/fpdf.php');
			//include("../lib/conex.php");
			session_start();
			$codigo = $cod_form;
			//$usuario=	$_SESSION['Nombre'];
			
			if (!VerificaConBD())	
			{	
				echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';		
				exit;
			}
				
			$data = array(); 
			$sql="SELECT f.*,fv.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,p.NRO_TRABAJADOR,p.CI,p.NRO_TRABAJADOR,c.DESCRIPCION,cc.DESCRIPCION as ccDESCRIPCION  from formulario f INNER JOIN form_vacacionesylicencia fv on f.COD_FORMULARIO=fv.COD_FORMULARIO inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL inner join cargo c on p.COD_CARGO=c.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO where    f.COD_FORMULARIO='$codigo'  ";
			   
			// $sql =  'SELECT f.*,fv.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,p.NRO_TRABAJADOR,p.CI,c.DESCRIPCION,cc.DESCRIPCION as cDESCRIPCION FROM formulario f inner join form_requerimiento_personal fr on f.COD_FORMULARIO=fr.COD_FORMULARIO inner join personal p on f.COD_PERSONAL=p.COD_PERSONAL inner join cargo c on fr.COD_CARGO_REQUERIDO=c.COD_CARGO inner join region_trabajo r on fr.REGION_TRABAJO=r.COD_REGION inner join centro_de_costo cc on cc.COD_CENTRO=fr.AREA '.
					// ' WHERE  f.COD_FORMULARIO= '.$codigo;
			
			//echo "/*$sql*/";
			 if ($resultado = mysql_query($sql, $_SESSION['BD']))
			 {	
				while($row = mysql_fetch_array($resultado))
				{
					$nombreSolicitante=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					
					
					 array_push($data, 
					  array( 
							 "codigo"    		=> $row['COD_FORMULARIO'],
							 "cod_usuario"					=> $row['COD_USUARIO'],
							 "cod_personal"					=> $row['COD_PERSONAL'],
							 "nombre_solicitante"   => $nombreSolicitante,
							 "cedula" 			=> $row['CEDULA'],
							 "nro_trabajador" 			=> $row['NRO_TRABAJADOR'],
							 "cargo"			=> $row['DESCRIPCION'],
							 "centro_costo"			=> $row['ccDESCRIPCION'],
							"observacion"		=> $row['OBSERVACIONES'],
							"fecha_ingreso" => $row['FECHA_INGRESO'],
							));	
				}
			 }
			 
			$sqlresponsable = 'SELECT p.COD_PERSONAL,p.NOMBRE,p.AP_PATERNO,fr.DETALLE FROM `personal` p inner join formulario_vacacion_responsables fr on p.COD_PERSONAL=fr.COD_PERSONAL'.
						' inner join formulario f on f.COD_FORMULARIO=fr.COD_FORMULARIO  WHERE fr.ACTIVO=1  and f.COD_FORMULARIO='. $codigo ; 
			
			//echo "/*$sql*/";
			
			$resultadoresponsable=mysql_query($sqlresponsable,$_SESSION['BD']);   
			$num_reg = mysql_num_rows($resultadoresponsable); 	
			//echo  "/*$num_reg*/";
			$dataresponsable = array();	
			mysql_query("SET NAMES 'utf8'");
			while ($row = mysql_fetch_array($resultadoresponsable)) 	{
				$nombre=$row['NOMBRE'].' '.$row['AP_PATERNO'];
				$D=$row['DETALLE'];
				//ECHO "/*$D*/";
				array_push($dataresponsable, 
				array( 	"codigop"		=> $row['COD_PERSONAL'], 
						"nombrep" 	=> $nombre,
						"detalle"		=> $row['DETALLE'], 
					));				
			}       								
			///////////////////////////////////////////////////////////////////////////////////////////////////////
			 $observacion=nl2br($data[0]['observacion']);
			 $vec2[0]=$observacion;
			$sqlVacacion = 'SELECT fv.* from form_vacacionesylicencia fv where fv.COD_FORMULARIO="'. $codigo .'"';  	
			//echo "/*---$sqlVacacion----*/";
			mysql_query("SET NAMES 'utf8'");
			$resultado1=mysql_query($sqlVacacion,$_SESSION['BD']);    	
			$data1 = array();	
			
			while ($row1 = mysql_fetch_array($resultado1)) 	{
				$desdefecha="";
				$hastafecha="";
				$fecha_ingreso="";
				if($row1['DESDE_FECHA']!="")
				{
					$valores = explode ("/", $row1['DESDE_FECHA']); 
					$gestion = $valores[2] ;
					$mes = $valores[1] ;
					$dia = $valores[0] ;
					$desdefecha=$dia."/".$mes."/".$gestion;
				}
				if($row1['HASTA_FECHA']!="")
				{
					$valores = explode ("/", $row1['HASTA_FECHA']); 
					$gestion1 = $valores[2] ;
					$mes1 = $valores[1] ;
					$dia1 = $valores[0] ;
					$hastafecha=$dia1."/".$mes1."/".$gestion1;
				}
				if( $row1['FECHA_DE_INGRESO']!="")
				{
					$valores = explode ("/", $row1['FECHA_DE_INGRESO']); 
					$gestion2 = $valores[2] ;
					$mes2 = $valores[1] ;
					$dia2 = $valores[0] ;
					$fecha_ingreso=$dia2."/".$mes2."/".$gestion2;
				}
						
				array_push($data1, 
				array( 	"codigop"		=> $row1['COD_FORMULARIO'], 
						"saldoinicial" 	=> $row1['SALDO_INICIAL'],
						"ndiashabiles" 	=> $row1['NDIAS_HABILES'],
						"nuevosaldo" 	=> $row1['NUEVO_SALDO'],
						"desdefecha" 	=> $desdefecha,
						"hastafecha" 	=> $hastafecha,
						"fecha_ingreso" 	=>  $fecha_ingreso
						
						
						));				
			}     
			///////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$sqlLicencia = 'SELECT fv.* from form_licencia fv where fv.COD_FORMULARIO="'. $codigo .'" order by fv.COD_TIPO_LICENCIA';  
			mysql_query("SET NAMES 'utf8'");
			$resultado2=mysql_query($sqlLicencia,$_SESSION['BD']);    	
			$data2 = array();	
			
			while ($row2 = mysql_fetch_array($resultado2)) 	{
				$desdefecha="";
				$hastafecha="";
				$fecha_ingreso="";
				if($row2['DESDE_FECHA']!="")
				{
					$valores = explode ("/", $row2['DESDE_FECHA']); 
					$gestion = $valores[2] ;
					$mes = $valores[1] ;
					$dia = $valores[0] ;
					
					$desdefecha=$dia."/".$mes."/".$gestion;
				}
				if( $row2['HASTA_FECHA']!="")
				{
				$valores = explode ("/", $row2['HASTA_FECHA']); 
				$gestion1 = $valores[2] ;
				$mes1 = $valores[1] ;
				$dia1 = $valores[0] ;
				$hastafecha=$dia1."/".$mes1."/".$gestion1;
				}
				if( $row2['FECHA_INGRESO_LIC']!="")
				{
				$valores = explode ("/", $row2['FECHA_INGRESO_LIC']); 
				$gestion2 = $valores[2] ;
				$mes2 = $valores[1] ;
				$dia2 = $valores[0] ;
				$fecha_ingreso=$dia2."/".$mes2."/".$gestion2;
				}
				array_push($data2, 
				array( 	"codigop"		=> $row2['COD_TIPO_LICENCIA'], 
						"ndiashabiles" 	=> $row2['NDIAS_HABILES'],
						"desdefecha" 	=> $desdefecha,
						"hastafecha" 	=> $hastafecha,
						"fecha_ingreso" 	=>$fecha_ingreso,
					
						
						
						));
			}
					///	flujo
				$vecflujo;
				$vecfecha;
				$dim=0;
			
				$sqlcargador =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,DATE_FORMAT(f.FECHA_INI, "%d/%m/%Y")  AS FECHA FROM formulario f  inner join usuario u on f.COD_USUARIO=u.COD_USUARIO inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
					' WHERE  f.COD_FORMULARIO= '.$codigo;
					$resultcargador=mysql_query($sqlcargador,$_SESSION['BD']);
					while ($rowcarg = mysql_fetch_array($resultcargador)) {
						$vecflujo[$dim]	=$rowcarg['NOMBRE']." ".$rowcarg['AP_PATERNO']." ".$rowcarg['AP_MATERNO'];
						$vecfecha[$dim]=$rowcarg['FECHA'];
						$dim++;
					}
				$sqlflujo =  'SELECT  af.COD_ASIGNAR as flujo FROM asignar_flujo af '.
					' WHERE  af.COD_FORMULARIO= '.$codigo;	
				$resultflujo=mysql_query($sqlflujo,$_SESSION['BD']);
				$totflujo = mysql_fetch_array($resultflujo);
				$tflujo=$totflujo['flujo'];
					
				$sqldetalleflujo =  'SELECT COD_USUARIO,DATE_FORMAT(FECHA, "%d/%m/%Y")  AS FECHAS FROM detalle_flujo  '.
					' WHERE  COD_FLUJO= '.$tflujo.
					' order by ORDEN asc';
				$resuldetalle=mysql_query($sqldetalleflujo,$_SESSION['BD']);  
				while ($rowd = mysql_fetch_array($resuldetalle)) {
						$sqlusuario =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO FROM usuario u  inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
						' WHERE  u.COD_USUARIO= '.$rowd['COD_USUARIO'];
						$resultuserdetalle=mysql_query($sqlusuario,$_SESSION['BD']);
						while ($rowuser = mysql_fetch_array($resultuserdetalle)) {
							$vecflujo[$dim]	=$rowuser['NOMBRE']." ".$rowuser['AP_PATERNO']." ".$rowuser['AP_MATERNO'];
							$vecfecha[$dim]=$rowd['FECHAS'];
							$dim++;
						}
					
				}
			///
		class PDF extends FPDF
		{
			
			var $B;
			var $I;
			var $U;
			var $HREF;

			

			function WriteHTML($html)
			{
				// Intérprete de HTML
				$html = str_replace("\n",' ',$html);
				$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
				foreach($a as $i=>$e)
				{
					if($i%2==0)
					{
						// Text
						if($this->HREF)
							$this->PutLink($this->HREF,$e);
						else
							$this->Write(3,$e);
					}
					else
					{
						// Etiqueta
						if($e[0]=='/')
							$this->CloseTag(strtoupper(substr($e,1)));
						else
						{
							// Extraer atributos
							$a2 = explode(' ',$e);
							$tag = strtoupper(array_shift($a2));
							$attr = array();
							foreach($a2 as $v)
							{
								if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
									$attr[strtoupper($a3[1])] = $a3[2];
							}
							$this->OpenTag($tag,$attr);
						}
					}
				}
			}
			function OpenTag($tag, $attr)
			{
				// Etiqueta de apertura
				if($tag=='B' || $tag=='I' || $tag=='U')
					$this->SetStyle($tag,true);
				if($tag=='A')
					$this->HREF = $attr['HREF'];
				if($tag=='BR')
					$this->Ln(3);
			}

			function CloseTag($tag)
			{
				// Etiqueta de cierre
				if($tag=='B' || $tag=='I' || $tag=='U')
					$this->SetStyle($tag,false);
				if($tag=='A')
					$this->HREF = '';
			}

			function SetStyle($tag, $enable)
			{
				// Modificar estilo y escoger la fuente correspondiente
				$this->$tag += ($enable ? 1 : -1);
				$style = '';
				foreach(array('B', 'I', 'U') as $s)
				{
					if($this->$s>0)
						$style .= $s;
				}
				$this->SetFont('',$style);
			}
			function PutLink($URL, $txt)
			{
				$this->SetTextColor(0,0,255);
				$this->SetStyle('U',true);
				$this->Write(3,$txt,$URL);
				$this->SetStyle('U',false);
				$this->SetTextColor(0);
			}
		}


		// Creación del objeto de la clase heredada
		$pdf = new PDF();
		//$pdf->AliasNbPages();
		$pdf->AddPage('P','Letter');					
				   $pdf-> Image('../images/MadepaMarcaDeAgua.png',0,0,216,280);
					$pdf-> SetFont('Times','B',10);
					$pdf-> SetLineWidth(0.2);
					$pdf-> text(43,35,'                             FORMULARIO DE VACACIONES Y LICENCIAS ');
					$pdf-> rect(10,29,195,8,'D');
					$pdf-> rect(8,10,200,263,'D');
					
					$pdf-> SetFont('Times','B',9);
					
					$pdf-> text(17,50,'     Nombre Trabajador:');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(55,50, $data[0]['nombre_solicitante']);
					$pdf-> SetFont('Times','B',9);
					
					$pdf-> text(135,50,utf8_decode('     Cédula Identidad: '));
					$pdf-> SetFont('Times','',8);
					$pdf-> text(170,50, $data[0]['cedula']);
					$pdf-> SetFont('Times','B',9);
					
					$pdf-> text(135,60,utf8_decode('     Código Trabajador: '));
					
					$pdf-> SetFont('Times','B',9);
					
					$pdf-> text(17,55,'     Fecha Ingreso: ');
					$pdf-> text(80,55,'     Cargo: ');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(95,55, $data[0]['cargo']);
					$pdf-> text(170,60, $data[0]['nro_trabajador']);
					$pdf-> text(45,55,$data[0]['fecha_ingreso']); 
					$pdf-> SetFont('Times','B',9);
					$pdf-> text(17,60,'     Area : ');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(35,60, $data[0]['centro_costo']);
					
					
					
					$pdf-> SetFont('Times','B',10);
					$pdf-> text(15,75,'                                                                                     VACACIONES ');
					$pdf-> rect(10,70,195,7,'D');
					$pdf-> rect(10,80,30,7,'D');
					$pdf-> rect(40,80,25,7,'D');
					$pdf-> rect(65,80,25,7,'D');
					$pdf-> rect(90,80,25,7,'D');
					$pdf-> rect(115,80,25,7,'D');
					$pdf-> rect(140,80,65,7,'D');
					$pdf-> rect(10,87,30,5,'D');
					
					$pdf-> rect(40,87,25,5,'D');
					$pdf-> rect(65,87,25,5,'D');
					$pdf-> rect(90,87,25,5,'D');
					$pdf-> rect(115,87,25,5,'D');
					$pdf-> rect(140,87,65,5,'D');
					$pdf-> SetFont('Times','B',9);
					$pdf-> text(17,85," Saldo Inicial"); 
					$pdf-> text(42,83,"     N  Dias"); 
					$pdf-> text(42,86,utf8_decode("     Hábiles")); 
					$pdf-> text(65,85,"     Nuevo Saldo");
					$pdf-> text(90,85,"     Desde Fecha");
					$pdf-> text(115,85,"     Hasta Fecha");
					$pdf-> text(146,83,"         Fecha de Ingreso al trabajo");
					$pdf-> text(146,86,"             luego de Vacaciones");
					$pdf-> SetFont('Times','',9);
					IF($data1[0]['ndiashabiles']!=0){
					$pdf-> text(23,91,$data1[0]['saldoinicial']); 
					$pdf-> text(50,91,$data1[0]['ndiashabiles']); 
					$pdf-> text(75,91,$data1[0]['nuevosaldo']);} 
					$pdf-> text(95,91,$data1[0]['desdefecha']); 
					$pdf-> text(120,91,$data1[0]['hastafecha']); 
					$pdf-> text(160,91,$data1[0]['fecha_ingreso']);
					///////////////////////////////////////////////////////////////////////////
					$pdf-> rect(10,97,195,7,'D');
					$pdf-> SetFont('Times','B',9);
					$pdf-> text(25,102,'                                   RESPONSABLE DE SUS FUNCIONES DURANTE SU(S) VACACION(ES) ');
					$pdf-> text(12,109,"Responsable"); 
					$pdf-> text(105,109,"Funciones"); 
					$y=0;
					$pdf-> SetFont('Times','',6);
					$yy1=114;
					while($y<$num_reg) 
					{
						$pdf-> text(10,$yy1,$dataresponsable[$y]['nombrep']);//1.0
						$pdf-> text(40,$yy1,$dataresponsable[$y]['detalle']); //1.1
						$yy1=$yy1+4;
						$y++;
						
					}
					//////////////////////////////////////////////////////////////////////////
					$pdf-> rect(10,142,195,7,'D');
					$pdf-> SetFont('Times','B',9);
					$pdf-> text(25,147,'                                                                  LICENCIA CON GOCE DE HABERES   ');
					$pdf-> rect(10,155,95,9,'D');
					$pdf-> rect(10,164,95,5,'D');
					$pdf-> rect(10,169,95,5,'D');
					$pdf-> rect(10,174,95,5,'D');
					$pdf-> rect(10,179,95,5,'D');
					$pdf-> rect(10,184,95,5,'D');
					$pdf-> rect(10,189,95,7,'D');
					
					$pdf-> text(40,160,"                 Concepto"); 
					$pdf-> text(110,159," N Dias"); 
					$pdf-> text(110,162,utf8_decode("Hábiles"));
					$pdf-> text(129,159,"Desde");
					$pdf-> text(129,162,"Fecha");
					$pdf-> text(148,159,"Hasta");
					$pdf-> text(148,162,"Fecha");
					$pdf-> text(176,158,"Fecha de");
					$pdf-> text(175,160.5,"Ingreso luego");
					$pdf-> text(175,163.5,"de la Licencia");
					$pdf-> SetFont('Times','',8);
					$pdf-> text(16,168,"Matrimonio del Trabajador/a (Hasta 3 Dias)"); 
					
					$pdf-> text(16,173,utf8_decode("Cumpleaños del Trabajador/a (1/2 Dia)")); 
					$pdf-> text(16,178,utf8_decode("Exámen Papanicolau (1 Dia y solo para Trabajadoras)"));
					$pdf-> text(16,183,"Nacimiento de Hijo del Trabajador/a (Hasta 3 Dias)");
					$pdf-> text(16,188,"Fallecimiento de Familia Directa del Trabajador/a (Hasta 3 Dias)");	
					$pdf-> text(16,192,utf8_decode("Intervención quirúrgica por enfermedad de Familia Directa del"));
					$pdf-> text(16,195,"Trabajador/a (Hasta 3 Dias)");			
					
					$pdf-> rect(105,155,20,9,'D');
					$pdf-> rect(125,155,20,9,'D');
					$pdf-> rect(145,155,20,9,'D');
					$pdf-> rect(165,155,40,9,'D');
					// "ndiashabiles" 	=> $row2['NDIAS_HABILES'],
						// "desdefecha" 	=> $row2['DESDE_FECHA'],
						// "hastafecha" 	=> $row2['HASTA_FECHA'],
						// "fecha_ingreso" 	=> $row2['FECHA_INGRESO_LIC'],
					$pdf-> rect(105,164,20,5,'D');
					IF($data2[0]['ndiashabiles']!=0)
					$pdf-> text(113,168,$data2[0]['ndiashabiles']);//0.0 
					$pdf-> text(128,168,$data2[0]['desdefecha']); //0.1
					$pdf-> text(148,168,$data2[0]['hastafecha']); //0.2
					$pdf-> text(176,168,$data2[0]['fecha_ingreso']); //0.3
					$pdf-> rect(105,169,20,5,'D');
					
					$pdf-> rect(105,174,20,5,'D');
					$pdf-> rect(105,179,20,5,'D');
					$pdf-> rect(105,184,20,5,'D');
					$pdf-> rect(105,189,20,7,'D');
					
					$pdf-> rect(125,164,20,5,'D');
					IF($data2[1]['ndiashabiles']!=0)
					$pdf-> text(113,173,$data2[1]['ndiashabiles']);//1.0
					$pdf-> text(128,173,$data2[1]['desdefecha']); //1.1
					$pdf-> text(148,173,$data2[1]['hastafecha']); //1.2
					$pdf-> text(176,173,$data2[1]['fecha_ingreso']); //1.3	
					IF($data2[2]['ndiashabiles']!=0)
					$pdf-> text(113,178,$data2[2]['ndiashabiles']);//2.0 
					$pdf-> text(128,178,$data2[2]['desdefecha']); //2.1
					$pdf-> text(148,178,$data2[2]['hastafecha']); //2.2 
					$pdf-> text(176,178,$data2[2]['fecha_ingreso']); //2.3
					IF($data2[3]['ndiashabiles']!=0)
					$pdf-> text(113,183,$data2[3]['ndiashabiles']); //3.0 
					$pdf-> text(128,183,$data2[3]['desdefecha']); //3.1
					$pdf-> text(148,183,$data2[3]['hastafecha']); //3.2
					$pdf-> text(176,183,$data2[3]['fecha_ingreso']); //3.3
					IF($data2[4]['ndiashabiles']!=0)
					$pdf-> text(113,188,$data2[4]['ndiashabiles']); //4.0
					$pdf-> text(128,188,$data2[4]['desdefecha']); //4.1
					$pdf-> text(148,188,$data2[4]['hastafecha']); //4.2
					$pdf-> text(176,188,$data2[4]['fecha_ingreso']); //4.3
					IF($data2[5]['ndiashabiles']!=0)
					$pdf-> text(113,194,$data2[5]['ndiashabiles']); //5.0
					$pdf-> text(128,194,$data2[5]['desdefecha']); //5.1
					$pdf-> text(148,194,$data2[5]['hastafecha']); //5.2
					$pdf-> text(176,194,$data2[5]['fecha_ingreso']); //5.3
					$pdf-> rect(125,169,20,5,'D');
					$pdf-> rect(125,174,20,5,'D');
					$pdf-> rect(125,179,20,5,'D');
					$pdf-> rect(125,184,20,5,'D');
					$pdf-> rect(125,189,20,7,'D');
					
					$pdf-> rect(145,164,20,5,'D');
					$pdf-> rect(145,169,20,5,'D');
					$pdf-> rect(145,174,20,5,'D');
					$pdf-> rect(145,179,20,5,'D');
					$pdf-> rect(145,184,20,5,'D');
					$pdf-> rect(145,189,20,7,'D');
					
					
					$pdf-> rect(165,164,40,5,'D');
					$pdf-> rect(165,169,40,5,'D');
					$pdf-> rect(165,174,40,5,'D');
					$pdf-> rect(165,179,40,5,'D');
					$pdf-> rect(165,184,40,5,'D');
					$pdf-> rect(165,189,40,7,'D');
					
				
					//$pdf-> text(147,190,$data[0]['fecha_termino']);
					
					$pdf-> SetFont('Times','B',9);
					$pdf-> text(13,203,'OBSERVACIONES');
					$pdf-> rect(10,205,195,22,'D');
					$pdf-> SetFont('Times','',8);
					//$pdf->Ln(161);
					
					$pdf->SetY(207);
					$pdf->SetFontSize(6);
					$pdf-> WriteHTML('<font size=1>'.$vec2[0].'</font>');
					//$pdf-> text(20,174, $vec2[0]);
								$x=70;
					$y=243;
					$pdf-> SetFont('Times','B',8);
					$pdf-> text(20,243,utf8_decode('FLUJO DE APROBACIÓN :'));
					$pdf-> SetFont('Times','',8);
					$pdf-> text(125,243,'CARGADOR');
					$pdf-> text(160,243,$vecfecha[0]);
					for($i=0;$i<$dim;$i++)
					{
						$pdf-> SetFont('Times','',8);
						$pdf-> text($x,$y,utf8_decode($vecflujo[$i]));
						$d=$dim-1;
						if($i>0 and  $i!=$d){
						$pdf-> text(125,$y,'APROBADOR');
						$pdf-> text(160,$y,$vecfecha[$i]);
						}
						
						if($i==$d){
						$pdf-> text(125,$y,'EJECUTOR');
						$pdf-> text(160,$y,$vecfecha[$i]);
						}
						$y=$y+5;
					}
					
					$pdf-> text(20,270,'Recursos Humanos - Formulario de Vacaciones y Licencias ');
					
			sleep(2);
			$pdf->Output("../Documentacion/Formularios/form".$cod_form.".pdf","F");
			
		///////////////////////////////////////////////
		}
		if($tipoform==6){
			$mail->Subject = "Rendición de Viaticos";
			require('../fpdf17/fpdf.php');
			session_start();
			$codigo = $cod_form;
			if (!VerificaConBD())	
			{	
				echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';		
				exit;
			}
			$data = array(); 
	$sql="SELECT f.*,fv.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,p.NRO_TRABAJADOR,p.CI,p.NRO_TRABAJADOR ".
		" from formulario f INNER JOIN formulario_rendicion_viaticos fv on f.COD_FORMULARIO=fv.cod_formulario".
		" inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL ".
		"  where    f.COD_FORMULARIO='$codigo'  ";
	
	 if ($resultado = mysql_query($sql, $_SESSION['BD']))
	 {	
		while($row = mysql_fetch_array($resultado))
		{
			$nombreSolicitante=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
			
			
			 array_push($data, 
			  array( 
					 "codigo"    		=> $row['COD_FORMULARIO'],
					 "cod_usuario"					=> $row['COD_USUARIO'],
					 "cod_personal"					=> $row['COD_PERSONAL'],
					 "nombre_solicitante"   => $nombreSolicitante,
					 "fecha_elaboracion" 			=> $row['fecha_elaboracion'],
					 "nro_revision" 			=> $row['nro_revision'],
					 "gestion_revision"			=> $row['gestion_revision'],
					 "cargo"			=> $row['cargo'],
					 "regional"		=> $row['regional'],
					 "unidad" => $row['unidad'],
					 "subcentro" => $row['subcentro'],
					 "area" => $row['area'],
					 "desde_fecha" => $row['desde_fecha'],
					 "hasta_fecha" => $row['hasta_fecha'],
					 "destino" => $row['destino'],
					 "motivo_viaje" => $row['motivo_viaje'],
					 "total_facturado_bs" => $row['total_facturado_bs'],
					 "total_nofacturado_bs" => $row['total_nofacturado_bs'],
					 "total_rciva_bs" => $row['total_rciva_bs'],
					 "total_bs" => $row['total_bs'],
					 "monto_entregado_rendir_bs" => $row['monto_entregado_rendir_bs'],
					 "monto_rendido_bs" => $row['monto_rendido_bs'],
					 "resultado_rendicion" => $row['resultado_rendicion'],
					 "resultado_rendicion_diferencia" => $row['resultado_rendicion_diferencia']
					));	
		}
	 }
	$data1 = array(); 
	$sql1="SELECT f.* ".
		" from facturas_viaticos f".
		"  where  f.activo=1 and  f.cod_formulario='$codigo'  ";
	
	 if ($resultado1 = mysql_query($sql1, $_SESSION['BD']))
	 {	
		while($row1 = mysql_fetch_array($resultado1))
		{
			array_push($data1, 
			array( 
				   "codigo"    		=> $row1['id'],
				   "fecha" 			=> $row1['fecha'],
				   "nro_factura" 			=> $row1['nro_factura'],
				   "razon_social"			=> $row1['razon_social'],
				   "concepto"			=> $row1['concepto'],
				   "facturado"		=> $row1['facturado'],
				   "no_facturado" => $row1['no_facturado'],
				   "rc_iva" => $row1['rc_iva'],
				   "total_bs" => $row1['total_bs']
				  ));	
		}
	}
				
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	 $motivo_viaje=nl2br($data[0]['motivo_viaje']); 
	///////////////////////////////////////////////////////////////////////////////////////////////////////
		///	flujo
		$vecflujo;
		$vecfecha;
		$dim=0;
		// mysql_query("SET NAMES 'utf8'");
		$sqlcargador =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,DATE_FORMAT(f.FECHA_INI, "%d/%m/%Y")  AS FECHA FROM formulario f  inner join usuario u on f.COD_USUARIO=u.COD_USUARIO inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
			' WHERE  f.COD_FORMULARIO= '.$codigo;
			
			$resultcargador=mysql_query($sqlcargador,$_SESSION['BD']);
			// mysql_query("SET NAMES 'utf8'");
			while ($rowcarg = mysql_fetch_array($resultcargador)) {
				$vecflujo[$dim]	=$rowcarg['NOMBRE']." ".$rowcarg['AP_PATERNO']." ".$rowcarg['AP_MATERNO'];
				$vecfecha[$dim]=$rowcarg['FECHA'];
				$dim++;
			}
		$sqlflujo =  'SELECT  af.COD_ASIGNAR as flujo FROM asignar_flujo af '.
			' WHERE  af.COD_FORMULARIO= '.$codigo;	
		$resultflujo=mysql_query($sqlflujo,$_SESSION['BD']);
		$totflujo = mysql_fetch_array($resultflujo);
		$tflujo=$totflujo['flujo'];
			
		$sqldetalleflujo =  'SELECT COD_USUARIO,DATE_FORMAT(FECHA, "%d/%m/%Y")  AS FECHAS FROM detalle_flujo  '.
			' WHERE  COD_FLUJO= '.$tflujo.
			' order by ORDEN asc';
		$resuldetalle=mysql_query($sqldetalleflujo,$_SESSION['BD']);  
		while ($rowd = mysql_fetch_array($resuldetalle)) {
				$sqlusuario =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO FROM usuario u  inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
				' WHERE  u.COD_USUARIO= '.$rowd['COD_USUARIO'];
				$resultuserdetalle=mysql_query($sqlusuario,$_SESSION['BD']);
				while ($rowuser = mysql_fetch_array($resultuserdetalle)) {
					$vecflujo[$dim]	=$rowuser['NOMBRE']." ".$rowuser['AP_PATERNO']." ".$rowuser['AP_MATERNO'];
					$vecfecha[$dim]=$rowd['FECHAS'];
					$dim++;
				}
			
		}
	///
class PDF extends FPDF
{
    
	var $B;
	var $I;
	var $U;
	var $HREF;

	

	function WriteHTML($html)
	{
		// Int�rprete de HTML
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(3,$e);
			}
			else
			{
				// Etiqueta
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraer atributos
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}
	function OpenTag($tag, $attr)
	{
		// Etiqueta de apertura
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(3);
	}

	function CloseTag($tag)
	{
		// Etiqueta de cierre
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
		// Modificar estilo y escoger la fuente correspondiente
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}
	function PutLink($URL, $txt)
	{
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(3,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
	function BasicTableM($header,$data,$dt,$vecfecha,$vecflujo,$dim)
	{
		$camw="17,18,50,49,15,15,15,15";
		$valores = explode (",", $camw); 
		$w = $valores;
		 for($i=0;$i<count($header);$i++)
		{
			$this->Cell($w[$i],9,'',1,0,'C');
		}
		$this-> rect(10,115,17,6,'D');
		$this-> rect(27,115,68,6,'D');
		$this-> rect(95,115,49,6,'D');
		$this-> rect(144,115,30,6,'D');
		$this-> rect(174,115,15,6,'D');
		$this-> rect(189,115,15,6,'D');
		//$this-> rect(27,119,18,6,'D');
		$this-> SetFont('Times','B',9);
		$this-> text(15,127, 'Fecha');
		$this-> text(28,125, 'N* Factura');
		$this-> text(30,128, 'o Recibo');
		$this-> text(46,127, utf8_decode('Razón social de Empresa que emite'));
		$this-> text(112,127, utf8_decode('Concepto'));
		$this-> text(144.5,127, utf8_decode('Facturado'));
		$this-> text(159.5,125, utf8_decode('No'));
		$this-> text(159.5,128, utf8_decode('Facturado'));
		$this-> text(176,127, utf8_decode('RC-IVA'));
		$this-> text(190.5,127, utf8_decode('Total Bs.'));

		$this-> text(42,119, utf8_decode('Facturas y/o recibos adjuntos'));
		$this-> text(152,119, utf8_decode('Monto Bs.'));
		$this-> text(175,118, utf8_decode('Grossing'));
		$this-> text(180,120.5, utf8_decode('Up'));

			
		$this->Ln();
		$this->SetWidths(array(17, 18, 50, 49,15,15,15,15));
		foreach($data as $row)
		{
			$this-> SetFont('Times','',8.5);
			$this->Row(array(date("d-m-Y",strtotime($row['fecha'])), utf8_decode($row['nro_factura']), utf8_decode($row['razon_social']), utf8_decode($row['concepto']),number_format(((double)$row['facturado']),2),number_format(((double)$row['no_facturado']),2),number_format(((double)$row['rc_iva']),2),number_format(((double)$row['total_bs']),2)));
			
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('P','Letter');
			 $this-> rect(8,10,200,263,'D');
				$this->Ln();
			}
			
		}
		$this->Cell(134,5,'TOTAL',1,0,'C',false,'',3,0,false,'T','B');
		  
			$this->Cell(15,5,number_format(((double)$dt[0]['total_facturado_bs']),2),1,0,'R',false,'',3,0,false,'T','B');
			$this->Cell(15,5,number_format(((double)$dt[0]['total_nofacturado_bs']),2),1,0,'R',false,'',3,0,false,'T','B');
			$this->Cell(15,5,number_format(((double)$dt[0]['total_rciva_bs']),2),1,0,'R',false,'',3,0,false,'T','B');
			$this->Cell(15,5,number_format(((double)$dt[0]['total_bs']),2),1,0,'R',false,'',3,0,false,'T','B');
			$this->Ln();
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('P','Letter');
			 $this-> rect(8,10,200,263,'D');
				$this->Ln();
			}
			$this->Ln();
			$this->Cell(134,5,'Monto entregado a Rendir Bs.',1,0,'L',false,'',3,0,false,'T','B');
			$this->Cell(15,5,number_format(((double)$dt[0]['monto_entregado_rendir_bs']),2),1,0,'R',false,'',3,0,false,'T','B');
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('P','Letter');
			 $this-> rect(8,10,200,263,'D');
				$this->Ln();
			}
			$this->Ln();
			$this->Cell(134,5,'Monto Rendido/gastado Bs.',1,0,'L',false,'',3,0,false,'T','B');
			$this->Cell(15,5,number_format(((double)$dt[0]['monto_rendido_bs']),2),1,0,'R',false,'',3,0,false,'T','B');
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('P','Letter');
			 $this-> rect(8,10,200,263,'D');
				$this->Ln();
			}
			$this->Ln();
			$this->Cell(134,5,$dt[0]['resultado_rendicion'],1,0,'L',false,'',3,0,false,'T','B');
			$this->Cell(15,5,number_format(((double)$dt[0]['resultado_rendicion_diferencia']),2),1,0,'R',false,'',3,0,false,'T','B');

			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('P','Letter');
			 $this-> rect(8,10,200,263,'D');
				$this->Ln();
			}
			$this->Ln();
			$this->Ln();
			$this->Ln();
			//$y=213;
			$y=$this->GetY();
			$x=45;
			$this-> SetFont('Times','',8);
			$this-> text(125,$y,'CARGADOR');
			$this-> text(160,$y,$vecfecha[0]);
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('P','Letter');
			 $this-> rect(8,10,200,263,'D');
				$this->Ln();
			}
			for($i=0;$i<$dim;$i++)
			{
				$this-> SetFont('Times','',8);
				$this-> text($x,$y,$vecflujo[$i]);
				$d=$dim-1;
				if($i>0 and  $i!=$d){
				$this-> text(125,$y,'APROBADOR');
				$this-> text(160,$y,$vecfecha[$i]);
				}
				$a=$this->GetY();
				if($a>250)
				{
					$this->AddPage('P','Letter');
					$this-> rect(8,10,200,263,'D');
					$this->Ln();
				}
				if($i==$d){
				$this-> text(125,$y,'EJECUTOR');
				$this-> text(160,$y,$vecfecha[$i]);
				}
				$y=$y+5;
			}
		
	}
	////multicell
	
		protected $widths;
		protected $aligns;

		function SetWidths($w)
		{
			// Set the array of column widths
			$this->widths = $w;
		}

		function SetAligns($a)
		{
			// Set the array of column alignments
			$this->aligns = $a;
		}

		function Row($data)
		{
			// Calculate the height of the row
			$nb = 0;
			for($i=0;$i<count($data);$i++)
				$nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h = 4*$nb;
			// Issue a page break first if needed
			$this->CheckPageBreak($h);
			// Draw the cells of the row
			for($i=0;$i<count($data);$i++)
			{
				$w = $this->widths[$i];
				$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				if($i==4){$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';}
				if($i==5){$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';}
				if($i==6){$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';}
				if($i==7){$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';}
				// Save the current position
				$x = $this->GetX();
				$y = $this->GetY();
				// Draw the border
				$this->Rect($x,$y,$w,$h);
				// Print the text
				$this->MultiCell($w,4,$data[$i],0,$a);
				// Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}
			// Go to the next line
			$this->Ln($h);
		}

		function CheckPageBreak($h)
		{
			// If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		}

		function NbLines($w, $txt)
		{
			// Compute the number of lines a MultiCell of width w will take
			if(!isset($this->CurrentFont))
				$this->Error('No font has been set');
			$cw = $this->CurrentFont['cw'];
			if($w==0)
				$w = $this->w-$this->rMargin-$this->x;
			$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
			$s = str_replace("\r",'',(string)$txt);
			$nb = strlen($s);
			if($nb>0 && $s[$nb-1]=="\n")
				$nb--;
			$sep = -1;
			$i = 0;
			$j = 0;
			$l = 0;
			$nl = 1;
			while($i<$nb)
			{
				$c = $s[$i];
				if($c=="\n")
				{
					$i++;
					$sep = -1;
					$j = $i;
					$l = 0;
					$nl++;
					continue;
				}
				if($c==' ')
					$sep = $i;
				$l += $cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
							$i++;
					}
					else
						$i = $sep+1;
					$sep = -1;
					$j = $i;
					$l = 0;
					$nl++;
				}
				else
					$i++;
			}
			return $nl;
		}
}


// Creaci�n del objeto de la clase heredada
$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->AddPage('P','Letter');					
		   $pdf-> Image('../images/MadepaMarcaDeAgua.png',0,0,216,280);
			$pdf-> SetFont('Times','B',10);
			$pdf-> SetLineWidth(0.2);
			$pdf-> text(70,35,utf8_decode('FORMULARIO DE RENDICIÓN DE GASTOS DE VIATICOS'));
			$pdf-> rect(10,29,195,8,'D');
			$pdf-> rect(8,10,200,263,'D');
		
			$pdf-> text(73,50,utf8_decode('Sección 1 - INFORMACIÓN GENERAL'));
			$pdf-> rect(10,44,195,8,'D');
			
			$pdf-> text(70,109,utf8_decode('Sección 2 - CONTROL VIÁTICOS'));
			$pdf-> rect(10,103,195,8,'D');

			

			$pdf-> SetFont('Times','B',9);
			$pdf-> text(15,60,utf8_decode('Fecha de Elaboración:'));
			$pdf-> text(135,60,utf8_decode('N* de Revisión:'));
			$pdf-> text(15,66,'Nombre del Solicitante:');
			$pdf-> text(15,72,'Cargo del Solicitante:');
	
			$pdf-> text(15,78,'Unidad de Negocio:');
			$pdf-> text(85,78,'Regional:');
			$pdf-> text(135,78,utf8_decode('Área:'));

			$pdf-> text(15,84,'Destino:');
			$pdf-> text(15,90,'Motivo de Viaje:');
			$pdf-> text(15,97,'Fechas de Viaje');
			$pdf-> text(75,97,'Desde Fecha:');
			$pdf-> text(130,97,'Hasta Fecha:');

			$pdf-> SetFont('Times','',9);
			$pdf-> text(55,60, date("d-m-Y",strtotime($data[0]['fecha_elaboracion'])));
			$numero=$data[0]['nro_revision'];
			$gestion=$data[0]['gestion_revision'];
			$codigo_solicitud=$numero."/".$gestion;
				if($numero<100)
				{
					$codigo_solicitud="0".$numero."/".$gestion;
				}
				if($numero<10)
				{
					$codigo_solicitud="00".$numero."/".$gestion;
				}
			$pdf-> text(165,60, $codigo_solicitud);
			$pdf-> text(55,66, $data[0]['nombre_solicitante']);
			$pdf-> text(55,72, $data[0]['cargo']);
	
			$pdf-> text(43,78, $data[0]['unidad']);
			
			$pdf-> text(102,78, $data[0]['regional']);
			$pdf-> text(145,78, $data[0]['area']);

			$pdf-> text(35,84, $data[0]['destino']);
			$pdf->SetY(87);
			$pdf->SetX(42);
			$pdf->MultiCell(160,4,mb_strtoupper(utf8_decode($motivo_viaje)),0,'L');
			$pdf-> text(95,97, date("d-m-Y",strtotime($data[0]['desde_fecha'])));
			$pdf-> text(150,97, date("d-m-Y",strtotime($data[0]['hasta_fecha'])));

			$pdf-> Ln(30);
			$campos = "Fecha,,Razon social de Empresa que emite,Concepto,Facturado,No facturado,RC IVA,Total Bs.";
			$campos  = substr($campos, 0, strlen($campos) - 1);
			$valores = explode (",", $campos); 
			$header1 = $valores; 
			$pdf-> BasicTableM($header1,$data1,$data,$vecfecha,$vecflujo,$dim);
			
			sleep(2);	
			$pdf->Output("../Documentacion/Formularios/form".$cod_form.".pdf","F");

		}
		if($tipoform==5){
			$mail->Subject = "Solicitud de Viaje";
			require('../fpdf17/fpdf.php');
			session_start();
			$codigo = $cod_form;
			if (!VerificaConBD())	
			{	
				echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';		
				exit;
			}
		
	$data = array(); 
	$sql="SELECT f.*,fv.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,p.NRO_TRABAJADOR,p.CI,p.NRO_TRABAJADOR, ".
		" t.nombre as tnombre,d.nombre_destino from formulario f INNER JOIN formulario_autorizacion_viaje fv on f.COD_FORMULARIO=fv.cod_formulario".
		" inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL inner join tipo_viaje t on fv.idtipo_viaje=t.id ".
		" inner join destino_viaje d on fv.destino=d.id ".
		"  where    f.COD_FORMULARIO='$codigo'  ";
	
	 if ($resultado = mysql_query($sql, $_SESSION['BD']))
	 {	
		while($row = mysql_fetch_array($resultado))
		{
			$nombreSolicitante=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
			
			
			 array_push($data, 
			  array( 
					 "codigo"    		=> $row['COD_FORMULARIO'],
					 "cod_usuario"					=> $row['COD_USUARIO'],
					 "cod_personal"					=> $row['COD_PERSONAL'],
					 "nombre_solicitante"   => $nombreSolicitante,
					 "fecha_solicitud" 			=> $row['fecha_solicitud'],
					 "nro_solicitud" 			=> $row['nro_solicitud'],
					 "gestion_solicitud"			=> $row['gestion_solicitud'],
					 "cargo"			=> $row['cargo'],
					 "unidad"		=> $row['unidad'],
					 "regional" => $row['regional'],
					 "centro" => $row['centro'],
					 "ntipo_viaje" => $row['tnombre'],
					 "destino" => $row['nombre_destino'],
					 "fecha_salida" => $row['fecha_salida'],
					 "fecha_retorno" => $row['fecha_retorno'],
					 "dias_viaje" => $row['dias_viaje'],
					 "finalidad_viaje" => $row['finalidad_viaje'],
					 "monto_por_dia" => $row['monto_por_dia'],
					 "moneda" => $row['moneda']
					));	
		}
	 }
	 
				
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	 $finalidad_viaje=nl2br($data[0]['finalidad_viaje']); 
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
		///	flujo
		$vecflujo;
		$vecfecha;
		$dim=0;
		// mysql_query("SET NAMES 'utf8'");
		$sqlcargador =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,DATE_FORMAT(f.FECHA_INI, "%d/%m/%Y")  AS FECHA FROM formulario f  inner join usuario u on f.COD_USUARIO=u.COD_USUARIO inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
			' WHERE  f.COD_FORMULARIO= '.$codigo;
			
			$resultcargador=mysql_query($sqlcargador,$_SESSION['BD']);
			// mysql_query("SET NAMES 'utf8'");
			while ($rowcarg = mysql_fetch_array($resultcargador)) {
				$vecflujo[$dim]	=$rowcarg['NOMBRE']." ".$rowcarg['AP_PATERNO']." ".$rowcarg['AP_MATERNO'];
				$vecfecha[$dim]=$rowcarg['FECHA'];
				$dim++;
			}
		$sqlflujo =  'SELECT  af.COD_ASIGNAR as flujo FROM asignar_flujo af '.
			' WHERE  af.COD_FORMULARIO= '.$codigo;	
		$resultflujo=mysql_query($sqlflujo,$_SESSION['BD']);
		$totflujo = mysql_fetch_array($resultflujo);
		$tflujo=$totflujo['flujo'];
			
		$sqldetalleflujo =  'SELECT COD_USUARIO,DATE_FORMAT(FECHA, "%d/%m/%Y")  AS FECHAS FROM detalle_flujo  '.
			' WHERE  COD_FLUJO= '.$tflujo.
			' order by ORDEN asc';
		$resuldetalle=mysql_query($sqldetalleflujo,$_SESSION['BD']);  
		while ($rowd = mysql_fetch_array($resuldetalle)) {
				$sqlusuario =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO FROM usuario u  inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
				' WHERE  u.COD_USUARIO= '.$rowd['COD_USUARIO'];
				$resultuserdetalle=mysql_query($sqlusuario,$_SESSION['BD']);
				while ($rowuser = mysql_fetch_array($resultuserdetalle)) {
					$vecflujo[$dim]	=$rowuser['NOMBRE']." ".$rowuser['AP_PATERNO']." ".$rowuser['AP_MATERNO'];
					$vecfecha[$dim]=$rowd['FECHAS'];
					$dim++;
				}
			
		}
	///
class PDF extends FPDF
{
    
	var $B;
	var $I;
	var $U;
	var $HREF;

	

	function WriteHTML($html)
	{
		// Int�rprete de HTML
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(3,$e);
			}
			else
			{
				// Etiqueta
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraer atributos
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}
	function OpenTag($tag, $attr)
	{
		// Etiqueta de apertura
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(3);
	}

	function CloseTag($tag)
	{
		// Etiqueta de cierre
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
		// Modificar estilo y escoger la fuente correspondiente
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}
	function PutLink($URL, $txt)
	{
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(3,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
}


// Creaci�n del objeto de la clase heredada
$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->AddPage('P','Letter');					
		   $pdf-> Image('../images/MadepaMarcaDeAgua.png',0,0,216,280);
			$pdf-> SetFont('Times','B',10);
			$pdf-> SetLineWidth(0.2);
			$pdf-> text(70,35,utf8_decode('SOLICITUD DE AUTORIZACIÓN DE VIAJE '));
			$pdf-> rect(10,29,195,8,'D');
			$pdf-> rect(8,10,200,263,'D');
		
			$pdf-> text(73,50,utf8_decode('Sección 1 - INFORMACIÓN GENERAL'));
			$pdf-> rect(10,44,195,8,'D');
			$pdf-> text(70,92,utf8_decode('Sección 2 - INFORMACIÓN SOBRE EL VUELO'));
			$pdf-> rect(10,86,195,8,'D');
			$pdf-> text(70,142,utf8_decode('Sección 3 - INFORMACIÓN SOBRE VIÁTICOS'));
			$pdf-> rect(10,136,195,8,'D');

			$pdf-> text(70,192,utf8_decode('Sección 4 - AUTORIZACIONES Y FIRMAS'));
			$pdf-> rect(10,186,195,8,'D');

			$pdf-> rect(80,157,60,7,'D');
			$pdf-> rect(80,164,30,7,'D');
			$pdf-> rect(110,164,30,7,'D');
			$pdf-> rect(80,171,30,7,'D');
			$pdf-> rect(110,171,30,7,'D');
			
			$pdf-> SetFont('Times','B',9);
			$pdf-> text(15,60,'Fecha de Solicitud:');
			$pdf-> text(135,60,'N* de Solicitud:');
			$pdf-> text(15,67,'Nombre del Solicitante:');
			$pdf-> text(15,74,'Cargo del Solicitante:');
			$pdf-> text(15,81,'Unidad de Negocio:');
			$pdf-> text(85,81,'Regional:');
			$pdf-> text(135,81,utf8_decode('Área:'));
			$pdf-> text(15,102,'Tipo de Viaje:');
			$pdf-> text(85,102,'Destino:');

			$pdf-> text(15,109,'Fecha de Salida:');
			$pdf-> text(85,109,'Fecha de Retorno:');
			$pdf-> text(155,109,utf8_decode('Días de Viaje:'));

			$pdf-> text(15,116,'Finalidad del Viaje:');

			$pdf-> SetFont('Times','',9);
			$pdf-> text(55,60, date("d-m-Y",strtotime($data[0]['fecha_solicitud'])));
			$numero=$data[0]['nro_solicitud'];
			$gestion=$data[0]['gestion_solicitud'];
			$codigo_solicitud=$numero."/".$gestion;
				if($numero<100)
				{
					$codigo_solicitud="0".$numero."/".$gestion;
				}
				if($numero<10)
				{
					$codigo_solicitud="00".$numero."/".$gestion;
				}
			$pdf-> text(165,60, $codigo_solicitud);
			$pdf-> text(55,67, $data[0]['nombre_solicitante']);
			$pdf-> text(55,74, $data[0]['cargo']);
			$pdf-> text(43,81, $data[0]['unidad']);
			$pdf-> text(100,81, $data[0]['regional']);
			$pdf-> text(145,81, $data[0]['centro']);

			$pdf-> text(43,102, $data[0]['ntipo_viaje']);
			$pdf-> text(100,102, $data[0]['destino']);

			$pdf-> text(43,109, $data[0]['fecha_salida']);
			$pdf-> text(115,109, $data[0]['fecha_retorno']);
			$pdf-> text(180,109, $data[0]['dias_viaje']);

			$pdf->SetY(113);
			$pdf->SetX(42);
			$pdf->MultiCell(160,4,mb_strtoupper(utf8_decode($finalidad_viaje)),0,'L');

			$pdf->SetY(159);
			$pdf->SetX(80);
			$pdf->MultiCell(60,4,mb_strtoupper(utf8_decode($data[0]['ntipo_viaje'])),0,'C');

			$pdf->SetY(166);
			$pdf->SetX(80);
			$pdf->MultiCell(30,4,mb_strtoupper(utf8_decode('Días')),0,'C');

			if($data[0]['moneda']==1)
			{
				$moneda='BOLIVIANOS';
			}
			if($data[0]['moneda']==2)
			{
				$moneda='DOLARES';
			}
			$pdf->SetY(166);
			$pdf->SetX(110);
			$pdf->MultiCell(30,4,mb_strtoupper(utf8_decode($moneda)),0,'C');


			$pdf->SetY(173);
			$pdf->SetX(80);
			$pdf->MultiCell(30,4,mb_strtoupper(utf8_decode($data[0]['dias_viaje'])),0,'C');
			
			$total=$data[0]['dias_viaje']*$data[0]['monto_por_dia'];
			$total=number_format(((double)$total),2);
			$pdf->SetY(173);
			$pdf->SetX(110);
			$pdf->MultiCell(30,4,mb_strtoupper(utf8_decode($total)),0,'C');

			$y=213;
			$x=45;
			$pdf-> SetFont('Times','',8);
			$pdf-> text(125,213,'CARGADOR');
			$pdf-> text(160,213,$vecfecha[0]);
			for($i=0;$i<$dim;$i++)
			{
				$pdf-> SetFont('Times','',8);
				$pdf-> text($x,$y,$vecflujo[$i]);
				$d=$dim-1;
				if($i>0 and  $i!=$d){
				$pdf-> text(125,$y,'APROBADOR');
				$pdf-> text(160,$y,$vecfecha[$i]);
				}
				
				if($i==$d){
				$pdf-> text(125,$y,'EJECUTOR');
				$pdf-> text(160,$y,$vecfecha[$i]);
				}
				$y=$y+5;
			}
			
			sleep(2);	
			$pdf->Output("../Documentacion/Formularios/form".$cod_form.".pdf","F");
			////////////////////////////////////////////////////////////////////////////
		}
		if($tipoform==3){
			$mail->Subject = "Desvinculación de Personal";
			require('../fpdf17/fpdf.php');
			session_start();
			$codigo = $cod_form;
	
			if (!VerificaConBD())	
			{	
				echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';		
				exit;
			}
	
			$data = array(); 
			$sql="SELECT f.*,fv.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,p.NRO_TRABAJADOR,p.CI,p.NRO_TRABAJADOR,c.DESCRIPCION,cc.DESCRIPCION as ccDESCRIPCION  from formulario f INNER JOIN form_desvinculacion fv on f.COD_FORMULARIO=fv.COD_FORMULARIO inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL inner join cargo c on p.COD_CARGO=c.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO where   f.COD_FORMULARIO='$codigo'  ";
			 if ($resultado = mysql_query($sql, $_SESSION['BD']))
			 {	
				while($row = mysql_fetch_array($resultado))
				{
					$nombreSolicitante=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					 array_push($data, 
					  array( 
							 "codigo"    		=> $row['COD_FORMULARIO'],
							 "cod_usuario"		=> $row['COD_USUARIO'],
							 "cod_personal"		=> $row['COD_PERSONAL'],
							 "nombre_solicitante" =>$nombreSolicitante,
							 "evaluaciondesempenio"	 => $row['EVALUACION_DESEMPENIO'],
							 "tipo_retiro"			 => $row['TIPO_RETIRO'],
							 "justificacion"		 => $row['JUSTFICACION'],
							 "existen_cartas"		 => $row['EXISTEN_CARTAS'],
							 "consideracion_futura"	 => $row['CONSIDERACION_FUTURA'],
							 "fecha_tentativa"		 => $row['FECHA_TENTATIVA'],
							 "cedula" 				 => $row['CEDULA'],
							 "nro_trabajador" 		 => $row['NRO_TRABAJADOR'],
							 "cargo"				 => $row['DESCRIPCION'],
							 "centro_costo"			 => $row['ccDESCRIPCION'],
							 "fecha_ingreso"   	   	 => $row['FECHA_INGRESO']
							));	
				}
			 }
		$justificacion=nl2br($data[0]['justificacion']);
	    $vec[0]=$justificacion;
			$cartassi="";
			$cartasno="";
			$consideracionsi="";
			$consideracionno="";
			
			$forsozo="";
			$voluntario="";
			$conclusion="";
			if($data[0]['existen_cartas']==1)
			{
				$cartassi="X";
			}
			else
			{
				$cartasno="X";
			}
			if($data[0]['consideracion_futura']==1)
			{
				$consideracionsi="X";
			}
			else
			{
				$consideracionno="X";
			}
	
			if($data[0]['tipo_retiro']==1)
			{
				$conclusion="X";
			}
			if($data[0]['tipo_retiro']==2)
			{
				$forsozo="X";
			}
			if($data[0]['tipo_retiro']==3)
			{
				$voluntario="X";
			}
		$vecflujo;
		$vecfecha;
		$dim=0;
	
		$sqlcargador =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,DATE_FORMAT(f.FECHA_INI, "%d/%m/%Y")  AS FECHA FROM formulario f  inner join usuario u on f.COD_USUARIO=u.COD_USUARIO inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
			' WHERE  f.COD_FORMULARIO= '.$codigo;
			$resultcargador=mysql_query($sqlcargador,$_SESSION['BD']);
			while ($rowcarg = mysql_fetch_array($resultcargador)) {
				$vecflujo[$dim]	=$rowcarg['NOMBRE']." ".$rowcarg['AP_PATERNO']." ".$rowcarg['AP_MATERNO'];
				$vecfecha[$dim]=$rowcarg['FECHA'];
				$dim++;
			}
		$sqlflujo =  'SELECT  af.COD_ASIGNAR as flujo FROM asignar_flujo af '.
			' WHERE  af.COD_FORMULARIO= '.$codigo;	
		$resultflujo=mysql_query($sqlflujo,$_SESSION['BD']);
		$totflujo = mysql_fetch_array($resultflujo);
		$tflujo=$totflujo['flujo'];
			
		$sqldetalleflujo =  'SELECT COD_USUARIO,DATE_FORMAT(FECHA, "%d/%m/%Y")  AS FECHAS FROM detalle_flujo  '.
			' WHERE  COD_FLUJO= '.$tflujo.
			' order by ORDEN asc';
		$resuldetalle=mysql_query($sqldetalleflujo,$_SESSION['BD']);  
		while ($rowd = mysql_fetch_array($resuldetalle)) {
				$sqlusuario =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO FROM usuario u  inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
				' WHERE  u.COD_USUARIO= '.$rowd['COD_USUARIO'];
				$resultuserdetalle=mysql_query($sqlusuario,$_SESSION['BD']);
				while ($rowuser = mysql_fetch_array($resultuserdetalle)) {
					$vecflujo[$dim]	=$rowuser['NOMBRE']." ".$rowuser['AP_PATERNO']." ".$rowuser['AP_MATERNO'];
					$vecfecha[$dim]=$rowd['FECHAS'];
					$dim++;
				}
			
		}
	///
	class PDF extends FPDF
	{
		
		var $B;
		var $I;
		var $U;
		var $HREF;

		

		function WriteHTML($html)
		{
			// Intérprete de HTML
			
			$html = str_replace("\n",' ',$html);
			$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
			foreach($a as $i=>$e)
			{
				//$this-> SetX(20);
				if($i%2==0)
				{
					
					// Text
					if($this->HREF)
						$this->PutLink($this->HREF,$e);
					else{
						//$this-> SetX(20);
						$this->Write(3,$e);}
				}
				else
				{
					// Etiqueta
					//$this-> SetX(20);
					if($e[0]=='/')
						$this->CloseTag(strtoupper(substr($e,1)));
					else
					{
						// Extraer atributos
						$a2 = explode(' ',$e);
						$tag = strtoupper(array_shift($a2));
						$attr = array();
						foreach($a2 as $v)
						{
							if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
								$attr[strtoupper($a3[1])] = $a3[2];
						}
						$this->OpenTag($tag,$attr);
					}
				}
			}
		}
		function OpenTag($tag, $attr)
		{
			// Etiqueta de apertura
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,true);
			if($tag=='A')
				$this->HREF = $attr['HREF'];
			if($tag=='BR')
				$this->Ln(3);
		}

		function CloseTag($tag)
		{
			// Etiqueta de cierre
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,false);
			if($tag=='A')
				$this->HREF = '';
		}

		function SetStyle($tag, $enable)
		{
			// Modificar estilo y escoger la fuente correspondiente
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0)
					$style .= $s;
			}
			$this->SetFont('',$style);
		}
		function PutLink($URL, $txt)
		{
			//$pdf-> SetX(15);
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(4,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}
	}


// Creación del objeto de la clase heredada
$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->AddPage('P','Letter');					
		   $pdf-> Image('../images/MadepaMarcaDeAgua.png',0,0,216,280);
			$pdf-> SetFont('Times','B',10);
			$pdf-> SetLineWidth(0.2);
			$pdf-> text(43,35,'                  REQUERIMIENTO DE DESVINCULACION DE PERSONAL ');
			$pdf-> rect(10,29,195,8,'D');
			
			//$pdf-> line(50,30 ,155 ,30 );
			$pdf-> rect(8,10,200,263,'D');
			// $pdf-> line(123,98 ,123,68);
			
			$pdf-> SetFont('Times','',10);
			$pdf-> text(15,45,'Este requerimiento debe ser solicitado por el jefe directo del trabajador quien debe indicar las causas del requerimiento de  ');
			$pdf-> text(15,50,utf8_decode('desvinculación reguardando los respaldos respectivos.'));
			$pdf-> text(15,55,utf8_decode('Solo se procederá una vez cuente con los V°B° correspondientes.'));
			$pdf-> text(15,60,utf8_decode('En caso de requerir apoyo para la notificación de la desvinculación, puede solicitar soporte al area de Recursos Humanos'));
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(15,70,' 1.-  Antecedentes del Trabajador ');
			$pdf-> rect(10,65,195,7,'D');
			
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(17,80,'     Nombre Trabajador:');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(55,80, $data[0]['nombre_solicitante']);
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(130,80,utf8_decode('     Cédula de Identidad:'));
			$pdf-> SetFont('Times','',8);
			$pdf-> text(165,80, $data[0]['cedula']);
			
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(17,85,'     Cargo:');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(55,85, $data[0]['cargo']);
			
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(130,85,utf8_decode('     Código Trabajador:'));
			$pdf-> SetFont('Times','',8);
			$pdf-> text(165,85, $data[0]['nro_trabajador']);
			
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(130,90,'     Fecha Ingreso:');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(165,90, $data[0]['fecha_ingreso']);
			
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(17,90,'     Area:');
			$pdf-> SetFont('Times','',8);
			$pdf-> text(55,90, $data[0]['centro_costo']);
			
			$pdf-> SetFont('Times','B',9);
		
			$pdf-> text(17,95,utf8_decode('     Evaluación Desempeño:'));
			$pdf-> SetFont('Times','',8);
			$pdf-> text(55,95, $data[0]['evaluaciondesempenio']);
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(15,105,utf8_decode(' 2.-  Antecedentes de Desvinculación '));
			$pdf-> rect(10,100,195,7,'D');
			$pdf-> SetFont('Times','B',10);
			
			
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,120,'Tipo de Retiro :');
			$pdf-> rect(15,115,40,7,'D');
			$pdf-> SetFont('Times','',10);
			$pdf-> text(58,120,utf8_decode('Conclusión de Periodo de Prueba :'));
			$pdf-> rect(55,115,55,7,'D');
			$pdf-> rect(110,115,10,7,'D');
			$pdf-> text(113,120,$conclusion);
			$pdf-> rect(120,115,20,7,'D');
			$pdf-> SetFont('Times','',10);
			$pdf-> text(122,120,'Forzoso :');
			$pdf-> rect(140,115,10,7,'D');
			$pdf-> text(143,120,$forsozo);
			$pdf-> rect(150,115,20,7,'D');
			$pdf-> SetFont('Times','',10);
			$pdf-> text(152,120,'Voluntario :');
			$pdf-> rect(170,115,10,7,'D');
			$pdf-> text(173,120,$voluntario);
			
			 $pdf-> SetFont('Times','',10);
			$pdf-> text(15,130,utf8_decode('En caso de retiro voluntario, se deberá hacer llegar inmediatamente a Recursos Humanos la carta de renuncia del trabajador(a).'));
			 
			 $pdf-> SetFont('Times','B',10);
			$pdf-> text(15,145,utf8_decode(' 3.-  Justificación del Requerimiento '));
			$pdf-> rect(10,140,195,7,'D');
			$pdf-> rect(10,155,195,23,'D');
			$pdf-> SetFont('Times','',8);
			$pdf->SetY(157);
			$pdf->SetFontSize(6);
			$pdf-> WriteHTML('<font size=1>'.$vec[0].'</font>');
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,190,utf8_decode('Existen Cartas de Amonestación :'));
			$pdf-> rect(15,185,75,7,'D');
			$pdf-> SetFont('Times','',10);
			$pdf-> text(93,190,'SI ');
			$pdf-> rect(90,185,10,7,'D');
			$pdf-> rect(100,185,10,7,'D');
			$pdf-> text(103,190,$cartassi);
			
			$pdf-> text(113,190,'NO ');
			$pdf-> rect(110,185,10,7,'D');
			
			$pdf-> rect(120,185,10,7,'D');
			$pdf-> text(123,190,$cartasno);
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,200,utf8_decode('Considera una recontratación futura  :'));
			$pdf-> rect(15,195,75,7,'D');
			
			//
			$pdf-> SetFont('Times','',10);
			$pdf-> text(93,200,'SI ');
			$pdf-> rect(90,195,10,7,'D');
			
			$pdf-> rect(100,195,10,7,'D');
			$pdf-> text(103,200,$consideracionsi);
			
			$pdf-> text(113,200,'NO ');
			$pdf-> rect(110,195,10,7,'D');
			
			$pdf-> rect(120,195,10,7,'D');
			$pdf-> text(123,200,$consideracionno);
			//
			
			$pdf-> SetFont('Times','B',10);
			$pdf-> text(20,210,utf8_decode('Fecha Tentativa de la Desvinculación  :'));
			
			$pdf-> SetFont('Times','',10);
			$pdf-> text(90,210,$data[0]['fecha_tentativa']);
			
			$x=70;
			$y=223;
			$pdf-> SetFont('Times','B',8);
			$pdf-> text(20,223,utf8_decode('FLUJO DE APROBACIÓN :'));
			$pdf-> SetFont('Times','',8);
			$pdf-> text(125,223,'CARGADOR');
			$pdf-> text(160,223,$vecfecha[0]);
			for($i=0;$i<$dim;$i++)
			{
				$pdf-> SetFont('Times','',8);
				$pdf-> text($x,$y,utf8_decode($vecflujo[$i]));
				$d=$dim-1;
				if($i>0 and  $i!=$d){
				$pdf-> text(125,$y,'APROBADOR');
				$pdf-> text(160,$y,$vecfecha[$i]);
				}
				if($i==$d){
				$pdf-> text(125,$y,'EJECUTOR');
				$pdf-> text(160,$y,$vecfecha[$i]);
				}
				$y=$y+5;
			}
			
			$pdf-> text(20,270,utf8_decode('Recursos Humanos - Formulario de Requerimiento de Desvinculación  de Personal '));
			
			sleep(2);
			$pdf->Output("../Documentacion/Formularios/form".$cod_form.".pdf","F");
				
		}
		if($tipoform==4){
			$mail->Subject = "Cambios Contractuales";
			require('../fpdf17/fpdf.php');
			session_start();
			$codigo = $cod_form;			
			if (!VerificaConBD())	
			{	
				echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';		
				exit;
			}
				
			$data = array(); 
			$sql="SELECT f.*,fv.*,p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,p.NRO_TRABAJADOR,p.CI,fv.CEDULA  as cedu,fv.FECHA_INGRESO,p.NRO_TRABAJADOR,c.DESCRIPCION,cc.DESCRIPCION as ccDESCRIPCION  from formulario f INNER JOIN form_cambioscontractuales fv on f.COD_FORMULARIO=fv.COD_FORMULARIO inner join personal p on p.COD_PERSONAL=f.COD_PERSONAL inner join cargo c on p.COD_CARGO=c.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO where   f.COD_FORMULARIO=$codigo ";
			 if ($resultado = mysql_query($sql, $_SESSION['BD']))
			 {	
				while($row = mysql_fetch_array($resultado))
				{
					$nombreSolicitante=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
					 array_push($data, 
					  array( 
							"codigo"    		=> $row['COD_FORMULARIO'],
							 "cod_usuario"					=> $row['COD_USUARIO'],
							 "cod_personal"					=> $row['COD_PERSONAL'],
							 "nombre_solicitante"				=> $nombreSolicitante,
							 "cedula" 			=> $row['cedu'],
							 "fecha_ingreso"		=> $row['FECHA_INGRESO'],
							 "fecha_ultimo_aumento" 			=> $row['FECHA_ULTIMO_AUMENTO'],
							 "desempenio"			=> $row['DESEMPENIO'],
							 "razon_fundamentada"			=> $row['RAZON_FUNDAMENTADA'],
							"mes_cambios_propuesto"		=> $row['MES_CAMBIOS_PROPUESTOS'],
							"anio_cambios_propuesto"		=> $row['ANIO_CAMBIOS_PROPUESTO'],
							"observacion"		=> $row['OBSERVACION'],
							"lugaryfecha"		=> $row['LUGAR_Y_FECHA'],
							));	
				}
			 }
			$data1 = array();
			$sql1 = 'SELECT fv.* from detalle_cambios_contractuales fv where fv.COD_FORMULARIO="'. $codigo .'"'; 
			if ($resultado1 = mysql_query($sql1, $_SESSION['BD']))
			{
				while($row1 = mysql_fetch_array($resultado1))
				{
					array_push($data1, 
					array( 	"codigoform"		=> $row1['COD_FORMULARIO'], 
							"codconcepto" 	=> $row1['COD_CONCEPTO'],
							"actual" 	=> $row1['ACTUAL'],
							"propuesto" 	=> $row1['PROPUESTO'],

					));	
				}
			}
			function traer_unidad($codunida)
			{
				$t2="";
				if($codunida=="")
				{ }
				else{
				$sqlunidad = 'SELECT DESCRIPCION from unidad where COD_UNIDAD="'. $codunida .'"'; 
				$resultunidad=mysql_query($sqlunidad,$_SESSION['BD']);
				$tot2 = mysql_fetch_array($resultunidad);
				$t2=$tot2['DESCRIPCION'];
				}
				return $t2;
			}
			function traer_subcentro($codsub)
			{
				$t2="";
				if($codsub=="")
				{ }
				else{
				$sqlsub = 'SELECT DESCRIPCION from subcentro where COD_SUBCENTRO="'. $codsub .'"'; 
				$resultsub=mysql_query($sqlsub,$_SESSION['BD']);
				$totsub = mysql_fetch_array($resultsub);
				$t2=$totsub['DESCRIPCION'];}
				return $t2;
			}
			function traer_centro($codcentro)
			{
				$t2="";
				if($codcentro=="")
				{ }
				else{
				$sqlsub = "SELECT DESCRIPCION from centro_de_costo where COD_CENTRO=$codcentro "; 
				$resultsub=mysql_query($sqlsub,$_SESSION['BD']);
				$totsub = mysql_fetch_array($resultsub);
				$t2=$totsub['DESCRIPCION'];}
				return $t2;
			}
			function traer_cargo($codcargo)
			{
				$t2="";
				if($codcargo=="")
				{ }
				else{
				$sqlsub = "SELECT DESCRIPCION from cargo where COD_CARGO=$codcargo "; 
				$resultsub=mysql_query($sqlsub,$_SESSION['BD']);
				$totsub = mysql_fetch_array($resultsub);
				$t2=$totsub['DESCRIPCION'];}
				return $t2;
			}
			function traer_nivel($codnivel)
			{
				$nivel="";
				$sqlnivel = "SELECT * from nivel where COD_NIVEL=$codnivel "; 
				if ($resultnivel = mysql_query($sqlnivel, $_SESSION['BD']))
				{
					while($rown = mysql_fetch_array($resultnivel))
					{
						$nivel=$rown['NOMBRE_NIVEL']."-".$rown['CATEGORIA'];
					}
				}
				return  $nivel;
				
			}
				function traer_ubicacion($codubicacion)
			{
				$t2="";
				if($codubicacion=="")
				{ }
				else{
				$sqlsub = "SELECT DESCRIPCION from region_trabajo where COD_REGION=$codubicacion "; 
				$resultsub=mysql_query($sqlsub,$_SESSION['BD']);
				$totsub = mysql_fetch_array($resultsub);
				$t2=$totsub['DESCRIPCION'];
				
				}
				return $t2;
			}
			$unidadactual=traer_unidad($data1[0]['actual']);
			$unidadactualp=traer_unidad($data1[0]['propuesto']);
			$subcentroactual=traer_subcentro($data1[1]['actual']);
			$subcentroactualp=traer_subcentro($data1[1]['propuesto']);
			$centroactual=traer_centro($data1[2]['actual']);
			$centroactualp=traer_centro($data1[2]['propuesto']);
			$ubicacon_actual=traer_ubicacion($data1[3]['actual']);
			$ubicacon_actualp=traer_ubicacion($data1[3]['propuesto']);
			//
			$cargoactual=traer_cargo($data1[4]['actual']);
			$cargoactualp=traer_cargo($data1[4]['propuesto']);
			$nivelactual=traer_nivel($data1[5]['actual']);
			$nivelactualp=traer_nivel($data1[5]['propuesto']);
			if($data1[6]['actual']==1)
			$tipo_contrato_actual="INDEFINIDO";
			else{
				if($data1[6]['actual']=="")
				{$tipo_contrato_actual="";}
				else
				$tipo_contrato_actual="POR TEMPORADA";
			}
			
			if($data1[6]['propuesto']==1)
			$tipo_contrato_actualp="INDEFINIDO";
			else{
				if($data1[6]['propuesto']=="")
				{$tipo_contrato_actualp="";}
				else
				$tipo_contrato_actualp="POR TEMPORADA";
			}
			$razon_fundamentada=nl2br($data[0]['razon_fundamentada']);
					
					
					$vec[0]=$razon_fundamentada;
					
					/////////////////////////////////////////////
			$mes[1]="ENERO";$mes[2]="FEBRERO";$mes[3]="MARZO";$mes[4]="ABRIL";$mes[5]="MAYO";$mes[6]="JUNIO";$mes[7]="JULIO";$mes[8]="AGOSTO";$mes[9]="SEPTIEMBRE";$mes[10]="OCTUBRE";$mes[11]="NOVIEMBRE";$mes[12]="DICIEMBRE";
			$observacion=nl2br($data[0]['observacion']);
					
					$vec1[0]=$observacion;
			///	flujo
				$vecflujo;
				$vecfecha;
				$dim=0;
			
				$sqlcargador =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,DATE_FORMAT(f.FECHA_INI, "%d/%m/%Y")  AS FECHA FROM formulario f  inner join usuario u on f.COD_USUARIO=u.COD_USUARIO inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
					' WHERE  f.COD_FORMULARIO= '.$codigo;
					$resultcargador=mysql_query($sqlcargador,$_SESSION['BD']);
					while ($rowcarg = mysql_fetch_array($resultcargador)) {
						$vecflujo[$dim]	=$rowcarg['NOMBRE']." ".$rowcarg['AP_PATERNO']." ".$rowcarg['AP_MATERNO'];
						$vecfecha[$dim]=$rowcarg['FECHA'];
						$dim++;
					}
				$sqlflujo =  'SELECT  af.COD_ASIGNAR as flujo FROM asignar_flujo af '.
					' WHERE  af.COD_FORMULARIO= '.$codigo;	
				$resultflujo=mysql_query($sqlflujo,$_SESSION['BD']);
				$totflujo = mysql_fetch_array($resultflujo);
				$tflujo=$totflujo['flujo'];
					
				$sqldetalleflujo =  'SELECT COD_USUARIO,DATE_FORMAT(FECHA, "%d/%m/%Y")  AS FECHAS FROM detalle_flujo  '.
					' WHERE  COD_FLUJO= '.$tflujo.
					' order by ORDEN asc';
				$resuldetalle=mysql_query($sqldetalleflujo,$_SESSION['BD']);  
				while ($rowd = mysql_fetch_array($resuldetalle)) {
						$sqlusuario =  'SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO FROM usuario u  inner join personal p on u.COD_PERSONAL=p.COD_PERSONAL '.
						' WHERE  u.COD_USUARIO= '.$rowd['COD_USUARIO'];
						$resultuserdetalle=mysql_query($sqlusuario,$_SESSION['BD']);
						while ($rowuser = mysql_fetch_array($resultuserdetalle)) {
							$vecflujo[$dim]	=$rowuser['NOMBRE']." ".$rowuser['AP_PATERNO']." ".$rowuser['AP_MATERNO'];
							$vecfecha[$dim]=$rowd['FECHAS'];
							$dim++;
						}
					
				}
			///
					
					//////////////////////////////////////////
		class PDF extends FPDF
		{
			
			var $B;
			var $I;
			var $U;
			var $HREF;

			

			function WriteHTML($html)
			{
				// Intérprete de HTML
				$html = str_replace("\n",' ',$html);
				$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
				foreach($a as $i=>$e)
				{
					if($i%2==0)
					{
						// Text
						if($this->HREF)
							$this->PutLink($this->HREF,$e);
						else
							$this->Write(3,$e);
					}
					else
					{
						// Etiqueta
						if($e[0]=='/')
							$this->CloseTag(strtoupper(substr($e,1)));
						else
						{
							// Extraer atributos
							$a2 = explode(' ',$e);
							$tag = strtoupper(array_shift($a2));
							$attr = array();
							foreach($a2 as $v)
							{
								if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
									$attr[strtoupper($a3[1])] = $a3[2];
							}
							$this->OpenTag($tag,$attr);
						}
					}
				}
			}
			function OpenTag($tag, $attr)
			{
				// Etiqueta de apertura
				if($tag=='B' || $tag=='I' || $tag=='U')
					$this->SetStyle($tag,true);
				if($tag=='A')
					$this->HREF = $attr['HREF'];
				if($tag=='BR')
					$this->Ln(3);
			}

			function CloseTag($tag)
			{
				// Etiqueta de cierre
				if($tag=='B' || $tag=='I' || $tag=='U')
					$this->SetStyle($tag,false);
				if($tag=='A')
					$this->HREF = '';
			}

			function SetStyle($tag, $enable)
			{
				// Modificar estilo y escoger la fuente correspondiente
				$this->$tag += ($enable ? 1 : -1);
				$style = '';
				foreach(array('B', 'I', 'U') as $s)
				{
					if($this->$s>0)
						$style .= $s;
				}
				$this->SetFont('',$style);
			}
			function PutLink($URL, $txt)
			{
				$this->SetTextColor(0,0,255);
				$this->SetStyle('U',true);
				$this->Write(3,$txt,$URL);
				$this->SetStyle('U',false);
				$this->SetTextColor(0);
			}
		}
			

		// Creación del objeto de la clase heredada
		$pdf = new PDF();
		//$pdf->AliasNbPages();
		$pdf->AddPage('P','Letter');					
				   $pdf-> Image('../images/MadepaMarcaDeAgua.png',0,0,216,280);
					$pdf-> SetFont('Times','B',10);
					$pdf-> SetLineWidth(0.2);
					$pdf-> text(43,35,'                             FORMULARIO DE CAMBIOS CONTRACTUALES ');
					$pdf-> rect(10,29,195,8,'D');
					
					//$pdf-> line(50,30 ,155 ,30 );
					$pdf-> rect(8,10,200,263,'D');
					// $pdf-> line(123,98 ,123,68);
					
					$pdf-> SetFont('Times','B',10);
					$pdf-> text(12,45,utf8_decode('Este formulario debe ser llenado por el Jefe Directo del Trabajador. No podrá  proceder hasta contar con los V°B°'));
					$pdf-> text(12,50,'respectivos');
					
					$pdf-> SetFont('Times','B',9);
				
					$pdf-> text(17,60,'     Nombre Trabajador:');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(55,60, $data[0]['nombre_solicitante']);
					$pdf-> SetFont('Times','B',9);
				
					$pdf-> text(130,60,'     CI:');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(145,60, $data[0]['cedula']);
					
					$pdf-> SetFont('Times','B',9);
				
					$pdf-> text(17,65,'     Fecha Ingreso:');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(45,65, $data[0]['fecha_ingreso']);
					
					$pdf-> SetFont('Times','B',9);
				
					$pdf-> text(70,65,'     Fecha Ultimo Aumento:');
					$pdf-> SetFont('Times','',8);
					$pdf-> text(115,65, $data[0]['fecha_ultimo_aumento']);
					
					$pdf-> SetFont('Times','B',9);
				
					$pdf-> text(140,65,utf8_decode('    Desempeño:'));
					$pdf-> SetFont('Times','',8);
					$pdf-> text(165,65, $data[0]['desempenio']);
					
					$pdf-> SetFont('Times','B',10);
				
					$pdf-> text(12,75,'Razones que fundamentan esta solicitud:');
					
					$pdf-> rect(10,80,195,18,'D');
					$pdf-> SetFont('Times','',8);
					//$pdf->Ln(71);
					
					$pdf->SetY(82);
					$pdf->SetFontSize(6);
					$pdf-> WriteHTML('<font size=1>'.$vec[0].'</font>');
					//$pdf-> text(20,84, $vec[0]);
					
					
					$pdf-> SetFont('Times','B',10);
					$pdf-> text(12,105,utf8_decode('Los cambios propuestos  deben ser incluidos en el proceso de remuneración del mes :'));
					$pdf-> SetFont('Times','',8);
					$pdf-> text(150,105, $mes[$data[0]['mes_cambios_propuesto']]);
					//$pdf-> text(150,105, "DICIEMBRE");
					$pdf-> text(168,105, "/");
					$pdf-> text(173,105, $data[0]['anio_cambios_propuesto']);
					
					$pdf-> SetFont('Times','B',10);
					$pdf-> text(15,115,utf8_decode('Importante : Completar en Columna Propuesto sólo los campos que serán modificados'));
					
					
					
					$pdf-> rect(15,120,50,9,'D');
					$pdf-> rect(15,129,50,5,'D');
					$pdf-> rect(15,134,50,5,'D');
					$pdf-> rect(15,139,50,5,'D');
					$pdf-> rect(15,144,50,5,'D');
					$pdf-> rect(15,149,50,5,'D');
					
					$pdf-> rect(15,154,50,5,'D');
					$pdf-> rect(15,159,50,5,'D');
					$pdf-> rect(15,164,50,5,'D');
					
					$pdf-> rect(15,169,50,5,'D');
					$pdf-> rect(15,174,50,5,'D');
					$pdf-> rect(15,179,50,5,'D');
					$pdf-> rect(15,184,50,5,'D');
					
					//
					$pdf-> rect(65,120,70,9,'D');
					$pdf-> SetFont('Times','',7);
					$pdf-> text(68,133, $unidadactual);
					$pdf-> text(68,138, $subcentroactual);
					$pdf-> text(68,148, $ubicacon_actual);
					$pdf-> text(68,143, $centroactual);
					$pdf-> text(68,153,$cargoactual);
					$pdf-> text(68,158,$nivelactual);
					$pdf-> text(68,163,$tipo_contrato_actual);
					$pdf-> text(68,168,$data1[7]['actual']);
					$pdf-> text(68,173,$data1[8]['actual']);
					$pdf-> text(68,178,$data1[9]['actual']);
					$pdf-> text(68,183,$data1[10]['actual']);
					$pdf-> text(68,188,$data1[11]['actual']);
					$pdf-> SetFont('Times','B',10);
					$pdf-> rect(65,129,70,5,'D');
					$pdf-> rect(65,134,70,5,'D');
					$pdf-> rect(65,139,70,5,'D');
					$pdf-> rect(65,144,70,5,'D');
					$pdf-> rect(65,149,70,5,'D');
					
					$pdf-> rect(65,154,70,5,'D');
					$pdf-> rect(65,159,70,5,'D');
					$pdf-> rect(65,164,70,5,'D');
					
					$pdf-> rect(65,169,70,5,'D');
					$pdf-> rect(65,174,70,5,'D');
					$pdf-> rect(65,179,70,5,'D');
					$pdf-> rect(65,184,70,5,'D');
					$pdf-> SetFont('Times','',7);
					$pdf-> text(138,133, $unidadactualp);
					$pdf-> text(138,138, $subcentroactualp);
					$pdf-> text(138,148, $ubicacon_actualp);
					$pdf-> text(138,143, $centroactualp);
					$pdf-> text(138,153,$cargoactualp);
					$pdf-> text(138,158,$nivelactualp);
					$pdf-> text(138,163,$tipo_contrato_actualp);
					$pdf-> text(138,168,$data1[7]['propuesto']);
					$pdf-> text(138,173,$data1[8]['propuesto']);
					$pdf-> text(138,178,$data1[9]['propuesto']);
					$pdf-> text(138,183,$data1[10]['propuesto']);
					$pdf-> text(138,188,$data1[11]['propuesto']);
					$pdf-> SetFont('Times','B',10);
							$pdf-> rect(135,120,60,9,'D');
							$pdf-> rect(135,129,60,5,'D');
							$pdf-> rect(135,134,60,5,'D');
							$pdf-> rect(135,139,60,5,'D');
							$pdf-> rect(135,144,60,5,'D');
							$pdf-> rect(135,149,60,5,'D');
							
							$pdf-> rect(135,154,60,5,'D');
							$pdf-> rect(135,159,60,5,'D');
							$pdf-> rect(135,164,60,5,'D');
							
							$pdf-> rect(135,169,60,5,'D');
							$pdf-> rect(135,174,60,5,'D');
							$pdf-> rect(135,179,60,5,'D');
							$pdf-> rect(135,184,60,5,'D');
					//
					
					
					$pdf-> text(30,125,"CONCEPTOS"); 
					$pdf-> text(85,125,"ACTUAL"); 
					$pdf-> text(150,125,"PROPUESTO"); 
					
					
					
					$pdf-> SetFont('Times','',8);
					$pdf-> text(16,133,"UNIDAD"); 
					$pdf-> text(16,138,"SUBCENTRO"); 
					$pdf-> text(16,143,"CENTRO");
						// $pdf-> text(20,187,utf8_decode('Para contratos que no sean de tipo indefinido, debéra especificar la fecha de término :'));
					$pdf-> text(16,148,utf8_decode('UBICACIÓN'));
					$pdf-> text(16,153,"CARGO");
					$pdf-> text(16,158,"NIVEL");	
					$pdf-> text(16,163,"TIPO DE CONTRATO");
					$pdf-> text(16,168,"SUELDO BASE");
					$pdf-> text(16,173,"ASIGNACIONES ESPECIALES");
					$pdf-> text(16,178,"JEFATURA DIRECTA");
					$pdf-> text(16,183,"OTRO");	
					$pdf-> text(16,188,"OTRO");	
					
					$pdf-> SetFont('Times','B',10);
				
					$pdf-> text(12,198,'OBSERVACIONES');
				
					$pdf-> rect(10,200,195,18,'D');
					$pdf-> SetFont('Times','',8);
					//$pdf->Ln(120);
					$pdf->SetY(202);
					$pdf->SetFontSize(6);
					$pdf-> WriteHTML('<font size=1>'.$vec1[0].'</font>');
					
					$pdf-> SetFont('Times','B',10);
					$pdf-> text(12,225,'Lugar y Fecha :');
					$pdf-> SetFont('Times','',10);
					$pdf-> text(60,225, $data[0]['lugaryfecha']);
					$pdf-> SetFont('Times','',10);
					
					$x=70;
					$y=233;
					$pdf-> SetFont('Times','B',8);
					$pdf-> text(20,233,utf8_decode('FLUJO DE APROBACIÓN :'));
					$pdf-> SetFont('Times','',8);
					$pdf-> text(125,233,'CARGADOR');
					$pdf-> text(160,233,$vecfecha[0]);
					for($i=0;$i<$dim;$i++)
					{
						$pdf-> SetFont('Times','',8);
						$pdf-> text($x,$y,utf8_decode($vecflujo[$i]));
						$d=$dim-1;
						if($i>0 and  $i!=$d){
						$pdf-> text(125,$y,'APROBADOR');
						$pdf-> text(160,$y,$vecfecha[$i]);
						}
						if($i==$d){
							$pdf-> text(125,$y,'EJECUTOR');
							$pdf-> text(160,$y,$vecfecha[$i]);
						}
						$y=$y+5;
					}
					
					$pdf-> text(20,270,'Recursos Humanos - Formulario de Cambios Contractuales ');
					
		sleep(2);	
		$pdf->Output("../Documentacion/Formularios/form".$cod_form.".pdf","F");
		
		}
		
	
	
}
function EnviarPDF($mailuser,$usuario,$tipoform,$nombresolicitante,$cod_form)
{
	$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}

		$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $HOST;  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $CREDENCIAL;                 // SMTP username
			$mail->Password = $CONTRASENA;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->CharSet = 'UTF-8';
			$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
			$mail->addAddress($mailuser, $usuario);     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');

			$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			*/

			$mail->isHTML(true);                                  // Set email format to HTML

			if($tipoform==1){
				$mail->Subject = "Requerimiento de Personal";
				}
				if($tipoform==2){
				$mail->Subject = "Vacaciones y Licencias";
				}
				if($tipoform==3){
					$mail->Subject = "Desvinculación de Personal";
				}
				if($tipoform==4){
					$mail->Subject = "Cambios Contractuales";
				}
				if($tipoform==5){
					$mail->Subject = "Solicitud de Viaje";
				}
				if($tipoform==6){
					$mail->Subject = "Rendición de Viaticos";
				}
			
			$Registros ='';	
			$tipoform1="";
			$nombreform="";
			if($tipoform==1){
			$tipoform1= "Requerimiento de Personal";
				$nombreform=QuitaAcentos($nombresolicitante).".pdf";
			}
			if($tipoform==2){
				$tipoform1 = "Vacaciones y Licencias";
				$nombreform=QuitaAcentos($nombresolicitante).".pdf";
			}
			if($tipoform==3){
			$tipoform1 = "Desvinculación de Personal";
			$nombreform=QuitaAcentos($nombresolicitante).".pdf";
			}
			if($tipoform==4){
			$tipoform1 = "Cambios Contractuales";
			$nombreform=QuitaAcentos($nombresolicitante).".pdf";
			}
			if($tipoform==5){
				$tipoform1 = "Viaje";
				$nombreform=QuitaAcentos($nombresolicitante).".pdf";
			}
			if($tipoform==6){
				$tipoform1 = "Rendición de Vaiticos";
				$nombreform=QuitaAcentos($nombresolicitante).".pdf";
			}
			$ruta="../Documentacion/Formularios/form".(string)$cod_form.".pdf";
			$mail->addAttachment($ruta, $nombreform);
			$body = '<body>'.
				'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.
				//'<div align="center"><a href="http://Swrh.madepa.com.bo:8181"><img src="../img/CaratulaMail.jpg"></a></div><br>'.
				'<br>'.
				 $Registros . '</table>'.
				'<br>'.
				'  <strong> Se le comunica a usted que su solicitud de '.$tipoform1.' solicitada para: '.$nombresolicitante.'  </strong> <br>	'.
				
				//'  <strong> link: http://www.google.com.bo </strong><br> '.
				
				'  <strong>ha pasado todo el Proceso de Aprobaciones. </strong><br><br><br> '.
				'  <strong> Su solicitud esta siendo procesada.... </strong><br><br><br> '.
				
				
				'<b>Atentamente, </b>'.
				'<br>'.
				'<b>Recursos Humanos</b> '.
				'</div>'.
				'</body>';

				$mail->Body    = $body;
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					return true;
				}
		////////////////////////////////////////////////////////////////////////////////////
		
}
function EnvioMailUsuarioNuevo($mailuser,$usuario,$login,$password)
{
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}
			$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $HOST;  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $CREDENCIAL;                 // SMTP username
			$mail->Password = $CONTRASENA;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->CharSet = 'UTF-8';
			$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
			$mail->addAddress($mailuser, $usuario);     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');

			$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			*/

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'ACCESO AL SISTEMA WEB DE RRHH';
			$Registros ='';	
			$body = '<body>'.
				'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.
				// '<div align="center"><a href="http://swrh.madepa.com.bo"><img src="http://swrh.madepa.com.bo/MADEPA/img/CaratulaMail.jpg"></a></div><br>'.
				'<br>'.
				 $Registros . '</table>'.
				'<br>'.
				'  <strong> Estimado(a):   '.$usuario.' </strong> <br><br>	'.
				
				'  <strong>En adjunto usted encontrará el Usuario y Password provisional para su acceso al Sistema Web de RR.HH. </strong><br><br> '.
				'  <strong>  - Usuario Provisional: '.$login.'</strong><br> '.
				'  <strong>  - Password Provisional: '.$password.'</strong><br><br> '.
				'  <strong>  Una vez ingresado a la aplicación, el sistema le solicitará cambie su Usuario y Password a libre elección. </strong><br><br> '.
				// '  <strong>  Pinche aquí para ingresar al sistema:  http://swrh.madepa.com.bo/ </strong><br><br> '.
				'  <strong>  Favor tener en cuenta que el Sistema Web de RRHH puede que no funcione de manera óptima con Internet Explorer, si utilizas este navegador te recomendamos que actualices a una versión superior o bien que utilices una alternativa como Firefox o Chrome. </strong><br><br> '.
				'<b>Atentamente, </b>'.
				'<br>'.
				'<b>Recursos Humanos</b> '.
				'</div>'.
				'</body>';
				$mail->Body    = $body;
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					return true;
				}
		/////////////////////////////////////////////////////////////
	
}
function EnvioMailUsuarioConfirmacion($mailuser,$usuario,$login,$password)
{
	
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
			$rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
			$HOST="";
			$CREDENCIAL="";
			$CONTRASENA="";
			while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}

		$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $HOST;  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $CREDENCIAL;                 // SMTP username
			$mail->Password = $CONTRASENA;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->CharSet = 'UTF-8';
			$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
			$mail->addAddress($mailuser, $usuario);     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');

			$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			*/

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'ACCESO AL SISTEMA WEB DE RRHH';
			$Registros ='';	
			
			$body = '<body>'.
			'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.
			// '<div align="center"><a href="http://swrh.madepa.com.bo"><img src="http://swrh.madepa.com.bo/MADEPA/img/CaratulaMail.jpg"></a></div><br>'.
			'<br>'.
			$Registros . '</table>'.
			'<br>'.
			'  <strong> Estimado(a):   '.$usuario.' </strong> <br><br>	'.
			
			'  <strong> Se le informa a usted que los datos ingresados para Usuario y Pasword para su acceso al Sistema Web de RR.HH. han</strong><br> '.
			'  <strong> sido guardados satisfactoriamente.</strong><br><br> '.
			'  <strong>  - Usuario : '.$login.'</strong><br> '.
			'  <strong>  - Password: '.$password.'</strong><br><br> '.
			'  <strong>  Le recomendamos borrar este mail informativo con la finalidad de resguardar sus datos de acceso. </strong><br>'.
			'  <strong>  Se agradece su atención. </strong><br><br>'.
			
			'<b>Atentamente, </b>'.
			'<br>'.
			'<b>Recursos Humanos</b> '.
			'</div>'.
			'</body>';
				$mail->Body    = $body;
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					return false;
				} else {
					return true;
				}
		////////////////////////////////////////////////////////////////////////////////////
		
		
}
function EnvioMailInformacionCargador($mailuser,$usuario,$tipoform)
{
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}
		$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $HOST;  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $CREDENCIAL;                 // SMTP username
			$mail->Password = $CONTRASENA;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->CharSet = 'UTF-8';
			$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
			$mail->addAddress($mailuser, $usuario);     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');

			$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			*/

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Flujo de Aprobación';
			$form="";
			if($tipoform==1)
			$form="Requerimiento de Personal";
			if($tipoform==2)
			$form= "Vacaciones y Licencias";	
			
			if($tipoform==3)
			$form = "Desvinculación de Personal";
			if($tipoform==4)
			$form= "Cambios Contractuales";
			if($tipoform==5)
			$form= "Viaje";
			if($tipoform==6)
			$form= "Rendición de Viaticos";

			$Registros ='';	
		
			$body = '<body>'.
				'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.
				   
				//'<div align="center"><a href="http://Swrh.madepa.com.bo:8181"><img src="../img/CaratulaMail.jpg"></a></div><br>'.
				'<br>'.
				 $Registros . '</table>'.
				'<br>'.
				'  <strong>Estimado(a):  '.$usuario.' </strong> <br>	'.
				'  <strong>Se le informa a usted  que su Solicitud de '.$form.'  esta siguiendo el respectivo proceso de aprobación. </strong> <br><br>	'.
				
				//'  <strong> link: http://www.google.com.bo </strong><br> '.
				
				'  <strong> Usted puede  verificar el avance del mismo ingresando a: </strong><br> '.
				// '  <strong> http://swrh.madepa.com.bo/ </strong><br><br> '.
				'  <strong> Menú Principal > Aprobaciones > Status de Aprobaciones </strong><br><br>  '.
				'  <strong> Se agradece su atención </strong><br> '.
				'<br>'.
				'<br>'.
				'<b>Atentamente, </b>'.
				'<br>'.
				'<b>Recursos Humanos</b> '.
				'</div>'.
				'</body>';

			$mail->Body    = $body;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
				return false;
			} else {
				return true;
			}
		////////////////////////////////////////////////////////////////////////////////////

		//////////////////////////////////////////////
		
}
function EnvioMailDeFaltaInjustificadas($mailuser,$usuario,$nombreValidador,$nombreAmonestado,$fechafalta)
{
		$sqlcorreo = 'SELECT *  from `correo` where CODCORREO=1 ';
		  $rcorreo = mysql_query($sqlcorreo,$_SESSION['BD']);
		  $HOST="";
		  $CREDENCIAL="";
		  $CONTRASENA="";
		 while ($row1 = mysql_fetch_array($rcorreo)) 
		{
			$HOST =$row1['HOST'];
			$CREDENCIAL  =$row1['CREDENCIAL'];
			$CONTRASENA   =$row1['CONTRASENA'];
		}
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $HOST;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $CREDENCIAL;                 // SMTP username
		$mail->Password = $CONTRASENA;                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->CharSet = 'UTF-8';
		$mail->setFrom($CREDENCIAL, 'Sistema Web de RR.HH.');
		$mail->addAddress($mailuser, $usuario);     // Add a recipient

		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Falta Injustificada';

		$Registros ='';	
		
		$body = '<body>'.
				'<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">'.
				   
				//'<div align="center"><a href="http://Swrh.madepa.com.bo:8181"><img src="../img/CaratulaMail.jpg"></a></div><br>'.
				'<br>'.
				 $Registros . '</table>'.
				'<br>'.
				'  <strong>Estimados(as):  Representantes de RRHH </strong> <br><br>	'.
				'  <strong>Se le informa a usted  que el usuario  '.$nombreValidador.'  ha reportado en el Sistema Web de RRHH. </strong> <br>	'.
				
				'  <strong> una falta Injustificada del trabajador(a): '.$nombreAmonestado.' en fecha: '.$fechafalta.' </strong><br><br> '.
				'  <strong> Favor procesar el Comunicado Interno y/o Memorándum Interno según corresponda. </strong><br><br>  '.
				
				
				'<br>'.
				'<br>'.
				'<b>Atentamente, </b>'.
				'<br>'.
				'<b>Recursos Humanos</b> '.
				'</div>'.
				'</body>';
		$mail->Body    = $body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->addCC('lzegarra@madepa.com.bo');
	    $mail->addBCC('mrnogales@madepa.com.bo');

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		} else {
			return true;
		}
		///////////////////////////////////////////////////////////////////////////////
		
}
		
?>