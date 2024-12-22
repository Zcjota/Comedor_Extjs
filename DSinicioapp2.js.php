


/*!
 * Intecruz-TPMV
 * Copyright(c) 2013
 */

Ext.onReady(function(){   
	Ext.namespace('Ext.dsdata');
		<?php
							session_start();
							header("Content-Type: application/x-javascript'");
							header("Cache-Control: max-age=1, must-revalidate, no-cache");
							header("Content-Type: text/javascript");

							header("Pragma: no-cache");
							header("Expires: 0"); // set expiration time
								$inicio="";
							
							 if( $_SESSION['tema']=="/Comedor/ext/resources/css/xtheme-blue.css")
							 {
								$inicio="DSpoliticaprivacidad.html";
								
							 }
							  if( $_SESSION['tema']=="/Comedor/ext/resources/css/xtheme-gray.css")
							 {
								$inicio="DSpoliticaprivacidadgray.html";
							 }
							 if( $_SESSION['tema']=="/Comedor/ext/resources/css/tema_verde/resources/css/xtheme-tema_verde.css")
							 {
								$inicio="DSpoliticaprivacidadolive.html";
							 }		
?>
    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
    //Panel central
    Ext.dsdata.PAcentral = new Ext.TabPanel({
					region: 'center', 
					deferredRender: false,
					enableTabScroll:true,
					autoScroll: true, 
					margins:'0 4 4 0',
					activeTab: 0,     
					items: [ 	
					{
						xtype: 'iframepanel',    
						id : 'TABcentral',    
						title :  "<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Información</b></FONT>",    
						loadMask  : true,    				  	
						//defaultSrc : 'DSpoliticaprivacidad.html',    
						defaultSrc : '<?php echo $inicio ?>',
						closable:false
					}
				]
				});
	var FNcentral = function(tp){
			//alert("hola");
				tp.getSelectionModel().on('selectionchange', function(tree, node){
				  var newFrame = Ext.dsdata.PAcentral.add({    
				  	xtype: 'iframepanel',    
				  	id : node.id,    
				  	title : node.attributes.text,    
				  	loadMask  : true,    				  	
				  	defaultSrc : node.attributes.url,    
				  	closable:true});
				  	Ext.dsdata.PAcentral.doLayout();  //if TabPanel is already rendered
				  	Ext.dsdata.PAcentral.setActiveTab(newFrame); 
				})
			}		
	
						
	var FNcentralclick = function(node) {	
				ids=node.id;
				
				 var j=0;
				 if(ids=="s15")
					{
						var g="<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Retrasos / Faltas (Sin Revision) </b></FONT>";
						j=1;
					}
					if(ids=="s45")
					{
						var g="<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Horas Extras* (Aprobacion)</b></FONT>";
						j=1;
					}
					if(ids=="s24")
					{
						var g="<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Bandeja (Borradores)</b></FONT>";
						j=1;
					}
					if(ids=="s25")
					{
						var g="<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Bandeja (Revisores)</b></FONT>";
						j=1;
					}
					if(ids=="s29")
					{
						var g="<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Bandeja (Rechazado)</b></FONT>";
						j=1;
					}
					if(ids=="s26")
					{
						var g="<FONT FACE=ARIAL  SIZE=0><b style = color:green; >Pendientes de Aprobacion</b></FONT>";
						j=1;
					}
					if(j==0)
					{
					g=node.attributes.text;
					}
			//	var g=node.attributes.text;
			  var newFrame = Ext.dsdata.PAcentral.add({    
			  	xtype: 'iframepanel',    
			  	id : node.id,    
			  	title : g,  
				
			  	loadMask  : true,    			  	
			  	defaultSrc : node.attributes.url,    
			  	closable:true});
			  	Ext.dsdata.PAcentral.doLayout();  //if TabPanel is already rendered
			  	Ext.dsdata.PAcentral.setActiveTab(newFrame); 
			}

	function empty(mixed_var) {
	  var undef, key, i, len;
	  var emptyValues = [undef, null, false, 0, '', '0'];

	  for (i = 0, len = emptyValues.length; i < len; i++) {
		if (mixed_var === emptyValues[i]) {
		  return true;
		}
	  }

	  if (typeof mixed_var === 'object') {
		for (key in mixed_var) {
		  // TODO: should we check for own properties only?
		  //if (mixed_var.hasOwnProperty(key)) {
		  return false;
		  //}
		}
    return true;
  }

  return false;
}
    var argLogo = new Ext.Panel({
		    id: 'argLogoPanel',			
			html: '<img src="img/logo_bugssmall.png"/>' 
		});
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	 var handleAction = function(action){
	//	alert(action);
        var newFrame = window.parent.Ext.dsdata.PAcentral.add({    
			  	xtype: 'iframepanel',    
			  	id : 'idevaluacion',    
			  	title : 'EMD',    
			  	loadMask  : true,    			  	
			  	defaultSrc : 'DSlists/DSListadoCargo.php',    
			  	closable:true});
			  	window.parent.Ext.dsdata.PAcentral.doLayout(); 
			  	window.parent.Ext.dsdata.PAcentral.setActiveTab(newFrame);
    };
	 var handleAction1 = function(action){
        var newFrame = window.parent.Ext.dsdata.PAcentral.add({    
			  	xtype: 'iframepanel',    
			  	id : 'idevaluacion1',    
			  	title : 'EEE',    
			  	loadMask  : true,    			  	
			  	defaultSrc : 'DSlists/DSListadoCargo.php',    
			  	closable:true});
			  	window.parent.Ext.dsdata.PAcentral.doLayout(); 
			  	window.parent.Ext.dsdata.PAcentral.setActiveTab(newFrame);
    };
	
	 var handleActionDinamico = function(idm,titlem,url){
	 
	  
        var newFrame = window.parent.Ext.dsdata.PAcentral.add({    
			  	xtype: 'iframepanel',    
			  	id : idm,    
			  	title : titlem,    
			  	loadMask  : true,    			  	
			  	defaultSrc : url,    
			  	closable:true});
			  	window.parent.Ext.dsdata.PAcentral.doLayout(); 
			  	window.parent.Ext.dsdata.PAcentral.setActiveTab(newFrame);
    };
	
    function Actualizar()
	{
      
		Ext.Ajax.request({  
		url: 'servicesAjax/DSActualizarBandeja.php',  
		timeout: 1000000,	
		method: 'POST',  
		
		success: desactivo,  
		failure: no_desactivo  
		});  

		function desactivo(resp)  
		{  	
			//echo '{"success":true, "message":{"reason":"'.$bandejarevisor."-".$pendiente."-".$borradores."-".$rechazado.'"}}';
				var data = Ext.util.JSON.decode(resp.responseText);
				var coddoc = data.message.reason;
				var x = coddoc.length;
				var bandejarevisor="";
				var pendiente="";
				var borradores="";
				var rechazado="";
				var horas="";
				var borradorSinLeer="";
				var rechazadoSinLeer="";
				var total_sin_revision="";
				var total_sin_revisionretraso="";
				var total_EMD="";
				var y=1;
				if(x>0)
				{
					for(i=0;i<x;i++)
					{
						if(coddoc.charAt(i)!="-")
						{
							
							
							if(y==1)
						    { bandejarevisor=bandejarevisor+coddoc.charAt(i);}
							if(y==2)
						    { pendiente=pendiente+coddoc.charAt(i);}
							if(y==3)
						    { borradores=borradores+coddoc.charAt(i);}
							if(y==4)
						    { rechazado=rechazado+coddoc.charAt(i);}
							if(y==5)
						    { horas=horas+coddoc.charAt(i);}
							if(y==6)
						    { borradorSinLeer=borradorSinLeer+coddoc.charAt(i);}
							if(y==7)
						    { rechazadoSinLeer=rechazadoSinLeer+coddoc.charAt(i);}
							if(y==8)
						    { total_sin_revision=total_sin_revision+coddoc.charAt(i);}
							if(y==9)
						    { total_sin_revisionretraso=total_sin_revisionretraso+coddoc.charAt(i);}
							if(y==10)
						    { total_EMD=total_EMD+coddoc.charAt(i);}
							
						}
						else
						{
							y++;
						}
						
					}}
				//aprobaciones pendientes
			
				 var ch2 = Ext.getCmp('c26'); 
				  if(pendiente=="0"){
						var chx = Ext.getCmp('Me10'); 
						if (empty(chx) != true) {
							lrx='<b style =color:green><font size=1>Aprobaciones </font></b>';
							chx.setTitle(lrx);
						}
						if (empty(ch2) != true) {
							 lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Pendientes de </br>Aprobacion ['+pendiente+']</a>';
							ch2.setText(lr);
						}
						var chx = Ext.getCmp('MENU10'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:green><font size=1>Aprobaciones </font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU10').getNodeById('s26'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Pendientes de Aprobacion ['+pendiente+']</b></FONT>';
							 chx.setText(lr);
						}
					
				 }
				 else
				 {
					var chx = Ext.getCmp('Me10'); 	
					if (empty(chx) != true) {
						lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Aprobaciones <img src="img/ala.gif"/></font></a>';
						chx.setTitle(lrx);
					}
					if (empty(ch2) != true) {
						 lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Pendientes de </br>Aprobacion ['+pendiente+']</a>';
						ch2.setText(lr);
					}
					var chx = Ext.getCmp('MENU10'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:red><font size=1>Aprobaciones <img src="img/ala.gif"/></font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU10').getNodeById('s26'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Pendientes de Aprobacion ['+pendiente+']</b></FONT>';
							 chx.setText(lr);
						}
					
				 }
				 
				 var ch3 = Ext.getCmp('c24'); 
				 if (empty(ch3) != true) {
					 lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Borradores) ['+borradores+']</a>';
					ch3.setText(lr);
				 }
				
				 var ch4 = Ext.getCmp('c29'); 
				 
					if (empty(ch4) != true) {
						lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Rechazado) ['+rechazado+']</a>';
						 ch4.setText(lr);
					}
				  
				  var choras = Ext.getCmp('c45'); 
				 
				 if(horas=="0"){
					if (empty(choras) != true) {
						 lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Horas Extras </br>(Aprobacion)</a>';
						choras.setText(lr);
					}
					 var chx = Ext.getCmp('Me6'); 
					if (empty(chx) != true) {
						lrx='<b style =color:green><font size=1>Control de Asistencia </font></b>';
						chx.setTitle(lrx);
					}
					   var chx = Ext.getCmp('MENU6'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:green><font size=1>Control de Asistencia </font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU6').getNodeById('s45'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Horas Extras(Aprobacion)</b></FONT>';
							 chx.setText(lr);
						}
				
				 }
				 else
				 {
					if (empty(choras) != true) {
						 lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Horas Extras </br>(Aprobacion) ['+horas+']</a>';
					 choras.setText(lr);
					}
					 var chx = Ext.getCmp('Me6'); 
					if (empty(choras) != true) {
						 lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Control de Asistencia <img src="img/ala.gif"/></font></a>';
						 chx.setTitle(lrx);
					}
					 var chx = Ext.getCmp('MENU6'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:red><font size=1>Control de Asistencia <img src="img/ala.gif"/></font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU6').getNodeById('s45'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Horas Extras(Aprobacion) ['+horas+']</b></FONT>';
							 chx.setText(lr);
						}
					
				 }
				 var chborradorSinLeer = Ext.getCmp('c24');
				 if(borradorSinLeer =="0"){
					if (empty(chborradorSinLeer) != true) {
					 lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Borradores) ['+borradores+']</a>';
					chborradorSinLeer.setText(lr);
					}
				
					var chx = Ext.getCmp('Me9'); 
					if (empty(chx) != true) {
						lrx='<b style =color:green><font size=1>Bandejas </font></b>';
						chx.setTitle(lrx);
					}
					 var chx = Ext.getCmp('MENU9'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:green><font size=1>Bandejas </font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU9').getNodeById('s24'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Bandeja (Borradores) ['+borradores+']</b></FONT>';
							 chx.setText(lr);
						}
				
				 }
				 else
				 {
					if (empty(chborradorSinLeer) != true) {
						lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Borradores) ['+borradores+']</a>';
						chborradorSinLeer.setText(lr);
					}
					
				    var chx = Ext.getCmp('Me9'); 
					if (empty(chx) != true) {	
						lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Bandejas <img src="img/ala.gif"/></font></a>';
						chx.setTitle(lrx);
					}					
					 var chx = Ext.getCmp('MENU9'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:red><font size=1>Bandejas <img src="img/ala.gif"/></font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU9').getNodeById('s24'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Bandeja (Borradores) ['+borradores+']</b></FONT>';
							 chx.setText(lr);
						}
					
				 }
				 
				 var chrechazadoSinLeer = Ext.getCmp('c29');
				 if(rechazadoSinLeer =="0"){
					if (empty(chrechazadoSinLeer) != true) {
						 lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Rechazado) ['+rechazado+']</a>';
						chrechazadoSinLeer.setText(lr);
					}
					var chx = Ext.getCmp('Me9'); 
					if(borradorSinLeer=="0"){
						if (empty(chx) != true) {
							lrx='<b style =color:green><font size=1>Bandejas </font></b>';
							chx.setTitle(lrx);
						}
						
					}
					 var chx = Ext.getCmp('MENU9'); 	
						if (empty(chx) != true) {
							if(borradorSinLeer=="0"){
							lrx='<b style =color:green><font size=1>Bandejas </font></b>';
							chx.setTitle(lrx);
							}
						}
						var chx = Ext.getCmp('MENU9').getNodeById('s29'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Bandeja (Rechazado) ['+rechazado+']</b></FONT>';
							 chx.setText(lr);
						}
				 }
				 else
				 {
					if (empty(chrechazadoSinLeer) != true) {
						lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Rechazado) ['+rechazado+']</a>';
						chrechazadoSinLeer.setText(lr);
					}
					 var chx = Ext.getCmp('Me9'); 	
					if (empty(chx) != true) {
						lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Bandejas <img src="img/ala.gif"/></font></a>';
						chx.setTitle(lrx);
					}
					 var chx = Ext.getCmp('MENU9'); 	
						if (empty(chx) != true) {
							lrx='<b style =color:red><font size=1>Bandejas <img src="img/ala.gif"/></font></b>';
							chx.setTitle(lrx);
						}
						var chx = Ext.getCmp('MENU9').getNodeById('s29'); 	
									
						if (empty(chx) != true) {
							lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Bandeja (Rechazado) ['+rechazado+']</b></FONT>';
							 chx.setText(lr);
						}
				 	
				 }
				  ///////////////sin revision faltas
				  
				 if(total_sin_revision=="0" ){
				  var ch1 = Ext.getCmp('c15'); 
					if (empty(ch1) != true) {
						lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;"> Faltas </br>(Sin Revision) ['+total_sin_revision+']</a>';
						ch1.setText(lr);
					}
					var chx = Ext.getCmp('Me6'); 
					
					if(horas=="0" && total_sin_revisionretraso=="0")
					{
						if (empty(chx) != true) {
							lrx='<b style =color:green><font size=1>Control de Asistencia </font></b>';
							chx.setTitle(lrx);
						}
						
					}
					var chx = Ext.getCmp('MENU6'); 	
					if (empty(chx) != true) {
						if(horas=="0" && total_sin_revisionretraso=="0")
						{
							lrx='<b style =color:green><font size=1>Control de Asistencia</font></b>';
							chx.setTitle(lrx);
						}
					}
					var chx = Ext.getCmp('MENU6').getNodeById('s15'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Faltas (Sin Revision) ['+total_sin_revision+']</b></FONT>';
						 chx.setText(lr);
					}
					
				 }
				 else
				 {
					 var ch1 = Ext.getCmp('c15'); 
					 if (empty(ch1) != true) {
						lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"> Faltas </br>(Sin Revision) ['+total_sin_revision+']</a>';
						ch1.setText(lr);
					 }
					
				   var chx = Ext.getCmp('Me6'); 
					if (empty(chx) != true) {
						lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Control de Asistencia <img src="img/ala.gif"/></font></a>';
						chx.setTitle(lrx);
					}
					var chx = Ext.getCmp('MENU6'); 	
					if (empty(chx) != true) {
						lrx='<b style =color:red><font size=1>Control de Asistencia <img src="img/ala.gif"/></font></b>';
						chx.setTitle(lrx);
					}
					var chx = Ext.getCmp('MENU6').getNodeById('s15'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Faltas (Sin Revision) ['+total_sin_revision+']</b></FONT>';
						 chx.setText(lr);
					}
				 }
				  ///////////////sin revision retraso
				 
				 if(total_sin_revisionretraso=="0" ){
					
					  var ch1 = Ext.getCmp('c63');
						if (empty(ch1) != true) {
							lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Retrasos </br>(Sin Revision) ['+total_sin_revisionretraso+']</a>';
							ch1.setText(lr);
						}
						
					
					var chx = Ext.getCmp('Me6'); 
						if(horas=="0" && total_sin_revision=="0" )
						{
							if (empty(chx) != true) {
								lrx='<b style =color:green><font size=1>Control de Asistencia </font></b>';
								chx.setTitle(lrx);
							}
							
						}
					var chx = Ext.getCmp('MENU6'); 	
					if (empty(chx) != true) {
						if(horas=="0" && total_sin_revision=="0" )
						{
							lrx='<b style =color:green><font size=1>Control de Asistencia </font></b>';
							chx.setTitle(lrx);
						}
						
					}
					var chx = Ext.getCmp('MENU6').getNodeById('s63'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Retrasos (Sin Revision) ['+total_sin_revisionretraso+']</b></FONT>';
						 chx.setText(lr);
					}
						
				 }
				 else
				 {
					  var ch1 = Ext.getCmp('c63'); 
					  if (empty(ch1) != true) {
						lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Retrasos </br>(Sin Revision) ['+total_sin_revisionretraso+']</a>';
						ch1.setText(lr);
					  }
					  var chx = Ext.getCmp('Me6'); 
					 if (empty(chx) != true) {
						 lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Control de Asistencia <img src="img/ala.gif"/></font></a>';
						chx.setTitle(lrx);
					 }
					 var chx = Ext.getCmp('MENU6'); 	
					if (empty(chx) != true) {
						
							lrx='<b style =color:red><font size=1>Control de Asistencia <img src="img/ala.gif"/></font></b>';
							chx.setTitle(lrx);
						
						
					}
					var chx = Ext.getCmp('MENU6').getNodeById('s63'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Retrasos (Sin Revision) ['+total_sin_revisionretraso+']</b></FONT>';
						 chx.setText(lr);
					}
				  	
				 }
				 ///////////////
				 
				 if(bandejarevisor=="0"){
				   
				  var ch1 = Ext.getCmp('c25'); 
				  if (empty(ch1) != true) {
					  lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Revisores) ['+bandejarevisor+']</a>';
					 ch1.setText(lr);
				  }
				  var chx = Ext.getCmp('Me9');
				 
					 if(borradorSinLeer=="0" && rechazadoSinLeer=="0"){
						if (empty(chx) != true) {
						lrx='<b style =color:green><font size=1>Bandejas </font></b>';
						chx.setTitle(lrx);
						}
						
					 }
					 
					 var chx = Ext.getCmp('MENU9'); 	
					if (empty(chx) != true) {
						 if(borradorSinLeer=="0" && rechazadoSinLeer=="0"){
							lrx='<b style =color:green><font size=1>Bandejas </font></b>';
							chx.setTitle(lrx);
						 }
							
						
						
					}
					var chx = Ext.getCmp('MENU9').getNodeById('s25'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Bandeja (Revisores) ['+bandejarevisor+']</b></FONT>';
						 chx.setText(lr);
					}
					
				 }
				 else
				 {
					 var ch1 = Ext.getCmp('c25'); 
					 if (empty(ch1) != true) {
						lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Bandeja </br>(Revisores) ['+bandejarevisor+']</a>';
						ch1.setText(lr);
						var chx = Ext.getCmp('Me9'); 
						 if (empty(chx) != true) {
						 lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Bandejas <img src="img/ala.gif"/></font></a>';
						chx.setTitle(lrx);
						 }
					 }
					
				  
					
					var chx = Ext.getCmp('MENU9').getNodeById('s25'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Bandeja (Revisores) ['+bandejarevisor+']</b></FONT>';
						 chx.setText(lr);
						  var chx = Ext.getCmp('MENU9'); 	
						if (empty(chx) != true) {
							
								lrx='<b style =color:red><font size=1>Bandejas <img src="img/ala.gif"/></font></b>';
								chx.setTitle(lrx);
						
						}
					}
					
				 }
				 ////////////EMD
				 if(total_EMD=="0"){
				   
				  var ch1 = Ext.getCmp('c57'); 
				  if (empty(ch1) != true) {
					  lr='<a style ="color:green; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Pendientes E.M.D. ['+total_EMD+']</a>';
					 ch1.setText(lr);
				  }
				  var chx = Ext.getCmp('Me13');
				 
					 //if(borradorSinLeer=="0" && rechazadoSinLeer=="0"){
						if (empty(chx) != true) {
						lrx='<b style =color:green><font size=1>Evaluación de Desempeño </font></b>';
						chx.setTitle(lrx);
						}
						
					 //}
					 
					 var chx = Ext.getCmp('MENU13'); 	
					if (empty(chx) != true) {
						// if(borradorSinLeer=="0" && rechazadoSinLeer=="0"){
							lrx='<b style =color:green><font size=1>Evaluación de Desempeño  </font></b>';
							chx.setTitle(lrx);
						 //}
							
						
						
					}
					var chx = Ext.getCmp('MENU13').getNodeById('s57'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:green"; >Pendientes E.M.D. ['+total_EMD+']</b></FONT>';
						 chx.setText(lr);
					}
					
				 }
				 else
				 {
					 var ch1 = Ext.getCmp('c57'); 
					 if (empty(ch1) != true) {
						lr='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;">Pendientes E.M.D. ['+total_EMD+']</a>';
						ch1.setText(lr);
						var chx = Ext.getCmp('Me13'); 
						 if (empty(chx) != true) {
							lrx='<a style ="color:red; font: bold 8.5px tahoma,arial,verdana,sans-serif;"><font size=1>Evaluación de Desempeño <img src="img/ala.gif"/></font></a>';
							chx.setTitle(lrx);
						}
					 }
					
				  
					
					var chx = Ext.getCmp('MENU13').getNodeById('s57'); 	
								
					if (empty(chx) != true) {
						lr='<FONT FACE=ARIAL  SIZE=0><b style = "color:red"; >Pendientes E.M.D. ['+total_EMD+']</b></FONT>';
						 chx.setText(lr);
						  var chx = Ext.getCmp('MENU13'); 	
							if (empty(chx) != true) {
								
									lrx='<b style =color:red><font size=1>Evaluación de Desempeño <img src="img/ala.gif"/></font></b>';
									chx.setTitle(lrx);
							
							}
					}
					
				 }
				 ///////////////
				window.setTimeout(function()
													 {
													  Actualizar();
													 },30000);
		}  
  
		function no_desactivo(resp)  
		{  			
			
		}  
	
     }	
	var lblsession = new Ext.form.Label({
			text: '',
			x: 0,
			y: 0,
			width:150,
			//height: 1000,
			cls: 'namelabel',
			html:
			'<table width="100%" HEIGHT="20%" border="0"  >  <tr><td height="0" style=" url(images/lcentro.png) no-repeat left center ">' +
							'<div id="menudsh"><ul>'+
							
							'<li><a href="#"><img src="img/user.png" align="absmiddle" border="0"/>'+
							
							<?php
								//$titlem='<a style ='.".'color:green; font: bold 8px tahoma,arial,verdana,sans-serif;'.".'>'. $_SESSION['Nombresesion'] . ' ' . $_SESSION['Apellido1'].' </a>';
							$titlem="<FONT FACE=ARIAL  SIZE=1><b style = color:green; >". $_SESSION['Nombresesion'] . " " . $_SESSION['Apellido1']."</b></FONT>";
							//echo $_SESSION['Nombre'];
							  if (isset($_SESSION['Nombresesion'])) {
								echo "'&nbsp; " . $titlem . "'+";
							  } else {
								echo "'&nbsp;Desconocido'+";
							  }
							?>	
							'</a></li>'+	 
							
									'</ul></div>' +					      
							' </td></tr></table>'
			
				
		});	
		var lblsession1 = new Ext.form.Label({
			text: '',
			x: 0,
			y: 0,
			width:150,
			//height: 1000,
			cls: 'namelabel',
			html:
			'<table width="100%" HEIGHT="20%" border="0"  >  <tr><td height="20" style=" url(images/lcentro.png) no-repeat left center ">' +
							'<div id="menudsh"><ul>'+
							
							'<li><a href="#"><img src="img/user.png" align="absmiddle" border="1"/>'+
							
							<?php
								//$titlem='<a style ='.".'color:green; font: bold 8px tahoma,arial,verdana,sans-serif;'.".'>'. $_SESSION['Nombresesion'] . ' ' . $_SESSION['Apellido1'].' </a>';
							$titlem="<FONT FACE=ARIAL  SIZE=1><b style = color:green; >". $_SESSION['Nombresesion'] . " " . $_SESSION['Apellido1']."</b></FONT>";
							//echo $_SESSION['Nombre'];
							  if (isset($_SESSION['Nombresesion'])) {
								echo "'&nbsp; " . $titlem . "'+";
							  } else {
								echo "'&nbsp;Desconocido'+";
							  }
							?>	
							'</a></li>'+	 
							
									'</ul></div>' +					      
							' </td></tr></table>'
			
				
		});	
			var lblsession2 = new Ext.form.Label({
			text: 'eee',
			x: 0,
			y: 0,
			width:150,
			//height: 1000,
			cls: 'namelabel',
			
			
				
		});	
	
	
	 Ext.dsdata.PAmenu = new Ext.FormPanel(
	{
		region: 'north',
		//title: lblsession2,
		id: 'PAmenuPr',
		align: 'center',
		//height: 20,
		title:'<P ALIGN=right> <a href="DSlists/DSDatosUsuario.php"><img src="img/sesion16.png" border="1"/> <FONT FACE=ARIAL  SIZE=1 color="green"> <?php echo $titlem="<FONT FACE=ARIAL  SIZE=1>". $_SESSION['Nombre1'] . " " . $_SESSION['App']."</FONT>"; ?> </font></a> | <a href="DSlists/DSConfirmarInicioSessionReseteado.php"><img src="img/reseteo16.png" border="1"/> <FONT FACE=ARIAL  SIZE=1 color="green"> Cambio de Password </font></a> | <a href="DScerrarsesion.php"><img src="img/cerrar16.png" border="1"/> <FONT FACE=ARIAL  SIZE=1 color="green"> Salir del Sistema </font> </a> | </P>',
	     collapsible: true,
		margins: '0 0 0 0',
		y:0,
	 
		
		  tbar: [
							 <?php
							 echo $_SESSION['menu'];
							?>		
						
					
			   ]
     })

	// var PAmenu = new Ext.FormPanel(
	// {
		// //region: 'north',
		// id: 'PAmenuPr',
		// height: 29, 
		// y:58,
		// tbar:  new Ext.Toolbar({
            // enableOverflow: true,
            // items: [{
                // xtype:'splitbutton',
                // text: 'Menu Button',
                // iconCls: 'add16',
                // handler: handleAction.createCallback('Menu Button'),
                // menu: [{text: 'Menu Item 1', handler: handleAction.createCallback('Menu Item 1')},
				// {text: 'Menu Item 2', handler: handleAction1.createCallback('Menu Item 2')}
				// ]
            // },'-',{
                // xtype:'splitbutton',
                // text: 'Cut',
                // iconCls: 'add16',
                // handler: handleAction.createCallback('Cut'),
                // menu: [{text: 'Cut menu', handler: handleAction.createCallback('Cut menu')}]
            // },{
                // text: 'Copy',
                // iconCls: 'add16',
                // handler: handleAction.createCallback('Copy')
            // },{
                // text: 'Paste',
                // iconCls: 'add16',
                // menu: [{text: 'Paste menu', handler: handleAction.createCallback('Paste menu')}]
            // },'-',{
                // text: 'Format',
                // iconCls: 'add16',
                // handler: handleAction.createCallback('Format')
            // },'->',{
                // text: 'Right',
                // iconCls: 'add16',
                // handler: handleAction.createCallback('Right')
            // }]
        // })
	// });
	////////////////////////////////////////////////////////////////////////////////////////////////////////
        
    var viewport = new Ext.Viewport({
        layout: 'border',
        items: [
        // cabecera para menu o imagenes
        new Ext.BoxComponent({
            region: 'north',
            id: 'PAcabecera',
            height: 30, // tamaño cabecera            
            // autoEl: {
                // tag: 'div',
                // html:
					// '<html xmlns="http://www.w3.org/1999/xhtml"> '+
					// '<head>  </head> '+
					// '<table width="100%" HEIGHT="20%" border="0" bgcolor="#0000FF"> <tr><td width="309" style="background: #81BEF7 url(images/lizquierdo1.png) no-repeat left center " ></td><td height="50" style="background: #81BEF7 url(images/lcentro.png) no-repeat left center ">' +
                	
                	// '<div id="menudsh"><ul>'+
                	// '<li><a href="DScerrarsesion.php"><img src="img/salir.png" align="absmiddle" border="0"/>&nbsp;</a></li>'+								      	
	                // '<li><a href="#"><img src="img/user.png" align="absmiddle" border="0"/>'+
	                // <?php
					// //echo $_SESSION['Nombre'];
	                  // if (isset($_SESSION['Nombresesion'])) {
	                  	// echo "'&nbsp;" . $_SESSION['Nombresesion'] . " " . $_SESSION['Apellido1'] . "'+";
	                  // } else {
	                  	// echo "'&nbsp;Desconocido'+";
	                  // }
	                // ?>	
	                // '</a></li>'+	 
					// '<li><a href="DSlists/DSConfirmarInicioSessionReseteado.php"><img src="img/key1.png" align="absmiddle" border="0"/>&nbsp;</a></li>'+								      	
					        // '</ul></div>' +					      
                	// ' </td><td width="70" style="background: #81BEF7 url(images/lderecho.png) no-repeat center center " ></td></tr></table>'+
					// '</html>'
                
            // }
        }),Ext.dsdata.PAmenu, {
            region: 'west',
            id: 'PAmenu', // see Ext.getCmp() below
            title: '<b style =color:green>Menu Principal </b>',
            split: true,
            width: 230,
			// height:200,
			
            minSize: 175,
            maxSize: 400,
            collapsible: true,            
            margins: '0 0 0 6',
            layout: {
                type: 'accordion',
                animate: true
            },
            items: [
					<?php     
						
						if($_SESSION['banderSession']==1){
							if($_SESSION['temas']==0){
							include("DSlibListaITEMS.php"); 
							DevuelveListaMenuItem();
							}
							if($_SESSION['temas']==1){
							include("DSlibListaITEMSgris.php"); 
							DevuelveListaMenuItem();
							}
							if($_SESSION['temas']==2){
							include("DSlibListaITEMSverde.php"); 
							DevuelveListaMenuItem();
							}
							
						}
						?>
					]
        }, Ext.dsdata.PAcentral
        
        ]
    }); 
Ext.getCmp('PAmenuPr').expand();	
});

