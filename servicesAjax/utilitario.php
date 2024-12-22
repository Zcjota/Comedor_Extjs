
<?php

		include("../lib/conex.php"); 
		
		$conex = ConectarConBD();
		
	function asignacion($conex,$cargador,$idusuario,$personalE)
	{	$cant=0;
			if($cargador!=2)
			{
				$sqlAsignacion=' select count(COD_USUARIO) as TOT from usuario_horario  where COD_USUARIO ='.$idusuario.' and COD_HORARIO='.$personalE.' and  ACTIVO=1 ';
				//echo "/*-----consulta-------------$sqlAsignacion*/";
				$resultadoAsig=mysqli_query($conex,$sqlAsignacion);
				$totAsig = mysqli_fetch_assoc($resultadoAsig);
				$tAsig=$totAsig['TOT'];
				if($tAsig!=0)
				{
					$cant=1;
				}
			}
			
			return $cant;
	}
		function DevuelveListaCampos($conex)
	{
		session_start();
		$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		$nombreValidador=$_SESSION['Apellido1']." ".$_SESSION['Apellido2']." ".$_SESSION['Nombre'];	
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }

		$campos ="{
            type: 'string',
            dataIndex: 'nombrecargo',
            disabled: false
        }, {
            type: 'string',
            dataIndex: 'nombre',
            disabled: false
        }
		
		
		,{  type: 'list' , dataIndex: 'nombreHorario', options: [";
		 $sqlvariable=' SELECT  * from horario  '.
	     
		
		 ' ORDER BY NOMBRE_HORARIO ';
		 
		$resultadoVariable=mysqli_query($conex,$sqlvariable);  
		
		$ban=0;
		$campos1=$campos;
		 while ($rowVariable = mysqli_fetch_assoc($resultadoVariable)) 
		{	
			$horario=$rowVariable['NOMBRE_HORARIO'];
			$tipoAsignacion1=asignacion($rcargador,$ridcargador,$rowVariable['COD_HORARIO']);
			if($tipoAsignacion1==1  || $rcargador ==2 )
			{
				$campos= $campos."'".$horario."'".',';
				$ban=1;
			}
			$campos1= $campos1."'".$horario."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		if($ban==0)
		{
			$campos= $campos1.',';
		}
		
		$campos  = substr($campos, 0, strlen($campos) - 1);
		$campos.="],phpMode: true},";
	//	echo "/*a ver ------>$campos*/";
		$uni="{  type: 'list' , dataIndex: 'nombreunidad', options: [";
		 $sqlunidad=' SELECT  * from unidad where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");

		$resultadounidad=mysqli_query($conex,$sqlunidad);  
		
		$campos1=$uni;
		//echo "/*$sqlunidad*/";
		 while ($rowunidad = mysqli_fetch_assoc($resultadounidad)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowunidad['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		
		
		$campos1 = substr($campos1, 0, strlen($campos1) - 1);
		$campos1.="],phpMode: true},";
		
		$sub="{  type: 'list' , dataIndex: 'nombresubcentro', options: [";
		 $campos2=$sub;
		//echo "/*a ver ------>$campos*/";
		// mysqli_query("SET NAMES 'utf8'");
		mysqli_set_charset($conex, "utf8");
		 $sqlsubcentro=' SELECT  * from subcentro where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		 	$resultadosubcentro=mysqli_query($conex,$sqlsubcentro); 
		 while ($rowsub = mysqli_fetch_assoc($resultadosubcentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos2= $campos2."'".$rowsub['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		
		
		$campos2 = substr($campos2, 0, strlen($campos2) - 1);
		$campos2.="],phpMode: true},";
		
		$cos="{  type: 'list' , dataIndex: 'nombrecosto', options: [";
		 $campos3=$cos;
		//echo "/*a ver ------>$campos*/";
		
		 $sqlcentro=' SELECT  * from centro_de_costo where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");
		 	$resultadocentro=mysqli_query($conex,$sqlcentro); 
		 while ($rowcen = mysqli_fetch_assoc($resultadocentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos3= $campos3."'".$rowcen['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		
		
		$campos3 = substr($campos3, 0, strlen($campos3) - 1);
		$campos3.="],phpMode: true}";
		return $campos.$campos1.$campos2.$campos3;
	}
	function DevuelveListaCamposx($conex)
	{
		session_start();
		$rcargador=$_SESSION['tipoUser'];
		$ridcargador=$_SESSION['IdUsuario'];
		$nombreValidador=$_SESSION['Apellido1']." ".$_SESSION['Apellido2']." ".$_SESSION['Nombre'];	
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }

		$campos ="{
            type: 'string',
            dataIndex: 'nombrecargo',
            disabled: false
        }, {
            type: 'string',
            dataIndex: 'nombre',
            disabled: false
        }, {
            type: 'string',
            dataIndex: 'nombreunidad',
            disabled: false
        }, {
            type: 'string',
            dataIndex: 'nombresubcentro',
            disabled: false
        }, {
            type: 'string',
            dataIndex: 'nombrecosto',
            disabled: false
        },{  type: 'list' , dataIndex: 'nombreHorario', options: [";
		 $sqlvariable=' SELECT  * from horario  '.
	     
		
		 ' ORDER BY NOMBRE_HORARIO ';
		 
		$resultadoVariable=mysqli_query($conex,$sqlvariable);  
		
		$ban=0;
		$campos1=$campos;
		 while ($rowVariable = mysqli_fetch_assoc($resultadoVariable)) 
		{	
			$horario=$rowVariable['NOMBRE_HORARIO'];
			$tipoAsignacion1=asignacion($rcargador,$ridcargador,$rowVariable['COD_HORARIO']);
			if($tipoAsignacion1==1  || $rcargador ==2 )
			{
				$campos= $campos."'".$horario."'".',';
				$ban=1;
			}
			$campos1= $campos1."'".$horario."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		if($ban==0)
		{
			$campos= $campos1.',';
		}
		
		$campos  = substr($campos, 0, strlen($campos) - 1);
		$campos.="],phpMode: true}";
	//	echo "/*a ver ------>$campos*/";
		
		return $campos;
	}
	function DevuelveUnidad($conex)
	{
		
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }

		$campos ="{
            type: 'string',
            dataIndex: 'nombre',
            disabled: false
        }, {
            type: 'string',
            dataIndex: 'codigo',
            disabled: false
        },
		
		{  type: 'list' , dataIndex: 'nombreUnidad', options: [";
		 $sqlunidad=' SELECT  * from unidad where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");
		$resultadounidad=mysqli_query($conex,$sqlunidad);  
		
		$campos1=$campos;
		//echo "/*$sqlunidad*/";
		 while ($rowunidad = mysqli_fetch_assoc($resultadounidad)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowunidad['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		
		
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true},";
		$campos.="{  type: 'list' , dataIndex: 'nombreSubcentro', options: [";
		$campos1=$campos;
		//echo "/*a ver ------>$campos*/";
		// mysqli_query("SET NAMES 'utf8'");
		mysqli_set_charset($conex, "utf8");
		 $sqlsubcentro=' SELECT  * from subcentro where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		 	$resultadosubcentro=mysqli_query($conex,$sqlsubcentro); 
		 while ($rowsub = mysqli_fetch_assoc($resultadosubcentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowsub['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true},";
		$campos.="{  type: 'list' , dataIndex: 'nombre_centro', options: [";
		$campos1=$campos;
		 $sqlcentro=' SELECT  * from centro_de_costo where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");
		 	$resultadocentro=mysqli_query($conex,$sqlcentro); 
		 while ($rowcen = mysqli_fetch_assoc($resultadocentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowcen['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true}";
		
		return $campos;
	}
	function Devuelveflujo($conex)
	{
		
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }

		$campos ="
		
		{  type: 'list' , dataIndex: 'unidadP', options: [";
		 $sqlunidad=' SELECT  * from unidad where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");
		$resultadounidad=mysqli_query($conex,$sqlunidad);  
		
		$campos1=$campos;
		//echo "/*$sqlunidad*/";
		 while ($rowunidad = mysqli_fetch_assoc($resultadounidad)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowunidad['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		
		
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true},";
		$campos.="{  type: 'list' , dataIndex: 'subcentroP', options: [";
		$campos1=$campos;
		//echo "/*a ver ------>$campos*/";
		// mysqli_query("SET NAMES 'utf8'");
		mysqli_set_charset($conex, "utf8");
		 $sqlsubcentro=' SELECT  * from subcentro where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		 	$resultadosubcentro=mysqli_query($conex,$sqlsubcentro); 
		 while ($rowsub = mysqli_fetch_assoc($resultadosubcentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowsub['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true},";
		$campos.="{  type: 'list' , dataIndex: 'centroP', options: [";
		$campos1=$campos;
		 $sqlcentro=' SELECT  * from centro_de_costo where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		mysqli_set_charset($conex, "utf8");
		 	$resultadocentro=mysqli_query($conex,$sqlcentro); 
		 while ($rowcen = mysqli_fetch_assoc($resultadocentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowcen['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true}";
		
		return $campos;
	}
	function DevuelveUnidadConsolidado($conex)
	{
		
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }

		$campos ="{
            type: 'string',
            dataIndex: 'nombre',
            disabled: false
        },
		
		{  type: 'list' , dataIndex: 'nombreunidad', options: [";
		 $sqlunidad=' SELECT  * from unidad where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");
		$resultadounidad=mysqli_query($conex,$sqlunidad);  
		
		$campos1=$campos;
		//echo "/*$sqlunidad*/";
		 while ($rowunidad = mysqli_fetch_assoc($resultadounidad)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowunidad['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		
		
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true},";
		$campos.="{  type: 'list' , dataIndex: 'nombresubcentro', options: [";
		$campos1=$campos;
		//echo "/*a ver ------>$campos*/";
		// mysqli_query("SET NAMES 'utf8'");
		mysqli_set_charset($conex, "utf8");
		 $sqlsubcentro=' SELECT  * from subcentro where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		 	$resultadosubcentro=mysqli_query($conex,$sqlsubcentro); 
		 while ($rowsub = mysqli_fetch_assoc($resultadosubcentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowsub['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true},";
		$campos.="{  type: 'list' , dataIndex: 'nombrecosto', options: [";
		$campos1=$campos;
		 $sqlcentro=' SELECT  * from centro_de_costo where ACTIVO=1 '.
	     
		
		 ' ORDER BY DESCRIPCION ';
		//  mysqli_query("SET NAMES 'utf8'");
		 mysqli_set_charset($conex, "utf8");
		 	$resultadocentro=mysqli_query($conex,$sqlcentro); 
		 while ($rowcen = mysqli_fetch_assoc($resultadocentro)) 
		{	
		//	echo $rowunidad['DESCRIPCION'];
			
			$campos1= $campos1."'".$rowcen['DESCRIPCION']."'".',';	// $op=pertenece($rcargador,$ridcargador,$horario);
				// if($op==1){
				
				//}
	
		}
		$campos  = substr($campos1, 0, strlen($campos1) - 1);
		$campos.="],phpMode: true}";
		
		return $campos;
	}
	//YYDevuelveUnidad();
	function DevuelveCampos($conex)
	{
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }
		 
		$campos = "'codigo','nombre','cargo','nombreunidad','nombresubcentro','nombrecosto',";
		$h=1;
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
			$campos= $campos."'c".$h."'".',';		
			$h++;
		}
		
		$campos  = substr($campos, 0, strlen($campos) - 1);
		//$campos="'unidad','cod_area','c1','c2','b1','b2'";
		return $campos;
	}
	function DevuelveColumnas($conex)
	{
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		
		$columnas = "new Ext.grid.RowNumberer({width: 28}),{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CODIGO</a>', dataIndex : 'codigo',width: 50,align: 'left',renderer: formato } ,";
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>NOMBRE</a>', dataIndex : 'nombre',width: 250,align: 'left',renderer: formato } ,";
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CARGO</a>', dataIndex : 'cargo',width: 150,align: 'left',renderer: formato } ,";
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>UNIDAD</a>', dataIndex : 'nombreunidad',width: 150,align: 'left',renderer: formato } ,";
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>SUBCENTRO</a>', dataIndex : 'nombresubcentro',width: 150,align: 'left',renderer: formato } ,";
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CENTRO</a>', dataIndex : 'nombrecosto',width: 150,align: 'left',renderer: formato } ,";
		$j=1;
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
				$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>HORARIO</BR>".$row['DESCRIPCION']."</BR>(".$row['HORARIO']."-".$row['HORARIO_SALIDA'].")</a>', dataIndex : 'c" .$j . "',width: 100,align: 'left',renderer: formato,} ,";	
				
					
				
				$j++;
	
		}
		
		
		
		$columnas  = substr($columnas, 0, strlen($columnas) - 1);
		return $columnas;
	}
	function DevuelveCamposIndividual($conex)
	{
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }
		 
		$campos = "'codigo','fechaMarcacion','Ndia',";
		$h=1;
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
			$campos= $campos."'c".$h."'".',';		
			$h++;
		}
		
		$campos  = substr($campos, 0, strlen($campos) - 1);
		//$campos="'unidad','cod_area','c1','c2','b1','b2'";
		return $campos;
	}
	function DevuelveColumnasIndividual($conex)
	{
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		
		$columnas = "new Ext.grid.RowNumberer({width: 28}),{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>CODIGO</a>', dataIndex : 'codigo',width: 50,align: 'left',renderer: formato } ,";
		
		
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>DIA</a>', dataIndex : 'Ndia',width: 150,align: 'left',renderer: formato } ,";
		$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>FECHA</a>', dataIndex : 'fechaMarcacion',width: 150,align: 'left',renderer: formato } ,";
		$j=1;
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
				$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>HORARIO</BR>".$row['DESCRIPCION']."</a>', dataIndex : 'c" .$j . "',width: 100,align: 'left',renderer: formato,} ,";	
				
					
				
				$j++;
	
		}
		
		
		
		$columnas  = substr($columnas, 0, strlen($columnas) - 1);
		return $columnas;
	}	

	function DevuelveCamposResumenComedor($conex)
	{
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }
		 
		$campos = "'codigo','nombre',";
		$h=1;
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
			$campos= $campos."'c".$h."'".',';		
			$h++;
		}
		
		$campos  = substr($campos, 0, strlen($campos) - 1);
		//$campos="'unidad','cod_area','c1','c2','b1','b2'";
		return $campos;
	}
	function DevuelveColumnasResumenComedor($conex)
	{
		
		if (!VerificaConBD())	
		{
			echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
			exit;
        }
		$sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
		 $rHorario=mysqli_query($conex,$sqlHorario); 
		
		
		$columnas = "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;></a>', dataIndex : 'nombre',width: 250,align: 'left',renderer: formato } ,";
		
		$j=1;
		 while ($row= mysqli_fetch_assoc($rHorario)) 
		{	
				$columnas .= "{ header : '<a style =color:#15428B; font: bold 9px tahoma,arial,verdana,sans-serif;>HORARIO</BR>".$row['DESCRIPCION']."</BR>(".$row['HORARIO']."-".$row['HORARIO_SALIDA'].")</a>', dataIndex : 'c" .$j . "',width: 100,align: 'left',renderer: formato,} ,";	
				
					
				
				$j++;
	
		}
		
		
		
		$columnas  = substr($columnas, 0, strlen($columnas) - 1);
		return $columnas;
	}
	// mysqli_close($conex)
?>
		
