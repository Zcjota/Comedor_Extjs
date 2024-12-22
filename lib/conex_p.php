<?php 
function VerificaConBD()
{
	//session_start();
    if (!isset($_SESSION['BD']))
		{ if (!($_SESSION['BD']=mysql_connect("137.184.65.117","rhdeveloper","Rrhh@12@MdpData")))  //+D@t@S0ft
		    return false;					  
		  else {
			mysql_select_db("zkbiotime", $_SESSION['BD']);
			return true;
		  }	
		}
	else
	  if (!($_SESSION['BD']))
		{ if (!($_SESSION['BD']=mysql_connect("137.184.65.117","rhdeveloper","Rrhh@12@MdpData"))) 
		    return false;					  
		  else {
			mysql_select_db("zkbiotime", $_SESSION['BD']);
			return true;
		  }	
		}
	  else	
	    return true;
}

?>
