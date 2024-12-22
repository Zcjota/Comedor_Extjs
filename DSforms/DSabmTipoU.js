
  	var winTipoU;
	
		var codigo;
		var opcion;

		var txtNombre = new Ext.form.TextField({
				name: 'nom',
				hideLabel: true,	
				maxLength : 150,    
				width: 230,
				x: 100,
				y: 15,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							btnAceptar.focus();
						}
					}
				}
		});		
		
		
			
		// Labels
		var lblNombre = new Ext.form.Label({
			text: 'Nombre:',
			x: 10,
			y: 20,
			height: 70,
			cls: 'x-label'
		});			
		// botones

		var btnAceptar = new Ext.Button({
		    id: 'btnAceptarTu',
			x: 100,
			y: 50,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmTipoU.guardarDatos();
			} 
		});		
		
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiarTu',
			x: 190,
			y: 50,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmTipoU.getForm();
				frm.reset();
				frm.clearInvalid();
				winTipoU.hide();
			} 
		});		
		
		var frmTipoU = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[lblNombre,
					txtNombre,
					btnAceptar, btnLimpiar],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmTipoUAJAX.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmTipoU.getForm();
								frm.reset();
								frm.clearInvalid();
								winTipoU.hide();
								Ext.dsdata.frmTipoU.load({params:{start:0,limit:25}});
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
		
        function altaTipoU(){		
			if (!winTipoU) {
				winTipoU = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 150,		
					title: 'Perfil Usuario',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,		
					modal: true,
					items: [frmTipoU],
					listeners: {				
						show: function(){
							txtNombre.focus(true, 300);
						}
					}
				});
			}		
			opcion = 0;
			winTipoU.show();
		}
		
		function modTipoU(indice){		
			if (!winTipoU) {
				winTipoU = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 150,		
					title: 'Perfil Usuario',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,				
					modal: true,					
					items: [frmTipoU],
					listeners: {				
						show: function(){
							txtNombre.focus(true, 300);
							}
					}
				});
			}		
			opcion = 1;			
			codigo = Ext.dsdata.frmTipoU.getAt(indice).get('codigo');
			txtNombre.setValue(Ext.dsdata.frmTipoU.getAt(indice).get('nombre'));					
			winTipoU.show();
		}
