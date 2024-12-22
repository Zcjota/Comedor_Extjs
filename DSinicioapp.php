
<?php
session_start();
 $codigotema=$_SESSION['tema'];
 $temas=$_SESSION['temas'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RRHH - Intranet</title>	
		<style type="text/css">
		
		<!--				
    html, body {font:normal 12px verdana; margin:0; padding:0; border:0 none; overflow:hidden; height:100%; }
    p { margin:5px;}
    .settings { background-image:url(ext/shared/icons/fam/folder_wrench.png);}
      .n { background-image:url(ext/shared/icons/fam/folder_go.png);}
	  .NUL { background-image:url(img/key1.png);}
	  .PRE { background-image:url(img/pre.png);}
	  .TRA { background-image:url(img/tra.png);}
	  .REP { background-image:url(img/rep.png);}
	  .CTA { background-image:url(img/form.PNG);}
	  .MAN { 
	  background-image: url( img/icon/flecha2.jpeg ) !important;
		background-repeat: no-repeat !important;
		background-size: 16px 16px !important;}
	  .MAN1 { 
			background-image: url( img/icon/flecha2.jpeg ) !important;
		background-repeat: no-repeat !important;
		background-size: 16px 16px !important;
	  }
	   .MAN2 { background-image:url(img/flechaverde.png);}
	  .Salir { background-image:url(img/salir.png);}
	  .Reseteo { background-image:url(img/key1.png);}
    .divcentro {position: absolute;top: 50%;left: 50%;}
		-->
		</style>
		
	  <div id="DSinicio" class="divcentro">
	  	<div align="center"><img src="img/al.gif"/><br/></div>
	  	<span id="DSinicio-msg" style="font-size:12px">Iniciando Intranet S.R.L</span>
	  </div>
	  <link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />	
	  <link rel="stylesheet" type="text/css" href="<?php echo $codigotema ?>" />
	   
	  <link rel="stylesheet" type="text/css" href="DSmenu.css" />	
	      
		 
 
      <script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	    <script type="text/javascript" src="ext/ext-all.js"></script>	    
	    <script type="text/javascript" src="ext/ui/miframe.js"></script>
		 <script type="text/javascript" src="ext/ux/TabCloseMenu.js"></script>
		 <script src="<?php if($temas==1){echo $a='DSinicioapp1.js.php';}?>" type="text/javascript"></script>
     
      <script type="text/javascript">document.getElementById('DSinicio').innerHTML = '';</script>
	  <style type="text/css">
	  
		.add {
		background-image: url( img/add.png ) !important;
		}
		.add1 {
		background-image: url( img/add1.png ) !important;
		}
		.add2 {
		background-image: url( img/add2.png ) !important;
		}
		.submenu {
		background-image: url( img/FlechaSubmenu.png ) !important;
		}
		.submenugris {
		background-image: url( img/flechasubmenugris.png ) !important;
		}
		.submenuverde {
		background-image: url( img/flechasubmenuverde.png ) !important;
		}
		.name{	
		font-size:8px !important;
		color:#000022;	
	}
	.S1 {
		 background-image: url( img/equipo2.png ) !important;
		  background-repeat: no-repeat !important;
	     background-size: 36px 36px !important;
		}
	.S2 {
		 background-image: url( img/cv.png ) !important;
		  background-repeat: no-repeat !important;
	     background-size: 28px 28px !important;
		}
	.form{
		 background-image: url( img/form.png ) !important;
		}
	.horario{
	 background-image: url( img/horarios.png ) !important;
	}
	.valoracion{
	 background-image: url( img/valoracion.png ) !important;
	}
	.alerta{
	 background-image: url( img/alerta.png ) !important;
	}
	.aprobarHE{
	 background-image: url( img/AprobacionHE.png ) !important;
	}
	.HEEdicion{
	 background-image: url( img/HEEdicion.png ) !important;
	}
	.VHorarios{
	 background-image: url( img/VHorarios.jpg ) !important;
	}
	.horas_extras{
	 background-image: url( img/horas_extras.png ) !important;
	}
	.bandeja{
	 background-image: url( img/bandeja.png ) !important;
	}
	.status{
	 background-image: url( img/status.png ) !important;
	}
	.asistencia{
	 background-image: url( img/asistencia.png ) !important;
	}
	.pendiente{
	 background-image: url( img/pendientesAprobacion.png ) !important;
	}
	.parametros{
	 background-image: url( img/parametros.png ) !important;
	}
	.cerrar{
	 background-image: url( img/cerrar.png ) !important;
	}
	.cambiar{
	 background-image: url( img/reseteo.png ) !important;
	}
	.usuario{
	 background-image: url( img/usuario.png ) !important;
	}
	.usuarios{
	 background-image: url( img/usuarios.png ) !important;
	}
	.perfil{
	 background-image: url( img/Perfil.png ) !important;
	}
	.licencia{
	 background-image: url( img/licencia.png ) !important;
	}
	.grupo{
	 background-image: url( img/grupo.png ) !important;
	}
	.turno{
	 background-image: url( img/turno.png ) !important;
	}
	.consolidado{
	 background-image: url( img/consolidado.png ) !important;
	}
	.reciclaje{
	 background-image: url( img/reciclaje.png ) !important;
	}
	.cerrar16{
	 background-image: url( img/cerrar16.png ) !important;
	}
	.alertaicon
	{
	 background-image: url( img/alertaicon.png ) !important;
	}
	.sesion16{
	 background-image: url( img/sesion16.png ) !important;
	}
	.reseteo16{
	 background-image: url( img/reseteo16.png ) !important;
	}
	.centro{
	 background-image: url( img/centro.png ) !important;
	}
	.unidad{
	 background-image: url( img/unidad.png ) !important;
	}
	.subcentro{
	 background-image: url( img/subcentro.png ) !important;
	}
	.cargo{
	 background-image: url( img/cargo.png ) !important;
	}
	.reloj{
	 background-image: url( img/reloj.png ) !important;
	}
	.masivas{
	 background-image: url( img/masivas.png ) !important;
	}.ISI01{
		background-image: url( img/icon/formulario/ISI01_Requerimiento_Personal.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI02{
		background-image: url( img/icon/formulario/ISI02_Cambios_Contractuales.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI03{
		background-image: url( img/icon/formulario/ISI03_Vacaciones_Licencias.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI04{
		background-image: url( img/icon/formulario/ISI04_Form_Desvinculacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI05{
		background-image: url( img/icon/dato_personal/ISI05_Colaboradores.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI06{
		background-image: url( img/icon/dato_personal/ISI06_Asignacion_Codigo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI07{
		background-image: url( img/icon/dato_personal/ISI07_Control_Vacaciones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI08{
		background-image: url( img/icon/dato_personal/ISI08_Finalizacion_Contrato.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI09{
		background-image: url( img/icon/dato_personal/ISI09_Certificado_Trabajo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI10{
		background-image: url( img/icon/dato_personal/ISI10_Alerta_RC_IVA.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI11{
		background-image: url( img/icon/dato_personal/ISI11_Contrato.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI12{
		background-image: url( img/icon/dato_personal/ISI12_Finiquito.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI13{
		background-image: url( img/icon/dato_personal/ISI13_Casa_Cuna.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI14{
		background-image: url( img/icon/dato_personal/ISI14_Documento_Identidad.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI15{
		background-image: url( img/icon/dato_personal/ISI15_Licencia_Conducir.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI16{
		background-image: url( img/icon/dato_personal/ISI16_Control_Prestamos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI17{
		background-image: url( img/icon/dato_personal/ISI17_Control_Seguros.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI18{
		background-image: url( img/icon/dato_personal/ISI18_Control_Vacunas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}.ISI19{
		background-image: url( img/icon/dato_personal/ISI19_Control_Covid.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;	
	}.ISI20{
		background-image: url( img/icon/dato_personal/ISI20_Contactos_Internos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI21{
		background-image: url( img/icon/parametros/ISI21_Reloj.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI22{
		background-image: url( img/icon/parametros/ISI22_Cargo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI23{
		background-image: url( img/icon/parametros/ISI23_UNidad.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI24{
		background-image: url( img/icon/parametros/ISI24_Subcentro.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI25{
		background-image: url( img/icon/parametros/ISI25_Centro_de_Costo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI26{
		background-image: url( img/icon/parametros/ISI26_Tipo_de_Justificacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI27{
		background-image: url( img/icon/parametros/ISI27_Conceptos_de_Planilla.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI28{
		background-image: url( img/icon/parametros/ISI28_Salario_Minimo_Nacional.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI29{
		background-image: url( img/icon/parametros/ISI29_Parametro_de_la_PLanilla.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI30{
		background-image: url( img/icon/parametros/ISI30_Generacion_de_Planilla_Sueldo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI31{
		background-image: url( img/icon/parametros/ISI31_Conceptos_Contables.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI32{
		background-image: url( img/icon/parametros/ISI32_Cuentas_Contables.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI33{
		background-image: url( img/icon/parametros/ISI33_Generacion_Planilla_Aguinaldo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI34{
		background-image: url( img/icon/parametros/ISI34_Generacion_Planilla_Prima.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI35{
		background-image: url( img/icon/parametros/ISI35_Generacion_Planilla_Retroactivos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI36{
		background-image: url( img/icon/adm_usuarios/ISI36_Usuarios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI37{
		background-image: url( img/icon/adm_usuarios/ISI37_Perfil_Usuario.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI38{
		background-image: url( img/icon/adm_usuarios/ISI38_Reporte_General.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI39{
		background-image: url( img/icon/adm_usuarios/ISI39_Reporte_Individual.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI40{
		background-image: url( img/icon/adm_usuarios/ISI40_Visualizadores_Horarios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI41{
		background-image: url( img/icon/adm_usuarios/ISI41_Visualizadores_Control_Asistencia.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI42{
		background-image: url( img/icon/adm_usuarios/ISI42_Visualizadores_Formularios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI43{
		background-image: url( img/icon/control_asistencia/ISI43_Reporte_General.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI44{
		background-image: url( img/icon/control_asistencia/ISI44_Reporte_Individual.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI45{
		background-image: url( img/icon/control_asistencia/ISI45_Retrasos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI46{
		background-image: url( img/icon/control_asistencia/ISI46_Faltas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI47{
		background-image: url( img/icon/control_asistencia/ISI47_Horas_Extras_Edicion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI48{
		background-image: url( img/icon/control_asistencia/ISI48_Horas_Extras_Aprobacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI49{
		background-image: url( img/icon/control_asistencia/ISI49_Horas_Extras_Individual.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI50{
		background-image: url( img/icon/control_asistencia/ISI50_Registro_de_Licencias.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI51{
		background-image: url( img/icon/control_asistencia/ISI51_Historico_de_Licencias.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI52{
		background-image: url( img/icon/control_asistencia/ISI52_Horarios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI53{
		background-image: url( img/icon/control_asistencia/ISI53_Historico_de_Justificacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI54{
		background-image: url( img/icon/control_asistencia/ISI54_Asignacion_de_Horarios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI55{
		background-image: url( img/icon/control_asistencia/ISI55_Cracion_de_Grupos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI56{
		background-image: url( img/icon/control_asistencia/ISI56_Visualizacion_de_Turnos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI57{
		background-image: url( img/icon/control_asistencia/ISI57_Reporte_Consolidado.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI58{
		background-image: url( img/icon/control_asistencia/ISI58_Feriados.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI59{
		background-image: url( img/icon/control_asistencia/ISI59_Redistribucion_Dominicales.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI60{
		background-image: url( img/icon/control_asistencia/ISI60_Reporte_Consolidado_RRHH.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI61{
		background-image: url( img/icon/control_asistencia/ISI61_Reporte_Consolidado_Enviado.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI62{
		background-image: url( img/icon/control_asistencia/ISI62_Registrar_Marcacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI63{
		background-image: url( img/icon/control_asistencia/ISI63_Reporte_Asistencia.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI64{
		background-image: url( img/icon/rhegyster/ISI64_Celulares_Moviles.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI65{
		background-image: url( img/icon/rhegyster/ISI65_Marcacion_Movil.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI66{
		background-image: url( img/icon/bandejas/ISI66_Bandeja_Borradores.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI67{
		background-image: url( img/icon/bandejas/ISI67_Bandeja_Revisores.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI68{
		background-image: url( img/icon/bandejas/ISI68_Bandeja_Rechazados.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI69{
		background-image: url( img/icon/bandejas/ISI69_Bandeja_Enviados.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI70{
		background-image: url( img/icon/aprobaciones/ISI70_Pendientes_de_Aprobacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI71{
		background-image: url( img/icon/aprobaciones/ISI71_Status_de_Aprobacion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI72{
		background-image: url( img/icon/aprobaciones/ISI72_Formularios_Aprobados.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI73{
		background-image: url( img/icon/aprobaciones/ISI73_Historico_de_Formularios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI74{
		background-image: url( img/icon/aprobaciones/ISI74_Papelera_de_Reciclaje.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI75{
		background-image: url( img/icon/descargas/ISI75_Administrador_de_Documentos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI76{
		background-image: url( img/icon/descargas/ISI76_Repositorio_de_Documentos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI77{
		background-image: url( img/icon/descargas/ISI77_Comunicaciones_Internas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI78{
		background-image: url( img/icon/descargas/ISI78_Comunicaciones_Varias.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI79{
		background-image: url( img/icon/madepapp/ISI79_Boleta_de_Pago.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI80{
		background-image: url( img/icon/madepapp/ISI80_Notificaciones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI81{
		background-image: url( img/icon/madepapp/ISI81_Requerimiento_de_Personal.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI82{
		background-image: url( img/icon/madepapp/ISI82_Registros_Moviles.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI83{
		background-image: url( img/icon/madepapp/ISI83_Llamadas_de_Atencion.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI84{
		background-image: url( img/icon/madepapp/ISI84_Medalleo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI85{
		background-image: url( img/icon/madepapp/ISI85_Gestion_de_Ranking.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI86{
		background-image: url( img/icon/madepapp/ISI86_Tarjetas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI87{
		background-image: url( img/icon/madepapp/ISI87_Asignacion_de_Tarjetas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI88{
		background-image: url( img/icon/madepapp/ISI88_Roles_Responsabilidades.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI89{
		background-image: url( img/icon/control_comedor/ISI89_Reloj_Comedor.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI90{
		background-image: url( img/icon/control_comedor/ISI90_Horario_Comedor.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI91{
		background-image: url( img/icon/control_comedor/ISI91_Proveedor.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI92{
		background-image: url( img/icon/control_comedor/ISI92_Asignacion_Especial.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI93{
		background-image: url( img/icon/control_comedor/ISI93_Pedido_Comedor.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI94{
		background-image: url( img/icon/control_comedor/ISI94_Reporte_General_Diario.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI95{
		background-image: url( img/icon/control_comedor/ISI95_Reporte_Individual.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI96{
		background-image: url( img/icon/control_comedor/ISI96_Reporte_Resumen.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI97{
		background-image: url( img/icon/control_comedor/ISI97_Reporte_Alimenticio.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI98{
		background-image: url( img/icon/variables/ISI98_Gestionadores.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI99{
		background-image: url( img/icon/variables/ISI99_Visualizadores_de_Variables.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI100{
		background-image: url( img/icon/variables/ISI100_Variables_Mensuales.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI101{
		background-image: url( img/icon/variables/ISI101_Variables_RRHH.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI102{
		background-image: url( img/icon/reportes/ISI102_Planilla_General_Sueldos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI103{
		background-image: url( img/icon/reportes/ISI103_Planilla_CNS.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI104{
		background-image: url( img/icon/reportes/ISI104_Planilla_de_AFP.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI105{
		background-image: url( img/icon/reportes/ISI105_Ministerio_de_Trabajo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI106{
		background-image: url( img/icon/reportes/ISI106_Planilla_Impositiva.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI107{
		background-image: url( img/icon/reportes/ISI107_Boleta_de_Pago.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI108{
		background-image: url( img/icon/reportes/ISI108_Boleta_Servicios_Externos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI109{
		background-image: url( img/icon/reportes/ISI109_Reporte_de_Quincena.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI110{
		background-image: url( img/icon/reportes/ISI110_Reporte_Abono_Sueldos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI111{
		background-image: url( img/icon/reportes/ISI111_Ministerio_de_Economia.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI112{
		background-image: url( img/icon/reportes/ISI112_Provisiones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI113{
		background-image: url( img/icon/reportes/ISI113_Reporte_de_Vacaciones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI114{
		background-image: url( img/icon/reportes/ISI114_Reporte_Horas_Extras.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI115{
		background-image: url( img/icon/reportes/ISI115_Costo_Mensual_Empleado.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI116{
		background-image: url( img/icon/reportes/ISI116_Reporte_Detallado.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI117{
		background-image: url( img/icon/reportes/ISI117_Asiento_Contable.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI118{
		background-image: url( img/icon/reportes/ISI118_Altas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI119{
		background-image: url( img/icon/reportes/ISI119_Bajas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI120{
		background-image: url( img/icon/reportes/ISI120_Base_de_Datos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI121{
		background-image: url( img/icon/reportes/ISI121_Ropa_de_Trabajo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI122{
		background-image: url( img/icon/reportes/ISI122_Dependientes_Familiares.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI123{
		background-image: url( img/icon/reportes/ISI123_Planilla_de_Aguinaldo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI124{
		background-image: url( img/icon/reportes/ISI124_Planila_Segundo_Aguinaldo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI125{
		background-image: url( img/icon/reportes/ISI125_Planilla_de_Prima.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}	
	.ISI126{
		background-image: url( img/icon/reportes/ISI126_Planilla_de_Retroactivo.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI127{
		background-image: url( img/icon/descripciones_de_cargo/ISI127_Formulario.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI128{
		background-image: url( img/icon/descripciones_de_cargo/ISI128_Parametros.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI129{
		background-image: url( img/icon/descripciones_de_cargo/ISI129_Valoracion_de_Perfiles.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI130{
		background-image: url( img/icon/descripciones_de_cargo/ISI130_Biblioteca_de_Cargos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI131{
		background-image: url( img/icon/descripciones_de_cargo/ISI131_Control_Formulario.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI132{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI132_Formulario_EMD.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI133{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI133_Biblioteca_de_Evaluaciones_EMD.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI134{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI134_Parametros_EMD.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI135{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI135_Control_Formulario_EMD.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI136{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI136_Pendientes_EMD.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI137{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI137_Formulario_PMP.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI138{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI138_Biblioteca_de_Evaluaciones_PMP.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI139{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI139_Parametros_PMP.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI140{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI140_Control_Formulario_PMP.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI141{
		background-image: url( img/icon/evaluacion_de_desempeño/ISI141_Status_PMP.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI142{
		background-image: url( img/icon/actualizacion_de_datos/ISI142_Cargar_Vacaciones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI143{
		background-image: url( img/icon/actualizacion_de_datos/ISI143_Cargar_Marcaciones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI144{
		background-image: url( img/icon/actualizacion_de_datos/ISI144_Ingresos_Egresos_Masivos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI145{
		background-image: url( img/icon/actualizacion_de_datos/ISI145_Actualizar_Salarios.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI146{
		background-image: url( img/icon/actualizacion_de_datos/ISI146_Subir_Marcaciones.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI147{
		background-image: url( img/icon/actualizacion_de_datos/ISI147_Actualizar_Marcaciones_Subidas.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI148{
		background-image: url( img/icon/actualizacion_de_datos/ISI148_Actualizar_Datos_Personales.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI149{
		background-image: url( img/icon/actualizacion_de_datos/ISI149_Horas_Extras.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI150{
		background-image: url( img/icon/actualizacion_de_datos/ISI150_Otros_Ingresos_Egresos.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI151{
		background-image: url( img/icon/diferencial_de_perfiles/ISI151_Formulario.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI152{
		background-image: url( img/icon/diferencial_de_perfiles/ISI152_Biblioteca_de_Perfil.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	.ISI153{
		background-image: url( img/icon/diferencial_de_perfiles/ISI153_Control_de_Formulario.png ) !important;
		background-repeat: no-repeat !important;
		background-size: 32px 32px !important;
	}
	
	
    

	</style>
	
	</head>
	<body>		
	</body>
</html>