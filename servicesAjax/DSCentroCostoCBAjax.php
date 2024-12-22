<?php     
	include("../lib/conex.php");
	
	// if (!VerificaConBD())	{	
	// 	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';			
	// 	exit;	
	// }
	$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}
		mysqli_query("SET NAMES 'utf8'");	
	$sql = 'SELECT * FROM `centro_de_costo` WHERE ACTIVO = 1 ORDER BY DESCRIPCION ';  	
	$resultado=mysqli_query($conex,$sql);    	

	$data = array();	
	
	while ($row = mysqli_fetch_array($resultado)) 	{
		
				
				array_push($data, 
				array( 	"codigop"		=> $row['COD_CENTRO'], 
						"nombrep" 	=> $row['DESCRIPCION'],
						
						));	
			
	}       										 
	$o = array(              
		"total"=>count($data),  
		"data"=>$data  
	);      
	echo json_encode($o); 	
 ?> 