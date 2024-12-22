/*!
 *INTECRUZ-CACC
 * Copyright(c) 2012
 */
  	var winProveedor;
	
		var codigo;
		var opcion;

		var txtNombre = new Ext.form.TextField({
				name: 'txtNombre',
				maxLength : 150,
				width: 260,
				x: 100,
				y: 15,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
						  txtRepresentate.focus(true, 300);
						}
					}
				}
		});	
		var txtRepresentate = new Ext.form.TextField({
				name: 'txtRepresentate',
				maxLength : 150,
				width: 260,
				x: 100,
				y: 45,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
						  txtNit.focus(true, 300);
						}
					}
				}
		});	
		var txtNit = new Ext.form.TextField({
				name: 'txtNit',
				maxLength : 150,
				width: 260,
				x: 100,
				y: 75,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtDireccion.focus(true, 300);
						}
					}
				}
		});	
		var txtDireccion = new Ext.form.TextField({
				name: 'txtDireccion',
				maxLength : 150,
				width: 260,
				x: 100,
				y: 105,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
						 btnAceptar.focus(true, 300);
						}
					}
				}
		});	
		// Labels
		
		var lblNombre = new Ext.form.Label({
			text: 'NOMBRE :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel',
		});	
		var lblRepresentante = new Ext.form.Label({
			text: 'REPRESENTANTE  :',
			x: 10,
			y: 50,
			height: 20,
			cls: 'namelabel',
		});	
		var lblNit = new Ext.form.Label({
			text: 'NIT  :',
			x: 10,
			y: 80,
			height: 20,
			cls: 'namelabel',
		});	
		var lblDireccion = new Ext.form.Label({
			text: 'DIRECCION  :',
			x: 10,
			y: 110,
			height: 20,
			cls: 'namelabel',
		});	
		
		// botones

		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 100,
			y: 60,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmproveedor.guardarDatos();

			} 
		});		
		
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 190,
			y: 60,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmproveedor.getForm();
				frm.reset();
				frm.clearInvalid();
				winProveedor.hide();
			} 
		});		
		
		var frmproveedor = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[	lblNombre,lblRepresentante,lblNit,lblDireccion,
					txtNombre,txtRepresentate,txtNit,txtDireccion
				  ],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmProveedorAjax.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmproveedor.getForm();
								frm.reset();
								frm.clearInvalid();
								winProveedor.hide();
								
								Ext.dsdata.storeProveedor.load({params:{start:0,limit:25}});
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									txtNombre.focus(true, 100);
								});
							}
							else {
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}					
						}
					});
				}
			}
		});		
		
        function NuevoProveedor(){	
        	
			if (!winProveedor) {
			
				winProveedor = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 210,		
					title: 'PROVEEDOR',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,					
					items: [frmproveedor],
					buttonAlign:'center',
				    buttons:[btnAceptar, btnLimpiar],
					listeners: {				
						show: function(){
							txtNombre.focus(true, 300);
						}
					}
				});
			}		
			
			txtNombre.setValue("");
			txtRepresentate.setValue("");
			txtNit.setValue("");
			txtDireccion.setValue("");
			opcion = 0;
			winProveedor.show();
		}
		
		function modProveedor(indice){		
			if (!winProveedor) {
				winProveedor = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 210,		
					title: 'PROVEEDOR',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,
					items: [frmproveedor],
					buttonAlign:'center',
				    buttons:[btnAceptar, btnLimpiar],
					listeners: {				
						show: function(){
							txtNombre.focus(true, 300);
						}
					}
				});
			}		
			opcion = 1;			
			codigo = Ext.dsdata.storeProveedor.getAt(indice).get('codigo');
			txtNombre.setValue(Ext.dsdata.storeProveedor.getAt(indice).get('nombre'));
			txtRepresentate.setValue(Ext.dsdata.storeProveedor.getAt(indice).get('representa_legal'));
			txtNit.setValue(Ext.dsdata.storeProveedor.getAt(indice).get('nit'));
			txtDireccion.setValue(Ext.dsdata.storeProveedor.getAt(indice).get('direccion'));
			winProveedor.show();
		}
