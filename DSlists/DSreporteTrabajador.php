<?php
	
	session_start();
 $codigotema=$_SESSION['tema'];
 if ( !isset( $_SESSION['IdUsuario'] ) ) {
    header("location: /Comedor/index_session.php");
  } 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>CONTROL DE ASISTENCIA POR TRABAJADOR</title>
	<link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />
	 <link rel="stylesheet" type="text/css" href="../ext/ux/css/ColumnHeaderGroup.css" />
	<link rel="stylesheet" type="text/css" href="../ext/ux/css/LockingGridView.css" />
    <!-- GC -->
 	<!-- LIBS -->

 	<script type="text/javascript" src="../ext/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->
	<script type="text/javascript" src="../ext/ext-all.js"></script>	
	<script type="text/javascript" src="../ext/locale/ext-lang-es.js"></script> 
	<script type="text/javascript" src="../ext/ux/BufferView.js"></script> 
   <script type="text/javascript" src="../ext/ux/LockingGridView.js"></script>
    <script type="text/javascript" src="../ext/ux/ColumnHeaderGroup.js"></script>
     <script src="../DSforms/DSControlAsistenciaTrabajador.js" type='text/javascript'></script>
	 <script src="../DSforms/DSmotivoGloza.js" type='text/javascript'></script>
	 <script src="../DSforms/DSmotivoGrupoGlozas.js" type='text/javascript'></script>
	  <script src="../DSforms/DSCronogramaPersonal.js" type='text/javascript'></script>
	 <script src="DSListaDetallePersonaLicencia.js" type='text/javascript'></script>
	
	
	<style type="text/css">
	.ColorAzul table{
			background-color: #deecfd;
			color: #15428b;
			font: bold 11px;
	}
	.ColorRojo table{
			background-color: #fddeec;
			color: #15428b;
			font: bold 11px;
	}
	.ColorVerde table{
			background-color: #ecfdde;
			color: #15428b;
			font: bold 11px;
	}
	.x-grid3-row-alt {
		background-color: #cccccc !important;  
	}
	.name{	
		font-size:8px !important;
		color:#000022;	
	}
	.name1{	
		font-size:10px !important;
		color:#000022;	
	}
	.namelabel{	
		font-size:10px !important;
		color:#000022;	
	}
	
	
	</style>
	</head>
	<body>
	 <script>
	 
			Ext.onReady(function()
			{  
				
				IngresarControlAsistencia();
			});
		</script>
	</body>
</html>