<?php 
    header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache");
 session_start();
 if ( !isset( $_SESSION['IdUsuario'] ) ) {
    header("location: /Comedor/index_session.php");
  } 
 
 $codigotema=$_SESSION['tema'];
 $_SESSION['valicacionForm'] = isset($_REQUEST['op_form'])?$_REQUEST['op_form']:'Colaboradores';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv='cache-control' content='no-cache'>
		<meta http-equiv='expires' content='0'>
		<meta http-equiv='pragma' content='no-cache'>
		<title>EMPLEADO</title>
	<link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />
	<link rel="stylesheet" type="text/css" href="../ext/ux/fileuploadfield/css/fileuploadfield.css" />
	 <link rel="stylesheet" type="text/css" href="../ext/ux/gridfilters/css/GridFilters.css" />
    <link rel="stylesheet" type="text/css" href="../ext/ux/gridfilters/css/RangeMenu.css" />
	
    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="../ext/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->
	<style type="text/css"> 
		.zoom{ /* Aumentamos la anchura y altura durante 2 segundos 
	*/ transition: width 2s, height 2s, transform 2s; 
	-moz-transition: width 2s, height 2s, -moz-transform 2s; -webkit-transition: width 2s, height 2s, -webkit-transform 2s; -o-transition: width 2s, height 2s,-o-transform 2s; } .zoom:hover{ /* tranformamos el elemento al pasar el mouse por encima al doble de su tamaño con scale(2). */ transform : scale(2); -moz-transform : scale(2); /* Firefox */ -webkit-transform : scale(2); /* Chrome - Safari */ -o-transform : scale(2); /* Opera */ } </style> 
	</style>
	
    <script type="text/javascript" src="../ext/ext-all.js"></script>
	<script type="text/javascript" src="../ext/locale/ext-lang-es.js"></script> 
	<script src="../ext/ux/fileuploadfield/FileUploadField.js" type='text/javascript'></script>
	<script src="../ext/ux/fileuploadfield/css/fileuploadfield.css" type='text/css'></script>
	<script src="file-upload.css" type='text/css'></script>	
	<script type="text/javascript" src="../ext/ux/gridfilters/menu/RangeMenu.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/menu/ListMenu.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/GridFilters.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/Filter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/StringFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/DateFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/ListFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/NumericFilter.js"></script>
	<script type="text/javascript" src="../ext/ux/gridfilters/filter/BooleanFilter.js"></script>	
    
     <script src="../DSforms/DSabmAltaPersonal_v2.js" type='text/javascript'></script>
	 <script src="../DSforms/DSCodigoNuevo.js" type='text/javascript'></script>
	 <script src="../DSforms/DSmotivoBaja.js" type='text/javascript'></script>
	 <script src="../DSforms/DSabmDocumentosPersonal.js" type='text/javascript'></script>
	 <script src="DSAltaEmpleado_v2.js.php" type='text/javascript'></script>
	 <script src="../DSforms/DSactualizarDependientePersonal.js" type='text/javascript'></script>
	 <script type="text/javascript">
		
	</script>
	<style type="text/css">
	.upload-icon {
            background: url('../ext/shared/icons/fam/image_add.png') no-repeat 0 0 !important;
    }
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
	
        /* style rows on mouseover */
        .x-grid3-row-over .x-grid3-cell-inner {
            font-weight: bold;
        }
   
	.x-grid3-row-alt {
		background-color: #cccccc !important;  
	}
	.name{	
		font-size:10px !important;
		color:#000022;	
		
	}
	.numero{	
		font-size:12px !important;
		color:#000022;	
		
	}
	.p{
		font-size:10px !important;
		color:#000022;	
	}
	.namelabel{	
		font-size:10px !important;
		color:#000022;	
	}
	.fondoPlomo {
			background: #D8D8D8 !important;
			font-size:10px !important;
			color:#000022;	
			}.search-item{
		border:1px solid #fff;
		padding:3px;
		background-position:right bottom; 
		background-repeat:no-repeat;
	}
	</style>
	</head>
	<body>
	</body>
</html>