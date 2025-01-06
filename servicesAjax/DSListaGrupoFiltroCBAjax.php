	<?php     
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
	  			  
		  
	
	include("../lib/conex.php");
	$conex = ConectarConBD();
	// if (!VerificaConBD())	{	
	// 	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
	// 	exit;	
	// }
	if (!$conex) {
		echo json_encode(['success' => false, 'errors' => ['reason' => 'No se puede conectar con la BD']]);
		exit;
	}
	
	// mysqli_query("SET NAMES 'utf8'");	
	$sql = 'SELECT * FROM `grupo` WHERE ACTIVO = 1 ORDER BY  NOMBRE_GRUPO';  	
	$resultado=mysqli_query($conex,$sql);    
	
	$data = array();	
	array_push($data, 
				array( 	"codigog"		=> -1, 
						"nombreg"		=> "SIN FILTRO GRUPO",
						));	
	array_push($data, 
				array( 	"codigog"		=> 0, 
						"nombreg"		=> "SIN GRUPO",
						
						));	
	while ($row = mysqli_fetch_array($resultado)) 	{	
		
				array_push($data, 
				array( 	"codigog"		=> $row['COD_GRUPO'], 
						"nombreg"		=> $row['NOMBRE_GRUPO'],
						
						));				
	}       										 
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
?> 