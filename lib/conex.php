<?php
date_default_timezone_set('America/La_Paz');

function VerificaConBD()
{
   
    if (!isset($_SESSION)) {
        session_start(); // Asegura que la sesión esté iniciada
    }

    if (!isset($_SESSION['BD']) || !$_SESSION['BD']) {
        
        $_SESSION['BD'] = mysqli_connect("localhost", "root", "", "comedor");

       
        if (!$_SESSION['BD'] || mysqli_connect_errno()) {
            die("Error al conectar con la base de datos (VerificaConBD): " . mysqli_connect_error());
        }
    }

    return true; 
}

function ConectarConBD()
{
   
    $conexion = mysqli_connect("localhost", "root", "", "comedor");

   
    if (!$conexion || mysqli_connect_errno()) {
        die("Error al conectar con la base de datos (ConectarConBD): " . mysqli_connect_error());
    }

    return $conexion;
}

?>
