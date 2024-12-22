var winLogin;
				Ext.override(Ext.data.Connection, {
        timeout:65000
});
		var argLogo = new Ext.Panel({
		    id: 'argLogoPanel',
			x: 50,
			y: 10,
			width: 200,
			height:150,
			// html: '<img src="img/madepa.jpg" WIDTH="180" HEIGHT="130"/>' 
		});
		
		var txtUsuario = new Ext.form.TextField({
				name: 'usuario',
				hideLabel: true,		
				width: 230,
				x: 120,
				y: 20,
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
				width: 230,
				x: 120,
				y: 50,
				allowBlank: false,
				blankText: 'Campo requerido.',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							frmLogin.validarAcceso();
						}
					}
				}
		});
		
		// Labels
		var lblUsuario = new Ext.form.Label({
			text: 'Usuario :',
			x: 40,
			y: 20,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" ><b>Usuario :<b/></font>'
		});
		
		var lblClave = new Ext.form.Label({
			text: 'Password :',
			x: 40,
			y: 50,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" ><b>Contraseña :<b/></font>'
		});
		var lblVersion = new Ext.form.Label({
			text: 'V.11',
			x: 40,
			y: 85,
			height: 20,
			cls: 'x-label',
			html: '<font color="#2E64FE" ><b>v4.0<b/></font>'
		});
		
		// botones
		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 85,
			y: 80,
			text: '<font color="#2E64FE" "><b>Iniciar<b/></font>',
			icon: 'img/key1.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmLogin.validarAcceso();
			} 
		});
		var btnCancelar = new Ext.Button({
		    id: 'btnCancelar',
			x: 170,
			y: 80,
			text: 'Cancelar',
			icon: 'img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmLogin.getForm();
				frm.reset();
				frm.clearInvalid();
				txtUsuario.focus(true, 100);
			} 
		});	
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 160,
			y: 134,
			text: '<font color="#2E64FE" ><b>Limpiar Caché<b/></font>',
			icon: 'img/garbage.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmLogin.getForm();
				frm.reset();
				frm.clearInvalid();
				//txtUsuario.focus(true, 100);
				Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Caché Limpio!!</a>'); 
				window.setTimeout(function()
				{
				  window.location.reload(true);
			   
				},3000);	
				
				
			} 
		});
		var cuadroDig = [

			{
				xtype:'fieldset',
				id:'idcuadroDig',
				// title: '<font color= black>Datos del Certificado</font>',
				// checkboxToggle:true,
				style : { background :'#ffffff',borderRadius: '7px'},
				autoScroll:true,	
				x: 120,
				y: 80,
				height:30,
				width: 230,
				
			}			
		  ]
		var chkinicio =[
			{
				xtype  : 'checkbox',
				x: 175,
				y: 85,							
				name: 'inicial',
				id: 'ini',
				checked: false,			 		  
				boxLabel   : 'No soy un robot.',
				// html: 'No soy un robot...',
				inputValue : '1',
				handler: function() 
				{ 
					if (this.getValue() == true)
					{
						btnAceptar.setDisabled(false);
					}
					else
					{
						btnAceptar.setDisabled(true);
					} 
				} 
			}

		]
		var lblmsj = new Ext.form.Label({
			// text: 'Para un rendimiento adecuado del Sistema, limpie los cookies periódicamente.',
			x: 10,
			y: 119,
			height: 20,
			cls: 'x-label',
			html: '<font color="#686b88" ><b><small>Para un rendimiento adecuado del Sistema, limpie los cookies periódicamente.</small></font>'
		});
		
		var frmLogin = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[argLogo, lblUsuario, lblClave, txtUsuario, txtClave,cuadroDig,chkinicio,lblmsj,btnLimpiar],
			validarAcceso: function(){
				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: 'servicesAjax/DSiniciosesionAJAX.php',
						method: 'POST',
						timeout: 1000000,
						waitTitle: 'Conectando',
						waitMsg: 'Validando usuario...',
						//timeout: 1000000,
						//Ext.Ajax.timeout: 1000000,
						success: function(form, action){
							 // winLogin.hide();
							  var data = Ext.util.JSON.decode(action.response.responseText);
							 codform = data.message.reason;
							 if(codform==1)
							 {
								 window.location = "DSinicioapp.php";
								// bandera=0;
							 }
							 else
							 {
								 window.location = "DSlists/DSConfirmarInicioSession.php";
							 }
							  
							  //Ext.Msg.alert('Inicio', 'Bienvenido');
							  				
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
										frmLogin.getForm().reset();
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
					width: 435,
					height: 230,
					// x:530,
					// y:185,
					title: '<font color="#2E64FE" ><b>Inicio Sesión<b/></font>',			
					resizable: false,
					closeAction: 'hide',
					closable: false,
					draggable: true,
					plain: true,
					border: false,
					modal: false,					
					items: [frmLogin],
					buttonAlign:'center',
					buttons:[btnAceptar,btnCancelar],
					listeners: {						
						show: function(){
							txtUsuario.focus(true, 300);
						}
					}
				});				
			}
			btnAceptar.setDisabled(true);
			winLogin.show();
		}
		
		Ext.onReady(function(){
			
			Ext.BLANK_IMAGE_URL = 'ext/docs/resources/s.gif';
			Ext.QuickTips.init();
			abrirLogin();
		});
