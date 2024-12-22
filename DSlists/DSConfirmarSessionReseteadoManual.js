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
		var storeSession = new Ext.data.JsonStore(
		{
				url: '../servicesAjax/DSListaUsuariosPass.php',
				root: 'data',			
				totalProperty: 'total',
				fields: ['codusuario', 'login','contrasena','usuario_actual','passwor_actual'],
				listeners: { 
					load: function(thisStore, record, ids) 
						{  					
							
								
								log=record[0].data.usuario_actual;
								txtUsuario.setValue(log);
								txtClave.setValue(record[0].data.passwor_actual);
								txtClavec.setValue(record[0].data.passwor_actual);
								//alert(log);
						   // }
					    }
							

				}	      
			
					
		});
		storeSession.load();
		var txtUsuario = new Ext.form.TextField({
				name: 'usuario',
				hideLabel: true,		
				width: 180,
				x: 100,
				y: 110,
				allowBlank: false,
				blankText: 'Usuario requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtClave.focus();
						}
					}
				}
		});
		
		
		var txtClave = new Ext.form.TextField({
				name: 'password',
				hideLabel: true,
				inputType:'password', 
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
		var txtClavec = new Ext.form.TextField({
				name: 'Cpassword',
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
		
		// Labels
		var lblUsuario = new Ext.form.Label({
			text: 'Usuario Nuevo:',
			x: 10,
			y: 110,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" face="New Time Roman"><b>Usuario Nuevo:<b/></font>'
		});
		
		var lblClave = new Ext.form.Label({
			text: 'Password Nuevo:',
			x: 10,
			y: 140,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" face="New Time Roman"><b>Password Nuevo:<b/></font>'
		});
		var lblClavec = new Ext.form.Label({
			text: 'Confirmar:',
			x: 10,
			y: 170,
			height: 20,
			cls: 'x-label',
				html: '<font color="#2E64FE" face="New Time Roman"><b>Confirmar :<b/></font>'
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
				ban=buscarUsuario(txtUsuario.getValue());
				if(ban==0)
				{
					if(txtClave.getValue()==txtClavec.getValue()){
						
						frmLoginC.validarAcceso();
						
					}
					else
					alert("La contraseña es incorrecta ")
					
				}
				else
				alert("El Usuario Ya Existe");
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
				// txtUsuario.focus(true, 100);
			} 
		});
		
		
		
		var frmLoginC = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[argLogo, lblUsuario, lblClave,lblClavec, txtUsuario, txtClave,txtClavec, btnAceptar, btnLimpiar],
			validarAcceso: function(){
				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSConfirmarClave.php',
						// params :{registros : registrosGrid2,codGrupo:codPersonal },  
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Validando usuario...',
						success: function(form, action){
								alert("Cambios Guardados Correctamente....... Inicie Sessión ");
								window.location = "../DSinicioapp.php";
								// window.location = "../DScerrarsesion.php";
								btnAceptar.setDisabled(true);
							 	btnLimpiar.setDisabled(true);		
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								if (data.errors.id == '3') {
									Ext.Msg.alert('Error', data.errors.reason, function(){
										txtClave.focus(true, 100);
									});
								} else {
									Ext.Msg.alert('Error', data.errors.reason, function(){
										txtUsuario.focus(true, 100);
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
					height: 280,
					 x:530,
					 y:200,	
					title: '<font color="#2E64FE" face="New Time Roman"><b>Cambio de Usuario y Password<b/></font>',			
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
							txtUsuario.focus(true, 300);
							
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
