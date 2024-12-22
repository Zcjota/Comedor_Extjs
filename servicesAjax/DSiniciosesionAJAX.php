<?php 
include("../lib/conex.php");

if (!isset($_REQUEST["usuario"])){
    echo '{success:false, errors:{reason: "Se requiere Usuario", id:1}}';
    exit;
}

if (!isset($_REQUEST["password"])) {
   echo '{success:false, errors:{reason: "Se requiere password", id:2}}';
   exit;
}

if (VerificaConBD()) {
    $conexion = ConectarConBD();

    // $sql = "SELECT U.COD_USUARIO, U.NOMBRE, U.AP_PATERNO, U.AP_MATERNO, U.LOGIN, U.PASSWORD, U.COD_TIPOU, U.BANDERA, U.FLUJO_VISUALIZADOR, U.COD_PERSONAL, U.TEMA " .
    $sql = "SELECT U.COD_USUARIO, U.NOMBRE, U.AP_PATERNO, U.AP_MATERNO, U.LOGIN, U.PASSWORD, U.COD_TIPOU, U.BANDERA, U.COD_PERSONAL, U.TEMA " .
           "FROM `usuario` U INNER JOIN tipo_usuario TU ON U.COD_TIPOU = TU.COD_TIPOU " .
           "WHERE U.LOGIN='" . strtoupper(mysqli_real_escape_string($conexion, $_REQUEST["usuario"])) . "' AND U.ACTIVO = 1 LIMIT 1";

    mysqli_set_charset($conexion, 'utf8');

    function cortar_nombre($name) {
        return strtok($name, ' ');
    }

    function primeraMayuscula($name) {
        return ucfirst(strtolower($name));
    }

    function QuitaAcentos($cadena) {
        $p = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', '&'];
        $r = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'y'];
        return str_replace($p, $r, $cadena);
    }

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);

        list($IdUsuariov, $Nombrev, $Apellido1v, $Apellido2v, $Usuariov, $Contraseniav, $tipov, $bandera, $cod_personal, $tema) = array_values($row);
        // list($IdUsuariov, $Nombrev, $Apellido1v, $Apellido2v, $Usuariov, $Contraseniav, $tipov, $bandera, $revisor, $cod_personal, $tema) = array_values($row);
        if (strcmp($Contraseniav, $_REQUEST["password"]) == 0) {
            // session_start();
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			
            $nomb = cortar_nombre($Nombrev);

            $_SESSION['IdUsuario'] = $IdUsuariov;
            $_SESSION['Nombre'] = $Nombrev; 
            $_SESSION['Apellido1'] = $Apellido1v;
            $_SESSION['Apellido2'] = $Apellido2v;
            $_SESSION['Usuario'] = $Usuariov;     
            $_SESSION['Contrasenia'] = $Contraseniav;                        
            $_SESSION['tipoUser'] = $tipov;
            $_SESSION['banderSession'] = $bandera;
            $_SESSION['Nombresesion'] = $nomb; 
            // $_SESSION['revisor'] = $revisor; 
            $_SESSION['cod_personal'] = $cod_personal; 
            $_SESSION['Nombre1'] = primeraMayuscula(QuitaAcentos($nomb)); 
            $_SESSION['App'] = primeraMayuscula(QuitaAcentos($Apellido1v));

            switch ($tema) {
                case 0:
                    include("../DSlibListaITEMStoolbar.php");
                    break;
                case 1:
                    include("../DSlibListaITEMStoolbargris.php");
                    break;
                case 2:
                    include("../DSlibListaITEMStoolbarverde.php");
                    break;
                case 3:
                    include("../DSlibListaITEMStoolbarnew.php");
                    break;
                case 4:
                    include("../DSlibListaITEMStoolbarblack.php");
                    break;
            }

            $no = DevuelveListaMenuItem1();
            $_SESSION['menu'] = $no;

            $dirtema = "/Comedor/ext/resources/css/xtheme-blue.css";
            if ($tema == 1) {
                $dirtema = "/Comedor/ext/resources/css/xtheme-gray.css";
            } elseif ($tema == 2) {
                $dirtema = "/Comedor/ext/resources/css/tema_verde/resources/css/xtheme-tema_verde.css";
            } elseif ($tema == 3) {
                $dirtema = "/Comedor/ext/resources/css/AZUL/resources/css/xtheme-newgentheme.css";
            } elseif ($tema == 4) {
                $dirtema = "/Comedor/ext/resources/css/xtheme-access.css";
            }

            $_SESSION['tema'] = $dirtema;
            $_SESSION['temas'] = $tema;

            echo '{"success":true, "message":{"reason": '.$bandera.'}}';
        } else {
            echo '{success:false, errors:{reason:"Password Incorrecto", id:3}}';
        }
    } else {
        echo '{success:false, errors:{reason:"Usuario Incorrecto", id:4}}';
    }

    mysqli_close($conexion);
} else {
    echo '{success:false, errors:{reason:"Error al conectar con BD.", id:0}}';
}

function str2date($in) {
    $t = preg_split("/[-\/ ]/", $in);

    if (count($t) != 3 || !is_numeric($t[0]) || !is_numeric($t[1]) || !is_numeric($t[2])) {
        return -1;
    }

    if ($t[2] < 1902 || $t[2] > 2037) {
        return -3;
    }

    return mktime(0, 0, 0, $t[1], $t[0], $t[2]);
}
?>
