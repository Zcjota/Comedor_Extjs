/*!
 * DSoft-RBJ
 * Copyright(c) 2012
 */
  	var winHorarioComedor;
	
		var codigo;
		var opcion;

		var txtDescripcion_Hc = new Ext.form.TextField({
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
		var txtHorario=  new Ext.form.TimeField({
				fieldLabel: 'Time Field',
				x: 100,
				y: 45,
				width: 100,
			   //minValue: '4:00',
			  // maxValue: '23:59',
			   increment: 15,
			   format:'H:i',
			   name:'txtHorario',
				cls :'name',			   
		});
		var txtHorarioFin=  new Ext.form.TimeField({
				fieldLabel: 'Time Field',
				x: 100,
				y: 75,
				width: 100,
			   //minValue: '4:00',
			  // maxValue: '23:59',
			   increment: 15,
			   format:'H:i',
			   name:'txtHorarioFin',
				cls :'name',			   
		});
		// Labels
		
		var lblNombre_Comedor = new Ext.form.Label({
			text: 'NOMBRE :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel',
		});	
		var lblHorario_Comedor = new Ext.form.Label({
			text: 'HORA INICIO :',
			x: 10,
			y: 50,
			height: 20,
			cls: 'namelabel',
		});	
		var lblHorario_Comedor_fin = new Ext.form.Label({
			text: 'HORA FIN :',
			x: 10,
			y: 80,
			height: 20,
			cls: 'namelabel',
		});	
		// botones

		var btnAceptar_Hc = new Ext.Button({
		    id: 'btnAceptar_Hc',
			x: 100,
			y: 120,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmHorarioComedor.guardarDatos();

			} 
		});		
		
		var btnLimpiar_Hc = new Ext.Button({
		    id: 'btnLimpiar_Hc',
			x: 190,
			y: 120,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmHorarioComedor.getForm();
				frm.reset();
				frm.clearInvalid();
				winHorarioComedor.hide();
			} 
		});		
		
		var frmHorarioComedor = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[	lblNombre_Comedor,lblHorario_Comedor,lblHorario_Comedor_fin,
					txtDescripcion_Hc, txtHorario, txtHorarioFin,
					btnAceptar_Hc, btnLimpiar_Hc],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmHorarioComedorAjax.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmHorarioComedor.getForm();
								frm.reset();
								frm.clearInvalid();
								winHorarioComedor.hide();
								
								Ext.dsdata.storeHorario_Comedor.load({params:{start:0,limit:25}});
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									txtDescripcion_Hc.focus(true, 100);
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
		
        function NuevoHorarioComedor(){	
        	
			if (!winHorarioComedor) {
			
				winHorarioComedor = new Ext.Window({
					layout: 'fit',
					width: 400,
					height:195,		
					title: 'Registrar Horario',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmHorarioComedor],
					listeners: {				
						show: function(){
							txtDescripcion_Hc.focus(true, 300);
						}
					}
				});
			}		
			
			txtDescripcion_Hc.setValue("");
			txtHorario.setValue("");
			txtHorarioFin.setValue("");
			opcion = 0;
			winHorarioComedor.show();
		}
		
		function modHorario(indice){		
			if (!winHorarioComedor) {
				winHorarioComedor = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 195,		
					title: 'Modificar Horario',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmHorarioComedor],
					listeners: {				
						show: function(){
							txtDescripcion_Hc.focus(true, 300);
						}
					}
				});
			}		
			opcion = 1;			
			codigo = Ext.dsdata.storeHorario_Comedor.getAt(indice).get('codigo');
			txtDescripcion_Hc.setValue(Ext.dsdata.storeHorario_Comedor.getAt(indice).get('descripcion'));
			txtHorario.setValue(Ext.dsdata.storeHorario_Comedor.getAt(indice).get('horario'));
			txtHorarioFin.setValue(Ext.dsdata.storeHorario_Comedor.getAt(indice).get('horario_fin'));
			
			winHorarioComedor.show();
		}
