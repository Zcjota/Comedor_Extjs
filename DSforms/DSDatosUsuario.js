var winLogin;
		
		var argLogo = new Ext.Panel({
		    id: 'argLogoPanel',
			x: 105,
			y: 10,
			width: 200,
			height:150,
			html: '<img src="../img/InicioS.png" WIDTH="90" HEIGHT="80"/>' 
		});
		var log="";
		var id="";
		var storeSession = new Ext.data.JsonStore(
		{
				url: '../servicesAjax/DSListaUsuario.php',
				root: 'data',			
				totalProperty: 'total',
				fields: ['codigo', 'nombre','login','contrasena','correo','tema'],
				listeners: { 
					load: function(thisStore, record, ids) 
						{  					
							
								
								log=record[0].data.nombre;
								id=record[0].data.codigo;
								txtnombre.setValue(log);
								txtlogin.setValue(record[0].data.login);
								txtclave.setValue(record[0].data.contrasena);
								txtcorreo.setValue(record[0].data.correo);
								cbotema.setValue(record[0].data.tema)
								//alert(log);
						   // }
					    }
							

				}	      
			
					
		});
		storeSession.load();
		var txtnombre = new Ext.form.TextField({
				name: 'txtnombre',
				hideLabel: true,		
				width: 180,
				x: 100,
				y: 110,
				allowBlank: false,
				blankText: 'Nombre',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtlogin.focus();
						}
					}
				}
		});
		
		
		var txtlogin = new Ext.form.TextField({
				name: 'login',
				hideLabel: true,
				//inputType:'password', 
				width: 180,
				x: 100,
				y: 140,
				allowBlank: false,
				blankText: 'Password requerido.',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							frmLoginC.validarAcceso();
						}
					}
				}
		});
		var txtclave = new Ext.form.TextField({
				name: 'txtclave',
				hideLabel: true,
				inputType:'password', 
				width: 180,
				x: 100,
				y: 170,
				allowBlank: false,
				blankText: 'Password requerido.',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});
		var txtcorreo = new Ext.form.TextField({
				name: 'txtcorreo',
				hideLabel: true,
				width: 180,
				x: 100,
				y: 200,
				allowBlank: false,
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});
		
		// Labels
		var lblnombre = new Ext.form.Label({
			text: 'Nombre:',
			x: 10,
			y: 110,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" face="New Time Roman"><b>Nombre:<b/></font>'
		});
		
		var lblusuario = new Ext.form.Label({
			text: 'login:',
			x: 10,
			y: 140,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" face="New Time Roman"><b>login:<b/></font>'
		});
		var lblclave = new Ext.form.Label({
			text: 'Password:',
			x: 10,
			y: 170,
			height: 20,
			cls: 'x-label',
				html: '<font color="#2E64FE" face="New Time Roman"><b>Password :<b/></font>'
		});
		var lblcorreo = new Ext.form.Label({
			text: 'Correo:',
			x: 10,
			y: 200,
			height: 20,
			cls: 'x-label',
				html: '<font color="#2E64FE" face="New Time Roman"><b>Correo :<b/></font>'
		});
		var lbltema = new Ext.form.Label({
			text: 'Tema:',
			x: 10,
			y: 230,
			height: 20,
			cls: 'x-label',
				html: '<font color="#2E64FE" face="New Time Roman"><b>Tema :<b/></font>'
		});
		function buscarUsuario(coditem){ 
			
			var cantida = 0;
			storeSession.each(function(record){
				if(record.data.login == coditem)
					cantida = 1;
				
			});
			return cantida;
		}
		var ban=0;
		// botones
		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 100,
			y: 205,
			text: '<font color="#2E64FE" face="New Time Roman"><b>Guardar<b/></font>',
			icon: '../img/key1.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				ban=buscarUsuario(txtnombre.getValue());
				if(ban==0)
				{
					if(txtlogin.getValue()==txtclave.getValue()){
						
						frmLoginC.validarAcceso();
						
					}
					else
					alert("La contraseña es incorrecta ")
					
				}
				else
				alert("El Usuario Ya Existe");
			} 
		});
		var storeTema = new Ext.data.SimpleStore(
		{
			fields: ['codigop', 'nombrep'],
			data : [					
						// ['0', 'azul'],			
						['1', 'gris'],	
						//['2', 'verde'],	
						//['3', 'azul y verde'],	
						//['4', 'oscuro'],
				],   
			autoLoad: false 		
		});
		var cbotema= new Ext.form.ComboBox(
		{   		
			x: 100,
			y: 230,	
			width : 185,
			store: storeTema, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione tema...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbotema',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
				'select': function(cmb,record,index){
						
							  frmLoginC.validarAcceso();
						 	    
					}
				}
			});	
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 200,
			y: 205,
			//text: 'Limpiar',
			text: '<font color="#2E64FE" face="New Time Roman"><b>Cancelar<b/></font>',
			icon: '../img/garbage.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
			 window.location = "../DSinicioapp.php";
				// var frm = frmLoginC.getForm();
				// frm.reset();
				// frm.clearInvalid();
				// txtnombre.focus(true, 100);
			} 
		});
		
		
		
		var frmLoginC = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[argLogo,lblcorreo, lblnombre, lblusuario,lblclave,lbltema, txtnombre, txtlogin,txtclave,txtcorreo,cbotema
			
],
			validarAcceso: function(){
				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DScambiarTema.php',
					 params :{id:id },  
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Validando usuario...',
						success: function(form, action){
								alert("Cambios Guardados Correctamente....... Inicie Sessión ");
								window.location = "../index.php";
								// window.location = "../DScerrarsesion.php";
								btnAceptar.setDisabled(true);
							 	btnLimpiar.setDisabled(true);		
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								if (data.errors.id == '3') {
									Ext.Msg.alert('Error', data.errors.reason, function(){
										txtlogin.focus(true, 100);
									});
								} else {
									Ext.Msg.alert('Error', data.errors.reason, function(){
										txtnombre.focus(true, 100);
										frmLoginC.getForm().reset();
									});								
								}
							}
							else {
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}							
						}
					});
				}
			}
		});
		
		
		
	function abrirLogin(){	
  	
			if (!winLogin) {
				winLogin = new Ext.Window({
					layout: 'fit',
					width: 330,
					height: 310,
					 x:530,
					 y:200,	
					title: '<font color="#2E64FE" face="New Time Roman"><b>Datos<b/></font>',			
					//title: 'CONFIRME SU SESSION',			
					resizable: false,
					closeAction: 'hide',
					closable: false,
					draggable: false,
					plain: true,
					border: false,
					//modal: true,					
					items: [frmLoginC],
					listeners: {						
						show: function(){
						//alert(log);
							txtnombre.focus(true, 300);
							
						}
					}
				});				
			}
			
			winLogin.show();
		}
		
		Ext.onReady(function(){
			
			Ext.BLANK_IMAGE_URL = 'ext/docs/resources/s.gif';
			Ext.QuickTips.init();
			abrirLogin();
		});
