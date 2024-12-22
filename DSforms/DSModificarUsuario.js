/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
		var winModificarUsuario;		
		var codi;
		var bandera=0;
		var txtCodigo = new Ext.form.TextField(
		{
				name: 'codigo',
				hideLabel: true,						
				x: 110,
				y: 10																				
		});
		
		var txtNombreM = new Ext.form.TextField({
				name: 'nombre',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 10,
				allowBlank: true,
				maxLength:100,				
				style : {textTransform: "uppercase"},
				blankText: 'Nombre requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtApellidoPaternoM.focus();
						}
					}
				}
		});
		
		var txtApellidoPaternoM = new Ext.form.TextField({
				name: 'apellidopaterno',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 40,				
				maxLength:100,
				style : {textTransform: "uppercase"},				
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtApellidoMaternoM.focus();
						}
					}
				}
		});
		
		var txtApellidoMaternoM = new Ext.form.TextField({
				name: 'apellidomaterno',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 70,
				maxLength:100,
				style : {textTransform: "uppercase"},				
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtcorreoM.focus();
						}
					}
				}
		});
		var txtcorreoM = new Ext.form.TextField({
				name: 'correo',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 100,
				maxLength:100,
				//style : {textTransform: "uppercase"},				
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtUsuarioM.focus();
						}
					}
				}
		});				
		var txtUsuarioM = new Ext.form.TextField({
				name: 'usuario',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 130,
				allowBlank: false,
				maxLength:50,
				//style : {textTransform: "uppercase"},
				blankText: 'Usuario requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				forceSelection: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtContraseniaM.focus();
						}
					}
				}
		});
		
		var txtContraseniaM = new Ext.form.TextField({
				name: 'contrasenia',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 160,
				allowBlank: false,
				
				blankText: 'Contraseña requerido',
				maxLength:50,
				//inputType:'password', 
			//	style : {textTransform: "uppercase"},
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							cboTipoUsuario.focus();
						}
					}
				}
		});
		
		var storeCbTipoUsuario = new Ext.data.JsonStore(
		{
		  	url:'../servicesAjax/DSListaTipoUCBAJAX.php',
			root: 'data',  
			totalProperty: 'total',
			fields : ['codtu','nombtu']			
		});		
		storeCbTipoUsuario.load();		
		var cboTipoUsuario = new Ext.form.ComboBox(
		{
		    x: 110,
			y: 190,
			width : 200,
			mode: 'local',
		    hiddenName: 'tipo_usuario',
			store:storeCbTipoUsuario,
			//autocomplete: true,
		    style : {textTransform: "uppercase"},
			allowBlank :true,
			emptyText:'Seleccione..',
			triggerAction : 'all',
			displayField:'nombtu',
			//typeAhead: true,
			valueField:'codtu',
			//selectOnFocus: true,
			forceSelection:true,
			cls:'name',
			listeners: {
					'select': function(cmb,record,index)
					{
						btnAceptarM.focus(true, 300);
					}
			}					
		});					
		// Labels		
		
		var lblNombre = new Ext.form.Label({
			text: 'Nombre :',
			x: 10,
			y: 15,
			height: 20,
			cls: 'x-label'
		});
		
		var lblApellidoPaterno = new Ext.form.Label({
			text: 'Apellido Paterno :',
			x: 10,
			y: 45,
			height: 20,
			cls: 'x-label'
		});
		
		var lblApellidoMaterno = new Ext.form.Label({
			text: 'Apellido Materno :',
			x: 10,
			y: 75,
			height: 20,
			cls: 'x-label'
		});
		
		var lblCorreo = new Ext.form.Label({
			text: 'Correo :',
			x: 10,
			y: 105,
			height: 20,
			cls: 'x-label'
		});
		
		var lblUsuario = new Ext.form.Label({
			text: 'Usuario :',
			x: 10,
			y: 135,
			height: 20,
			cls: 'x-label'
		});
		
		var lblContrasenia = new Ext.form.Label({
			text: 'Contraseña :',
			x: 10,
			y: 165,
			height: 20,
			cls: 'x-label'
		});
		
		var lblTipoUsuario = new Ext.form.Label({
			text: 'Tipo Usuario :',
			x: 10,
			y: 195,
			height: 20,
			cls: 'x-label'
		});	
		// botones
		var btnAceptarM = new Ext.Button({
		    id: 'btnAceptarM',
			x: 60,
			y: 225,
			text: 'Aceptar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmModificarUsuario.validarAcceso();
			} 
		});
		
		var btnLimpiarM = new Ext.Button({
		    id: 'btnLimpiarM',
			x:150,
			y: 225,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{				
				var frm = frmModificarUsuario.getForm();	
				frm.reset();
				frm.clearInvalid();
				winModificarUsuario.hide();
			} 
		});		
		function resetPassword(codi)
			{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSResetearAJAX.php',
				method:'POST',
				params:{codi:codi},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					Ext.Msg.hide();	
					winModificarUsuario.hide();	
					Ext.namespace.storeUsuario.load({params:{start:0,limit:25}});	
					Ext.MessageBox.alert('Mensaje', 'Password Reseteado'); 
					
					// Ext.dsdata.storeCliente.load({params:{start:0,limit:25	}});	

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
			var btnResetear = new Ext.Button({
		    id: 'btnResetearC',
			x: 240,
			y: 225,
			text: 'Reset Password',
			icon: '../img/refresh.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{	
				if(txtcorreoM.getValue()!="")
				{
					bandera=1;
					frmModificarUsuario.validarAcceso();
				}
				else
				{
					Ext.Msg.alert('Error!', 'Imposible resetear no existe una direccion de correo ');
				}
				//resetPassword(codi);
			} 
		});		
		var frmModificarUsuario = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[
					lblNombre, lblApellidoPaterno, lblApellidoMaterno, lblUsuario, lblContrasenia, lblTipoUsuario, lblCorreo,
					txtCodigo, txtNombreM, txtApellidoPaternoM, txtApellidoMaternoM, txtUsuarioM, txtContraseniaM,  cboTipoUsuario, txtcorreoM,
					btnAceptarM, btnLimpiarM,btnResetear
				  ],
			validarAcceso: function(){
				
				if (this.getForm().isValid()) 
				{
					this.getForm().submit(
					{						
						url: '../servicesAjax/DSModificarUsuarioAJAX.php',											
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando Datos...',
						success: function(form, action)
						{	
							if(bandera==1)
							{
								Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
								resetPassword(codi);
								bandera=0;
							}
							else{
							winModificarUsuario.hide();	
							Ext.namespace.storeUsuario.load({params:{start:0,limit:25}});	
							}
						},					
						failure: function(form, action)
						{
							if (action.failureType == 'server') 
							{
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('ARG', data.errors.reason, function()
								{
									txtNombreM.focus(true, 100);
								});
							}
							else 
							{
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}							
						}
					});
				}
			}
		});		
		
        function ModificarUsuario(indice)
		{		
			if (!winModificarUsuario) 
			{
				winModificarUsuario = new Ext.Window(
				{
					layout: 'fit',
					width: 400,
					height: 300,		
					title: 'Modificar Usuario',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,					
					items: [frmModificarUsuario],
					listeners: 
					{
						show: function()
						{
							txtNombreM.focus(true, 100);
						}
					}
				});
			}			
			codi=Ext.namespace.storeUsuario.getAt(indice).get('codigo');
			txtCodigo.setValue(Ext.namespace.storeUsuario.getAt(indice).get('codigo'));			
			txtNombreM.setValue(Ext.namespace.storeUsuario.getAt(indice).get('nombre'));
			txtApellidoPaternoM.setValue(Ext.namespace.storeUsuario.getAt(indice).get('apellidopaterno'));
			txtApellidoMaternoM.setValue(Ext.namespace.storeUsuario.getAt(indice).get('apellidomaterno'));
			txtcorreoM.setValue(Ext.namespace.storeUsuario.getAt(indice).get('correo'));
			txtUsuarioM.setValue(Ext.namespace.storeUsuario.getAt(indice).get('usuario'));
			txtContraseniaM.setValue(Ext.namespace.storeUsuario.getAt(indice).get('contrasenia'));
			cboTipoUsuario.setValue(Ext.namespace.storeUsuario.getAt(indice).get('cod_tu'));	
			winModificarUsuario.show();			
		}
	
