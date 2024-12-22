/*!
 * DS- TPMV
 * Copyright(c) 2012
 */
  	var winPedidoComedor;
			Ext.apply(Ext.form.VTypes, {
			daterange: function (val, field) {
				var date = field.parseDate(val);

				if (!date) {
					return;
				}
				if (field.startDateField && (!this.dateRangeMax || (date.getTime() !== this.dateRangeMax.getTime()))) {
					var start = Ext.getCmp(field.startDateField);
					start.setMaxValue(date);
					start.validate();
					this.dateRangeMax = date;
				}
				else if (field.endDateField && (!this.dateRangeMin || (date.getTime() !== this.dateRangeMin.getTime()))) {
					var end = Ext.getCmp(field.endDateField);
					end.setMinValue(date);
					end.validate();
					this.dateRangeMin = date;
				}
				return true;
			}
		});
		var opcion;
		var registros = new Array(); 
		var registrosb = new Array(); 
     	var rowIndex;
	   var fm = Ext.form;
		var storePersonaL= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaPersonalInformePedidoGRAJAX.php',   
			root: 'data',  
			totalProperty: 'total',		
			fields: ['codigo', 'nombre','nombreP','app','apm','codtrabajador','cargo','unidad','subcentro','centro'],
				
		});		
		 storePersonaL.load();
		
		var cboPer = new Ext.form.ComboBox(
		{   		
			x: 100,
			y: 15,		
			width : 310,
			store: storePersonaL, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Personal...',   
			triggerAction: 'all',   		
			displayField:'nombre',   
			//typeAhead: true,
			valueField: 'codtrabajador',
			hiddenName : 'cbpersonal',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name1",
			listeners: {
						'select': function(cmb,record,index)
								{                    

								}
							    
			}		
		});		
		var storePedidoPersonal = new Ext.data.ArrayStore({// Ext.create('Ext.data.ArrayStore',{  
			fields: [ 
			   {name: 'codigop'},
			    {name: 'nombrep'}
			   
			],  
			id: 0
		});
	
			var ColumnasP = new Ext.grid.ColumnModel(  
			[	
			{  
                header: 'Codigo',  
                dataIndex: 'codigop',                
                hidden: true
            },
			
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Personal</a>',
                dataIndex: 'nombrep',  
				renderer: formatop, 
                width:380,
                sortable: true
			}
			
			
			]  
			);
		function formatop(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}	
		var GridPedido = new Ext.grid.EditorGridPanel({  
			id: 'GridPedido',
			y:45,
			x:10,
			width :400,	
			height : 130,
			
			store: storePedidoPersonal,
							
			cm: ColumnasP,
			
		
			sm: new Ext.grid.RowSelectionModel(
			{
                singleSelect: true,
                listeners: 
				{
					rowselect: function(sm, row, rec) 
					{                        
						rowIndex = row;	
						
							
                    }
                }
            }),
			border: false,   
			enableColLock:false,
			stripeRows: false,
			clicksToEdit: 1
	
			 
		});			
		var storeTipoPedido = new Ext.data.SimpleStore(
		{
			fields: ['codigop', 'nombrep'],
			data : [					
									
						['1', 'DIETA'],
						
				],   
			autoLoad: false 		
		});
		

		var cboTipoPedido = new Ext.form.ComboBox(
		{   		
			x: 100,
			y: 190,	
			width : 250,
			store: storeTipoPedido, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'TIPO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbtipo',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name1",
			listeners: {
						'select': function(cmb,record,index)
								{                        
									
								}
							    
			}		
		});
		var txtFechaDe = new Ext.form.DateField(
		{
			name: 'fechaini',
			hideLabel: true, 
			maxLength :10,
			width:100,
			allowBlank: false,
			id: 'startdtVAK',
			vtype: 'daterange',
			endDateField: 'enddtVAK', // id of the end date field
			x: 100,		
			y : 220,	
			
			value: new Date().format('d/m/Y'),
			format : 'd/m/Y',
			minValue: new Date().format('d/m/Y'),
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
												
					}
				}
			}				
		});
		var txtFechaHasta = new Ext.form.DateField(
		{
			name: 'fechahasta',
			hideLabel: true, 
			maxLength :10,
			width:100,
			allowBlank: false,
			id: 'enddtVAK',
			vtype: 'daterange',
			startDateField: 'startdtVAK', // id of the start date field	
			minValue: new Date(),			
			x: 100,		
			y : 250,	
			value: new Date().format('d/m/Y'),
			format : 'd/m/Y',
			
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
											
					}
				}
			}				
		});

					
		// Labels
		var lblPersonal = new Ext.form.Label({
			text: 'PERSONAL :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'x-label'
		});
		
		var lblTipoPedido = new Ext.form.Label({
			text: 'TIPO PEDIDO :',
			x: 10,
			y: 190,
			height: 20,
			cls: 'x-label'
		});
		var lblfecha = new Ext.form.Label({
			text: 'DEL :',
			x: 10,
			y: 220,
			height: 20,
			cls: 'x-label'
		});
		var lblfechaH = new Ext.form.Label({
			text: 'HASTA :',
			x: 10,
			y: 250,
			height: 20,
			cls: 'x-label'
		});
			
		// botones
		function GuardarArray1() { 
			var store = Ext.getCmp("GridPedido").getStore();
		
			var datosGrid1 = []; 
			var i=0;				
			store.each(function(rec){                                                       
				datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
				i=1;	
   			});    	
			if(i==1)
			{
				registrosGrid2 = Ext.encode(datosGrid1);
				frmPedidoComedor.guardarDatos();
			}
			else
			{
					Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">No se puede guardar. Lista de personal vacia</a>'); 
			}
			
			//alert(registrosGrid2);
		}; 	
		var btnAcept = new Ext.Button({
		    id: 'btnAceptarApp',
			x: 100,
			y: 150,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
			GuardarArray1();
			
				
			} 
		});		
		
		var btnLimpiarAp = new Ext.Button({
		    id: 'btnLimpiarAp',
			x: 210,
			y: 150,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				registros.length=0;
				registrosb.length=0;
				var frm = frmPedidoComedor.getForm();
				frm.reset();
				frm.clearInvalid();
				winPedidoComedor.hide();
				
			} 
		});		
		function buscarItemRepetidoCargador(coditem){ 
			
			var cantida = 0;
			storePedidoPersonal.each(function(record){
				if(record.data.codigop == coditem)
					cantida = 1;
				
			});
			return cantida;
		}
		function ActualizarGridCargador()
		{				
			dimension = registros.length;
			var registro = new Array(8);
			if(cboPer.getValue()!=""){
				if(buscarItemRepetidoCargador(cboPer.getValue())==0)
				{
					registro[0] = cboPer.getValue();
					registro[1] = cboPer.getRawValue(); 
			
				registros[dimension] = registro;		

				storePedidoPersonal.loadData(registros);
				
				}	
				else
				{
				Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">El personal ya está asignado</a>'); 
				//alert("El Cargador ya esta Asignado");
				}
			}
			else
			{
				Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Elija un personal</a>'); 
				//alert("Elija Un Cargador");
			}
		} 
		
		
		var btnSeleccionar = new Ext.Button({
			id: 'btnSelecti',
			y : 15,
			x: 430,
			//text: 'Adicionar',
			text: '<a style ="color:#15428B; font: bold 10px tahoma,arial,verdana,sans-serif;">Adicionar</a>',
			icon: '../img/Nuevo.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{	
				ActualizarGridCargador();
			}
		});
		function EliminarFila()
		{
			var store = Ext.getCmp("GridPedido").getStore();
                store.removeAt(rowIndex);				
			this.GridPedido.getView().refresh();	
			registrosb = null;
				registrosb = new Array();
				for(var i = rowIndex; i < registros.length - 1; i++ )
				{
					registros[i] = registros[i+1];
				}
				
				for(var i = 0; i < registros.length - 1; i++ )
				{
					
					registrosb[i] = registros[i];
				}
				registros=null;
				
				registros = new Array();
				registros = registrosb;
				
				GridPedido.removeAll();
			    storePedidoPersonal.removeAll();
				storePedidoPersonal.loadData(registros);	
			
		} 
		var btnQuitar = new Ext.Button({
			id: 'btnQuitarA',
			y : 45,
			x: 430,
			text: '<a style ="color:#15428B; font: bold 10px tahoma,arial,verdana,sans-serif;">Quitar</a>',
			
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{	
				EliminarFila();
			}
		});
		
		
		var frmPedidoComedor = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			width: 570,
			height:400,	
			items:[ lblPersonal, lblTipoPedido,lblfecha,lblfechaH,  cboPer,btnSeleccionar,btnQuitar,GridPedido,cboTipoPedido,
			        txtFechaDe,txtFechaHasta,
					],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSguardarPedidoComedor.php',						
						params :{registros : registrosGrid2},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmPedidoComedor.getForm();
								frm.reset();
								frm.clearInvalid();
								winPedidoComedor.hide();
								Ext.dsdata.Recargar();
								
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									//txtDescripcion.focus(true, 100);
								});
							}
							else {
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}					
						}
					});
				}
				else
				{
					Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Algunos campos son obligatorios complete el formulario </a>'); 
				}
			}
		});	

		
	
        function NuevoPedido(){	
			registros.length=0;
			registrosb.length=0;
			GridPedido.removeAll();
			    storePedidoPersonal.removeAll();
			if (!winPedidoComedor) {
				winPedidoComedor = new Ext.Window({
					layout: 'form',
					width: 570,
					height: 385,	
					title: 'PEDIDO COMEDOR',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,		
					modal: true,
					items: [frmPedidoComedor],
					buttonAlign:'center',
					buttons:[btnAcept, btnLimpiarAp],
					listeners: {				
						
					}
				});
			}
			
			
			txtFechaDe.setValue("");
			txtFechaHasta.setValue("");
			
			
				cboPer.setValue("");
				cboTipoPedido.setValue("");
				winPedidoComedor.show();
			
			
		
		
			
		}
		
		