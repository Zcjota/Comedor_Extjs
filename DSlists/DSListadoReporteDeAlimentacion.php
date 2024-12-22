<?php
session_start();
 $codigotema=$_SESSION['tema'];
 if ( !isset( $_SESSION['IdUsuario'] ) ) {
    header("location: /Comedor/index_session.php");
  } 
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Reporte Alimentacion</title>
	<link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />
	<link rel="stylesheet" type="text/css" href="../ext/ux/css/RowEditor.css" />
    <link rel="stylesheet" type="text/css" href="../ext/ux/css/Spinner.css" />
	 <link rel="stylesheet" type="text/css" href="../ext/ux/gridfilters/css/GridFilters.css" />
    <link rel="stylesheet" type="text/css" href="../ext/ux/gridfilters/css/RangeMenu.css" />
    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="../ext/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="../ext/ext-all.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/menu/RangeMenu.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/menu/ListMenu.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/GridFilters.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/Filter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/StringFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/DateFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/ListFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/NumericFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/BooleanFilter.js"></script>	
	<script type="text/javascript" src="../ext/locale/ext-lang-es.js"></script> 
	<script type="text/javascript" src="../ext/ux/RowEditor.js"></script>
	<script type="text/javascript" src="../ext/ux/Spinner.js"></script>
    <script type="text/javascript" src="../ext/ux/SpinnerField.js"></script>
	 <script src="../DSforms/DSReporteAlimenticio.js.php" type='text/javascript'></script>
	<style type="text/css">
		.x-grid3-row-alt {
		background-color: #cccccc !important;  
	}
	.name{	
		font-size:10px !important;
		color:#000022;	
	}
	</style>
	</head>
	<body>
		 <script>
			ResumenComedor();
		 </script>
	</body>
</html>