
  var winDependienteActualizar;
		//DEPENDIENTES
		var lblnombre_dependiente_act = new Ext.form.Label({
			html: 'NOMBRE :',
			x: 10,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblparentesco_dependiente_act = new Ext.form.Label({
			html: 'PARENTESCO :',
			x: 10,
			y: 45,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblci_dependiente_act = new Ext.form.Label({
			html: 'CI :',
			x: 10,
			y: 75,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblfv_dependiente_act = new Ext.form.Label({
			html: 'FECHA NAC. :',
			x: 10,
			y: 105,
			height: 20,
			cls: 'namelabel',
			
		});
		var txtNombre_dependiente_act = new Ext.form.TextField({
			name: 'txtNombre_dependiente_act',
			maxLength : 30,
			width: 200,
			x: 130,
			y: 15,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			//blankText: 'Campo requerido',
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
		var storeParentesco_dependiente_act = new Ext.data.SimpleStore(
			{
				fields: ['codigop', 'nombrep'],
				data : [					
							['1', 'PADRE'],			
							['2', 'MADRE'],
							['3', 'ESPOSO/A'],
							['4', 'HIJO/A'],
							['5', 'HERMANO/A'],
							['6', 'TÍO/A'],
					],   
				autoLoad: false 		
		});	
	
			var cboparentesco_dependiente_act= new Ext.form.ComboBox(
			{  
				y : 45,
				x: 130,	 				
				width : 100,
				store: storeParentesco_dependiente_act, 
				mode: 'local',
				//autocomplete : true,
			//	allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'PARENTESCO...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cboparentesco_dependiente',
				//selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
								'select': function(cmb,record,index){
								
								
								}	 
				}		
			});	
			var txtci_dependiente_act = new Ext.form.TextField({
				name: 'txtci_dependiente_act',
				maxLength : 30,
				width: 100,
				x: 130,
				y: 75,
				allowBlank: true,
				style : {textTransform: "uppercase"},
				//blankText: 'Campo requerido',
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
			var txtFechaVenc_dependiente_act= new Ext.form.DateField({
				name: 'txtFechaVenc_dependiente_act',
				hideLabel: true, 
				maxLength : 10,
				width: 91,
				y : 105,
				x: 130,		
				format : 'd/m/Y',
				allowBlank: true,		
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
			var btnAceptar_depediente_act = new Ext.Button({
				id: 'btnAceptar_depediente_act',
				x: 100,
				y: 230,
				text: 'Aceptar',
				icon: '../img/save.png',
				iconCls: 'x-btn-text-icon',
				minWidth: 80,
				handler:function(){
					registros_dep = [];
					if(txtNombre_dependiente_act.getValue()!="" && cboparentesco_dependiente_act.getValue()!=""  && txtFechaVenc_dependiente_act.getValue()!=""){
						storeDetalleDependiente.each(function(record){
							if(record.data.codigop ==codigop){
								registro = new Array(13);
								dimension = registros_dep.length;
								
								registro[0] = codigop;
								registro[1] = (txtNombre_dependiente_act.getValue()).toUpperCase();
								registro[2] = cboparentesco_dependiente_act.getRawValue();
								registro[3] = txtci_dependiente_act.getValue();
								registro[4] = txtFechaVenc_dependiente_act.getValue().format('d-m-Y');
								registro[5] = cboparentesco_dependiente_act.getValue();
								registros_dep[dimension] = registro;
								
							}
							else
							{
								registro = new Array(13);
								dimension = registros_dep.length;
								
								registro[0] = record.data.codigop;
								registro[1] = record.data.nombrep;
								registro[2] = record.data.parentescop;
								registro[3] = record.data.cip;
								registro[4] = record.data.fecha_venc_p;
								registro[5] = record.data.idparentescop;
								
								registros_dep[dimension] = registro;
							}
							
						});
						storeDetalleDependiente.loadData(registros_dep);
						var frm = frmActualizarDependiente.getForm();
						frm.reset();
						frm.clearInvalid();
						winDependienteActualizar.hide();
					}
					else
					{
						Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Existen campos obligatorios. Complete los datos para continuar.</a>'); 
					}
	
				} 
			});		
			
			var btnLimpiar_dep_actualizar = new Ext.Button({
				id: 'btnLimpiar_dep_actualizar',
				x: 190,
				y: 230,
				text: 'Cancelar',
				icon: '../img/delete.png',
				iconCls: 'x-btn-text-icon',
				minWidth: 80,
				handler:function(){
					var frm = frmActualizarDependiente.getForm();
					frm.reset();
					frm.clearInvalid();
					winDependienteActualizar.hide();
				} 
			});	

		var frmActualizarDependiente = new Ext.FormPanel({ 
			frame:true, 
			selectOnFocus: true,
			layout: 'absolute',
			width: 600,
			height: 400,
			items:[ lblnombre_dependiente_act,lblparentesco_dependiente_act,lblci_dependiente_act,lblfv_dependiente_act,
				txtNombre_dependiente_act,cboparentesco_dependiente_act,txtci_dependiente_act,txtFechaVenc_dependiente_act]
		});	
	
		var codigop=0;
		var indice_act=0;	
		function ActualizarDependiente(indi)
		{	

			if (!winDependienteActualizar) 
			{
				winDependienteActualizar = new Ext.Window(
				{
					layout: 'form',
					width: 400,
					height: 230,		
					title: 'ACTUALIZAR',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,					
					items: [frmActualizarDependiente],
					buttonAlign:'center',
					buttons:[btnAceptar_depediente_act, btnLimpiar_dep_actualizar],
					listeners: {					
						show: function(){
							
						}
					}
				});			
			}
			indice_act=	indi;
			codigop=storeDetalleDependiente.getAt(indi).get('codigop');
			
			txtNombre_dependiente_act.setValue(storeDetalleDependiente.getAt(indi).get('nombrep'));
			cboparentesco_dependiente_act.setValue(storeDetalleDependiente.getAt(indi).get('idparentescop'));
			txtci_dependiente_act.setValue(storeDetalleDependiente.getAt(indi).get('cip'));
			txtFechaVenc_dependiente_act.setValue(storeDetalleDependiente.getAt(indi).get('fecha_venc_p'));
			
			winDependienteActualizar.show();				
		}
	
	
		

       
		