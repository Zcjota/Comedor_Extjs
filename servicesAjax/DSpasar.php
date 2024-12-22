	<?php     
/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
	   session_start();
	
		$a=$_REQUEST["reg"];
		$_SESSION['reg']=$a;
		
		 $data = array();
		  array_push($data, 
	     array( 
			"codigo"                => 0,
			"descripcion" 		    =>  "")

			);
			
		$paging = array	(
	'success'=>true,
	'total'=>'1',
	'data'=> $data);
	echo json_encode($paging);

		// echo "{success: true}";
	

?> 