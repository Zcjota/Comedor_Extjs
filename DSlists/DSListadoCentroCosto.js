/*!
 * DSoft-TPMV
 * Copyright(c) 2012
 */
Ext.onReady(function(){
	Ext.namespace('Ext.dsdata');
	
	Ext.dsdata.storeCentroCosto = new Ext.data.JsonStore({  	
		url: '../servicesAjax/DSListadoCentroAjax.php',  
		root: 'data',   
		totalProperty: 'total',
		fields: ['codigo', 'descripcion','codunidad','nomunidad','codsubcentro','nomsubcentro',
				'codigo_base']		
	}); 
	var indice=-1;
	var Paginas = new Ext.PagingToolbar({
		pageSize: 200, 
		store: Ext.dsdata.storeCentroCosto,
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
	
	var Columnas = new Ext.grid.ColumnModel(  
		[{  
			header: 'codigo',  
			dataIndex: 'codigo',  
			align: 'right',
			hidden :true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Unidad</a>', 
			dataIndex: 'nomunidad',  
			renderer: formato, 	
			width: 200,
			align: 'left',
			sortable: true
		}	,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Subcentro</a>', 
			dataIndex: 'nomsubcentro',
			renderer: formato, 				
			width: 200,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Centro</a>', 
			dataIndex: 'descripcion',  
			renderer: formato, 	
			width: 200,
			align: 'left',
			sortable: true
		}
		,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Código Base</a>', 
			dataIndex: 'codigo_base',  
			renderer: formato, 	
			width: 150,
			align: 'center',
			sortable: true
		}	
			
		]  
	);	
	function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}
	var grid = new Ext.grid.GridPanel({  
		id: 'grisSubcentro',
		store: Ext.dsdata.storeCentroCosto, 
		region:'center',
		cm: Columnas, 
		enableColLock:false,
		stripeRows: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		bbar: Paginas, 
		columnLines: true,
		listeners:{			
			render:function(){
				Ext.dsdata.storeCentroCosto.load({params:{start:0,limit:200}});	
			},
			'celldblclick' :function()
			{	
				modCentro(indice);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
				listeners: {					
						rowselect: function(sm, row, rec)
						{  
							indice = row;
							//var RegistoMod = Ext.namespace.storeTramite.getAt(Indicev).get('numerotramite'); ASI SE LO LLAMA											
						}      
					}
		})		
	});	

	var filter = new Ext.form.TextField({name: 'filterValue',
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
				var o = {start : 0, limit:200};					
				Ext.dsdata.storeCentroCosto.baseParams['buscar'] = filterVal;
				Ext.dsdata.storeCentroCosto.reload({params:o});
			} 
			else {
				Ext.dsdata.storeCentroCosto.clearFilter();
			}	
		}
	});

	function eliminar(indice)
	{
        cod = Ext.dsdata.storeCentroCosto.getAt(indice).get('codigo'); 
		Ext.Ajax.request({  
		url: '../servicesAjax/DSdesactivarCentroAJAX.php',  
		method: 'POST',  
		params: {id:cod},  
		success: desactivo,  
		failure: no_desactivo  
		});  

		function desactivo(resp)  
		{  	
			Ext.MessageBox.alert('Mensaje', 'Eliminado');  			
			Ext.dsdata.storeCentroCosto.load({params:{start:0,limit:200}});
		}  
  
		function no_desactivo(resp)  
		{  			
			Ext.MessageBox.alert('Mensaje', resp.mensaje);  
		}  
        }	
		
	var PAmenu = new Ext.Panel({
		region: 'north',
		id: 'PAmenuPr',
		height: 29,   
		tbar: [{
				xtype: 'buttongroup',
				items: [{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nuevo</a>',
							icon: '../img/Nuevo.png',
							handler: function(t){
								NuevoCentro();						  				
							}
						},{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
							icon: '../img/Editar.png',
							handler: function(t)
							{
								if(indice!=-1)
								{
								modCentro(indice);}
								else{Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Seleccione uno de la Lista</a>'); }
								
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
												eliminar(indice);
											
											
										}}
									)
								}
								else	{ 
								Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"> Seleccione uno de la Lista</a>'); 
								}	
							
																				
							}
						}
						]
			},
			 '->', filter, bfilter								
			]
	});	
	
	var viewport1 = new Ext.Viewport({
		layout: 'border',
		items: [PAmenu, grid]		
	}); 
});