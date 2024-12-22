/*!
 * DSoft-RBJ
 * Copyright(c) 2012
 */
  	var winSubcentro;
	
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
							//cboPais.focus(true, 300);
						}
					}
				}
		});	
		// Labels
		
		var lblNombre = new Ext.form.Label({
			text: 'Descripcion :',
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
				frmSubcentro.guardarDatos();

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
				var frm = frmSubcentro.getForm();
				frm.reset();
				frm.clearInvalid();
				winSubcentro.hide();
			} 
		});		
		
		var frmSubcentro = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[	lblNombre,
					txtDescripcion,  
					btnAceptar, btnLimpiar],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmSubcentroAjax.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmSubcentro.getForm();
								frm.reset();
								frm.clearInvalid();
								winSubcentro.hide();
								
								Ext.dsdata.storeSubcentro.load({params:{start:0,limit:25}});
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
		
        function NuevoSubcentro(){	
        	
			if (!winSubcentro) {
			
				winSubcentro = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 150,		
					title: 'Registrar Subcentro',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmSubcentro],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			
			txtDescripcion.setValue("");
			opcion = 0;
			winSubcentro.show();
		}
		
		function modSubcentro(indice){		
			if (!winSubcentro) {
				winSubcentro = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 160,		
					title: 'Modificar Subcentro',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmSubcentro],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			opcion = 1;			
			codigo = Ext.dsdata.storeSubcentro.getAt(indice).get('codigo');
			txtDescripcion.setValue(Ext.dsdata.storeSubcentro.getAt(indice).get('descripcion'));
			
			winSubcentro.show();
		}
