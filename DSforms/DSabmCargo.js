/*!
 * DSoft-RBJ
 * Copyright(c) 2012
 */
  	var winCargo;
	
		var codigo;
		var opcion;

		var txtDescripcion = new Ext.form.TextField({
				name: 'des',
				//hideLabel: true,	
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
							cboPais.focus(true, 300);
						}
					}
				}
		});	
		// Labels
		
		var lblNombre = new Ext.form.Label({
			text: 'DESCRIPCION :',
			x: 10,
			y: 20,
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
				frmCargo.guardarDatos();

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
				var frm = frmCargo.getForm();
				frm.reset();
				frm.clearInvalid();
				winCargo.hide();
			} 
		});		
		
		var frmCargo = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[	lblNombre,
					txtDescripcion,  
					btnAceptar, btnLimpiar],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmCargoAjax.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmCargo.getForm();
								frm.reset();
								frm.clearInvalid();
								winCargo.hide();
								
								Ext.dsdata.storeCargo.load({params:{start:0,limit:25}});
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									txtDescripcion.focus(true, 100);
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
		
        function NuevoCargo(){	
        	
			if (!winCargo) {
			
				winCargo = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 150,		
					title: 'Registrar Cargo',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmCargo],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			
			txtDescripcion.setValue("");
			opcion = 0;
			winCargo.show();
		}
		
		function modCargo(indice){		
			if (!winCargo) {
				winCargo = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 160,		
					title: 'Modificar Cargo',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmCargo],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			opcion = 1;			
			codigo = Ext.dsdata.storeCargo.getAt(indice).get('codigo');
			txtDescripcion.setValue(Ext.dsdata.storeCargo.getAt(indice).get('descripcion'));
			
			winCargo.show();
		}
