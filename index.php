<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$usuario = isset($_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
  
?>
<script>

		function prueba() {
		
		  var check_p = document.getElementById("option1").checked;
		    if(check_p ==true){
				swal('MENSAJE', 'LOGIN o ' + check_p, 'success');
			}else{
				swal('MENSAJE', 'LOGIN o ' + check_p, 'warning');
			}
		 
		}
		function validarLogin() {	
		i = 1;
			var elem = document.getElementById("myBar");
			var width = 1;
			var id = setInterval(frame, 10);
			function frame() {
			  if (width >= 100) {
				clearInterval(id);
				i = 0;
			  } else {
				width++;
				elem.style.width = width + "%";
			  }
			}
		var check_p = document.getElementById("option1").checked;
		
		if(check_p ==true){
			 var user_p = document.getElementById("usuario").value;
		  var pass_p = document.getElementById("password").value;
		  Ext.Ajax.request({
					url : 'servicesAjax/DSiniciosesionAJAX.php',
					method : "post",	
					timeout: 1000000,
					params : {usuario: user_p,password: pass_p},
					success : function(response) {
						 var data = Ext.util.JSON.decode(response.responseText);
						 codform = data.success;
						
						 var validacionsucces = '';
						 if(codform==true)
						 {
							
							window.location = "DSinicioapp.php";
							
						 }
						 else
						 {
							
							 swal('MENSAJE', 'Usuario o Password incorrecto', 'error');
						 }
					   
					}
			});
			console.log('finalizo');
		}else{
			swal('MENSAJE', 'Validar el Captcha', 'warning');
		}
		
			Ext.override(Ext.data.Connection, {
					timeout:65000
			});
			
		}
   function handleClick(cb) {
  display("Clicked, new value = " + cb.checked);
}

		
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>S.R.L - Intranet</title>	
		<style type="text/css">
		
		<!--
		.divcentro {position: absolute;top: 50%;left: 50%;
			}
		-->
			.name{	
			font-size:10px !important;
			color:#000022;	
		}
		 #myProgress {
		  width: 100%;
		  background-color: grey;
		}

		#myBar {
		  width: 1%;
		  height: 15px;
		  background-color: blue;
		}
		</style>
			  
	 
	     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
	  <link rel="stylesheet" type="text/css" href="estilo.css" />	
	  <link rel="stylesheet" type="text/css" href="estilo2.css" />	
	  <script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	  <script type="text/javascript" src="ext/ext-all.js"></script>	 
   
   
	</head>
		
	<?php
		
	?>
	<body style="background: #0101DF url(images/portada.png) no-repeat center center fixed ; background-size: cover;" > 

<div class="login">
	<h1 style="font-size:150%;">INICIO DE SESIÓN</h1>
		<form name="form" id="form" action="" method="post">
			
			<input type="text" name="usuario" id="usuario" placeholder="Usuario" required="required" value="<?php echo $usuario?>" />
			<input type="password" name="password" id="password" placeholder="Password" required="required" value="" />
			 <form class="form1">  
			  <div class="inputGroup">
			 
				<input id="option1" name="option1" type="checkbox"/>
				<label for="option1"> <h5 style="font-size:100%;"><img src="images/recaptcha.png" width="50" height="41"> &nbsp;&nbsp; No soy un Robot.</h5></label>
			  </div>
			  
			</form>
			<button type="submit" value="submit" onclick="validarLogin()" class="btn btn-primary btn-block btn-large">Acceder.</button>
			<div id="myProgress">
			  <div id="myBar"></div>
			</div>
			<br/>
			<a style="color:white; font-size:95%; text-align: center; position: absolute;">Para un rendimiento adecuado del Sistema, <br>Limpie los cookies periódicamente.<br>Comando: (Ctrl + Shift + Supr).</a>
			
		</form>
	</div>


	</body>
</html>