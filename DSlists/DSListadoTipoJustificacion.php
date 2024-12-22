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
		<title>Tarjetero</title>
	<link rel="stylesheet" type="text/css" href="../ext/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />
	<link rel="stylesheet" type="text/css" href="../ext/ux/fileuploadfield/css/fileuploadfield.css" />

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="../ext/adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->
	<style type="text/css"> 
		.zoom{ /* Aumentamos la anchura y altura durante 2 segundos 
	*/ transition: width 2s, height 2s, transform 2s; 
	-moz-transition: width 2s, height 2s, -moz-transform 2s; -webkit-transition: width 2s, height 2s, -webkit-transform 2s; -o-transition: width 2s, height 2s,-o-transform 2s; } .zoom:hover{ /* tranformamos el elemento al pasar el mouse por encima al doble de su tamaño con scale(2). */ transform : scale(2); -moz-transform : scale(2); /* Firefox */ -webkit-transform : scale(2); /* Chrome - Safari */ -o-transform : scale(2); /* Opera */ } </style> 
	</style>
	<style type="text/css">
	.upload-icon {
            background: url('../ext/shared/icons/fam/image_add.png') no-repeat 0 0 !important;
        }
        #fi-button-msg {
            border: 2px solid #ccc;
            padding: 5px 10px;
            background: #eee;
            margin: 5px;
            float: left;
        }
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
    <script type="text/javascript" src="../ext/ext-all.js"></script>	
    <script src="../ext/ux/fileuploadfield/FileUploadField.js" type='text/javascript'></script>
	<script src="../ext/ux/fileuploadfield/css/fileuploadfield.css" type='text/css'></script>
	<script src="file-upload.css" type='text/css'></script>
	<script src="../DSlists/DSListadoTipoJustificacion.js" type='text/javascript'></script>
    <script src="../DSforms/DSabmTipoJustificacion.js" type='text/javascript'></script>
	
	
	
	</head>
	<body>
		 <script>
					
	 
			
		</script>
	</body>
</html>