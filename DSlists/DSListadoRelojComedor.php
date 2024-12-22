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
		<title>CATEGORIA</title>
	<link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />
	

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="../ext/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="../ext/ext-all.js"></script>
	<script type="text/javascript" src="../ext/locale/ext-lang-es.js"></script> 
    
    <script src="DSListadoRelojComedor.js" type='text/javascript'></script>   
	<script src="../DSforms/DSabmRelojComedor.js" type='text/javascript'></script>
	
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
	</style>
	</head>
	<body>
	</body>
</html>