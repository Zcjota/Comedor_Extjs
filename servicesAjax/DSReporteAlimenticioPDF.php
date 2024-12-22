<?php

	require('../fpdf17/fpdf.php');
    include("../lib/conex.php");
	$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}
	$fechaf = $_REQUEST["fechaf"];
	$fechai = $_REQUEST["fechai"];
	// mysqli_query("SET NAMES 'utf8'");
	mysqli_set_charset($conex, "utf8");
	$valores = explode ("-", $fechai); 
		$gestion = $valores[0] ;
		$mes = $valores[1] ;
		$dia = $valores[2] ;
	$valores1 = explode ("-", $fechaf); 
		$gestion1 = $valores1[0] ;
		$mes1 = $valores1[1] ;
		$dia1 = $valores1[2] ;
	$fechaii=$dia.'-'.$mes.'-'.$gestion;
	$fechaff=$dia1.'-'.$mes1.'-'.$gestion1;
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
		 while ($row= mysqli_fetch_array($rHorario)) 
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
	while ($row = mysqli_fetch_array($resultadom)) 
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
			if ($row1 = mysqli_fetch_array($resultado1)) 
			{
			  $nombre=$row1['NOMBRE'].' '.$row1['AP_PATERNO'];
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
				if ($row2 = mysqli_fetch_array($resultado2)) 
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
					if ($row1 = mysqli_fetch_array($resultado1)) 
					{
					  $nombre=$row1['NOMBRE'].' '.$row1['AP_PATERNO'];
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
						if ($row2 = mysqli_fetch_array($resultado2)) 
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
	
	function BasicTableM($header,$data,$column)
	{
		$camw="18,42,65,30,25,33,";
		for($p=1;$p<=$column;$p++)
		{
			$camw.="12,";
		}
		$camw  = substr($camw, 0, strlen($camw) - 1);
		$valores = explode (",", $camw); 
		$w = $valores;
		 for($i=0;$i<count($header);$i++)
		{
			$this->Cell($w[$i],9,$header[$i],1,0,'C');
		}
		$this-> SetFont('Times','',8.5);	
		$this->Ln();
		$vt1=0;$vt2=0;$vt3=0;$vt4=0;$vt5=0;$vt6=0;$vt7=0;$vt8=0;$vt9=0;$vt10=0;$vt11=0;$vt12=0;$vt13=0;$vt14=0;$vt15=0;	
		foreach($data as $row)
		{
			$this->Cell(18,5,$row['codigo'],1,0,'',false,'',3,0,false,'T','B');
		    $this->Cell(42,5,utf8_decode($row['nombre']),1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(65,5,utf8_decode($row['cargo']),1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(30,5,utf8_decode($row['unidad']),1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(25,5,utf8_decode($row['subcentro']),1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(33,5,utf8_decode($row['centro']),1,0,'',false,'',3,0,false,'T','B');
			 if($column>=1){$this->Cell(12,5,$row['c1'],1,0,'R',false,'',3,0,false,'T','B');$vt1=$vt1+$row['c1'];}
			if($column>=2){$this->Cell(12,5,$row['c2'],1,0,'R',false,'',3,0,false,'T','B');$vt2=$vt2+$row['c2'];}
			if($column>=3){$this->Cell(12,5,$row['c3'],1,0,'R',false,'',3,0,false,'T','B');$vt3=$vt3+$row['c3'];}
			if($column>=4){$this->Cell(12,5,$row['c4'],1,0,'R',false,'',3,0,false,'T','B');$vt4=$vt4+$row['c4'];}
			if($column>=5){$this->Cell(12,5,$row['c5'],1,0,'R',false,'',3,0,false,'T','B');$vt5=$vt5+$row['c5'];}
			if($column>=6){$this->Cell(12,5,$row['c6'],1,0,'R',false,'',3,0,false,'T','B');$vt6=$vt6+$row['c6'];}
			if($column>=7){$this->Cell(12,5,$row['c7'],1,0,'R',false,'',3,0,false,'T','B');$vt7=$vt7+$row['c7'];}
			if($column>=8){$this->Cell(12,5,$row['c8'],1,0,'R',false,'',3,0,false,'T','B');$vt8=$vt8+$row['c8'];}
			if($column>=9){$this->Cell(12,5,$row['c9'],1,0,'R',false,'',3,0,false,'T','B');$vt9=$vt9+$row['c9'];}
			if($column>=10){$this->Cell(12,5,$row['c10'],1,0,'R',false,'',3,0,false,'T','B');$vt10=$vt10+$row['c10'];}
			if($column>=11){$this->Cell(12,5,$row['c11'],1,0,'R',false,'',3,0,false,'T','B');$vt11=$vt11+$row['c11'];}
			if($column>=12){$this->Cell(12,5,$row['c12'],1,0,'R',false,'',3,0,false,'T','B');$vt12=$vt12+$row['c12'];}
			if($column>=13){$this->Cell(12,5,$row['c13'],1,0,'R',false,'',3,0,false,'T','B');$vt13=$vt13+$row['c13'];}
			if($column>=14){$this->Cell(12,5,$row['c14'],1,0,'R',false,'',3,0,false,'T','B');$vt14=$vt14+$row['c14'];}
			if($column>=15){$this->Cell(12,5,$row['c15'],1,0,'R',false,'',3,0,false,'T','B');$vt15=$vt15+$row['c15'];}
			 // for($i=1;$i<=$column;$i++)
			// {
				// $val="c".$i;
				// $this->Cell(12,5,$row[$val],1,0,'R',false,'',3,0,false,'T','B');
			// }
			$this->Ln();
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('L','letter');
				$this->Ln();
				$j1=40;
			}
			
			
		}
		   $this->Cell(18,5,'',1,0,'',false,'',3,0,false,'T','B');
		    $this->Cell(42,5,'',1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(65,5,'',1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(30,5,'',1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(25,5,'',1,0,'',false,'',3,0,false,'T','B');
			$this->Cell(33,5,'TOTAL ',1,0,'R',false,'',3,0,false,'T','B');
			 if($column>=1){$this->Cell(12,5,$vt1,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=2){$this->Cell(12,5,$vt2,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=3){$this->Cell(12,5,$vt3,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=4){$this->Cell(12,5,$vt4,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=5){$this->Cell(12,5,$vt5,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=6){$this->Cell(12,5,$vt6,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=7){$this->Cell(12,5,$vt7,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=8){$this->Cell(12,5,$vt8,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=9){$this->Cell(12,5,$vt9,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=10){$this->Cell(12,5,$vt10,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=11){$this->Cell(12,5,$vt11,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=12){$this->Cell(12,5,$vt12,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=13){$this->Cell(12,5,$vt13,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=14){$this->Cell(12,5,$vt14,1,0,'R',false,'',3,0,false,'T','B');}
			if($column>=15){$this->Cell(12,5,$vt15,1,0,'R',false,'',3,0,false,'T','B');}
			$this->Ln();
			$a=$this->GetY();
			if($a>250)
			{
			 $this->AddPage('L','letter');
				$this->Ln();
				$j1=40;
			}
		
	}
}


// Creaci�n del objeto de la clase heredada
$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->AddPage('L','letter');					
$pdf-> SetFont('Times','B',10);
$proveedor="";
	$sqlProveedor=' SELECT nombre  from proveedor  where activo=1  order by _id desc limit 1  ';
				 $rproveedor=mysqli_query($conex,$sqlProveedor); 
				 
				 if ($row= mysqli_fetch_array($rproveedor)) 
				 {	
					$proveedor=$row['nombre'];
				 }
			$pdf-> SetLineWidth(0.2);
			$pdf-> text(100,25,'DETALLE ALIMENTACION COMEDOR S.R.L');
			$pdf-> text(108,32,'DEL: '.$fechaii.'   AL: '.$fechaff);
			$pdf-> text(70,39,'PROVEEDOR: '.$proveedor);
			$pdf-> text(150,39,'REGIONAL: SANTA CRUZ');
		
			$pdf-> Ln(33);
			$campos = "CODIGO,COLABORADOR,CARGO,UNIDAD,SUBCENTRO,CENTRO,";
			$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
			$rHorario=mysqli_query($conex,$sqlHorario); 
			$column=0;
			 while ($row= mysqli_fetch_array($rHorario)) 
			{	
					$descripcion  = substr($row['DESCRIPCION'], 0,4);
					$campos .= $descripcion.",";
					$column++;
			}
			$campos  = substr($campos, 0, strlen($campos) - 1);
			$valores = explode (",", $campos); 
			$header1 = $valores; 
			$pdf-> BasicTableM($header1,$data,$column);
			
			// $header = array('FECHA', 'NRO. DE GUIA', 'RAZA','MARCA','INGRESO','SALIDA', 'TIPO'); 
			//$pdf-> Ln(10);
			//$pdf-> BasicTable($header,$data_detalle);
			
			
	sleep(2);	
	$pdf->Output();
?>