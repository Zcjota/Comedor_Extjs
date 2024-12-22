<?php
	include("../lib/conex.php");
	 session_start();	
	 if (empty($_SESSION['IdUsuario'])) { $IdUsuario=0;} else {  $IdUsuario=$_SESSION['IdUsuario'];}

	  if (empty($_SESSION['Nombre1'])) { $Nombre=0;} else {  $Nombre=strtoupper($_SESSION['Nombre1']).' '.strtoupper($_SESSION['App']);}
	 if (empty($_SESSION['tipoUser'])) { $tipoUser=0;} else {  $tipoUser=$_SESSION['tipoUser'];}
	 
	$codigoTrabajador             =    $_REQUEST["id"];
	$fechaini             =   $_REQUEST["fechaini"] ;
	$fechafin             =    (string)date("d/m/Y", strtotime($_REQUEST["fechafin"])) ;
	$cbtipo=1;
	//date_default_timezone_set('America/La_Paz');
		$fecha=date("Y-m-d H:i:s");
		echo "/*$fechaini*/"	;
		echo "/*$fechafin*/"	;
	
	// if (!VerificaConBD())
	// {	echo '{"Success": false, "errors":{"reason": "No se puede conectar con la BD"}}';	
	// 	exit;
	// }
	$conex = ConectarConBD();
    if (!$conex) {
        echo json_encode(["Success" => false, "errors" => ["reason" => "No se puede conectar con la BD"]]);
        exit;
    }	
	function existePersona($conex,$codPersona,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(tp.COD_PERSONAL) as TOTALE from  tipo_comida tp where tp.COD_PERSONAL='.$codPersona.' and tp.GESTION='.$gestion.' and tp.MES='.$mes.' and tp.DIA='.$dia;
		echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 function existePersonaActivo($conex,$codPersona,$gestion,$mes,$dia)
	 {
		$sqlex1 = 'SELECT count(gp.COD_PERSONAL) as TOTALE from  tipo_comida gp where gp.COD_PERSONAL='.$codPersona.' and gp.GESTION='.$gestion.' and gp.MES='.$mes.' and gp.DIA='.$dia.' and gp.ACTIVO=1';
		echo "/*$sqlex1*/";
		$resultadoex1=mysqli_query($conex,$sqlex1);
		$tot2 = mysqli_fetch_array($resultadoex1);
		$t2=$tot2['TOTALE'];
		
		
		
			return $t2;
	 }
	 mysqli_query($conex,"BEGIN");
	 $valores = explode ("/", $fechaini); 
					$gestion = $valores[2] ;
					$mes = $valores[1] ;
					$dia = $valores[0] ;
					$valores1 = explode ("/", $fechafin); 
					$gestion1 = $valores1[2] ;
					$mes1 = $valores1[1] ;
					$dia1 = $valores1[0] ;	
					$fDE=date($gestion."-".$mes."-".$dia);
					
					$fHATA=date($gestion1."-".$mes1."-".$dia1);
					$sqlt = "update `tipo_comida` set  VALIDADOR='$Nombre',FECHA=NOW(),COD_USUARIO=$IdUsuario,ACTIVO=0".
										" where ".
										"  COD_PERSONAL=$codigoTrabajador ";
					$resultadot = mysqli_Query($conex,$sqlt,);
					echo "/*$fDE*/";
					echo "/*$fHATA*/";
										
						
					 for($i=$fDE;$i<=$fHATA;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
						echo "/*$i*/";
					
						$valores1 = explode ("-", $i); 
						$gestion1 = $valores1[0] ;
						$mes1 = $valores1[1] ;
						$dia1 = $valores1[2] ;	
						$f=existePersona($conex,$codigoTrabajador,$gestion1,$mes1,$dia1);
						if($f!=0)
						{
							$f1=existePersonaActivo($conex,$codigoTrabajador,$gestion1,$mes1,$dia1);
							if($f1!=0)
							{
								$sql = "update `tipo_comida` set  VALIDADOR='$Nombre',FECHA=NOW(),COD_USUARIO=$IdUsuario,FECHA_INICIO='$fechaini',FECHA_FIN='$fechafin'".
										" where GESTION='$gestion1' and MES='$mes1' and DIA='$dia1'".
										" and COD_PERSONAL=$codigoTrabajador ";
												   
							}
							else{
								$sql = "update `tipo_comida` set  ACTIVO=1,VALIDADOR='$Nombre',FECHA=NOW(),COD_USUARIO=$IdUsuario,FECHA_INICIO='$fechaini',FECHA_FIN='$fechafin'".
										" where GESTION='$gestion1' and MES='$mes1' and DIA='$dia1'".
										" and COD_PERSONAL=$codigoTrabajador ";
							}
						}
						else{
						$sql = "INSERT INTO `tipo_comida` (COD_PERSONAL,COD_TIPO,GESTION,MES,DIA,VALIDADOR,FECHA,COD_USUARIO,FECHA_INICIO,FECHA_FIN,ACTIVO) VALUES ".
													  "($codigoTrabajador,$cbtipo,'$gestion1','$mes1','$dia1','$Nombre',NOW(),$IdUsuario,'$fechaini','$fechafin',1)";
						}
						$resultado = mysqli_Query($conex,$sql);
						$error = 0;	
						if (!$resultado)
							$error = 1;	
							
							if ($error == 1){
								 // Como ocurrio un error, entonces cancelamos toda la transacción,
								 // y dejamos todo igual hasta antes del BEGIN
								 mysqli_query($conex,"ROLLBACK");  
								 echo '{"Success": false, "errors":{"reason": "Error al guardar registro"}}';
							}
				}
				 if($error ==0)
						{
							
								mysqli_query($conex,"COMMIT");
								echo '{success: true,"msg":{"reason": "Se registro corectamente."}}';
							
						}
	// function existePersonal($codigo)
	 // {
		// $sqlex1 = 'SELECT count(NRO_TRABAJADOR) as TOTALE from  personal where NRO_TRABAJADOR='.$codigo;
		// echo "/*$sqlex1*/";
		// $resultadoex1=mysqli_query($sqlex1,$conex );
		// $tot2 = mysqli_fetch_array($resultadoex1);
		// $t2=$tot2['TOTALE'];
		
		
		
			// return $t2;
	 // }
	// switch ($op)
	// {
		// case "0":
		// {
			
			// $sql = "INSERT INTO `tarjetas_comedor` (CODIGO,NOMBRE,ACTIVO) VALUES ".
			                          // "($codigo,'$nombre', 1)";	
			// break;
		// }
		// case "1":
		// {
			// $sql = ' UPDATE `tarjetas_comedor` SET'. 
			       // ' NOMBRE = "'. $nombre.	'"'.
			      		   
				   // ' WHERE CODIGO = '.$codigo;
			// break;
		// }
	// }
		// mysqli_query("SET NAMES 'utf8'");	
	// //$total=existePersonal($codigo);
	
		// if ($resultado = mysqli_Query($sql, $conex ))
		// {	
		   // echo "{success: true}";
		// }  
		// else
		// {
		  // echo '{"Success": false, "errors":{"reason": "Error al guardar registro, código ya existente."}}';
		// }	
	
	
	

?>