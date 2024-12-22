/*!
 * DSoft-RBJ
 * Copyright(c) 2012
 */
  	var winCentroCosto;
	
		var codigo;
		var opcion;

		var txtDescripcion = new Ext.form.TextField({
				name: 'des',
				//hideLabel: true,	
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
							//cboPais.focus(true, 300);
						}
					}
				}
		});	
		///////////////
		
			var txtcodigobase= new Ext.form.TextField(
			{   
				x: 100,
				y: 105,		
				name: 'txtcodigobase',
				//hideLabel: true,	
				maxLength : 150,
				width: 260,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					
				
				}		
			});	
			
			
		// Labels
		var storeSubcentro= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaSubcCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
	storeSubcentro.load();

		var cboSubCentro= new Ext.form.ComboBox(
		{   
			// x: 140,
			// y: 15,	
			x: 100,
			y: 45,		
			width : 185,
			store: storeSubcentro, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione SUBCENTRO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbsubcentro',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
				
			
			}		
			});	
		var storeCentroCosto= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaUnidadCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeCentroCosto.load();

		var cboUnidad = new Ext.form.ComboBox(
		{   		
			x: 100,
			y: 15,	
			// x: 470,
			// y: 15,
			width : 260,
			store: storeCentroCosto, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione UNIDAD...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbunidad',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
			  
			}		
			});	
		var lblNombre = new Ext.form.Label({
			text: 'Subcentro :',
			x: 10,
			y: 50,
			height: 20,
			cls: 'namelabel',
		});	
		var lblNombreUnidad = new Ext.form.Label({
			text: 'Unidad :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel',
		});	
		var lblNombreCosto = new Ext.form.Label({
			text: 'Centro Costo :',
			x: 10,
			y: 80,
			height: 20,
			cls: 'namelabel',
		});	

		var lblCuentaContable = new Ext.form.Label({
			text: 'Código Base :',
			x: 10,
			y: 110,
			height: 20,
			cls: 'namelabel',
		});	
		// botones

		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 100,
			y: 170,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmCentroCosto.guardarDatos();

			} 
		});		
		
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 190,
			y:170,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmCentroCosto.getForm();
				frm.reset();
				frm.clearInvalid();
				winCentroCosto.hide();
			} 
		});		
		
		var frmCentroCosto = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[	lblNombre,lblNombreUnidad,lblNombreCosto,lblCuentaContable,	
					cboUnidad,cboSubCentro,txtDescripcion,	
					txtcodigobase,				
					btnAceptar, btnLimpiar
				],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmCentroAjax.php',						
						params :{codigo: codigo, opcion: opcion},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmCentroCosto.getForm();
								frm.reset();
								frm.clearInvalid();
								winCentroCosto.hide();
								
								Ext.dsdata.storeCentroCosto.load({params:{start:0,limit:25}});
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
		
        function NuevoCentro(){	
        	
			if (!winCentroCosto) {
			
				winCentroCosto = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 260,		
					title: 'Registrar Centro',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,								
					items: [frmCentroCosto],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			txtcodigobase.setValue("");
			txtDescripcion.setValue("");
			cboSubCentro.setValue("");
			cboUnidad.setValue("");
			opcion = 0;
			winCentroCosto.show();
		}
		
		function modCentro(indice){		
			if (!winCentroCosto) {
				winCentroCosto = new Ext.Window({
					layout: 'fit',
					width: 400,
					height: 260,		
					title: 'Modificar Centro',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,	
					modal: true,							
					items: [frmCentroCosto],
					listeners: {				
						show: function(){
							txtDescripcion.focus(true, 300);
						}
					}
				});
			}		
			opcion = 1;			
			codigo = Ext.dsdata.storeCentroCosto.getAt(indice).get('codigo');
			txtDescripcion.setValue(Ext.dsdata.storeCentroCosto.getAt(indice).get('descripcion'));
			cboSubCentro.setValue(Ext.dsdata.storeCentroCosto.getAt(indice).get('codsubcentro'));
			cboUnidad.setValue(Ext.dsdata.storeCentroCosto.getAt(indice).get('codunidad'));
			txtcodigobase.setValue(Ext.dsdata.storeCentroCosto.getAt(indice).get('codigo_base'));
			winCentroCosto.show();
		}
