/*!
 * INTECRUZ-CACC
 * Copyright(c) 2012
 */
Ext.onReady(function(){
	Ext.namespace('Ext.dsdata');
	Ext.dsdata.storeProveedor = new Ext.data.JsonStore({  	
		url: '../servicesAjax/DSListadoProveedorAjax.php',  
		root: 'data',   
		totalProperty: 'total',
		fields: ['codigo', 'nombre','representa_legal','nit','direccion']		
	}); 
	var indice=-1;
	var Paginas = new Ext.PagingToolbar({
		pageSize: 25, 
		store: Ext.dsdata.storeProveedor,
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
	
	var Columnas_proveedor = new Ext.grid.ColumnModel(  
		[{  
			header: 'codigo',  
			dataIndex: 'codigo',  
			align: 'right',
			hidden :true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nombre</a>', 
			dataIndex: 'nombre',  
			renderer: formato, 
			width: 150,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Representante</a>', 
			dataIndex: 'representa_legal',  
			renderer: formato, 
			width: 150,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nit</a>', 
			dataIndex: 'nit',  
			renderer: formato, 
			width: 150,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Dirección</a>', 
			dataIndex: 'direccion',  
			renderer: formato, 
			width: 150,
			align: 'left',
			sortable: true
		}	
			
		]  
	);	
	function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}
	var grid_proveedor = new Ext.grid.GridPanel({  
		id: 'gridProveedor',
		store: Ext.dsdata.storeProveedor, 
		region:'center',
		cm: Columnas_proveedor, 
		enableColLock:false,
		stripeRows: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		bbar: Paginas, 
		loadMask: true,
		listeners:{			
			render:function(){
				Ext.dsdata.storeProveedor.load({params:{start:0,limit:25}});	
			},
			'celldblclick' :function()
			{	
				modProveedor(indice);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
				listeners: {					
						rowselect: function(sm, row, rec)
						{  
							indice = row;
						}      
					}
		})		
	});	

	var filter = new Ext.form.TextField({name: 'filterValue',cls: 'namelabel',
	style : {textTransform: "uppercase"},
	listeners: {
						specialkey: function(f,e){
								if(e.getKey() == e.ENTER){
									var filterVal = filter.getValue();
									if( filterVal.length > 0 ) 
									{  
										var o = {start : 0, limit:25};					
										Ext.dsdata.storeProveedor.baseParams['buscar'] = filterVal;
										Ext.dsdata.storeProveedor.reload({params:o});
									} 
									else {
										filterVal="*";
										Ext.dsdata.storeProveedor.baseParams['buscar'] = filterVal;
										Ext.dsdata.storeProveedor.reload({params:o});
									}	
										
							}
						}
		}
	
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
				Ext.dsdata.storeProveedor.baseParams['buscar'] = filterVal;
				Ext.dsdata.storeProveedor.reload({params:o});
			} 
			else {
				Ext.dsdata.storeProveedor.clearFilter();
			}	
		}
	});

	function eliminar_proveedor(indice)
	{
        cod = Ext.dsdata.storeProveedor.getAt(indice).get('codigo'); 
		Ext.Ajax.request({  
		url: '../servicesAjax/DSdesactivarProveedorAJAX.php',  
		method: 'POST',  
		params: {id:cod},  
		success: desactivo,  
		failure: no_desactivo  
		});  

		function desactivo(resp)  
		{  	
			Ext.MessageBox.alert('Mensaje', 'Eliminado');  			
			Ext.dsdata.storeProveedor.load({params:{start:0,limit:25}});
		}  
  
		function no_desactivo(resp)  
		{  			
			Ext.MessageBox.alert('Mensaje', resp.mensaje);  
		}  
    }		
	var PAmenu_proveedor = new Ext.Panel({
		region: 'north',
		id: 'PAmenuProveedor',
		height: 29,   
		tbar: [{
				xtype: 'buttongroup',
				items: [{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nuevo</a>',
							icon: '../img/Nuevo.png',
							handler: function(t){
								NuevoProveedor();						  				
							}
						},{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
							icon: '../img/Editar.png',
							handler: function(t)
							{
								if(indice!=-1)
								{
								modProveedor(indice);}
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
												eliminar_proveedor(indice);
											
											
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
		items: [PAmenu_proveedor, grid_proveedor]		
	}); 
});