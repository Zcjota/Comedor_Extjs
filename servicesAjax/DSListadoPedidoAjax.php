<?php
	include("../lib/conex.php");       			  
	 session_start();	
	 $conex = ConectarConBD();
	 if (empty($_SESSION['IdUsuario'])) { $IdUsuario=0;} else {  $IdUsuario=$_SESSION['IdUsuario'];}
	 if (empty($_SESSION['tipoUser'])) { $tipoUser=0;} else {  $tipoUser=$_SESSION['tipoUser'];}
	 date_default_timezone_set('America/La_Paz');
	 if($IdUsuario!=0)
	 {
		$start =0;	
		$limit = 1000;
		$buscar = isset($_POST['buscar'])?$_POST['buscar']:'';
		if ((strcmp(trim($buscar), '') == 0) || (strcmp(trim($buscar), '*') == 0))
		{
			$sql_buscar = '';
		}
		else
		{ 
			
			$sql_buscar = " and (  p.AP_PATERNO LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%'".
						" OR p.AP_MATERNO LIKE '%" . str_replace('*', '%', trim(strtoupper($buscar))) . "%'".
					" OR p.NOMBRE LIKE '%". str_replace('*', '%', trim(strtoupper($buscar)))."%'".
					" OR p.NRO_TRABAJADOR LIKE '%". str_replace('*', '%', trim(strtoupper($buscar)))."%')";
		
					
		}
	   if ($tipoUser==0)
		{
			$sql_buscarpedido = '';
		}
		else
		{ 
			$sql_buscarpedido='';
			// if ($tipoUser!=2)
			// {
			// $sql_buscarpedido = " and t.COD_USUARIO=".$IdUsuario;
						
			// }
					
		}			
		if (!VerificaConBD())	
		{
		echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
		exit;
        }
	 }	 
	//  $st = mysqli_query($conex,' SELECT t.COD_PERSONAL,t.COD_TIPO,t.GESTION,t.MES,t.DIA,t.VALIDADOR,t.FECHA,t.FECHA_INICIO,t.FECHA_FIN,'.
	// 				' p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2 from tipo_comida t inner join personal p  on t.COD_PERSONAL=p.NRO_TRABAJADOR'.
	// 	               '   WHERE t.ACTIVO =1   '.$sql_buscarpedido.$sql_buscar.' GROUP BY t.COD_PERSONAL  ORDER BY p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2 ASC '.
	// 				   ' LIMIT '.$start.','.$limit);	
					   $st = mysqli_query($conex, 
    'SELECT t.COD_PERSONAL, t.COD_TIPO, t.GESTION, t.MES, t.DIA, t.VALIDADOR, t.FECHA, t.FECHA_INICIO, t.FECHA_FIN, 
            p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2 
     FROM tipo_comida t 
     INNER JOIN personal p ON t.COD_PERSONAL = p.NRO_TRABAJADOR 
     WHERE t.ACTIVO = 1 ' . $sql_buscarpedido . $sql_buscar . ' 
     GROUP BY t.COD_PERSONAL, t.COD_TIPO, t.GESTION, t.MES, t.DIA, t.VALIDADOR, t.FECHA, t.FECHA_INICIO, t.FECHA_FIN, 
              p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2 
     ORDER BY p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2 ASC 
     LIMIT ' . $start . ',' . $limit
);
		
		$tot=0;
		$w=0;
		$x;
		$x1;
		$y=1;
		$t;
		while ($row = mysqli_fetch_assoc($st)) 
		{	
		
			if($w==0)
			{
				$x=$row['FECHA'];
				$x1=$row['VALIDADOR'];
				$w=1;
			}
			else
			{
				if($x==$row['FECHA'] and $x1==$row['VALIDADOR'])
				{
					$y++;
					
				}
				else
				{
					$t[$tot]=$y;
					echo "/*---$t[$tot]---*/";
					$tot++;
					$x=$row['FECHA'];
					$x1=$row['VALIDADOR'];
					$y=1;
				}
			}
		
		}
		$t[$tot]=$y;
	
		
		
	// $sql=' SELECT t.COD_PERSONAL,t.COD_TIPO,t.GESTION,t.MES,t.DIA,t.VALIDADOR,t.FECHA,t.FECHA_INICIO,t.FECHA_FIN ,'.
	// 	 'p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2 from tipo_comida t '.
	  
	// 	 ' inner join personal p  on t.COD_PERSONAL=p.NRO_TRABAJADOR '.
	// 	 ' WHERE t.ACTIVO =1 '.$sql_buscarpedido.$sql_buscar .
	// 	 ' GROUP BY t.COD_PERSONAL  ORDER BY p.AP_PATERNO,p.AP_MATERNO,p.NOMBRE,p.NOMBRE2 ASC'.
	// 	 ' LIMIT '.$start.','.$limit;
	
		 $sql = 'SELECT t.COD_PERSONAL, t.COD_TIPO, t.GESTION, t.MES, t.DIA, t.VALIDADOR, t.FECHA, t.FECHA_INICIO, t.FECHA_FIN,
		 p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2 
  FROM tipo_comida t 
  INNER JOIN personal p ON t.COD_PERSONAL = p.NRO_TRABAJADOR 
  WHERE t.ACTIVO = 1 ' . $sql_buscarpedido . $sql_buscar . ' 
  GROUP BY t.COD_PERSONAL, t.COD_TIPO, t.GESTION, t.MES, t.DIA, t.VALIDADOR, t.FECHA, t.FECHA_INICIO, t.FECHA_FIN, 
		   p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2 
  ORDER BY p.AP_PATERNO, p.AP_MATERNO, p.NOMBRE, p.NOMBRE2 ASC 
  LIMIT ' . $start . ',' . $limit;

		
	echo "/*$sql*/";	
			// mysqli_query("SET NAMES 'utf8'");	
			mysqli_set_charset($conex, "utf8");

	$stotal = mysqli_query($conex,"SELECT COUNT(p.NRO_TRABAJADOR) AS TOTAL FROM `tipo_comida` t inner join personal p  on t.COD_PERSONAL=p.NRO_TRABAJADOR WHERE t.ACTIVO =1 ".$sql_buscarpedido.$sql_buscar);//TRAEMOS EL TOTAL
	$total = mysqli_fetch_assoc($stotal);//$stotal
	
	$resultado=mysqli_query($conex,$sql);  //TRAEMOS RESULTADOS
	
	 $data = array();
	 $ordenador="";
	 $auxordenador=1;
	 $aux=0;
	$con=1;
	while ($row = mysqli_fetch_assoc($resultado)) 
	{	
	  $tipo="";
	  if($row['COD_TIPO']==1)
	  {
	   $tipo="DIETA";
	  }
	  if($auxordenador<10)
			{
				$ordenador="0".$auxordenador;
			}
			else
			{
				$ordenador=$auxordenador;
			}
		if(($con)==$t[$aux])
			{	
				
				$aux++;
				$con=1;
					$auxordenador++;
					
			}
			else
			{
				
				$con++;
				
			}
		
		$valores = explode ("/", $row['FECHA_FIN']); 
	       $gestion = (int)$valores[2] ;
		   
		   $mes = (int)$valores[1] ;
		  
		   $dia = (int)$valores[0] ;
	       $fecha_fin=$gestion.'-'.$mes.'-'.$dia;
	  array_push($data, 
	  array( 
				"codigo"                => $row['COD_PERSONAL'],
				"encabezado"     =>     "#".$ordenador." PEDIDO A COMEDOR: ".$row['VALIDADOR']. " | FECHA PEDIDO:  ".(string)date("d/m/Y H:i:s", strtotime($row['FECHA'])),
				"nombre_completo" 		    => $row['AP_PATERNO'].' '.$row['AP_MATERNO'].' '.$row['NOMBRE'].' '.$row['NOMBRE2'],
				"tipo"                => $tipo,
				"fechaini"                => $row['FECHA_INICIO'],
				"fechafin"                => $row['FECHA_FIN'],
				"fechafin1"                => $fecha_fin,
				"registrado_por"                => $row['VALIDADOR'],
				"fecha"                => $row['FECHA'],
			));
		
			
	}
	
	$paging = array	(
	'success'=>true,
	'total'=>$total['TOTAL'],
	'data'=> $data);
	echo json_encode($paging);

    
?>