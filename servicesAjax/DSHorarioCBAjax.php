<?php     
	include("../lib/conex.php");
	$conex = ConectarConBD();
	
	 session_start();
		$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		$nombreValidador=$_SESSION['Apellido1']." ".$_SESSION['Apellido2']." ".$_SESSION['Nombre'];
	// if (!VerificaConBD())	{	
	// 	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
	// 	exit;	
	// }
	if (!$conex) {
		echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
		exit;
	}
	function dias($conex,$horario)
	{
		$d[1]='LUN';
		$d[2]='MAR';
		$d[3]='MIE';
		$d[4]='JUE';
		$d[5]='VIE';
		$d[6]='SAB';
		$d[7]='DOM';
	    $cadDia="";
		$sqldia = 'SELECT hd.COD_DIA  FROM `horario_dia` hd inner join horario h on hd.COD_HORARIO=h.COD_HORARIO  where hd.ACTIVO=1 AND hd.COD_HORARIO='.$horario.' order by hd.COD_DIA asc';
		 
		 $resultado1=mysqli_query($conex,$sqldia);  
		while ($row = mysqli_fetch_array($resultado1)) 	{
			$cadDia=$cadDia.(string) $d[$row['COD_DIA']].',';
			
		}
		return $cadDia;
	}
	function asignacion($conex,$cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador!=2)
			{
				$sqlAsignacion=' select count(COD_USUARIO) as TOT from usuario_horario  where COD_USUARIO ='.$idusuario.' and COD_HORARIO='.$personalE.' and  ACTIVO=1 ';
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
	
	$sql = 'SELECT * FROM `horario` WHERE ACTIVO = 1 ORDER BY NOMBRE_HORARIO ';  	
	$resultado=mysqli_query($conex,$sql);    	
	$data = array();	
	$m[1]="00";
	$m[5]="05";
	$m[10]="10";
	$m[15]="15";
	$m[20]="20";
	$m[25]="25";
	$m[30]="30";
	$m[35]="35";
	$m[40]="40";
	$m[45]="45";
	$m[50]="50";
	$m[55]="55";
	while ($row = mysqli_fetch_array($resultado)) 	{
		 $tipoAsignacion1=asignacion($conex,$rcargador,$ridcargador,$row['COD_HORARIO']);
			if($tipoAsignacion1==1  || $rcargador ==2 )
			{
				$descripcion="";
				$cadDia=dias($conex,$row['COD_HORARIO']);
				if($row['COD_TIPOHORARIO']==1)
				{
				$descripcion= 'HE:'.$row['INICIO_ENTRADAH'].':'.(string)$m[$row['INICIO_ENTRADAM']].'  HS:'.$row['FINAL_SALIDAH'].':'.(string)$m[$row['FINAL_SALIDAM']];
				}
				else
				{
					$descripcion= 'HE:'.$row['INICIO_ENTRADAH'].':'.(string) $m[$row['INICIO_ENTRADAM']].'  HS:'.$row['FINAL_ENTRADAH'].':'.(string) $m[$row['FINAL_ENTRADAM']].'  HE:'.$row['INICIO_SALIDAH'].':'.(string) $m[$row['INICIO_SALIDAM']].'  HS:'.$row['FINAL_SALIDAH'].':'.(string) $m[$row['FINAL_SALIDAM']];
				}
				
				array_push($data, 
				array( 	"codigop"		=> $row['COD_HORARIO'], 
						"nombrep" 	=> $row['NOMBRE_HORARIO'],
						"descripcion"   => $descripcion,
						"dias"  => $cadDia
						));	
			}
	}       										 
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
 ?> 