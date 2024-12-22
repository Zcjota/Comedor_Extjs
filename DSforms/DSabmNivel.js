	    var winNivel;
		var codigo;
		var opcion;
		var txtCategoria = new Ext.form.TextField({
			name: 'txtCategoria',
			maxLength : 150,
			width: 250,
			x: 140,
			y: 20,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls: 'name',
			listeners: {
			
			}
		});	
		var txtNivel = new Ext.form.TextField({
			name: 'txtNivel',
			maxLength : 150,
			width: 120,
			x: 140,
			y: 50,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			style: 'text-align: right',
			selectOnFocus: true,
			cls: 'name',
			listeners: {
			}
		});	
			var txtMidpoint = new Ext.form.NumberField({
				allowDecimals: false,
				allowBlank: false,
				decimalPrecision :2,
				allowNegative: false,
				name: 'txtMidpoint',
				hideLabel: true,		
				maxLength : 20,	
				align: 'right',
				x: 140,
				y: 80,
				width: 120,
				value : 0,
				forceDecimalPrecision : true,
				style: 'text-align: right',
				//style : {textTransform: "uppercase"},			
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							
						}
					}
				}
			});
		// Labels
		
		var lblcategoria = new Ext.form.Label({
			text: 'CATEGORIA :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel',
			html: 'CATEGORIA :',

		});	
		var lblnivel = new Ext.form.Label({
			text: ' ',
			x: 10,
			y: 50,
			height: 20,
			cls: 'namelabel',
			html: 'NIVEL :',

		});	
		var lblmidpoint = new Ext.form.Label({
			text: ' ',
			x: 10,
			y: 80,
			height: 20,
			cls: 'namelabel',
			html: 'MIDPOINT :',

		});	
		
		// botones

		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 100,
			y: 230,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmNivel.guardarDatos();

			} 
		});		
		
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 190,
			y: 230,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmNivel.getForm();
				frm.reset();
				frm.clearInvalid();
				winNivel.hide();
			} 
		});		
		
		var frmNivel = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			height: 190,
			items:[	lblcategoria,lblnivel,lblmidpoint,
					txtCategoria,txtNivel,txtMidpoint	
				],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmNivelAjax.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var data = Ext.util.JSON.decode(action.response.responseText);
								resp = data.message.reason;
									var frm = frmNivel.getForm();
									frm.reset();
									frm.clearInvalid();
									winNivel.hide();
									Ext.dsdata.storeNivelJerarquico.load({params:{start:0,limit:25}});
								
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									
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
		
        function NuevaNivel(){	
        	//if (!winNivel) {
				winNivel = new Ext.Window({
					layout: 'form',
					width: 450,
					height: 200,		
					title: 'NIVEL',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,		
					modal: true,							
					items: [frmNivel],
					buttonAlign:'center',
					buttons:[btnAceptar, btnLimpiar],
					listeners: {				
						show: function(){
							
							
						}
					}
				});
			//}	
			txtCategoria.setValue('');
			txtNivel.setValue('');
			txtMidpoint.setValue('');
			opcion = 0;
			winNivel.show();
		}
		
		function modNivel(indice){		
			//if (!winNivel) {
				winNivel = new Ext.Window({
					layout: 'form',
					width: 450,
					height: 200,		
					title: 'NIVEL',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,	
					modal: true,							
					items: [frmNivel],
					buttonAlign:'center',
					buttons:[btnAceptar, btnLimpiar],
					listeners: {				
						show: function(){
							
						}
					}
				});
			//}
				
			opcion = 1;			
			codigo = Ext.dsdata.storeNivelJerarquico.getAt(indice).get('COD_NIVEL');
			txtCategoria.setValue(Ext.dsdata.storeNivelJerarquico.getAt(indice).get('CATEGORIA'));
			txtNivel.setValue(Ext.dsdata.storeNivelJerarquico.getAt(indice).get('NOMBRE_NIVEL'));
			txtMidpoint.setValue(Ext.dsdata.storeNivelJerarquico.getAt(indice).get('midpoint'));
			winNivel.show();
		}
