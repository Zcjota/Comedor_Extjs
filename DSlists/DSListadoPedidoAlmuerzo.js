
Ext.onReady(function(){
	Ext.namespace('Ext.dsdata');
	// var reader = new Ext.data.JsonReader({ 
			// totalProperty   : 'total',  
			// successProperty : 'success',  
			// messageProperty : 'message',  
			// idProperty  : 'id',  
			// root        : 'data'  
			// },	
			// ['codigo', 'nombre_completo','tipo','fechaini','fechafin','registrado_por','fecha','encabezado']  
		// ); 
		
			// var gstore = new Ext.data.GroupingStore({ 
			// url        : '../servicesAjax/DSListadoPedidoAjax.php',
			// reader     : reader, 
			// sortInfo   : {field: 'fecha',direction:'ASC'}, 
			// groupField : "encabezado" ,
			// listeners: { 		       
					// load: function(thisStore, record, ids) 
					// {  					
						// Ext.Msg.hide();								
					// }
			// }
		
		// });  
	 
	 var fm = Ext.form;
	Ext.dsdata.storePedido = new Ext.data.JsonStore({  	
		url: '../servicesAjax/DSListadoPedidoAjax.php',  
		root: 'data',   
		totalProperty: 'total',
		fields: ['codigo', 'nombre_completo','tipo','fechaini','fechafin','registrado_por','fecha','encabezado','fechafin1'
			],
		listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						Ext.Msg.hide();								
					}
			}		
	}); 

	var indice=-1;
	var Paginas_Pedido = new Ext.PagingToolbar({
		pageSize: 1000, 
		store: Ext.dsdata.storePedido,
		displayInfo: true,
		afterPageText: 'de {0}',
		beforePageText: 'Pag.',
		firstText: 'Primera Pag.', 
		lastText: 'Ultima Pag.',
		nextText: 'Siguiente Pag.',
		prevText: 'Pag. Previa',
		refreshText: 'Refrescar',	
		displayMsg: 'Desplegando del {0} - {1} de {2}',
		emptyMsg: "No hay elementos para desplegar."
	});
	

	var sm = new Ext.grid.CheckboxSelectionModel(
			{
                singleSelect: false,
                listeners: 
				{
					rowselect: function(sm, row, rec) 
					{                        
						indice = row;
					
                        						
                    }
                }
            });
	var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Guardar',
        cancelText: 'Cancelar',
        listeners: {
            afteredit: {
                fn: function (obj, rowEditor, data, rowIndex) {
                   var id= Ext.dsdata.storePedido.getAt(rowIndex).get('codigo');
				   var fechaini= Ext.dsdata.storePedido.getAt(rowIndex).get('fechaini');
				   var fechafin= Ext.dsdata.storePedido.getAt(rowIndex).get('fechafin');
					insertarSC(id,fechaini,fechafin);
                    // var canti = parseInt(fields[9].getValue());
                    // var preci = parseFloat(fields[10].getValue());
                    // var total = canti * preci;  // falta obtener el valor de la grilla
                    // var prov = fields[12].getValue();
                    // var cuenta = fields[14].getValue();
                    // var fecha_comp = fields[15].getValue();
                    // var estado = fields[8].getValue();
                    // console.log("id : " + id + ", c : " +
                            // canti + ", pre : " + preci +
                            // ", prov : " + prov + ", cuent: " +
                            // cuenta + ", fech : " + fecha_comp +
                            // ", estad: " + estado);
                    // if (canti > 0 && preci > 0 && prov !== ""
                            // && cuenta !== "" && fecha_comp !== "") {
                        // insertarSC(id, canti, preci, total, prov, cuenta, fecha_comp, estado);
                    // } else {
                        // Ext.MessageBox.alert("ERROR", "Faltan datos.");
                    // }

                }
            }
        }
    });
	 function insertarSC(id,fechaini,fechafin) {
        Ext.Ajax.request(
                {
                    url: '../servicesAjax/DSModificarFechaPedido.php',
                    params: {
                        id: id,
                        fechaini: fechaini,
                        fechafin: fechafin,
                       
                    },
                    method: 'POST',
                    success: function (result, request)
                    {
                       
							Ext.dsdata.storePedido.load();
						
                    },
                    failure: function (result, request)
                    {
                        Ext.MessageBox.alert('ERROR', result.responseText);
                    }
                });
    }
	var Columnas_Pedido = new Ext.grid.ColumnModel(  
		[new Ext.grid.RowNumberer({width: 25}),sm,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Código</a>', 
			dataIndex: 'codigo',  
			width: 80,
			align: 'right',
			editor: {
                        xtype: 'textfield',
                        allowBlank: true,
                        readOnly:true,
                        disabled:true
                    }
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nombre Completo</a>', 
			dataIndex: 'nombre_completo',  
			renderer: formato, 
			width: 300,
			align: 'left',
			sortable: true,
			editor: {
                        xtype: 'textfield',
                        allowBlank: true,
                        readOnly:true,
                        disabled:true
                    }
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Tipo Pedido</a>', 
			dataIndex: 'tipo',  
			renderer: formato, 
			width: 100,
			align: 'left',
			sortable: true,
			editor: {
                        xtype: 'textfield',
                        allowBlank: true,
                        readOnly:true,
                        disabled:true
                    }
		}	
		,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Fecha Inicio</a>', 
			dataIndex: 'fechaini',  
			renderer: formato, 
			width: 100,
			align: 'left',
			sortable: true,
			editor: {
                        xtype: 'textfield',
                        allowBlank: true,
                        readOnly:true,
                        disabled:true
                    }
		},{  
			//xtype: 'datecolumn',
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Fecha Fin</a>', 
			dataIndex: 'fechafin', 
			renderer: formato,			
			//renderer: Ext.util.Format.dateRenderer('d/m/Y'),	
			width: 100,
			align: 'left',
			
			  editor: new fm.DateField({
                       
                        allowBlank: true,
                        minValue: new Date(),
							//renderer: Ext.util.Format.dateRenderer('d/m/Y'),	

                    })
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Registrado Por</a>', 
			dataIndex: 'registrado_por',  
			renderer: formato, 
			hidden:true,
			width: 200,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Fecha Registro</a>', 
			dataIndex: 'fecha',  
			renderer: formato, 
			hidden:true,
			width: 120,
			align: 'left',
			sortable: true
		}	,{ 
                header: '',  
                dataIndex: 'encabezado',
				//renderer: formato1,				
                width: 100,
                 sortable: false,
				hidden:true
			}					
		]  
	);	
	function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}
	
		var vieeew = new Ext.grid.GroupingView({  
			//forceFit            : true,
			ShowGroupName       : false,  
			enableNoGroup       : false,  
			enableGropingMenu   : false,  
			hideGroupedColumn   : true,
			startCollapsed	: true
		})
	var grid = new Ext.grid.EditorGridPanel({  
		id: 'gridPedido',
		store: Ext.dsdata.storePedido, 
		enableHdMenu: false,
		plugins: [editor],
		region:'center',
		cm: Columnas_Pedido,
		width: 100,	
		bbar: Paginas_Pedido, 
		//view : vieeew,	
		sm: sm,
		listeners:{			
			render:function(){
				Ext.dsdata.storePedido.load();
			},
			'celldblclick' :function()
			{	
				//modCargo(indice);
			}
		},
		// sm: new Ext.grid.RowSelectionModel({
				// singleSelect: true,
				// listeners: {					
						// rowselect: function(sm, row, rec)
						// {  
							// indice = row;
							// //var RegistoMod = Ext.namespace.storeTramite.getAt(Indicev).get('numerotramite'); ASI SE LO LLAMA											
						// }      
					// }
		// })		
	});	

	var filter = new Ext.form.TextField({name: 'filterValue',cls: 'namelabel',
	style : {textTransform: "uppercase"}
	
	});	
	var bfilter = new Ext.Toolbar.Button({
		text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Buscar</a>',
		tooltip: "Utilizar '*' para busquedas ",  
		icon: '../img/view.png',
		handler: function(btn,e) {					
			var filterVal = filter.getValue();
			if( filterVal.length > 0 ) 
			{  
				var o = {start : 0, limit:25};					
				Ext.dsdata.storePedido.baseParams['buscar'] = filterVal;
				Ext.dsdata.storePedido.reload({params:o});
			} 
			else {
				var o = {start : 0, limit:25};	
				filter.setValue('*');
				Ext.dsdata.storePedido.baseParams['buscar'] = '*';
				Ext.dsdata.storePedido.reload({params:o});
			}	
		}
	});

	function quitar(registrosGrid)
		{
			Ext.Ajax.request({  
										url: '../servicesAjax/DSquitarPedido.php',  
										method: 'POST',  
										params: {registrosGrid:registrosGrid},  
										success: desactivo,  
										failure: no_desactivo  
										});  

										function desactivo(resp)  
										{  	
											//Ext.dsdata.Recargar();  			
											Ext.dsdata.storePedido.load();
										}  
								  
										function no_desactivo(resp)  
										{  	
											
										}  
		}
	Ext.dsdata.Recargar = function(){  
			Ext.dsdata.storePedido.load();
		} 	
	var PAmenu = new Ext.Panel({
		region: 'north',
		id: 'PAmenuPr',
		height: 29,   
		tbar: [{
				xtype: 'buttongroup',
				items: [{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Realizar Pedido</a>',
							icon: '../img/Nuevo.png',
							handler: function(t){
								NuevoPedido();				  				
							}
						},{
							text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Eliminar</a>',
							icon: '../img/Eliminar.png',
							handler: function confirm()
							{
								if(indice!=-1)
								{
									return Ext.MessageBox.confirm('confirmar','desea eliminar este registro?',
										function(s){
											if(s=='yes'){
												var i=0;
												var datosGrid = [];  
												sm.each(function(rec){         
													i++;
													datosGrid.push(Ext.apply({id:rec.id},rec.data));            
												});    	
										if(i>0){
											Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										registrosGrid = Ext.encode(datosGrid); 	
										//alert(registrosGrid);
										quitar(registrosGrid);
									//	asignarAprobadorMA(registrosGrid);
									}
									else
									{Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Seleccione un Personal</a>'); }
											
											
										}}
									)
								}
								else	{ 
								Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"> Seleccione uno de la Lista</a>'); 
								}	
							
																				
							}
						}
						]
			}
										
			]
	});	
	
	var viewport1 = new Ext.Viewport({
		layout: 'border',
		items: [PAmenu, grid]		
	}); 
});