/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */
		var winAltaUsuario;	
		var storePersona= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaPersonalFlujoGRAJAX.php',   
			root: 'data',  
			totalProperty: 'total',		
			fields: ['codigo', 'nombre','nombreP','app','apm'],
				
		});		
		storePersona.load();

		var cboPer = new Ext.form.ComboBox(
		{   		
			x: 110,
			y: 10,	
			width : 250,
			store: storePersona, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Personal...',   
			triggerAction: 'all',   		
			displayField:'nombre',   
			//typeAhead: true,
			valueField: 'codigo',
			hiddenName : 'cbpersonal',
			//selectOnFocus: true,
			forceSelection:true,
			cls:'name',
			listeners: {
						'select': function(cmb,record,index)
								{                        
									indice = index;	
									txtNombre.setValue(storePersona.getAt(indice).get('nombreP'));
									txtApellidoPaterno.setValue(storePersona.getAt(indice).get('app'));
									txtApellidoMaterno.setValue(storePersona.getAt(indice).get('apm'));
										//alert(indice);		
								}
							    
			}		
		});					
		var txtNombre = new Ext.form.TextField({
				name: 'nombre',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 40,
				readOnly:true,
				allowBlank: false,
				maxLength:100,				
				style : {textTransform: "uppercase"},
				blankText: 'Nombre requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtApellidoPaterno.focus();
						}
					}
				}
		});
		
		var txtApellidoPaterno = new Ext.form.TextField({
				name: 'apellidopaterno',
				hideLabel: true,
				readOnly:true,				
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
							txtApellidoMaterno.focus();
						}
					}
				}
		});
		
		var txtApellidoMaterno = new Ext.form.TextField({
				name: 'apellidomaterno',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 100,
				readOnly:true,
				maxLength:100,
				style : {textTransform: "uppercase"},				
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtcorreo.focus();
						}
					}
				}
		});
		var txtcorreo = new Ext.form.TextField({
				name: 'correo',
				hideLabel: true,		
				width: 250,
				x: 110,
				y: 130,
				maxLength:100,
				//style : {textTransform: "uppercase"},				
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtUsuario.focus();
						}
					}
				}
		});		
		var txtUsuario = new Ext.form.TextField({
				name: 'usuario',
				hideLabel: true,		
				width: 150,
				x: 110,
				y: 160,
				allowBlank: false,
				maxLength:50,
				//style : {textTransform: "uppercase"},
				blankText: 'Usuario requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtContrasenia.focus();
						}
					}
				}
		});
		
		var txtContrasenia = new Ext.form.TextField({
				name: 'contrasenia',
				hideLabel: true,		
				width: 150,
				x: 110,
				y: 190,
				allowBlank: false,
				inputType:'password', 
				blankText: 'Contraseña requerido',
				maxLength:50,
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
			y: 220,
			width : 200,
			mode: 'local',
		    hiddenName: 'tusuario',
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
						btnAceptar.focus(true, 300);
					}
			}					
		});			
		// Labels	
		var lblPersonal = new Ext.form.Label({
			text: 'Personal :',
			x: 10,
			y: 15,
			height: 20,
			cls: 'x-label'
		});
		
		var lblNombre = new Ext.form.Label({
			text: 'Nombre :',
			x: 10,
			y: 45,
			height: 20,
			cls: 'x-label'
		});
		
		var lblApellidoPaterno = new Ext.form.Label({
			text: 'Apellido Paterno :',
			x: 10,
			y: 75,
			height: 20,
			cls: 'x-label'
		});
		
		var lblApellidoMaterno = new Ext.form.Label({
			text: 'Apellido Materno :',
			x: 10,
			y: 105,
			height: 20,
			cls: 'x-label'
		});
		
		var lblCorreo = new Ext.form.Label({
			text: 'Correo :',
			x: 10,
			y: 135,
			height: 20,
			cls: 'x-label'
		});
		
		var lblUsuario = new Ext.form.Label({
			text: 'Usuario :',
			x: 10,
			y: 165,
			height: 20,
			cls: 'x-label'
		});
		
		var lblContrasenia = new Ext.form.Label({
			text: 'Contraseña :',
			x: 10,
			y: 195,
			height: 20,
			cls: 'x-label'
		});
		
		var lblTipoUsuario = new Ext.form.Label({
			text: 'Tipo Usuario :',
			x: 10,
			y: 225,
			height: 20,
			cls: 'x-label'
		});	

		// botones
		var btnAceptar = new Ext.Button(
		{
		    id: 'btnAceptar',
			x: 110,
			y: 255,
			text: 'Aceptar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{
				frmAltaUsuario.Insertar();
			} 
		});
		
		var btnLimpiar = new Ext.Button(
		{
		    id: 'btnLimpiar',
			x: 200,
			y: 255,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{				
				var frm = frmAltaUsuario.getForm();
				frm.reset();
				frm.clearInvalid();
				winAltaUsuario.hide();
			} 
		});	
		
		
		var frmAltaUsuario = new Ext.FormPanel(
		{ 
			frame:true, 		
			layout: 'absolute',
			items:[
					lblPersonal,lblNombre, lblApellidoPaterno, lblApellidoMaterno, lblUsuario, lblContrasenia, lblTipoUsuario, lblCorreo,
					cboPer,txtNombre, txtApellidoPaterno, txtApellidoMaterno, txtUsuario, txtContrasenia, cboTipoUsuario, txtcorreo,
					btnAceptar, btnLimpiar
				  ],
			Insertar: function()
			{				
				if (this.getForm().isValid()) 
				{
					this.getForm().submit(
					{						
						url: '../servicesAjax/DSAltaUsuarioAJAX.php',	
						params :{cod_personal:storePersona.getAt(indice).get('codigo')},	
						method: 'POST',						
						waitTitle: 'Conectando',
						waitMsg: 'Enviando Datos...',
						success: function(form, action)
						{							
							winAltaUsuario.hide();		
							Ext.namespace.storeUsuario.load({params:{start:0,limit:25}});																
						},					
						failure: function(form, action)
						{
							if (action.failureType == 'server') 
							{
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('ARG', data.errors.reason, function()
								{
									txtNombre.focus(true, 100);
								});
							}
							else 
							{
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}
							//frmAltaUsuario.getForm().reset();
						}
					});
				}
			}
		});
			
		
        function AltaUsuario()
		{		
			if (!winAltaUsuario) 
			{
				winAltaUsuario = new Ext.Window(
				{
					layout: 'fit',
					width: 400,
					height: 330,		
					title: 'Alta Usuario',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,					
					items: [frmAltaUsuario],
					listeners: 
					{
						hide: function()
						{							
							var frm = frmAltaUsuario.getForm();
							frm.reset();
							frm.clearInvalid();
						},
						show: function()
						{					
							txtNombre.focus(true,100);
						}
					}
				});
				
			}			
			winAltaUsuario.show();
		}
