	<?php     
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
	  			  
		  
	
	include("../lib/conex.php");
	
	$conex = ConectarConBD(); // Inicializa la conexión correctamente
	if (!$conex) {
		die("Error al conectar con la base de datos");
	}
			
	// if (!VerificaConBD())	{	
	// 	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
	// 	exit;	
	// }
	
		
	$sql=' SELECT p.*,u.DESCRIPCION as uDESCRIPCION,s.DESCRIPCION as sDESCRIPCION,c.DESCRIPCION as cDESCRIPCION,cc.DESCRIPCION as ccDESCRIPCION '.
	     
		 '  FROM `personal` p inner join cargo c on p.COD_CARGO=c.COD_CARGO inner join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO inner join subcentro s on s.COD_SUBCENTRO=cc.COD_SUBCENTRO inner join unidad u  on u.COD_UNIDAD=cc.COD_UNIDAD ' .
		 ' where p.ACTIVO=1'.
		 ' ORDER BY p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2,p.NRO_TRABAJADOR';
		
		 
		 
	$sql1="SELECT * from tarjetas_comedor where ACTIVO=1 ORDER BY NOMBRE";
	$resultado1=mysqli_query($conex,$sql1);
	//}
	 $stotal = mysqli_query($conex,"SELECT COUNT(COD_PERSONAL) AS TOTAL FROM `personal`  WHERE ACTIVO = 1 ");//TRAEMOS EL TOTAL
	$total = mysqli_fetch_array($stotal);
	// mysqli_query("SET NAMES 'utf8'");
	mysqli_set_charset($conex, "utf8");
	$resultado=mysqli_query($conex,$sql);    
	
	$data = array();	
	//mysqli_query("SET NAMES 'utf8'");
	while ($row = mysqli_fetch_array($resultado)) 	{	

		
		$nombre_completo=$row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'];
		$nombre=$row['NOMBRE'].' '.$row['NOMBRE2'];
		array_push($data, 
		array( 	"codigo"		=> $row['COD_PERSONAL'], 
				"nombre" 	=> $nombre_completo,
				"nombreP"	=> $nombre,
				"app"		=> $row['AP_PATERNO'],
				"apm"		=> $row['AP_MATERNO'],
				"codtrabajador"		=> $row['NRO_TRABAJADOR'],
				"cargo"		=> $row['cDESCRIPCION'],
				"codcargo"		=> $row['COD_CARGO'],
				"unidad"		=> $row['uDESCRIPCION'],
				"subcentro"		=> $row['sDESCRIPCION'],
				"centro"		=> $row['ccDESCRIPCION'],
				"codcentro"		=> $row['COD_CENTRO'],
				
				));	
		
	}     
	while ($row1 = mysqli_fetch_array($resultado1)) 	{	

		
		$nombre_completo=$row1['NOMBRE'];
		$nombre=$row1['NOMBRE'];
		$sqlpersonal=' SELECT p.NOMBRE,p.NOMBRE2,p.AP_PATERNO,p.AP_MATERNO,c.DESCRIPCION as cDESCRIPCION,cc.DESCRIPCION as ccDescripcion,s.DESCRIPCION as sDescripcion,u.DESCRIPCION AS uDescripcion'.
			   '  from personal p '.
				' left join cargo c on c.COD_CARGO=p.COD_CARGO '.
				' left join centro_de_costo cc on p.COD_CENTRO=cc.COD_CENTRO'.
				' left join subcentro s on cc.COD_SUBCENTRO=s.COD_SUBCENTRO '.
				' left join unidad u on u.COD_UNIDAD=cc.COD_UNIDAD '.
			   '   where  p.NRO_TRABAJADOR='.$row1['CODIGO'];
			  // echo "/*$sqlpersonal*/";
				$rpersonal=mysqli_query($conex,$sqlpersonal); 
				$cDESCRIPCION="";
				$COD_CARGO="";
				$uDESCRIPCION="";
				
				$sDESCRIPCION="";
				$ccDESCRIPCION="";
				$COD_CENTRO="";
				while($rowp= mysqli_fetch_array($rpersonal)) 
				{	
					 //$nombre_completo=$rowp['AP_PATERNO'].' '.$rowp['AP_MATERNO'].' '.$rowp['NOMBRE'].' '.$rowp['NOMBRE2'];
					 $cDESCRIPCION=$rowp['cDESCRIPCION'];
					
					$uDESCRIPCION=$rowp['uDescripcion'];
					
					$sDESCRIPCION=$rowp['sDescripcion'];
					$ccDESCRIPCION=$rowp['ccDescripcion'];
				
					
				}
				
					array_push($data, 
					array( 	"codigo"		=> $row1['CODIGO'], 
							"nombre" 	=> $nombre_completo,
							"nombreP"	=> $nombre,
							
							"codtrabajador"		=> $row1['CODIGO'],
							
							
							"cargo"		=> $cDESCRIPCION,
							
							"unidad"		=> $uDESCRIPCION,
							"subcentro"		=> $sDESCRIPCION,
							"centro"		=> $ccDESCRIPCION,
							
							
							));	
				
		
		
	}       										
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
?> 