	var winPermisoUsuario;
	
	var registrosMOD;
	var registrosALTA;
	var registrosBAJA;
	var registrosMODF;
	var txtCodPerfil = new Ext.form.TextField({
			name: 'codperfil',
			hideLabel: true,
			hidden: true,
            maxLength : 10,	
			width:80,
			y :45,
			x: 100							
		});
		
		storePermisos = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaPermisoGRAJAX.php',   
		root: 'data',   		
		fields: ['codigosub','nombresub', 'codigomen','nombremen', 'ticket', 'rol'],
		listeners:{  
					 load: function(thisStore, record, ids) {  					
						var pos = 0;  						
						var miArray = new Array(); 						
						for(i=0; i<this.getCount();i++){  
							if(parseInt(record[i].data.ticket) == 1){  
								miArray[pos] = i;  
								pos++;  
							} 
						}  			
						gridModulo.getSelectionModel().selectRows(miArray, true);							
					 }
			}
 		});  	
		storePermisos2 = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaPermisoGRAJAX.php',   
		root: 'data',   		
		fields: ['codigosub','nombresub', 'codigomen','nombremen', 'ticket', 'rol'],
		listeners:{  
					 load: function(thisStore, record, ids) {  					
						var pos = 0;  						
						var miArray = new Array(); 						
						for(i=0; i<this.getCount();i++){  
							if(parseInt(record[i].data.ticket) == 1){  
								miArray[pos] = i;  
								pos++;  
							} 
						}  			
						gridAlta.getSelectionModel().selectRows(miArray, true);							
					 }
			}
 		});  	
		storePermisos3 = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaPermisoGRAJAX.php',   
		root: 'data',   		
		fields: ['codigosub','nombresub', 'codigomen','nombremen', 'ticket', 'rol'],
		listeners:{  
					 load: function(thisStore, record, ids) {  					
						var pos = 0;  						
						var miArray = new Array(); 						
						for(i=0; i<this.getCount();i++){  
							if(parseInt(record[i].data.ticket) == 1){  
								miArray[pos] = i;  
								pos++;  
							} 
						}  			
						gridBaja.getSelectionModel().selectRows(miArray, true);							
					 }
			}
 		});  	
		storePermisos4 = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaPermisoGRAJAX.php',   
		root: 'data',   		
		fields: ['codigosub','nombresub', 'codigomen','nombremen', 'ticket', 'rol'],
		listeners:{  
					 load: function(thisStore, record, ids) {  					
						var pos = 0;  						
						var miArray = new Array(); 						
						for(i=0; i<this.getCount();i++){  
							if(parseInt(record[i].data.ticket) == 1){  
								miArray[pos] = i;  
								pos++;  
							} 
						}  			
						gridModf.getSelectionModel().selectRows(miArray, true);							
					 }
			}
 		});  	
		
		var sm = new Ext.grid.CheckboxSelectionModel(); 
		var sm2 = new Ext.grid.CheckboxSelectionModel();
		var sm3 = new Ext.grid.CheckboxSelectionModel();
		var sm4 = new Ext.grid.CheckboxSelectionModel();
		var Columnas = new Ext.grid.ColumnModel(  
		[
			{                  
				header: 'codigo',  
				dataIndex: 'codigomen',  
				hidden :true				
			},{  
				header: 'Menu',  
				dataIndex: 'nombremen',  
				width: 200,
				sortable: true            
			},
			{                  
				header: 'codigo',  
				dataIndex: 'codigosub',  
				hidden :true				
			},{  
				header: 'Submenu',  
				dataIndex: 'nombresub',  
				width: 200,
				
				sortable: true            
			},sm
		]  
        );					
		var gridModulo = new Ext.grid.EditorGridPanel({  
			id: 'gridPermiso',
			x : 10,
			y : 10,
			width : 440,	
			height : 450,
			sm : sm,		
			store: storePermisos,	
			cm: Columnas, 	
			selModel: new Ext.grid.RowSelectionModel({multipleSelect:true}),
			border: false,   
			enableColLock:false,
			stripeRows: false,
			clicksToEdit: 1
		});				
		var Columnas2 = new Ext.grid.ColumnModel(  
		[
			{                  
				header: 'codigo',  
				dataIndex: 'codigomen',  
				align: 'right',  
				hidden :true				
			},{  
				header: '....',  
				dataIndex: 'rol', 
				align: 'right',  
				width: 40          
			},sm2
		]  
        );					
		var gridAlta = new Ext.grid.EditorGridPanel({  
			id: 'gridPermiso2',
			x : 450,
			y : 10,
			width : 67,	
			height : 450,
			sm : sm2,		
			store: storePermisos2,	
			cm: Columnas2, 	
			selModel: new Ext.grid.RowSelectionModel({multipleSelect:true}),
			border: false,   
			enableColLock:false,
			stripeRows: false,
			clicksToEdit: 1
		});		
		var Columnas3 = new Ext.grid.ColumnModel(  
		[
			{                  
				header: 'codigo',  
				dataIndex: 'codigomen',  
				align: 'right',  
				hidden :true				
			},{  
				header: '....',  
				dataIndex: 'rol', 
				align: 'right',  
				width: 40          
			},sm3
		]  
        );			
		
		var gridBaja = new Ext.grid.EditorGridPanel({  
			id: 'gridPermiso3',
			x : 512,
			y : 10,
			width : 65,	
			height : 450,
			sm : sm3,		
			store: storePermisos3,	
			cm: Columnas3, 	
			selModel: new Ext.grid.RowSelectionModel({multipleSelect:true}),
			border: false,   
			enableColLock:false,
			stripeRows: false,
			clicksToEdit: 1
		});		
		 
		var Columnas4 = new Ext.grid.ColumnModel(  
		[
			{                  
				header: 'codigo',  
				dataIndex: 'codigomen',  
				align: 'right',  
				hidden :true				
			},{  
				header: '....',  
				dataIndex: 'rol', 
				align: 'right',  
				width: 40          
			},sm4
		]  
        );			
		
		var gridModf = new Ext.grid.EditorGridPanel({  
			id: 'gridPermiso4',
			x : 560,
			y : 10,
			width : 65,	
			height : 450,
			sm : sm4,		
			store: storePermisos4,	
			cm: Columnas4, 	
			selModel: new Ext.grid.RowSelectionModel({multipleSelect:true}),
			border: false,   
			enableColLock:false,
			stripeRows: false,
			clicksToEdit: 1
		});				
		var btnAceptar = new Ext.Button({
		    id: 'btnAceptar',
			x: 180,
			y: 465,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				GuardarArray();
				/*
				alert(registrosMOD);
				alert(registrosALTA);
				alert(registrosBAJA);
				alert(registrosMODF);
				*/
				frmPermiso.guardarDatos();
			} 
		});
		
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 275,
			y: 465,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmPermiso.getForm().reset;					
				winPermisoUsuario.hide();
			} 
		});	

		function GuardarArray() {  			
			var keys = gridModulo.selModel.selections.keys;  
			var datosGrid = [];  
			sm.each(function(rec){                                                   
				datosGrid.push(Ext.apply({id:rec.id},rec.data));         				
   			});   			
			this.gridModulo.stopEditing();    
			registrosMOD = Ext.encode(datosGrid); 
			
			var keys = gridAlta.selModel.selections.keys;  
			var datosGrid2 = [];  
			sm2.each(function(rec){                                                   
				datosGrid2.push(Ext.apply({id:rec.id},rec.data));         				
   			});   			
			this.gridAlta.stopEditing();    
			registrosALTA = Ext.encode(datosGrid2); 
			
			var keys = gridBaja.selModel.selections.keys;  
			var datosGrid3 = [];  
			sm3.each(function(rec){                                                   
				datosGrid3.push(Ext.apply({id:rec.id},rec.data));         				
   			});   			
			this.gridBaja.stopEditing();    
			registrosBAJA = Ext.encode(datosGrid3); 
			
			var keys = gridModf.selModel.selections.keys;  
			var datosGrid4 = [];  
			sm4.each(function(rec){                                                   
				datosGrid4.push(Ext.apply({id:rec.id},rec.data));         				
   			});   			
			this.gridModf.stopEditing();    
			registrosMODF = Ext.encode(datosGrid4); 
		}; 	
	
		var frmPermiso = new Ext.FormPanel({ 
			frame:true, 
			//selectOnFocus: true,
			autoScroll:true,		
			layout: 'absolute',
			items:[txtCodPerfil, gridModulo, btnAceptar, btnLimpiar],
			guardarDatos: function(){
				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSguardarPermisosAJAX.php',
						params :{modulo : registrosMOD, alta : registrosALTA, baja : registrosBAJA, modificar : registrosMODF },  
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando Datos...',
						success: function(form, action){	
								winPermisoUsuario.hide();								
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
	
		function PermisoUsuario(Codigov)
		{		
			if (!winPermisoUsuario) 
			{
				winPermisoUsuario = new Ext.Window(
				{
					layout: 'fit',
					width: 530,
					height: 450,		
					title: 'Registro de Permiso',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,					
					items: [frmPermiso],
					listeners: {					
						show: function(){
					
						}
					}
				});			
			}	
			
			txtCodPerfil.setValue(Codigov);			
			storePermisos.load({ params:{codperfil: Codigov,roles:'Modulo'} });
			storePermisos2.load({ params:{codperfil: Codigov,roles:'Alta'} });
			storePermisos3.load({ params:{codperfil: Codigov,roles:'Baja'} });
			storePermisos4.load({ params:{codperfil: Codigov,roles:'Modf'} });
			winPermisoUsuario.show();				
		}
		
















