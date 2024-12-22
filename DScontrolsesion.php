<?
function ControlSesionUsuario() { 
session_start();
if (isset($_SESSION['InicioSesion']))	{
	if (isset($_SESSION['Nombre'])) {
		$ultima = $_SESSION['ControlSesion'];
		$actual = date("YmdGi");	
		$minutos = $actual - $ultima;
		if ($minutos > 100) {		  
			header("Location: http://datasoft.com.bo/BUGS/DSredireccion.html");	
		  return false;}
		else {
		  $_SESSION['ControlSesion'] = date("YmdGi");	
		  return true;
	  }
	} else { 
		header("Location: http://datasoft.com.bo/BUGS/");	
		return false;
}} else { 
		header("Location: http://datasoft.com.bo/BUGS/");	
		return false;
}
}
?>