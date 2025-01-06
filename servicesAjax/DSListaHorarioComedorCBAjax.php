<?php     
	include("../lib/conex.php");
	
	// if (!VerificaConBD())	{	
	// 	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
	// 	exit;	
	// }
	$conex = ConectarConBD(); // Inicializa la conexión correctamente
	if (!$conex) {
		die("Error al conectar con la base de datos");
	}
	
	$sql = 'SELECT CODIGO,DESCRIPCION FROM `horario_comedor` WHERE ACTIVO = 1 ORDER BY HORARIO ';  	
	$resultado=mysqli_query($conex,$sql);    	
	$data = array();	
	$i=0;
	while ($row = mysqli_fetch_array($resultado)) 	{	
				if($i==0)
				{
					array_push($data, 
					array( 	"codigop"		=> 0, 
					"nombrep" 	=> "TODOS"));
				}
				array_push($data, 
				array( 	"codigop"		=> $row['CODIGO'], 
				"nombrep" 	=> $row['DESCRIPCION']));
		$i++;	
						
	}  
	
	
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
 ?> 