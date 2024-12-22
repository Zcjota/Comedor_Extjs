/*!
 * DSoft-RBJ
 * Copyright(c) 2012
 */
  	var winPuertos;
	
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
							txtIpO1.focus(true, 300);
						}
					}
				}
		});	
		
		var txtIpO1 = new Ext.form.TextField({
				name: 'O1',
				//hideLabel: true,	
				maxLength : 3,
				width: 30,
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
							txtIpO2.focus(true, 300);
						}
					}
				}
		});	
		var txtIpO2 = new Ext.form.TextField({
				name: 'O2',
				//hideLabel: true,	
				maxLength : 3,
				width: 30,
				x: 135,
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
							txtIpO3.focus(true, 300);
						}
					}
				}
		});	
		var txtIpO3 = new Ext.form.TextField({
				name: 'O3',
				//hideLabel: true,	
				maxLength : 3,
				width: 30,
				x: 170,
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
							txtIpO4.focus(true, 300);
						}
					}
				}
		});	
		var txtIpO4 = new Ext.form.TextField({
				name: 'O4',
				//hideLabel: true,	
				maxLength : 3,
				width: 30,
				x: 205,
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
		var lblIP = new Ext.form.Label({
			text: 'IP :',
			x: 10,
			y: 50,
			height: 20,
			cls: 'namelabel',
		});
		
		// botones

		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 90,
			y: 90,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmReloj.guardarDatos();

			} 
		});		
		
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 180,
			y: 90,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmReloj.getForm();
				frm.reset();
				frm.clearInvalid();
				winPuertos.hide();
			} 
		});		
		
		var frmReloj = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[	lblNombre,lblIP,
					txtDescripcion,txtIpO1,txtIpO2, txtIpO3,txtIpO4,
					btnAceptar, btnLimpiar],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmRelojComedorAJAX.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmReloj.getForm();
								frm.reset();
								frm.clearInvalid();
								winPuertos.hide();
								
								Ext.dsdata.storeReloj.load({params:{start:0,limit:25}});
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
		
        function NuevoReloj(){	
        	
			if (!winPuertos) {
			
				winPuertos = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 160,		
					title: 'Registro de Reloj',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmReloj],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			
			txtDescripcion.setValue("");
			txtIpO1.setValue("");
			txtIpO2.setValue("");
			txtIpO3.setValue("");
			txtIpO4.setValue("");
			opcion = 0;
			winPuertos.show();
		}
		
		function modReloj(indice){		
			if (!winPuertos) {
				winPuertos = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 160,		
					title: 'Modificar Reloj',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmReloj],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}	
			opcion = 1;			
			codigo = Ext.dsdata.storeReloj.getAt(indice).get('codigo');
			txtDescripcion.setValue(Ext.dsdata.storeReloj.getAt(indice).get('descripcion'));
			txtIpO1.setValue(Ext.dsdata.storeReloj.getAt(indice).get('oct1'));
			txtIpO2.setValue(Ext.dsdata.storeReloj.getAt(indice).get('oct2'));
			txtIpO3.setValue(Ext.dsdata.storeReloj.getAt(indice).get('oct3'));
			txtIpO4.setValue(Ext.dsdata.storeReloj.getAt(indice).get('oct4'));
			

			winPuertos.show();
		}
