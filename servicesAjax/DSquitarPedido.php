<?php

/*!
 * DSoft-MHCA ARG
 * Copyright(c) 2010
 */
	include("../lib/conex.php");
	
	$reg = $_POST['registrosGrid'];
	//$regPersonal = $_POST['reg'];
	
	
	$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}
	
mysqli_set_charset($conex, "utf8");
		//  mysqli_query("SET NAMES 'utf8'");
	
		
	$records = json_decode(stripslashes($reg));
			
		
			if ($records != '')
			{
				
						foreach($records as $record)
						{		
						   mysqli_query($conex,"BEGIN");
							$codigo= 	$record -> codigo;
							
							$fecha= 	$record -> fecha;
							//$fecha=(string)date("Y-m-d H:i:s", strtotime($fecha));
								$sqlg= "update tipo_comida set ACTIVO=0 WHERE COD_PERSONAL=$codigo and FECHA='$fecha' ";
									// echo "/*$sqlg*/"	;
														  $result = mysqli_query($conex,$sqlg);
								
								$error = 0;	
								if (!$result)
									$error = 1;	
									
									if ($error == 1){
										 // Como ocurrio un error, entonces cancelamos toda la transacción,
										 // y dejamos todo igual hasta antes del BEGIN
										 mysqli_query($conex,"ROLLBACK");  
										 echo '{"Success": false, "errors":{"reason": "Error al guardar registro"}}';
									}
									else
									{
										mysqli_query($conex,"COMMIT");
										echo '{success: true,"msg":{"reason": "Se registro corectamente."}}';
									}
							
					}
				
				
				
			}	
		
		 
?>