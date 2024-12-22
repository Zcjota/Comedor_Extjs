<?php     
/*!
 * DSoft-RJ
 * Copyright(c) 2013
 */
	include('../lib/conex.php');
	 session_start();
		$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		$nombreValidador=$_SESSION['Apellido1']." ".$_SESSION['Apellido2']." ".$_SESSION['Nombre'];
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ReportedeControlDeComedorResumen.XLS\";"); 
    $start = isset($_POST['start'])?$_POST['start']:0;	
	$limit = isset($_POST['limit'])?$_POST['limit']:30;
	$buscar = isset($_POST['buscar'])?$_POST['buscar']:'';

	$fecha =  $_REQUEST['fecha'];
	$fechaf =  $_REQUEST['fechaf'];
	$registro= $_SESSION['reg'];
	// Conexión a la base de datos
$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}
	
	$Encabezados = "<h3> CONTROL ASISTENCIA COMEDOR</h3> <B> FECHA CONTROL DEL: ".date("d-m-Y",strtotime($fecha))."   -    HASTA: ".date("d-m-Y",strtotime($fechaf))."</B>".
			   "<table border = 1>" .
	
			  "		<tr>" .
			
			  "<th style='text-align:center;font:12px'>   </th> ";
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 $numHorario=0;
		 while ($row= mysqli_fetch_array($rHorario)) 
		{	
			$Encabezados.= "	<th style='text-align:center;font:12px'>HORARIO ".$row['DESCRIPCION']."  </th> ";
			 $numHorario++;
		}		
		$Encabezados.= "		</tr>";	
			 
	$Registros ='';	   
	
        $i=1;  
		function  aHtml($cadena){

			$minusculas = array ("á"=>"&aacute;","é"=>"&eacute;","í"=>"&iacute;","ó"=>"&oacute;", "ú"=>"&uacute;","ñ"=>"&ntilde;");
			$mayusculas = array ("Á"=>"&Aacute;","É"=>"&Eacute;","Í"=>"&Iacute;","Ó"=>"&Oacute;", "Ú"=>"&Uacute;","Ñ"=>"&Ntilde;");

			$cad = strtr($cadena,$minusculas);
			$cad = strtr($cadena,$mayusculas);
			return $cad;

		}
	$records = json_decode(stripslashes($registro));
			
	
			if ($records != '')
			{
			
				foreach($records as $record)
				{		
					
					  $codigo= 	$record -> codigo;
					$nombre= 	$record -> nombre;
					$nombre=htmlentities($nombre, ENT_QUOTES,'UTF-8');
					
					if($numHorario>=1){$c1= $record -> c1;}
					if($numHorario>=2){$c2= $record -> c2;}
					if($numHorario>=3){$c3= $record -> c3;}
					if($numHorario>=4){$c4= $record -> c4;}
					if($numHorario>=5){$c5= $record -> c5;}
					if($numHorario>=6){$c6= $record -> c6;}
					if($numHorario>=7){$c7= $record -> c7;}
					if($numHorario>=8){$c8= $record -> c8;}
					if($numHorario>=9){$c9= $record -> c9;}
					if($numHorario>=10){$c10= $record -> c10;}
					if($numHorario>=11){$c11= $record -> c11;}
					if($numHorario>=12){$c12= $record -> c12;}
					if($numHorario>=13){$c13= $record -> c13;}
					if($numHorario>=14){$c14= $record -> c14;}
					if($numHorario>=15){$c15= $record -> c15;}
				$Registros = $Registros .
						  "		<tr>" .
						 
						 
						   "			<td style='text-align:left;font:10px'> ". $nombre ." </td>" ;
						
						   
						if($numHorario>=1){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c1 ."</td>";} 
						if($numHorario>=2){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c2 ."</td>";}  
						if($numHorario>=3){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c3 ."</td>";}   
						if($numHorario>=4){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c4 ."</td>";}   
						if($numHorario>=5){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c5 ."</td>";}   
						if($numHorario>=6){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c6 ."</td>";}   
						if($numHorario>=7){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c7 ."</td>";}   
						if($numHorario>=8){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c8 ."</td>";}   
						if($numHorario>=9){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c9 ."</td>";}   
						if($numHorario>=10){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c10 ."</td>";}   
						if($numHorario>=11){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c11 ."</td>";}   
						if($numHorario>=12){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c12 ."</td>";}   
						if($numHorario>=13){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c13 ."</td>";}   
						if($numHorario>=14){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c14 ."</td>";}   
						if($numHorario>=15){$Registros.=   "	<td style='text-align:center;font:10px'> ". $c15 ."</td>";}   
						   
						 
						  
						  
													
						$Registros.="		</tr>";
														
								
						
				}
				
			}	
	
	
     //--------------------------------------------------------------------------------------------------------
	
    
	echo $Encabezados . $Registros . '</table>';
	mysqli_close($conex);
?> 