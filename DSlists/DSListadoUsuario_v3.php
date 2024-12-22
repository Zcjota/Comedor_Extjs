<?php
	header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache");
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
		<title>Listado Usuario</title>
	<link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />


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
    
    <script src="DSListadoUsuario_v3.js" type='text/javascript'></script>
	<script src="../DSforms/DSAltaUsuario.js" type='text/javascript'></script>
	<script src="../DSforms/DSModificarUsuario.js" type='text/javascript'></script>	
	<script src="../DSforms/DSEnvioSMS.js" type='text/javascript'></script>	
	<style type="text/css">
	.x-grid3-row-alt {
	background-color: #cccccc !important;  
	}
	.name{	
		font-size:10px !important;
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
	/* .x-grid3-row-selected {
    background-color: #fff !important;
    background-image: none;
    border-color: #a3bae9;
} */
	</style>
	</head>
	<body>
	</body>
</html>